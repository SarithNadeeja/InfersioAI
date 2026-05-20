<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-auid-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App UI/UX Design — InfersioAI</title>
    <meta name="description" content="Mobile app UI and UX: research, wireframes, prototypes, redesigns, and usability optimization for engaging, high-performance interfaces.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="app-ui-ux-design.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-auid-page">
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
                            <li><a href="app-ui-ux-design.php" aria-current="page">App UI/UX Design</a></li>
                            <li><a href="app-maintenance.php">App Maintenance &amp; Updates</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="software-engineering.php">Software</a>
                        <ul class="dropdown">
                            <li><a href="desktop-application-development.php">Desktop Application Development (Windows / macOS)</a></li>
                            <li><a href="custom-business-software.php">Custom Business Software</a></li>
                            <li><a href="system-automation-tools.php">System Automation Tools</a></li>
                            <li><a href="api-development.php">API Development &amp; Integration</a></li>
                            <li><a href="cloud-software.php">Cloud-Based Software Solutions</a></li>
                        </ul>
                    </li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="auid-page">
        <section class="auid-hero" aria-label="App UI and UX design hero">
            <div class="auid-hero-inner">
                <div class="auid-hero-copy">
                    <h1 class="auid-hero-title">App UI/UX Design</h1>
                    <p class="auid-hero-lede">
                        We design intuitive and engaging mobile interfaces that enhance user experience and usability.
                    </p>
                    <div class="auid-hero-actions">
                        <a class="auid-hero-cta" href="#auid-cta">Get Started</a>
                    </div>
                </div>
                <div class="auid-hero-visual">
                    <img src="assets/mobile-ui.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="auid-about" aria-labelledby="auid-about-heading">
            <div class="auid-about-inner">
                <div class="auid-about-copy" data-reveal>
                    <p class="auid-section-label">Overview</p>
                    <h2 id="auid-about-heading" class="auid-about-title">Design That Engages Users</h2>
                    <p class="auid-about-text">
                        We create mobile app designs that are visually appealing, user-friendly, and optimized for engagement
                        and performance.
                    </p>
                </div>
                <div class="auid-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ios-app.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="auid-services" class="auid-services" aria-labelledby="auid-services-heading">
            <div class="auid-services-inner">
                <p class="auid-section-label" data-reveal>Services</p>
                <h2 id="auid-services-heading" class="auid-services-title" data-reveal style="--reveal-delay: 40ms">
                    How we help
                </h2>
                <p class="auid-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Research-backed flows, crisp visual systems, and iteration cycles that keep your product easy to learn and
                    hard to put down.
                </p>

                <div class="auid-grid">
                    <article class="auid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="auid-card-title">UI Design for Mobile Apps</h3>
                        <p class="auid-card-desc">
                            Component libraries, typography, and motion that feel native on iOS and Android.
                        </p>
                    </article>
                    <article class="auid-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="auid-card-title">UX Research</h3>
                        <p class="auid-card-desc">
                            Interviews, journeys, and testing so every screen solves a real user problem.
                        </p>
                    </article>
                    <article class="auid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="auid-card-title">Wireframing &amp; Prototyping</h3>
                        <p class="auid-card-desc">
                            Low to high fidelity flows you can validate before engineering commits at scale.
                        </p>
                    </article>
                    <article class="auid-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="auid-card-title">App Redesign</h3>
                        <p class="auid-card-desc">
                            Modernize legacy screens while preserving what users already understand.
                        </p>
                    </article>
                    <article class="auid-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="auid-card-title">Usability Optimization</h3>
                        <p class="auid-card-desc">
                            Heuristic review and targeted fixes to reduce friction and improve task success.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="auid-features" class="auid-features" aria-labelledby="auid-features-heading">
            <div class="auid-features-inner">
                <h2 id="auid-features-heading" class="auid-features-title" data-reveal>What you get</h2>
                <p class="auid-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Interfaces that balance beauty with clarity—so growth and retention follow naturally.
                </p>
                <div class="auid-features-grid">
                    <div class="auid-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="auid-feature-dot" aria-hidden="true"></span>
                        <span class="auid-feature-text">User-Centered Design</span>
                    </div>
                    <div class="auid-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="auid-feature-dot" aria-hidden="true"></span>
                        <span class="auid-feature-text">Modern UI Trends</span>
                    </div>
                    <div class="auid-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="auid-feature-dot" aria-hidden="true"></span>
                        <span class="auid-feature-text">Improved Engagement</span>
                    </div>
                    <div class="auid-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="auid-feature-dot" aria-hidden="true"></span>
                        <span class="auid-feature-text">Clean Navigation</span>
                    </div>
                    <div class="auid-feature-item auid-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="auid-feature-dot" aria-hidden="true"></span>
                        <span class="auid-feature-text">Performance Optimization</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="auid-cta" class="auid-cta" aria-labelledby="auid-cta-heading">
            <div class="auid-cta-inner" data-reveal>
                <h2 id="auid-cta-heading" class="auid-cta-title">Design Your Mobile Experience</h2>
                <p class="auid-cta-desc">
                    Share your app and audience—we’ll map a design direction that feels clear, on-brand, and effortless to use.
                </p>
                <div class="auid-cta-actions">
                    <a class="auid-btn-outline" href="contact.php">Contact Us</a>
                    <a class="auid-btn-outline auid-btn-invert" href="mailto:sales@infersioai.com?subject=App%20UI%2FUX%20Design">Start a Project</a>
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

    <div id="ai-auid-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-auid-robot-container";
        window.ROBOT_ASSISTANT_KEY = "appUiUxDesignPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-auid-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="app-ui-ux-design.js"></script>
</body>
</html>
