<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-cpa-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cross-Platform App Development — InfersioAI</title>
    <meta name="description" content="Flutter and React Native development: one codebase for Android and iOS, polished UI/UX, performance tuning, and scalable mobile architecture.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cross-platform-apps.css">
</head>
<body id="page-top" class="ai-cpa-page">
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
                            <li><a href="cross-platform-apps.php" aria-current="page">Cross-Platform Apps (Flutter / React Native)</a></li>
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
                    <li><a href="index.php#about">About Us</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="cpa-page">
        <section class="cpa-hero" aria-label="Cross-platform app development hero">
            <div class="cpa-hero-inner">
                <div class="cpa-hero-copy">
                    <h1 class="cpa-hero-title">Cross-Platform App Development</h1>
                    <p class="cpa-hero-lede">
                        Build powerful mobile applications that run seamlessly on Android and iOS using a single codebase.
                    </p>
                    <div class="cpa-hero-actions">
                        <a class="cpa-hero-cta" href="#cpa-cta">Get Started</a>
                    </div>
                </div>
                <div class="cpa-hero-visual">
                    <img src="assets/cross-platform.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="cpa-about" aria-labelledby="cpa-about-heading">
            <div class="cpa-about-inner">
                <div class="cpa-about-copy" data-reveal>
                    <p class="cpa-section-label">Overview</p>
                    <h2 id="cpa-about-heading" class="cpa-about-title">One Codebase, Multiple Platforms</h2>
                    <p class="cpa-about-text">
                        We use modern frameworks like Flutter and React Native to build efficient applications that work across
                        platforms while maintaining performance and design quality.
                    </p>
                </div>
                <div class="cpa-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/mobile-main.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="cpa-services" class="cpa-services" aria-labelledby="cpa-services-heading">
            <div class="cpa-services-inner">
                <p class="cpa-section-label" data-reveal>Services</p>
                <h2 id="cpa-services-heading" class="cpa-services-title" data-reveal style="--reveal-delay: 40ms">
                    What we deliver
                </h2>
                <p class="cpa-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Shared business logic, native-feeling UI, and CI/CD that ships to both stores without doubling the work.
                </p>

                <div class="cpa-grid">
                    <article class="cpa-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="cpa-card-title">Flutter App Development</h3>
                        <p class="cpa-card-desc">
                            Expressive UIs, fast iteration, and a single Dart codebase for consistent behavior on every device.
                        </p>
                    </article>
                    <article class="cpa-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="cpa-card-title">React Native Apps</h3>
                        <p class="cpa-card-desc">
                            JavaScript and native modules where it matters—ideal for teams invested in the React ecosystem.
                        </p>
                    </article>
                    <article class="cpa-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="cpa-card-title">Multi-Platform Systems</h3>
                        <p class="cpa-card-desc">
                            Shared APIs, auth, and data layers with platform-specific polish only where users expect it.
                        </p>
                    </article>
                    <article class="cpa-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="cpa-card-title">UI/UX Optimization</h3>
                        <p class="cpa-card-desc">
                            Adaptive layouts, motion, and accessibility that feel at home on both Material and HIG patterns.
                        </p>
                    </article>
                    <article class="cpa-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="cpa-card-title">Performance Tuning</h3>
                        <p class="cpa-card-desc">
                            Startup time, jank reduction, bundle size, and memory—so your app stays smooth under real traffic.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="cpa-features" class="cpa-features" aria-labelledby="cpa-features-heading">
            <div class="cpa-features-inner">
                <h2 id="cpa-features-heading" class="cpa-features-title" data-reveal>Why teams choose cross-platform</h2>
                <p class="cpa-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Speed and consistency without giving up the quality bar your users expect.
                </p>
                <div class="cpa-features-grid">
                    <div class="cpa-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="cpa-feature-dot" aria-hidden="true"></span>
                        <span class="cpa-feature-text">Faster Development</span>
                    </div>
                    <div class="cpa-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="cpa-feature-dot" aria-hidden="true"></span>
                        <span class="cpa-feature-text">Cost Efficiency</span>
                    </div>
                    <div class="cpa-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="cpa-feature-dot" aria-hidden="true"></span>
                        <span class="cpa-feature-text">Cross-Device Compatibility</span>
                    </div>
                    <div class="cpa-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="cpa-feature-dot" aria-hidden="true"></span>
                        <span class="cpa-feature-text">Consistent UI/UX</span>
                    </div>
                    <div class="cpa-feature-item cpa-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="cpa-feature-dot" aria-hidden="true"></span>
                        <span class="cpa-feature-text">Scalable Architecture</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-cta" class="cpa-cta" aria-labelledby="cpa-cta-heading">
            <div class="cpa-cta-inner" data-reveal>
                <h2 id="cpa-cta-heading" class="cpa-cta-title">Build Cross-Platform Apps</h2>
                <p class="cpa-cta-desc">
                    Tell us about your product and release goals—we’ll recommend Flutter or React Native and a delivery plan that fits.
                </p>
                <div class="cpa-cta-actions">
                    <a class="cpa-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="cpa-btn-outline cpa-btn-invert" href="mailto:sales@infersioai.com?subject=Cross-Platform%20App%20Development">Start a Project</a>
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

    <div id="ai-cpa-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-cpa-robot-container";
        window.ROBOT_ASSISTANT_KEY = "crossPlatformAppsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-cpa-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="cross-platform-apps.js"></script>
</body>
</html>
