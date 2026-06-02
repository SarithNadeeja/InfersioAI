<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";
require_once __DIR__ . "/../includes/admin_layout.php";

$currentUser = admin_require_login();
if (!empty($currentUser["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

$currentId = (int) $currentUser["id"];
$error = "";
$ok = "";
$editing = null;
$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;

if (isset($_GET["delete"])) {
    $deleteId = (int) $_GET["delete"];
    if ($deleteId > 0) {
        $deleteError = admin_delete_user($deleteId, $currentId);
        if ($deleteError !== null) {
            header("Location: users.php?error=" . urlencode($deleteError));
        } else {
            header("Location: users.php?ok=deleted");
        }
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");
    $id = (int) ($_POST["id"] ?? 0);
    $username = trim((string) ($_POST["username"] ?? ""));
    $password = (string) ($_POST["password"] ?? "");
    $confirm = (string) ($_POST["confirm_password"] ?? "");

    $usernameError = admin_validate_username($username);
    if ($usernameError !== null) {
        $error = $usernameError;
    } elseif (admin_username_taken($username, $id)) {
        $error = "That username is already in use.";
    } elseif ($action === "create") {
        $passwordError = admin_validate_password($password, $confirm);
        if ($passwordError !== null) {
            $error = $passwordError;
        } elseif ($username === "admin" && $password === "admin") {
            $error = "Do not use the temporary default admin / admin credentials.";
        } else {
            admin_create_user($username, $password);
            header("Location: users.php?ok=added");
            exit;
        }
    } elseif ($action === "update" && $id > 0) {
        if ($password !== "" || $confirm !== "") {
            $passwordError = admin_validate_password($password, $confirm);
            if ($passwordError !== null) {
                $error = $passwordError;
            } else {
                admin_update_user($id, $username, $password);
                if ($id === $currentId) {
                    admin_session_start();
                    $_SESSION["admin_user_id"] = $currentId;
                }
                header("Location: users.php?ok=updated");
                exit;
            }
        } else {
            admin_update_user($id, $username, null);
            header("Location: users.php?ok=updated");
            exit;
        }
    } else {
        $error = "Invalid request.";
    }

    if ($error !== "" && $id > 0) {
        $editId = $id;
    }
}

if ($editId > 0) {
    $stmt = $pdo->prepare(
        "SELECT id, username, must_change_password, created_at::text AS created_at
         FROM admin_users WHERE id = :id LIMIT 1"
    );
    $stmt->execute(["id" => $editId]);
    $editing = $stmt->fetch() ?: null;
}

$users = admin_list_users();

$okMap = [
    "added" => "User added successfully.",
    "updated" => "User updated successfully.",
    "deleted" => "User removed successfully.",
];
if (!empty($_GET["ok"]) && isset($okMap[$_GET["ok"]])) {
    $ok = $okMap[$_GET["ok"]];
}
if (!empty($_GET["error"])) {
    $error = (string) $_GET["error"];
}

admin_page_start("Users", "users");
admin_page_header("Admin users", "Add, remove, and update usernames and passwords.");
?>

            <div class="card">
                <h2>Add user</h2>
                <?php if ($error && !$editing): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <?php if ($ok && !$editing): ?><div class="alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <form method="post" autocomplete="off">
                    <input type="hidden" name="action" value="create">
                    <div class="grid">
                        <div>
                            <label for="add_username">Username</label>
                            <input id="add_username" name="username" type="text" required minlength="3" maxlength="80" value="<?= htmlspecialchars((string) ($_POST["username"] ?? "")) ?>">
                        </div>
                    </div>
                    <div class="grid">
                        <div>
                            <label for="add_password">Password</label>
                            <input id="add_password" name="password" type="password" minlength="8" required autocomplete="new-password">
                        </div>
                        <div>
                            <label for="add_confirm_password">Confirm password</label>
                            <input id="add_confirm_password" name="confirm_password" type="password" minlength="8" required autocomplete="new-password">
                        </div>
                    </div>
                    <button class="btn" type="submit">Add user</button>
                </form>
            </div>

            <?php if ($editing): ?>
            <div class="card">
                <h2>Edit user</h2>
                <?php if ($error): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <p class="muted">
                    Updating <strong><?= htmlspecialchars((string) $editing["username"]) ?></strong>
                    <?php if ((int) $editing["id"] === $currentId): ?>
                        (your account)
                    <?php endif; ?>
                </p>
                <form method="post" autocomplete="off">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= (int) $editing["id"] ?>">
                    <label for="edit_username">Username</label>
                    <input id="edit_username" name="username" type="text" required minlength="3" maxlength="80" value="<?= htmlspecialchars((string) ($editing["username"] ?? "")) ?>">
                    <p class="muted" style="margin: 12px 0 8px;">Leave password fields empty to keep the current password.</p>
                    <div class="grid">
                        <div>
                            <label for="edit_password">New password</label>
                            <input id="edit_password" name="password" type="password" minlength="8" autocomplete="new-password">
                        </div>
                        <div>
                            <label for="edit_confirm_password">Confirm new password</label>
                            <input id="edit_confirm_password" name="confirm_password" type="password" minlength="8" autocomplete="new-password">
                        </div>
                    </div>
                    <button class="btn" type="submit">Save changes</button>
                    <a class="btn btn-ghost" href="users.php">Cancel</a>
                </form>
            </div>
            <?php endif; ?>

            <div class="card">
                <h2>All users</h2>
                <?php if ($ok && $editing): ?><div class="alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$users): ?>
                            <tr><td colspan="4" class="muted">No users found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($users as $row): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars((string) $row["username"]) ?>
                                        <?php if ((int) $row["id"] === $currentId): ?>
                                            <span class="muted">(you)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row["must_change_password"])): ?>
                                            <span class="muted">Must complete setup</span>
                                        <?php else: ?>
                                            Active
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars((string) $row["created_at"]) ?></td>
                                    <td>
                                        <div class="row-actions">
                                            <a class="btn btn-ghost" href="users.php?edit=<?= (int) $row["id"] ?>">Edit</a>
                                            <?php if ((int) $row["id"] !== $currentId): ?>
                                                <a
                                                    class="btn btn-danger"
                                                    href="users.php?delete=<?= (int) $row["id"] ?>"
                                                    onclick="return confirm('Remove this user?')"
                                                >Remove</a>
                                            <?php endif; ?>
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
