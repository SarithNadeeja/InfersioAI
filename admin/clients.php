<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";
require_once __DIR__ . "/../includes/admin_layout.php";
require_once __DIR__ . "/../includes/uploads.php";

$user = admin_require_login();
if (!empty($user["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

$error = "";
$ok = "";
$editing = null;
$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;

if (isset($_GET["delete"])) {
    $deleteId = (int) $_GET["delete"];
    if ($deleteId > 0) {
        $stmt = $pdo->prepare("SELECT logo_path FROM clients WHERE id = :id");
        $stmt->execute(["id" => $deleteId]);
        $row = $stmt->fetch();

        $del = $pdo->prepare("DELETE FROM clients WHERE id = :id");
        $del->execute(["id" => $deleteId]);

        if ($row && !empty($row["logo_path"])) {
            uploads_delete_stored_file((string) $row["logo_path"]);
        }
        header("Location: clients.php?ok=deleted");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $company = trim((string) ($_POST["company_name"] ?? ""));
    $website = trim((string) ($_POST["company_website"] ?? ""));

    if ($company === "" || $website === "") {
        $error = "Company name and website are required.";
    } elseif (!filter_var($website, FILTER_VALIDATE_URL)) {
        $error = "Please provide a valid website URL.";
    } else {
        $logoPath = "";
        $hasUpload = isset($_FILES["logo"]) && ($_FILES["logo"]["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;

        if ($hasUpload) {
            $file = $_FILES["logo"];
            if (($file["error"] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                $error = "Logo upload failed.";
            } else {
                $tmp = $file["tmp_name"];
                $mime = mime_content_type($tmp) ?: "";
                $allowed = [
                    "image/png" => "png",
                    "image/jpeg" => "jpg",
                    "image/webp" => "webp",
                    "image/gif" => "gif",
                ];
                if (!isset($allowed[$mime])) {
                    $error = "Logo must be PNG, JPG, WEBP, or GIF.";
                } else {
                    $name = "logo_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $allowed[$mime];
                    $saved = uploads_save_uploaded_file($tmp, "client-logos", $name);
                    if (!$saved["ok"]) {
                        $error = $saved["error"] !== "" ? $saved["error"] : "Failed to save uploaded logo.";
                    } else {
                        $logoPath = $saved["stored_path"];
                    }
                }
            }
        }

        if ($error === "") {
            if ($id > 0) {
                if ($logoPath !== "") {
                    $oldStmt = $pdo->prepare("SELECT logo_path FROM clients WHERE id = :id");
                    $oldStmt->execute(["id" => $id]);
                    $old = $oldStmt->fetch();

                    $upd = $pdo->prepare(
                        "UPDATE clients
                         SET company_name = :company, company_website = :website, logo_path = :logo, updated_at = NOW()
                         WHERE id = :id"
                    );
                    $upd->execute([
                        "id" => $id,
                        "company" => $company,
                        "website" => $website,
                        "logo" => $logoPath,
                    ]);

                    if ($old && !empty($old["logo_path"])) {
                        uploads_delete_stored_file((string) $old["logo_path"]);
                    }
                } else {
                    $upd = $pdo->prepare(
                        "UPDATE clients
                         SET company_name = :company, company_website = :website, updated_at = NOW()
                         WHERE id = :id"
                    );
                    $upd->execute([
                        "id" => $id,
                        "company" => $company,
                        "website" => $website,
                    ]);
                }

                header("Location: clients.php?ok=updated");
                exit;
            } else {
                if ($logoPath === "") {
                    $error = "Logo is required for a new client.";
                } else {
                    $ins = $pdo->prepare(
                        "INSERT INTO clients (company_name, company_website, logo_path)
                         VALUES (:company, :website, :logo)"
                    );
                    $ins->execute([
                        "company" => $company,
                        "website" => $website,
                        "logo" => $logoPath,
                    ]);
                    header("Location: clients.php?ok=added");
                    exit;
                }
            }
        }
    }
}

if ($editId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = :id LIMIT 1");
    $stmt->execute(["id" => $editId]);
    $editing = $stmt->fetch() ?: null;
}

$clients = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC")->fetchAll();
$okMap = [
    "added" => "Client added successfully.",
    "updated" => "Client updated successfully.",
    "deleted" => "Client removed successfully.",
];
if (!empty($_GET["ok"]) && isset($okMap[$_GET["ok"]])) {
    $ok = $okMap[$_GET["ok"]];
}
admin_page_start("Clients", "clients");
admin_page_header("Clients", "Add client name, logo, and website — shown on the homepage and About page.");
?>

            <div class="card">
                <h2><?= $editing ? "Edit client" : "Add client" ?></h2>
                <?php if ($error): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <?php if ($ok): ?><div class="alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $editing ? (int) $editing["id"] : 0 ?>">
                    <div class="grid">
                        <div>
                            <label for="company_name">Client name</label>
                            <input id="company_name" name="company_name" type="text" required value="<?= htmlspecialchars((string) ($editing["company_name"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="company_website">Client website</label>
                            <input id="company_website" name="company_website" type="url" required placeholder="https://example.com" value="<?= htmlspecialchars((string) ($editing["company_website"] ?? "")) ?>">
                        </div>
                    </div>
                    <label for="logo">Client logo <?= $editing ? "(optional — replace current)" : "" ?></label>
                    <input id="logo" name="logo" type="file" accept=".png,.jpg,.jpeg,.webp,.gif" <?= $editing ? "" : "required" ?>>
                    <button class="btn" type="submit"><?= $editing ? "Update client" : "Add client" ?></button>
                    <?php if ($editing): ?>
                        <a class="btn btn-ghost" href="clients.php">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h2>All clients</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Website</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$clients): ?>
                            <tr><td colspan="4" class="muted">No clients yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($clients as $c): ?>
                                <tr>
                                    <td><img class="logo-thumb" src="<?= htmlspecialchars(uploads_public_src((string) $c["logo_path"], "..")) ?>" alt="<?= htmlspecialchars($c["company_name"]) ?>"></td>
                                    <td><?= htmlspecialchars($c["company_name"]) ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($c["company_website"]) ?>" target="_blank" rel="noopener noreferrer">
                                            <?= htmlspecialchars($c["company_website"]) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="row-actions">
                                            <a class="btn btn-ghost" href="clients.php?edit=<?= (int) $c["id"] ?>">Edit</a>
                                            <a class="btn btn-danger" href="clients.php?delete=<?= (int) $c["id"] ?>" onclick="return confirm('Delete this client?')">Remove</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

<?php admin_page_end(); ?>
