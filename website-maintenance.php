<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-wm-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Maintenance &amp; Support — InfersioAI</title>
    <meta name="description" content="Ongoing website maintenance: updates, performance tuning, security monitoring, bug fixes, and backup &amp; recovery—so your site stays fast and reliable.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="website-maintenance.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-wm-page">
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
                            <li><a href="website-maintenance.php" aria-current="page">Website Maintenance &amp; Support</a></li>
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

    <main class="wm-page">
        <section class="wm-hero" aria-label="Website maintenance hero">
            <div class="wm-hero-inner">
                <div class="wm-hero-copy">
                    <h1 class="wm-hero-title">Website Maintenance &amp; Support</h1>
                    <p class="wm-hero-lede">
                        Keep your website secure, updated, and performing at its best with ongoing support.
                    </p>
                    <div class="wm-hero-actions">
                        <a class="wm-hero-cta" href="#wm-cta">Get Started</a>
                    </div>
                </div>
                <div class="wm-hero-visual">
                    <img src="assets/web-maintenance.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="wm-about" aria-labelledby="wm-about-heading">
            <div class="wm-about-inner">
                <div class="wm-about-copy" data-reveal>
                    <p class="wm-section-label">Overview</p>
                    <h2 id="wm-about-heading" class="wm-about-title">Reliable Ongoing Support</h2>
                    <p class="wm-about-text">
                        We provide continuous monitoring, updates, and improvements to ensure your website runs smoothly
                        and securely.
                    </p>
                </div>
                <div class="wm-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/web-main.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="wm-services" class="wm-services" aria-labelledby="wm-services-heading">
            <div class="wm-services-inner">
                <p class="wm-section-label" data-reveal>Services</p>
                <h2 id="wm-services-heading" class="wm-services-title" data-reveal style="--reveal-delay: 40ms">
                    What we cover
                </h2>
                <p class="wm-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Proactive care for your stack—from content and dependency updates to observability and recovery plans.
                </p>

                <div class="wm-grid">
                    <article class="wm-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="wm-card-title">Website Updates</h3>
                        <p class="wm-card-desc">
                            CMS, plugins, themes, and dependencies kept current so you stay compatible and secure.
                        </p>
                    </article>
                    <article class="wm-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="wm-card-title">Performance Optimization</h3>
                        <p class="wm-card-desc">
                            Caching, assets, and server tuning to improve load times and Core Web Vitals.
                        </p>
                    </article>
                    <article class="wm-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="wm-card-title">Security Monitoring</h3>
                        <p class="wm-card-desc">
                            Uptime checks, SSL, hardening guidance, and alerts when something needs attention.
                        </p>
                    </article>
                    <article class="wm-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="wm-card-title">Bug Fixes</h3>
                        <p class="wm-card-desc">
                            Rapid triage and fixes for broken layouts, forms, integrations, and edge-case errors.
                        </p>
                    </article>
                    <article class="wm-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="wm-card-title">Backup &amp; Recovery</h3>
                        <p class="wm-card-desc">
                            Scheduled backups and tested restore paths so you can recover with confidence.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="wm-features" class="wm-features" aria-labelledby="wm-features-heading">
            <div class="wm-features-inner">
                <h2 id="wm-features-heading" class="wm-features-title" data-reveal>Why teams choose us</h2>
                <p class="wm-features-sub" data-reveal style="--reveal-delay: 50ms">
                    A partnership mindset—clear communication, predictable cadence, and measurable reliability.
                </p>
                <div class="wm-features-grid">
                    <div class="wm-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="wm-feature-dot" aria-hidden="true"></span>
                        <span class="wm-feature-text">24/7 Monitoring</span>
                    </div>
                    <div class="wm-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="wm-feature-dot" aria-hidden="true"></span>
                        <span class="wm-feature-text">Fast Issue Resolution</span>
                    </div>
                    <div class="wm-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="wm-feature-dot" aria-hidden="true"></span>
                        <span class="wm-feature-text">Secure Systems</span>
                    </div>
                    <div class="wm-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="wm-feature-dot" aria-hidden="true"></span>
                        <span class="wm-feature-text">Performance Tracking</span>
                    </div>
                    <div class="wm-feature-item wm-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="wm-feature-dot" aria-hidden="true"></span>
                        <span class="wm-feature-text">Continuous Improvements</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="wm-cta" class="wm-cta" aria-labelledby="wm-cta-heading">
            <div class="wm-cta-inner" data-reveal>
                <h2 id="wm-cta-heading" class="wm-cta-title">Keep Your Website Running Smoothly</h2>
                <p class="wm-cta-desc">
                    Tell us about your site and stack—we’ll propose a maintenance plan that fits your risk profile and goals.
                </p>
                <div class="wm-cta-actions">
                    <a class="wm-btn-outline" href="contact.php">Contact Us</a>
                    <a class="wm-btn-outline wm-btn-invert" href="mailto:sales@infersioai.com?subject=Website%20Maintenance%20%26%20Support">Request a Plan</a>
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

    <div id="ai-wm-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-wm-robot-container";
        window.ROBOT_ASSISTANT_KEY = "websiteMaintenancePageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-wm-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="website-maintenance.js"></script>
</body>
</html>
