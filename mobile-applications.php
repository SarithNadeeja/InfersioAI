<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-mobile-apps-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Applications — InfersioAI</title>
    <meta name="description" content="Native and cross-platform mobile apps for Android and iOS—performance-focused engineering, refined UI/UX, and ongoing support.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mobile-applications.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-mobile-apps-page">
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
                        <a href="mobile-applications.php" aria-current="page">Mobile Applications</a>
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

    <main class="ma-page">
        <section class="ma-hero" aria-label="Mobile applications hero">
            <div class="ma-hero-inner">
                <div class="ma-hero-copy">
                    <h1 class="ma-hero-title">High-Performance Mobile Applications</h1>
                    <p class="ma-hero-lede">
                        We design and develop powerful mobile applications that deliver seamless user experiences across
                        devices and platforms.
                    </p>
                    <div class="ma-hero-actions">
                        <a class="ma-hero-cta" href="#ma-cta">Get Started</a>
                        <a class="ma-hero-demo" href="#ma-services">View Apps</a>
                    </div>
                </div>
                <div class="ma-hero-visual">
                    <img src="assets/mobile-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="ma-about" aria-labelledby="ma-about-heading">
            <div class="ma-about-inner">
                <div class="ma-about-copy" data-reveal>
                    <p class="ma-section-label">Overview</p>
                    <h2 id="ma-about-heading" class="ma-about-title">What Are Mobile Applications?</h2>
                    <p class="ma-about-text">
                        Mobile applications are powerful tools that allow businesses to connect with users directly on their
                        devices. From native apps to cross-platform solutions, we build applications that are fast, reliable,
                        and user-focused.
                    </p>
                </div>
                <div class="ma-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/mobile-ui.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="ma-services" class="ma-offerings" aria-labelledby="ma-offerings-heading">
            <div class="ma-offerings-inner">
                <p class="ai-section-eyebrow" data-reveal>Capabilities</p>
                <h2 id="ma-offerings-heading" class="ai-section-title" data-reveal style="--reveal-delay: 40ms">Core offerings</h2>
                <p class="ma-offerings-lead" data-reveal style="--reveal-delay: 60ms">
                    From platform-specific builds to shared codebases—delivery that balances speed, quality, and long-term
                    maintainability.
                </p>

                <div class="ai-grid">
                    <article id="ma-card-android" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/android-app.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Android App Development</h3>
                            <p class="ai-card-desc">
                                Develop high-performance Android applications tailored to your business needs.
                            </p>
                            <a class="ai-btn-outline" href="android-app-development.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ma-card-ios" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/ios-app.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">iOS App Development</h3>
                            <p class="ai-card-desc">
                                Create seamless and responsive iOS applications optimized for Apple devices.
                            </p>
                            <a class="ai-btn-outline" href="ios-app-development.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ma-card-cross-platform" class="ai-card" data-reveal style="--reveal-delay: 120ms">
                        <div class="ai-card-media">
                            <img src="assets/cross-platform.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Cross-Platform Apps (Flutter / React Native)</h3>
                            <p class="ai-card-desc">
                                Build apps that run on multiple platforms using a single codebase for faster deployment.
                            </p>
                            <a class="ai-btn-outline" href="cross-platform-apps.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ma-card-uiux" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/mobile-ui.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">App UI/UX Design</h3>
                            <p class="ai-card-desc">
                                Design intuitive and engaging mobile interfaces that enhance user experience.
                            </p>
                            <a class="ai-btn-outline" href="app-ui-ux-design.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ma-card-maintenance" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/mobile-maintenance.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">App Maintenance &amp; Updates</h3>
                            <p class="ai-card-desc">
                                Ensure your app stays updated, secure, and optimized with ongoing support and improvements.
                            </p>
                            <a class="ai-btn-outline" href="app-maintenance.php">Learn More</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="ma-features" class="ma-features" aria-labelledby="ma-features-heading">
            <div class="ma-features-inner">
                <h2 id="ma-features-heading" class="ma-features-title" data-reveal>Engineering &amp; design standards</h2>
                <p class="ma-features-sub" data-reveal style="--reveal-delay: 50ms">
                    What we prioritize on every build—so your app feels polished today and stays adaptable tomorrow.
                </p>
                <div class="ma-features-grid">
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">Responsive &amp; Adaptive Design</span>
                    </div>
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">High Performance Optimization</span>
                    </div>
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">Secure Architecture</span>
                    </div>
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">Cross-Platform Compatibility</span>
                    </div>
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">User-Centered Design</span>
                    </div>
                    <div class="ma-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ma-feature-dot" aria-hidden="true"></span>
                        <span class="ma-feature-text">Scalable Solutions</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="ma-cta" class="ma-cta" aria-labelledby="ma-cta-heading">
            <div class="ma-cta-inner" data-reveal>
                <h2 id="ma-cta-heading" class="ma-cta-title">Build Your Next Mobile Application</h2>
                <p class="ma-cta-desc">
                    Let us create a mobile experience that connects your business with users everywhere.
                </p>
                <div class="ma-cta-actions">
                    <a class="ma-btn-outline" href="contact.php">Contact Us</a>
                    <a class="ma-btn-outline ma-btn-invert" href="mailto:sales@infersioai.com?subject=Mobile%20Application%20Project">Start Your Project</a>
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

    <div id="ai-mobile-apps-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-mobile-apps-robot-container";
        window.ROBOT_ASSISTANT_KEY = "mobileApplicationsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-mobile-apps-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="mobile-applications.js"></script>
</body>
</html>
