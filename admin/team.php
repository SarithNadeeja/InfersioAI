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
        $stmt = $pdo->prepare("SELECT image_url FROM team_members WHERE id = :id");
        $stmt->execute(["id" => $deleteId]);
        $row = $stmt->fetch();

        $del = $pdo->prepare("DELETE FROM team_members WHERE id = :id");
        $del->execute(["id" => $deleteId]);

        if ($row && !empty($row["image_url"]) && !preg_match('#^https?://#i', (string) $row["image_url"])) {
            uploads_delete_stored_file((string) $row["image_url"]);
        }
        header("Location: team.php?ok=deleted");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $name = trim((string) ($_POST["name"] ?? ""));
    $role = trim((string) ($_POST["role"] ?? ""));
    $sortOrder = (int) ($_POST["sort_order"] ?? 0);
    $profileLink = "#";

    if ($name === "" || $role === "") {
        $error = "Name and profession are required.";
    } else {
        $finalImage = "";
        $hasUpload = isset($_FILES["photo"]) && ($_FILES["photo"]["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;

        if ($hasUpload) {
            $file = $_FILES["photo"];
            if (($file["error"] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                $error = "Photo upload failed.";
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
                    $error = "Photo must be PNG, JPG, WEBP, or GIF.";
                } else {
                    $fname = "team_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $allowed[$mime];
                    $saved = uploads_save_uploaded_file($tmp, "team-photos", $fname);
                    if (!$saved["ok"]) {
                        $error = $saved["error"] !== "" ? $saved["error"] : "Failed to save uploaded photo.";
                    } else {
                        $finalImage = $saved["stored_path"];
                    }
                }
            }
        }

        if ($error === "") {
            if ($id > 0) {
                $oldStmt = $pdo->prepare("SELECT image_url FROM team_members WHERE id = :id");
                $oldStmt->execute(["id" => $id]);
                $old = $oldStmt->fetch();

                if ($finalImage !== "") {
                    $upd = $pdo->prepare(
                        "UPDATE team_members
                         SET name = :name, role = :role, image_url = :img, profile_link = :plink,
                             sort_order = :sort, updated_at = NOW()
                         WHERE id = :id"
                    );
                    $upd->execute([
                        "id" => $id,
                        "name" => $name,
                        "role" => $role,
                        "img" => $finalImage,
                        "plink" => $profileLink,
                        "sort" => $sortOrder,
                    ]);
                    if ($old && !empty($old["image_url"]) && !preg_match('#^https?://#i', (string) $old["image_url"])) {
                        uploads_delete_stored_file((string) $old["image_url"]);
                    }
                } else {
                    $upd = $pdo->prepare(
                        "UPDATE team_members
                         SET name = :name, role = :role, profile_link = :plink,
                             sort_order = :sort, updated_at = NOW()
                         WHERE id = :id"
                    );
                    $upd->execute([
                        "id" => $id,
                        "name" => $name,
                        "role" => $role,
                        "plink" => $profileLink,
                        "sort" => $sortOrder,
                    ]);
                }
                header("Location: team.php?ok=updated");
                exit;
            } else {
                if ($finalImage === "") {
                    $error = "Photo is required when adding a leadership member.";
                } else {
                    $ins = $pdo->prepare(
                        "INSERT INTO team_members (name, role, image_url, profile_link, sort_order)
                         VALUES (:name, :role, :img, :plink, :sort)"
                    );
                    $ins->execute([
                        "name" => $name,
                        "role" => $role,
                        "img" => $finalImage,
                        "plink" => $profileLink,
                        "sort" => $sortOrder,
                    ]);
                    header("Location: team.php?ok=added");
                    exit;
                }
            }
        }
    }
}

if ($editId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM team_members WHERE id = :id LIMIT 1");
    $stmt->execute(["id" => $editId]);
    $editing = $stmt->fetch() ?: null;
}

$members = $pdo->query("SELECT * FROM team_members ORDER BY sort_order ASC, id ASC")->fetchAll();
$okMap = [
    "added" => "Leadership member added.",
    "updated" => "Leadership member updated.",
    "deleted" => "Leadership member removed.",
];
if (!empty($_GET["ok"]) && isset($okMap[$_GET["ok"]])) {
    $ok = $okMap[$_GET["ok"]];
}
admin_page_start("Leadership", "leadership");
admin_page_header("Leadership", "Add name, profession, and photo — shown on the homepage and About page.");
?>

            <div class="card">
                <h2><?= $editing ? "Edit member" : "Add member" ?></h2>
                <?php if ($error): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <?php if ($ok): ?><div class="alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $editing ? (int) $editing["id"] : 0 ?>">
                    <div class="grid">
                        <div>
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" required value="<?= htmlspecialchars((string) ($editing["name"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="role">Profession</label>
                            <input id="role" name="role" type="text" required placeholder="e.g. CEO, Lead Developer" value="<?= htmlspecialchars((string) ($editing["role"] ?? "")) ?>">
                        </div>
                    </div>
                    <label for="photo">Photo <?= $editing ? "(optional — replaces current)" : "" ?></label>
                    <input id="photo" name="photo" type="file" accept=".png,.jpg,.jpeg,.webp,.gif" <?= $editing ? "" : "required" ?>>
                    <div>
                        <label for="sort_order">Display order (lower appears first)</label>
                        <input id="sort_order" name="sort_order" type="number" value="<?= (int) ($editing["sort_order"] ?? 0) ?>">
                    </div>
                    <button class="btn" type="submit"><?= $editing ? "Update member" : "Add member" ?></button>
                    <?php if ($editing): ?>
                        <a class="btn btn-ghost" href="team.php">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h2>All leadership</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Profession</th>
                                <th>Order</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$members): ?>
                            <tr><td colspan="5" class="muted">No leadership members yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($members as $m): ?>
                                <tr>
                                    <td>
                                        <?php
                                        $src = (string) $m["image_url"];
                                        $imgSrc = uploads_public_src($src, preg_match('#^https?://#i', $src) ? "" : "..");
                                        ?>
                                        <img class="logo-thumb" src="<?= htmlspecialchars($imgSrc) ?>" alt="">
                                    </td>
                                    <td><?= htmlspecialchars((string) $m["name"]) ?></td>
                                    <td><?= htmlspecialchars((string) $m["role"]) ?></td>
                                    <td><?= (int) $m["sort_order"] ?></td>
                                    <td>
                                        <div class="row-actions">
                                            <a class="btn btn-ghost" href="team.php?edit=<?= (int) $m["id"] ?>">Edit</a>
                                            <a class="btn btn-danger" href="team.php?delete=<?= (int) $m["id"] ?>" onclick="return confirm('Remove this member?')">Remove</a>
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
