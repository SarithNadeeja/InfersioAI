<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";
require_once __DIR__ . "/../includes/admin_layout.php";
require_once __DIR__ . "/../includes/comments.php";

$user = admin_require_login();
if (!empty($user["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];
    if ($id > 0) {
        $del = $pdo->prepare("DELETE FROM visitor_comments WHERE id = :id");
        $del->execute(["id" => $id]);
    }
    header("Location: comments.php?ok=deleted");
    exit;
}

$comments = $pdo->query(
    "SELECT id, name, company, comment_text, created_at
     FROM visitor_comments
     ORDER BY created_at DESC"
)->fetchAll();
admin_page_start("Comments", "comments");
admin_page_header("Comments", "Visitor comments from the homepage.");
?>

            <div class="card">
                <h2>Homepage comments</h2>
                <?php if (isset($_GET["ok"])): ?>
                    <p class="alert-success">Comment removed.</p>
                <?php endif; ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$comments): ?>
                                <tr><td colspan="5" class="muted">No comments yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($comments as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["name"]) ?></td>
                                        <td><?= htmlspecialchars($row["company"]) ?></td>
                                        <td><?= nl2br(htmlspecialchars($row["comment_text"])) ?></td>
                                        <td><?= htmlspecialchars((string) $row["created_at"]) ?></td>
                                        <td>
                                            <a class="btn btn-danger" href="comments.php?delete=<?= (int) $row["id"] ?>" onclick="return confirm('Delete this comment?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

<?php admin_page_end(); ?>
