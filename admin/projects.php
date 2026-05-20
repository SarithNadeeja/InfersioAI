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

$services = [
    "ai-solutions" => "AI Solutions",
    "web-solutions" => "Web Solutions",
    "mobile-applications" => "Mobile Applications",
    "software-development" => "Software Development",
];

$serviceCategories = [
    "ai-solutions" => [
        "AI Chatbots",
        "AI Automation Systems",
        "AI Agents",
        "AI Lead Generation Systems",
        "AI Content Automation",
        "AI Security / Monitoring",
    ],
    "web-solutions" => [
        "Custom Website Development",
        "Web Application Development",
        "E-Commerce Solutions",
        "UI/UX Design & Optimization",
        "Website Maintenance & Support",
    ],
    "mobile-applications" => [
        "Android App Development",
        "iOS App Development",
        "Cross-Platform Apps (Flutter / React Native)",
        "App UI/UX Design",
        "App Maintenance & Updates",
    ],
    "software-development" => [
        "Desktop Application Development (Windows / macOS)",
        "Custom Business Software",
        "System Automation Tools",
        "API Development & Integration",
        "Cloud-Based Software Solutions",
    ],
];

$service = (string) ($_GET["service"] ?? "ai-solutions");
if (!isset($services[$service])) {
    $service = "ai-solutions";
}

$error = "";
$ok = "";
$editing = null;
$editId = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;

