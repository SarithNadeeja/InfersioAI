<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-apid-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Development &amp; Integration — InfersioAI</title>
    <meta name="description" content="REST APIs, third-party integration, data synchronization, and backend API systems—secure, scalable, and built for reliable connectivity.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="api-development.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-apid-page">
    <header class="site-header">
        <div class="container">
            <a class="logo" href="index.php#home">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <ul class="nav-menu">
                    <li><a href="index.php#home">Home</a></li>
                    <li class="has-dropdown">
                        <a href="ai-solutions.php">AI Solutions</a>
                        <ul class="dropdown">
                            <li><a href="ai-chatbots.php">AI Chatbots</a></li>
                            <li><a href="ai-automation.php">AI Automation Systems</a></li>
                            <li><a href="ai-agents.php">AI Agents</a></li>
                            <li><a href="ai-lead-generation.php">AI Lead Generation Systems</a></li>
                            <li><a href="ai-content-automation.php">AI Content Automation</a></li>
                            <li><a href="ai-security.php">AI Security / Monitoring</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="web-solutions.php">Web Solutions</a>
                        <ul class="dropdown">
                            <li><a href="custom-website-development.php">Custom Website Development</a></li>
                            <li><a href="web-application-development.php">Web Application Development</a></li>
                            <li><a href="ecommerce-solutions.php">E-Commerce Solutions</a></li>
                            <li><a href="ui-ux-design.php">UI/UX Design &amp; Optimization</a></li>
                            <li><a href="website-maintenance.php">Website Maintenance &amp; Support</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="mobile-applications.php">Mobile Applications</a>
                        <ul class="dropdown">
                            <li><a href="android-app-development.php">Android App Development</a></li>
                            <li><a href="ios-app-development.php">iOS App Development</a></li>
                            <li><a href="cross-platform-apps.php">Cross-Platform Apps (Flutter / React Native)</a></li>
                            <li><a href="app-ui-ux-design.php">App UI/UX Design</a></li>
                            <li><a href="app-maintenance.php">App Maintenance &amp; Updates</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="software-engineering.php">Software</a>
                        <ul class="dropdown">
                            <li><a href="desktop-application-development.php">Desktop Application Development (Windows / macOS)</a></li>
                            <li><a href="custom-business-software.php">Custom Business Software</a></li>
                            <li><a href="system-automation-tools.php">System Automation Tools</a></li>
                            <li><a href="api-development.php" aria-current="page">API Development &amp; Integration</a></li>
                            <li><a href="cloud-software.php">Cloud-Based Software Solutions</a></li>
                        </ul>
                    </li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="apid-page">
        <section class="apid-hero" aria-label="API development hero">
            <div class="apid-hero-inner">
                <div class="apid-hero-copy">
                    <h1 class="apid-hero-title">API Development &amp; Integration</h1>
                    <p class="apid-hero-lede">
                        Connect your systems and enable seamless data flow across platforms.
                    </p>
                    <div class="apid-hero-actions">
                        <a class="apid-hero-cta" href="#apid-cta">Get Started</a>
                    </div>
                </div>
                <div class="apid-hero-visual">
                    <img src="assets/api-dev.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="apid-about" aria-labelledby="apid-about-heading">
            <div class="apid-about-inner">
                <div class="apid-about-copy" data-reveal>
                    <p class="apid-section-label">About</p>
                    <h2 id="apid-about-heading" class="apid-about-title">Seamless System Connectivity</h2>
                    <p class="apid-about-text">
                        We design and integrate APIs that allow systems to communicate efficiently and securely.
                    </p>
                </div>
                <div class="apid-about-visual" data-reveal style="--reveal-delay: 90ms">
                    <img src="assets/api-dev.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="apid-services" class="apid-services" aria-labelledby="apid-services-heading">
            <div class="apid-services-inner">
                <p class="apid-section-label" data-reveal>Services</p>
                <h2 id="apid-services-heading" class="apid-services-title" data-reveal style="--reveal-delay: 45ms">
                    What we deliver
                </h2>
                <p class="apid-services-intro" data-reveal style="--reveal-delay: 90ms">
                    Contract-first APIs, observability, and integration patterns that stay maintainable as your ecosystem grows.
                </p>

                <div class="apid-grid">
                    <article class="apid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="apid-card-title">REST API Development</h3>
                        <p class="apid-card-desc">
                            Versioned REST surfaces with clear schemas, error models, and documentation your partners can actually use.
                        </p>
                    </article>
                    <article class="apid-card" data-reveal style="--reveal-delay: 70ms">
                        <h3 class="apid-card-title">API Integration</h3>
                        <p class="apid-card-desc">
                            Connect internal services and products with stable contracts, auth flows, and rollout strategies that reduce breakage.
                        </p>
                    </article>
                    <article class="apid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="apid-card-title">Third-Party Integration</h3>
                        <p class="apid-card-desc">
                            Payments, CRM, ERP, and SaaS connectors—implemented with webhooks, polling fallbacks, and idempotent handlers.
                        </p>
                    </article>
                    <article class="apid-card" data-reveal style="--reveal-delay: 70ms">
                        <h3 class="apid-card-title">Data Synchronization Systems</h3>
                        <p class="apid-card-desc">
                            Incremental sync, conflict rules, and reconciliation jobs so distributed data stays trustworthy over time.
                        </p>
                    </article>
                    <article class="apid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="apid-card-title">Backend API Systems</h3>
                        <p class="apid-card-desc">
                            Service layers, gateways, and policy enforcement—performance-tuned and ready for traffic spikes.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="apid-features" class="apid-features" aria-labelledby="apid-features-heading">
            <div class="apid-features-inner">
                <h2 id="apid-features-heading" class="apid-features-title" data-reveal>Engineering for connectivity</h2>
                <p class="apid-features-sub" data-reveal style="--reveal-delay: 55ms">
                    APIs your teams can extend without fear—and your security team can stand behind.
                </p>
                <div class="apid-features-grid">
                    <div class="apid-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="apid-feature-dot" aria-hidden="true"></span>
                        <span class="apid-feature-text">Secure Data Transfer</span>
                    </div>
                    <div class="apid-feature-item" data-reveal style="--reveal-delay: 45ms">
                        <span class="apid-feature-dot" aria-hidden="true"></span>
                        <span class="apid-feature-text">Scalable APIs</span>
                    </div>
                    <div class="apid-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="apid-feature-dot" aria-hidden="true"></span>
                        <span class="apid-feature-text">High Performance</span>
                    </div>
                    <div class="apid-feature-item" data-reveal style="--reveal-delay: 45ms">
                        <span class="apid-feature-dot" aria-hidden="true"></span>
                        <span class="apid-feature-text">Reliable Integration</span>
                    </div>
                    <div class="apid-feature-item apid-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="apid-feature-dot" aria-hidden="true"></span>
                        <span class="apid-feature-text">Flexible Architecture</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="apid-cta" class="apid-cta" aria-labelledby="apid-cta-heading">
            <div class="apid-cta-inner" data-reveal>
                <h2 id="apid-cta-heading" class="apid-cta-title">Integrate Your Systems</h2>
                <p class="apid-cta-desc">
                    Share your current stack and integration goals—we’ll propose contracts, tooling, and a delivery sequence that de-risks cutover.
                </p>
                <div class="apid-cta-actions">
                    <a class="apid-btn-outline" href="contact.php">Contact Us</a>
                    <a class="apid-btn-outline apid-btn-invert" href="mailto:sales@infersioai.com?subject=API%20Development%20%26%20Integration">Start a Project</a>
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

    <div id="ai-apid-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-apid-robot-container";
        window.ROBOT_ASSISTANT_KEY = "apiDevelopmentPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-apid-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="api-development.js"></script>
</body>
</html>
