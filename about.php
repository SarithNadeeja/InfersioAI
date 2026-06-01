<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$navCurrent = "about";
$clientLogos = public_clients();
$teamMembers = public_team_members();
?>
<!DOCTYPE html>
<html lang="en" class="about-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us — InfersioAI</title>
    <meta name="description" content="InfersioAI builds intelligent digital solutions—AI, software engineering, web, and mobile. Meet our team and explore how we help businesses transform.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="about.css">
</head>
<body id="page-top" class="about-page">
    <header class="site-header">
        <div class="container">
            <a class="logo" href="index.php">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <?php require __DIR__ . "/includes/site-nav.php"; ?>
            </nav>
        </div>
    </header>

    <main class="about-main">
        <section class="about-hero" aria-label="About InfersioAI">
            <div class="about-hero-inner">
                <div class="about-hero-copy about-reveal">
                    <p class="about-hero-eyebrow">About InfersioAI</p>
                    <h1 class="about-hero-title">Building Intelligent Digital Solutions</h1>
                    <p class="about-hero-sub">
                        InfersioAI is a modern technology company focused on AI, software engineering, and digital transformation.
                    </p>
                    <p class="about-hero-founded">Founded in 2026</p>
                </div>
                <div class="about-hero-visual about-reveal" style="--about-reveal-delay: 80ms">
                    <img src="assets/aboutus.png" alt="" width="1200" height="900" decoding="async">
                </div>
            </div>
        </section>

        <section class="about-section" aria-labelledby="about-overview-heading">
            <div class="about-container">
                <h2 id="about-overview-heading" class="about-section-title about-reveal">Who We Are</h2>
                <div class="about-overview-grid">
                    <div class="about-reveal" style="--about-reveal-delay: 60ms">
                        <p class="about-section-lead">
                            InfersioAI is a forward-thinking technology company specializing in artificial intelligence, web development,
                            mobile applications, and software engineering. We design and build intelligent systems that help businesses
                            automate operations, improve efficiency, and scale effectively.
                        </p>
                    </div>
                    <div class="about-overview-visual about-reveal" style="--about-reveal-delay: 120ms">
                        <img src="assets/whoweare.png" alt="" width="960" height="720" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section about-section--mission" aria-labelledby="about-mission-heading">
            <div class="about-container">
                <h2 id="about-mission-heading" class="about-section-title about-reveal">Our Mission</h2>
                <div class="about-mission-card about-reveal" style="--about-reveal-delay: 70ms">
                    <p class="about-section-lead">
                        Our mission is to empower businesses with intelligent, scalable, and future-ready digital solutions.
                        We combine design, development, and AI to create systems that deliver real impact.
                    </p>
                </div>
            </div>
        </section>

        <section class="about-section about-section--team" aria-labelledby="about-team-heading">
            <div class="about-container">
                <h2 id="about-team-heading" class="about-section-title about-reveal">Our Team</h2>
                <p class="about-section-lead about-team-intro about-reveal" style="--about-reveal-delay: 50ms">
                    A team of developers, designers, and engineers dedicated to building innovative digital solutions.
                </p>

                <?php if (!$teamMembers): ?>
                    <p class="about-team-empty about-reveal" style="--about-reveal-delay: 80ms">
                        Team profiles will appear here once added in the admin panel.
                    </p>
                <?php else: ?>
                    <div class="about-team-grid">
                        <?php foreach ($teamMembers as $i => $member): ?>
                            <?php
                            $imgSrc = (string) ($member["image_url"] ?? "");
                            $profile = (string) ($member["profile_link"] ?? "#");
                            $delay = min(40 + $i * 50, 240);
                            ?>
                            <article class="about-team-card about-reveal" style="--about-reveal-delay: <?= (int) $delay ?>ms">
                                <a class="about-team-photo-link"
                                   href="<?= htmlspecialchars($profile) ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="<?= htmlspecialchars((string) $member["name"]) ?> — view profile">
                                    <img src="<?= htmlspecialchars($imgSrc) ?>"
                                         alt=""
                                         width="400"
                                         height="400"
                                         loading="lazy"
                                         decoding="async">
                                </a>
                                <div class="about-team-body">
                                    <h3 class="about-team-name"><?= htmlspecialchars((string) $member["name"]) ?></h3>
                                    <p class="about-team-role"><?= htmlspecialchars((string) $member["role"]) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="about-section about-section--clients" aria-labelledby="about-clients-heading">
            <div class="about-container">
                <div class="about-clients-head about-reveal">
                    <h2 id="about-clients-heading" class="about-section-title">Trusted by Clients</h2>
                </div>
                <?php if (!$clientLogos): ?>
                    <p class="about-client-empty about-reveal" style="--about-reveal-delay: 60ms">
                        Client logos from the admin panel will appear here.
                    </p>
                <?php else: ?>
                    <div class="about-client-logo-grid about-reveal" style="--about-reveal-delay: 80ms">
                        <?php foreach ($clientLogos as $client): ?>
                            <a class="about-client-logo-card"
                               href="<?= htmlspecialchars((string) $client["company_website"]) ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               title="<?= htmlspecialchars((string) $client["company_name"]) ?>">
                                <div class="about-client-logo-card-inner">
                                    <img src="<?= htmlspecialchars((string) $client["logo_path"]) ?>"
                                         alt="<?= htmlspecialchars((string) $client["company_name"]) ?> logo"
                                         loading="lazy"
                                         decoding="async">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="about-section about-section--cta" aria-labelledby="about-cta-heading">
            <div class="about-container">
                <div class="about-cta-inner about-reveal">
                    <h2 id="about-cta-heading" class="about-section-title">Let’s Build Something Great Together</h2>
                    <p class="about-section-lead">
                        Whether you have a clear idea or need guidance, we’re here to help.
                    </p>
                    <div class="about-cta-actions">
                        <a class="about-btn-outline" href="contact.php">Contact Us</a>
                        <a class="about-btn-outline" href="mailto:sales@infersioai.com?subject=Project%20Inquiry">Start a Project</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section about-section--platforms" aria-labelledby="about-platforms-heading">
            <div class="about-container">
                <h2 id="about-platforms-heading" class="about-section-title about-reveal">Work With Us</h2>
                <p class="about-section-lead about-platform-desc about-reveal" style="--about-reveal-delay: 50ms">
                    You can also find us on leading freelance platforms.
                </p>
                <div class="about-platform-actions about-reveal" style="--about-reveal-delay: 100ms">
                    <a class="about-btn-outline"
                       href="https://www.fiverr.com/s/DBvkrpA"
                       target="_blank"
                       rel="noopener noreferrer">Fiverr</a>
                    <a class="about-btn-outline"
                       href="https://www.upwork.com/freelancers/~01fffe103875c2e12f?mp_source=share"
                       target="_blank"
                       rel="noopener noreferrer">Upwork</a>
                </div>
            </div>
        </section>
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
                    © <?= date("Y") ?> InfersioAI. All rights reserved.
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

    <div id="ai-about-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="script.js"></script>
    <script src="about.js"></script>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-about-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aboutPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-about-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
</body>
</html>
