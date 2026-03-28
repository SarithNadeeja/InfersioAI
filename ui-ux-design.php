<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-uxd-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI/UX Design &amp; Optimization — InfersioAI</title>
    <meta name="description" content="User-centered UI design, UX research, prototyping, usability optimization, and redesigns—modern aesthetics with accessibility and performance in mind.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ui-ux-design.css">
</head>
<body id="page-top" class="ai-uxd-page">
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
                            <li><a href="ui-ux-design.php" aria-current="page">UI/UX Design &amp; Optimization</a></li>
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

    <main class="uxd-page">
        <section class="uxd-hero" aria-label="UI and UX design hero">
            <div class="uxd-hero-inner">
                <div class="uxd-hero-copy">
                    <h1 class="uxd-hero-title">UI/UX Design &amp; Optimization</h1>
                    <p class="uxd-hero-lede">
                        We design intuitive, user-focused experiences that enhance engagement and usability.
                    </p>
                    <div class="uxd-hero-actions">
                        <a class="uxd-hero-cta" href="#uxd-cta">Get Started</a>
                    </div>
                </div>
                <div class="uxd-hero-visual">
                    <img src="assets/web-ux.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="uxd-about" aria-labelledby="uxd-about-heading">
            <div class="uxd-about-inner">
                <div class="uxd-about-copy" data-reveal>
                    <p class="uxd-section-label">Overview</p>
                    <h2 id="uxd-about-heading" class="uxd-about-title">Design That Works</h2>
                    <p class="uxd-about-text">
                        Great design is not just about visuals—it’s about usability, clarity, and user satisfaction. We create
                        interfaces that are both functional and engaging.
                    </p>
                </div>
                <div class="uxd-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/web-main.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="uxd-services" class="uxd-services" aria-labelledby="uxd-services-heading">
            <div class="uxd-services-inner">
                <p class="uxd-section-label" data-reveal>Services</p>
                <h2 id="uxd-services-heading" class="uxd-services-title" data-reveal style="--reveal-delay: 40ms">
                    How we help
                </h2>
                <p class="uxd-services-intro" data-reveal style="--reveal-delay: 80ms">
                    A focused process—research, structure, visual design, and iteration—so every screen earns its place.
                </p>

                <div class="uxd-grid">
                    <article class="uxd-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="uxd-card-title">UI Design</h3>
                        <p class="uxd-card-desc">
                            Cohesive visual systems, components, and layouts that reinforce your brand and hierarchy.
                        </p>
                    </article>
                    <article class="uxd-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="uxd-card-title">UX Research</h3>
                        <p class="uxd-card-desc">
                            Interviews, journeys, and testing to ground decisions in real user needs and behavior.
                        </p>
                    </article>
                    <article class="uxd-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="uxd-card-title">Wireframing &amp; Prototyping</h3>
                        <p class="uxd-card-desc">
                            Low to high fidelity flows you can validate before engineering invests at scale.
                        </p>
                    </article>
                    <article class="uxd-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="uxd-card-title">Usability Optimization</h3>
                        <p class="uxd-card-desc">
                            Heuristic review and targeted fixes to reduce friction and sharpen task completion.
                        </p>
                    </article>
                    <article class="uxd-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="uxd-card-title">Interface Redesign</h3>
                        <p class="uxd-card-desc">
                            Modernize legacy UIs while preserving what users already understand and trust.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="uxd-features" class="uxd-features" aria-labelledby="uxd-features-heading">
            <div class="uxd-features-inner">
                <h2 id="uxd-features-heading" class="uxd-features-title" data-reveal>What you get</h2>
                <p class="uxd-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Outcomes that balance polish with measurable usability—not decoration for its own sake.
                </p>
                <div class="uxd-features-grid">
                    <div class="uxd-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="uxd-feature-dot" aria-hidden="true"></span>
                        <span class="uxd-feature-text">User-Centered Design</span>
                    </div>
                    <div class="uxd-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="uxd-feature-dot" aria-hidden="true"></span>
                        <span class="uxd-feature-text">Modern Aesthetics</span>
                    </div>
                    <div class="uxd-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="uxd-feature-dot" aria-hidden="true"></span>
                        <span class="uxd-feature-text">Improved Conversion Rates</span>
                    </div>
                    <div class="uxd-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="uxd-feature-dot" aria-hidden="true"></span>
                        <span class="uxd-feature-text">Accessibility Focus</span>
                    </div>
                    <div class="uxd-feature-item uxd-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="uxd-feature-dot" aria-hidden="true"></span>
                        <span class="uxd-feature-text">Performance Optimization</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="uxd-cta" class="uxd-cta" aria-labelledby="uxd-cta-heading">
            <div class="uxd-cta-inner" data-reveal>
                <h2 id="uxd-cta-heading" class="uxd-cta-title">Improve Your User Experience</h2>
                <p class="uxd-cta-desc">
                    Share your product and audience—we’ll map a design path that feels clear, fast, and on-brand.
                </p>
                <div class="uxd-cta-actions">
                    <a class="uxd-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="uxd-btn-outline uxd-btn-invert" href="mailto:sales@infersioai.com?subject=UI%2FUX%20Design%20%26%20Optimization">Start a Project</a>
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

    <div id="ai-uxd-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-uxd-robot-container";
        window.ROBOT_ASSISTANT_KEY = "uiUxDesignPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-uxd-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ui-ux-design.js"></script>
</body>
</html>
