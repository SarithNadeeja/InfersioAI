<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-dad-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desktop Application Development — InfersioAI</title>
    <meta name="description" content="Custom desktop applications for Windows and macOS: enterprise software, offline systems, native integration, and high-performance engineering.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="desktop-application-development.css">
</head>
<body id="page-top" class="ai-dad-page">
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
                            <li><a href="desktop-application-development.php" aria-current="page">Desktop Application Development (Windows / macOS)</a></li>
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

    <main class="dad-page">
        <section class="dad-hero" aria-label="Desktop application development hero">
            <div class="dad-hero-inner">
                <div class="dad-hero-copy">
                    <h1 class="dad-hero-title">Desktop Application Development</h1>
                    <p class="dad-hero-lede">
                        Build powerful desktop software with high performance and seamless system integration.
                    </p>
                    <div class="dad-hero-actions">
                        <a class="dad-hero-cta" href="#dad-cta">Get Started</a>
                    </div>
                </div>
                <div class="dad-hero-visual">
                    <img src="assets/desktop-app.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="dad-about" aria-labelledby="dad-about-heading">
            <div class="dad-about-inner">
                <div class="dad-about-copy" data-reveal>
                    <p class="dad-section-label">About</p>
                    <h2 id="dad-about-heading" class="dad-about-title">Powerful Desktop Solutions</h2>
                    <p class="dad-about-text">
                        We develop custom desktop applications designed for performance, reliability, and deep system-level functionality.
                    </p>
                </div>
                <div class="dad-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/desktop-app.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="dad-services" class="dad-services" aria-labelledby="dad-services-heading">
            <div class="dad-services-inner">
                <p class="dad-section-label" data-reveal>Services</p>
                <h2 id="dad-services-heading" class="dad-services-title" data-reveal style="--reveal-delay: 40ms">
                    What we deliver
                </h2>
                <p class="dad-services-intro" data-reveal style="--reveal-delay: 80ms">
                    From greenfield products to modernization of legacy tools—engineered for the desktop environments your teams depend on.
                </p>

                <div class="dad-grid">
                    <article class="dad-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="dad-card-title">Windows Applications</h3>
                        <p class="dad-card-desc">
                            Native and .NET-based Windows clients with installers, auto-update paths, and enterprise deployment (MSIX, Group Policy–friendly builds).
                        </p>
                    </article>
                    <article class="dad-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="dad-card-title">macOS Applications</h3>
                        <p class="dad-card-desc">
                            Swift and cross-platform macOS apps with sandboxing awareness, notarization-ready packaging, and polished Aqua-native UX patterns.
                        </p>
                    </article>
                    <article class="dad-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="dad-card-title">Enterprise Desktop Software</h3>
                        <p class="dad-card-desc">
                            Role-based tools, audit trails, and integrations with directory services and internal APIs—built for IT governance and scale.
                        </p>
                    </article>
                    <article class="dad-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="dad-card-title">Offline Systems</h3>
                        <p class="dad-card-desc">
                            Resilient local-first apps with sync strategies, conflict handling, and storage models that work when connectivity drops.
                        </p>
                    </article>
                    <article class="dad-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="dad-card-title">System Integration Tools</h3>
                        <p class="dad-card-desc">
                            Bridges to hardware, file systems, databases, and line-of-business apps—using stable IPC, drivers, and secure credential flows where needed.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="dad-features" class="dad-features" aria-labelledby="dad-features-heading">
            <div class="dad-features-inner">
                <h2 id="dad-features-heading" class="dad-features-title" data-reveal>Built for the desktop</h2>
                <p class="dad-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Performance and control where it matters—on the user’s machine and inside your perimeter.
                </p>
                <div class="dad-features-grid">
                    <div class="dad-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="dad-feature-dot" aria-hidden="true"></span>
                        <span class="dad-feature-text">High Performance</span>
                    </div>
                    <div class="dad-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="dad-feature-dot" aria-hidden="true"></span>
                        <span class="dad-feature-text">Native Integration</span>
                    </div>
                    <div class="dad-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="dad-feature-dot" aria-hidden="true"></span>
                        <span class="dad-feature-text">Secure Systems</span>
                    </div>
                    <div class="dad-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="dad-feature-dot" aria-hidden="true"></span>
                        <span class="dad-feature-text">Scalable Architecture</span>
                    </div>
                    <div class="dad-feature-item dad-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="dad-feature-dot" aria-hidden="true"></span>
                        <span class="dad-feature-text">Reliable Execution</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="dad-cta" class="dad-cta" aria-labelledby="dad-cta-heading">
            <div class="dad-cta-inner" data-reveal>
                <h2 id="dad-cta-heading" class="dad-cta-title">Develop Desktop Software</h2>
                <p class="dad-cta-desc">
                    Share your platform targets, compliance needs, and integration landscape—we’ll shape a delivery plan that fits your release cadence.
                </p>
                <div class="dad-cta-actions">
                    <a class="dad-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="dad-btn-outline dad-btn-invert" href="mailto:sales@infersioai.com?subject=Desktop%20Application%20Development">Start a Project</a>
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

    <div id="ai-dad-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-dad-robot-container";
        window.ROBOT_ASSISTANT_KEY = "desktopAppDevPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-dad-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="desktop-application-development.js"></script>
</body>
</html>
