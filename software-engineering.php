<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-se-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Engineering — InfersioAI</title>
    <meta name="description" content="Advanced software engineering: desktop and business applications, automation, APIs, cloud systems, and scalable architecture for modern enterprises.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-solutions.css">
    <link rel="stylesheet" href="software-engineering.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-se-page">
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
                        <a href="software-engineering.php" aria-current="page">Software</a>
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

    <main class="se-page">
        <section class="se-hero" aria-label="Software engineering hero">
            <div class="se-hero-inner">
                <div class="se-hero-copy">
                    <h1 class="se-hero-title">Advanced Software Engineering Solutions</h1>
                    <p class="se-hero-lede">
                        We build scalable, high-performance software systems tailored to modern business needs.
                    </p>
                    <div class="se-hero-actions">
                        <a class="se-hero-cta" href="#se-cta">Get Started</a>
                    </div>
                </div>
                <div class="se-hero-visual">
                    <img src="assets/software-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="se-about" aria-labelledby="se-about-heading">
            <div class="se-about-inner">
                <div class="se-about-copy" data-reveal>
                    <p class="se-section-label">About</p>
                    <h2 id="se-about-heading" class="se-about-title">Powering Modern Business Systems</h2>
                    <p class="se-about-text">
                        We design and develop reliable software systems that handle complex operations, automate processes, and support business growth.
                    </p>
                </div>
                <div class="se-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/software-main2.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="se-services" class="ai-services" aria-labelledby="se-services-heading">
            <div class="ai-services-inner">
                <p class="ai-section-eyebrow">Capabilities</p>
                <h2 id="se-services-heading" class="ai-section-title">What we build</h2>

                <div class="ai-grid">
                    <article id="se-svc-desktop" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/desktop-app.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Desktop Application Development</h3>
                            <p class="ai-card-desc">
                                Native and cross-platform desktop apps for Windows and macOS—fast UIs, offline capability, and enterprise deployment options.
                            </p>
                            <a class="ai-btn-outline" href="desktop-application-development.php">Learn More</a>
                        </div>
                    </article>
                    <article id="se-svc-custom" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/software-system.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Custom Business Software</h3>
                            <p class="ai-card-desc">
                                Tailored systems for operations, finance, and customer workflows—built around your rules, roles, and reporting needs.
                            </p>
                            <a class="ai-btn-outline" href="custom-business-software.php">Learn More</a>
                        </div>
                    </article>
                    <article id="se-svc-automation" class="ai-card" data-reveal style="--reveal-delay: 120ms">
                        <div class="ai-card-media">
                            <img src="assets/automation-tools.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">System Automation Tools</h3>
                            <p class="ai-card-desc">
                                Scripts, schedulers, and pipelines that eliminate repetitive work and connect your tools with dependable automation.
                            </p>
                            <a class="ai-btn-outline" href="system-automation-tools.php">Learn More</a>
                        </div>
                    </article>
                    <article id="se-svc-api" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/api-dev.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">API Development &amp; Integration</h3>
                            <p class="ai-card-desc">
                                REST and event-driven APIs, partner integrations, and data sync layers with clear contracts and monitoring.
                            </p>
                            <a class="ai-btn-outline" href="api-development.php">Learn More</a>
                        </div>
                    </article>
                    <article id="se-svc-cloud" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/cloud-software.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Cloud-Based Software Solutions</h3>
                            <p class="ai-card-desc">
                                Cloud-native services with resilient hosting, scaling policies, and security practices aligned to your compliance goals.
                            </p>
                            <a class="ai-btn-outline" href="cloud-software.php">Learn More</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="se-features" class="se-features" aria-labelledby="se-features-heading">
            <div class="se-features-inner">
                <h2 id="se-features-heading" class="se-features-title" data-reveal>Engineering you can rely on</h2>
                <p class="se-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Architecture and delivery practices focused on longevity, security, and measurable performance.
                </p>
                <div class="se-features-grid">
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">Scalable Architecture</span>
                    </div>
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">Secure Systems</span>
                    </div>
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">High Performance</span>
                    </div>
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">API Integration</span>
                    </div>
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">Cloud Infrastructure</span>
                    </div>
                    <div class="se-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="se-feature-dot" aria-hidden="true"></span>
                        <span class="se-feature-text">Custom Business Logic</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="se-cta" class="se-cta" aria-labelledby="se-cta-heading">
            <div class="se-cta-inner" data-reveal>
                <h2 id="se-cta-heading" class="se-cta-title">Build Scalable Software Systems</h2>
                <p class="se-cta-desc">
                    Tell us about your workflows, users, and constraints—we’ll propose a technical plan that fits your budget and timeline.
                </p>
                <div class="se-cta-actions">
                    <a class="se-btn-outline" href="contact.php">Contact Us</a>
                    <a class="se-btn-outline se-btn-invert" href="mailto:sales@infersioai.com?subject=Software%20Engineering">Start a Project</a>
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

    <div id="ai-se-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-se-robot-container";
        window.ROBOT_ASSISTANT_KEY = "softwareEngineeringPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-se-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="software-engineering.js"></script>
</body>
</html>
