<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";

$user = admin_require_login();
if (!empty($user["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

$uploadsDir = __DIR__ . "/../uploads/team-photos";
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0777, true);
}

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
            $abs = realpath(__DIR__ . "/../" . ltrim((string) $row["image_url"], "/\\"));
            $base = realpath($uploadsDir);
            if ($abs && $base && strpos($abs, $base) === 0 && is_file($abs)) {
                @unlink($abs);
            }
        }
        header("Location: team.php?ok=deleted");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $name = trim((string) ($_POST["name"] ?? ""));
    $role = trim((string) ($_POST["role"] ?? ""));
    $profileLink = trim((string) ($_POST["profile_link"] ?? ""));
    $imageUrlField = trim((string) ($_POST["image_url_field"] ?? ""));
    $sortOrder = (int) ($_POST["sort_order"] ?? 0);

    if ($name === "" || $role === "" || $profileLink === "") {
        $error = "Name, role, and profile link are required.";
    } elseif (!filter_var($profileLink, FILTER_VALIDATE_URL)) {
        $error = "Profile link must be a valid URL.";
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
                    $target = $uploadsDir . "/" . $fname;
                    if (!move_uploaded_file($tmp, $target)) {
                        $error = "Failed to save uploaded photo.";
                    } else {
                        $finalImage = "uploads/team-photos/" . $fname;
                    }
                }
            }
        }

        if ($error === "" && $finalImage === "" && $imageUrlField !== "") {
            if (filter_var($imageUrlField, FILTER_VALIDATE_URL)) {
                $finalImage = $imageUrlField;
            } elseif (preg_match('#^(assets/|uploads/)#i', $imageUrlField)) {
                $finalImage = $imageUrlField;
            } else {
                $error = "Image URL must be a valid http(s) URL or a path starting with assets/ or uploads/.";
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
                        $oldAbs = realpath(__DIR__ . "/../" . ltrim((string) $old["image_url"], "/\\"));
                        $base = realpath($uploadsDir);
                        if ($oldAbs && $base && strpos($oldAbs, $base) === 0 && is_file($oldAbs)) {
                            @unlink($oldAbs);
                        }
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
                    $error = "Provide a photo upload or an image URL / path.";
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
    "added" => "Team member added.",
    "updated" => "Team member updated.",
    "deleted" => "Team member removed.",
];
if (!empty($_GET["ok"]) && isset($okMap[$_GET["ok"]])) {
    $ok = $okMap[$_GET["ok"]];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team — InfersioAI Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">InfersioAI Admin</div>
            <a class="nav-link" href="index.php">Dashboard</a>
            <a class="nav-link" href="clients.php">Client Manager</a>
            <a class="nav-link active" href="team.php">Team (About)</a>
            <a class="nav-link" href="projects.php?service=ai-solutions">AI Solutions</a>
            <a class="nav-link" href="projects.php?service=web-solutions">Web Solutions</a>
            <a class="nav-link" href="projects.php?service=mobile-applications">Mobile Applications</a>
            <a class="nav-link" href="projects.php?service=software-development">Software Development</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </aside>
        <main class="content">
            <div class="card">
                <h2><?= $editing ? "Edit team member" : "Add team member" ?></h2>
                <p class="muted">Shown on the public <a href="../about.php" target="_blank" rel="noopener noreferrer">About</a> page. Image: upload a file, or enter a full image URL / path like <code>assets/photo.jpg</code>.</p>
                <?php if ($error): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <?php if ($ok): ?><div style="margin-bottom:10px;color:#86efac;"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $editing ? (int) $editing["id"] : 0 ?>">
                    <div class="grid">
                        <div>
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" required value="<?= htmlspecialchars((string) ($editing["name"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="role">Role</label>
                            <input id="role" name="role" type="text" required placeholder="e.g. Founder, Developer" value="<?= htmlspecialchars((string) ($editing["role"] ?? "")) ?>">
                        </div>
                    </div>
                    <label for="profile_link">Profile link (LinkedIn or portfolio)</label>
                    <input id="profile_link" name="profile_link" type="url" required value="<?= htmlspecialchars((string) ($editing["profile_link"] ?? "")) ?>">
                    <label for="image_url_field">Image URL or path (if not uploading)</label>
                    <input id="image_url_field" name="image_url_field" type="text" placeholder="https://… or assets/team/name.jpg" value="<?= htmlspecialchars(preg_match('#^https?://#i', (string) ($editing["image_url"] ?? "")) ? (string) ($editing["image_url"] ?? "") : "") ?>">
                    <label for="photo">Photo file <?= $editing ? "(optional — replaces image)" : "" ?></label>
                    <input id="photo" name="photo" type="file" accept=".png,.jpg,.jpeg,.webp,.gif">
                    <div>
                        <label for="sort_order">Sort order (lower = first)</label>
                        <input id="sort_order" name="sort_order" type="number" value="<?= (int) ($editing["sort_order"] ?? 0) ?>">
                    </div>
                    <button class="btn" type="submit"><?= $editing ? "Update" : "Add" ?></button>
                    <?php if ($editing): ?>
                        <a class="btn btn-ghost" href="team.php">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h2>Team members</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Profile</th>
                                <th>Sort</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$members): ?>
                            <tr><td colspan="6" class="muted">No team members yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($members as $m): ?>
                                <tr>
                                    <td>
                                        <?php
                                        $src = (string) $m["image_url"];
                                        $imgSrc = preg_match('#^https?://#i', $src) ? $src : "../" . ltrim($src, "/");
                                        ?>
                                        <img class="logo-thumb" src="<?= htmlspecialchars($imgSrc) ?>" alt="">
                                    </td>
                                    <td><?= htmlspecialchars((string) $m["name"]) ?></td>
                                    <td><?= htmlspecialchars((string) $m["role"]) ?></td>
                                    <td><a href="<?= htmlspecialchars((string) $m["profile_link"]) ?>" target="_blank" rel="noopener noreferrer">Open</a></td>
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
        </main>
    </div>
</body>
</html>
