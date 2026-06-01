<?php
declare(strict_types=1);

$allowedRequirements = [
    'general' => 'General',
    'ai' => 'AI Solutions',
    'web' => 'Web Solutions',
    'mobile' => 'Mobile Applications',
    'software' => 'Software / Engineering',
    'other' => 'Other',
];

$flash = null;
$flashType = null;

if (isset($_GET['sent']) && $_GET['sent'] === '1') {
    $flash = 'Thank you — we received your message and will get back to you soon.';
    $flashType = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $requirement = (string) ($_POST['requirement'] ?? '');
    $message = trim((string) ($_POST['message'] ?? ''));
    $consent = isset($_POST['consent']);

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $flash = 'Please enter your name and a valid email address.';
        $flashType = 'error';
    } elseif (!array_key_exists($requirement, $allowedRequirements)) {
        $flash = 'Please select a requirement type.';
        $flashType = 'error';
    } elseif (!$consent) {
        $flash = 'Please confirm you agree to be contacted.';
        $flashType = 'error';
    } else {
        $reqLabel = $allowedRequirements[$requirement];
        $subject = '[InfersioAI Contact] ' . $reqLabel . ' — ' . $name;
        $bodyLines = [
            'Name: ' . $name,
            'Email: ' . $email,
            'Phone: ' . ($phone !== '' ? $phone : '—'),
            'Requirement: ' . $reqLabel,
            '',
            'Message:',
            $message !== '' ? $message : '—',
        ];
        $body = implode("\r\n", $bodyLines);
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'From: InfersioAI <sales@infersioai.com>',
            'Reply-To: ' . $email,
        ];
        $to = 'sales@infersioai.com';
        $sent = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("\r\n", $headers));
        if ($sent) {
            header('Location: contact.php?sent=1', true, 303);
            exit;
        }
        $flash = 'We could not send the message from this server. Please email us directly at sales@infersioai.com.';
        $flashType = 'error';
    }
}

$navCurrent = "contact";
?>
<!DOCTYPE html>
<html lang="en" class="contact-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us — InfersioAI</title>
    <meta name="description" content="Get in touch with InfersioAI. Questions, project inquiries, and support — we are here to help.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body id="page-top" class="contact-page">
    <header class="site-header">
        <div class="container">
            <a class="logo" href="index.php">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <?php require __DIR__ . "/includes/site-nav.php"; ?>
            </nav>
        </div>
    </header>

    <main class="contact-page-main">
        <section class="contact-hero" aria-labelledby="contact-hero-heading">
            <h1 id="contact-hero-heading" class="contact-hero-title">Let’s Talk</h1>
            <p class="contact-hero-lede">
                Have questions or need assistance? Contact us today. We’re here to help with your inquiries and provide the best support possible.
            </p>
        </section>

        <div class="contact-split">
            <div class="contact-form-panel">
                <?php if ($flash !== null): ?>
                    <div class="contact-flash contact-flash--<?= $flashType === 'success' ? 'success' : 'error' ?>" role="alert">
                        <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form class="contact-orel-form" method="post" action="contact.php" novalidate>
                    <div>
                        <label class="field-label" for="contact-name">Name</label>
                        <input id="contact-name" name="name" type="text" autocomplete="name" placeholder="Name" value="<?= htmlspecialchars((string) ($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label class="field-label" for="contact-email">E-Mail</label>
                        <input id="contact-email" name="email" type="email" autocomplete="email" placeholder="E-Mail" value="<?= htmlspecialchars((string) ($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label class="field-label" for="contact-phone">Phone Number</label>
                        <input id="contact-phone" name="phone" type="tel" autocomplete="tel" placeholder="Phone Number" value="<?= htmlspecialchars((string) ($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div>
                        <label class="field-label" for="contact-requirement">Tell us your requirement</label>
                        <select id="contact-requirement" name="requirement" required>
                            <?php
                            $sel = (string) ($_POST['requirement'] ?? 'general');
                            foreach ($allowedRequirements as $value => $label):
                            ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"<?= $sel === $value ? ' selected' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="field-label" for="contact-message">Your message</label>
                        <textarea id="contact-message" name="message" rows="5" placeholder="Your message"><?= htmlspecialchars((string) ($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                    <label class="contact-consent">
                        <input type="checkbox" name="consent" value="1" <?= isset($_POST['consent']) ? ' checked' : '' ?> required>
                        <span>I agree to be contacted regarding my inquiry.</span>
                    </label>
                    <button type="submit" class="contact-submit">Send message</button>
                </form>
            </div>

            <aside class="contact-info-panel" aria-label="Contact details">
                <div class="contact-info-block">
                    <h3>Global Sales</h3>
                    <div class="contact-info-row">
                        <svg class="contact-info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <a href="mailto:sales@infersioai.com">sales@infersioai.com</a>
                    </div>
                    <div class="contact-info-row">
                        <svg class="contact-info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                            <line x1="12" y1="18" x2="12.01" y2="18"/>
                        </svg>
                        <span>+94 707 023 213</span>
                    </div>
                </div>
                <div class="contact-info-block">
                    <h3>General</h3>
                    <div class="contact-info-row">
                        <svg class="contact-info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <a href="mailto:info@infersioai.com">info@infersioai.com</a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <footer class="site-footer ai-site-footer" aria-label="Footer">
        <div class="container footer-social-container">
            <div class="footer-social-top">
                <h2 class="footer-social-title">CHECK OUT OUR SOCIAL HANDLES</h2>
                <div class="footer-social-decor" aria-hidden="true">
                    <span class="footer-social-line"></span>
                    <span class="footer-social-v">∨</span>
                    <span class="footer-social-line"></span>
                </div>

                <div class="footer-social-icons">
                    <a class="social-item" href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <span class="social-pill"><span class="social-icon">in</span></span>
                        <span class="social-label">LinkedIn</span>
                    </a>
                    <a class="social-item" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <span class="social-pill"><span class="social-icon">f</span></span>
                        <span class="social-label">Facebook</span>
                    </a>
                    <a class="social-item" href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <span class="social-pill"><span class="social-icon">ig</span></span>
                        <span class="social-label">Instagram</span>
                    </a>
                    <a class="social-item" href="https://twitter.com/" target="_blank" rel="noopener noreferrer" aria-label="X">
                        <span class="social-pill"><span class="social-icon">X</span></span>
                        <span class="social-label">X</span>
                    </a>
                    <a class="social-item" href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <span class="social-pill"><span class="social-icon">▶</span></span>
                        <span class="social-label">YouTube</span>
                    </a>
                </div>

                <div class="footer-brand">
                    <div class="footer-brand-name">INFERSIOAI</div>
                    <div class="footer-brand-tagline">Leveraging technology to empower humanity.</div>
                </div>
            </div>

            <div class="footer-social-bottom">
                <div class="footer-bottom-left">
                    © <?= date('Y') ?> InfersioAI. All rights reserved.
                    <a class="footer-privacy" href="#privacy" onclick="return false;">Privacy Policy</a>
                </div>
                <div class="footer-bottom-right">
                    <a class="footer-contact" href="mailto:sales@infersioai.com">sales@infersioai.com</a>
                    <span class="footer-dot">•</span>
                    <span class="footer-contact">Phone: +94 707 023 213</span>
                    <a class="footer-backtop" href="#page-top" aria-label="Back to top">↑</a>
                </div>
            </div>
        </div>
    </footer>

    <div id="ai-contact-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="script.js"></script>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-contact-robot-container";
        window.ROBOT_ASSISTANT_KEY = "contactPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-contact-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
</body>
</html>