if (isset($_GET["delete"])) {
    $deleteId = (int) $_GET["delete"];
    if ($deleteId > 0) {
        $stmt = $pdo->prepare("DELETE FROM service_projects WHERE id = :id AND service_type = :service");
        $stmt->execute([
            "id" => $deleteId,
            "service" => $service,
        ]);
        header("Location: projects.php?service=" . urlencode($service) . "&ok=deleted");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id"] ?? 0);
    $clientName = trim((string) ($_POST["client_name"] ?? ""));
    $clientWebsite = trim((string) ($_POST["client_website"] ?? ""));
    $category = trim((string) ($_POST["category"] ?? ""));
    $simpleDescription = trim((string) ($_POST["simple_description"] ?? ""));
    $engagementStartDate = (string) ($_POST["engagement_start_date"] ?? "");
    $deliveryDate = (string) ($_POST["delivery_date"] ?? "");
    $projectValue = (float) ($_POST["project_value"] ?? 0);
    $postedService = (string) ($_POST["service_type"] ?? "");

    if (!isset($services[$postedService])) {
        $error = "Invalid service category.";
    } else {
        $service = $postedService;
    }

    if (
        $error === "" &&
        ($clientName === "" || $clientWebsite === "" || $category === "" || $simpleDescription === "" || $engagementStartDate === "" || $deliveryDate === "")
    ) {
        $error = "All fields are required.";
    } elseif ($error === "" && !in_array($category, $serviceCategories[$service], true)) {
        $error = "Invalid category for selected service.";
    } elseif ($error === "" && !filter_var($clientWebsite, FILTER_VALIDATE_URL)) {
        $error = "Please provide a valid client website URL.";
    } elseif ($error === "" && strtotime($deliveryDate) < strtotime($engagementStartDate)) {
        $error = "Delivery Date cannot be earlier than Engagement Start Date.";
    } elseif ($error === "" && $projectValue < 0) {
        $error = "Project Value cannot be negative.";
    }

    if ($error === "") {
        if ($id > 0) {
            $stmt = $pdo->prepare(
                "UPDATE service_projects
                 SET category = :category,
                     simple_description = :simple_description,
                     client_name = :client_name,
                     client_website = :client_website,
                     engagement_start_date = :engagement_start_date,
                     delivery_date = :delivery_date,
                     project_value = :project_value,
                     updated_at = NOW()
                 WHERE id = :id AND service_type = :service"
            );
            $stmt->execute([
                "id" => $id,
                "service" => $service,
                "category" => $category,
                "simple_description" => $simpleDescription,
                "client_name" => $clientName,
                "client_website" => $clientWebsite,
                "engagement_start_date" => $engagementStartDate,
                "delivery_date" => $deliveryDate,
                "project_value" => $projectValue,
            ]);
            header("Location: projects.php?service=" . urlencode($service) . "&ok=updated");
            exit;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO service_projects (
                service_type, category, simple_description, client_name, client_website, engagement_start_date, delivery_date, project_value
             ) VALUES (
                :service_type, :category, :simple_description, :client_name, :client_website, :engagement_start_date, :delivery_date, :project_value
             )"
        );
        $stmt->execute([
            "service_type" => $service,
            "category" => $category,
            "simple_description" => $simpleDescription,
            "client_name" => $clientName,
            "client_website" => $clientWebsite,
            "engagement_start_date" => $engagementStartDate,
            "delivery_date" => $deliveryDate,
            "project_value" => $projectValue,
        ]);
        header("Location: projects.php?service=" . urlencode($service) . "&ok=added");
        exit;
    }
}

if ($editId > 0) {
    $stmt = $pdo->prepare(
        "SELECT *
         FROM service_projects
         WHERE id = :id AND service_type = :service
         LIMIT 1"
    );
    $stmt->execute([
        "id" => $editId,
        "service" => $service,
    ]);
    $editing = $stmt->fetch() ?: null;
}

$projectsStmt = $pdo->prepare(
    "SELECT *
     FROM service_projects
     WHERE service_type = :service
     ORDER BY created_at DESC"
);
$projectsStmt->execute(["service" => $service]);
$projects = $projectsStmt->fetchAll();

$okMap = [
    "added" => "Project saved successfully.",
    "updated" => "Project updated successfully.",
    "deleted" => "Project deleted successfully.",
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
    <title><?= htmlspecialchars($services[$service]) ?> - InfersioAI Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">InfersioAI Admin</div>
            <a class="nav-link" href="index.php">Dashboard</a>
            <a class="nav-link" href="clients.php">Client Manager</a>
            <a class="nav-link" href="team.php">Team (About)</a>
            <a class="nav-link <?= $service === "ai-solutions" ? "active" : "" ?>" href="projects.php?service=ai-solutions">AI Solutions</a>
            <a class="nav-link <?= $service === "web-solutions" ? "active" : "" ?>" href="projects.php?service=web-solutions">Web Solutions</a>
            <a class="nav-link <?= $service === "mobile-applications" ? "active" : "" ?>" href="projects.php?service=mobile-applications">Mobile Applications</a>
            <a class="nav-link <?= $service === "software-development" ? "active" : "" ?>" href="projects.php?service=software-development">Software Development</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </aside>
        <main class="content">
            <div class="card">
                <h2><?= htmlspecialchars($services[$service]) ?> Projects</h2>
                <?php if ($error): ?><div class="msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                <?php if ($ok): ?><div style="margin-bottom:10px;color:#86efac;"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $editing ? (int) $editing["id"] : 0 ?>">
                    <input type="hidden" name="service_type" value="<?= htmlspecialchars($service) ?>">
                    <div class="grid">
                        <div>
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select a category</option>
                                <?php foreach ($serviceCategories[$service] as $cat): ?>
                                    <?php $selected = ((string) ($editing["category"] ?? "")) === $cat ? "selected" : ""; ?>
                                    <option value="<?= htmlspecialchars($cat) ?>" <?= $selected ?>><?= htmlspecialchars($cat) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="client_name">Client Name</label>
                            <input id="client_name" name="client_name" type="text" required value="<?= htmlspecialchars((string) ($editing["client_name"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="client_website">Client Website</label>
                            <input id="client_website" name="client_website" type="url" required value="<?= htmlspecialchars((string) ($editing["client_website"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="engagement_start_date">Engagement Start Date</label>
                            <input id="engagement_start_date" name="engagement_start_date" type="date" required value="<?= htmlspecialchars((string) ($editing["engagement_start_date"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="delivery_date">Delivery Date</label>
                            <input id="delivery_date" name="delivery_date" type="date" required value="<?= htmlspecialchars((string) ($editing["delivery_date"] ?? "")) ?>">
                        </div>
                        <div>
                            <label for="project_value">Project Value</label>
                            <input id="project_value" name="project_value" type="number" min="0" step="0.01" required value="<?= htmlspecialchars((string) ($editing["project_value"] ?? "0.00")) ?>">
                        </div>
                    </div>
                    <label for="simple_description">Simple Description</label>
                    <textarea id="simple_description" name="simple_description" rows="3" required><?= htmlspecialchars((string) ($editing["simple_description"] ?? "")) ?></textarea>
                    <button class="btn" type="submit"><?= $editing ? "Update Project" : "Save Project" ?></button>
                    <?php if ($editing): ?>
                        <a class="btn btn-ghost" href="projects.php?service=<?= urlencode($service) ?>">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h2>Manage <?= htmlspecialchars($services[$service]) ?> Projects</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Client Name</th>
                                <th>Client Website</th>
                                <th>Simple Description</th>
                                <th>Engagement Start Date</th>
                                <th>Delivery Date</th>
                                <th>Project Value</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$projects): ?>
                            <tr><td colspan="8" class="muted">No projects added yet for this service.</td></tr>
                        <?php else: ?>
                            <?php foreach ($projects as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars((string) $p["category"]) ?></td>
                                    <td><?= htmlspecialchars($p["client_name"]) ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($p["client_website"]) ?>" target="_blank" rel="noopener noreferrer">
                                            <?= htmlspecialchars($p["client_website"]) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars((string) $p["simple_description"]) ?></td>
                                    <td><?= htmlspecialchars((string) $p["engagement_start_date"]) ?></td>
                                    <td><?= htmlspecialchars((string) $p["delivery_date"]) ?></td>
                                    <td>$<?= number_format((float) $p["project_value"], 2) ?></td>
                                    <td>
                                        <div class="row-actions">
                                            <a class="btn btn-ghost" href="projects.php?service=<?= urlencode($service) ?>&edit=<?= (int) $p["id"] ?>">Edit</a>
                                            <a class="btn btn-danger" href="projects.php?service=<?= urlencode($service) ?>&delete=<?= (int) $p["id"] ?>" onclick="return confirm('Delete this project?')">Remove</a>
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
