<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-web-solutions-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Solutions — InfersioAI</title>
    <meta name="description" content="Custom websites, web applications, e-commerce, and UI/UX—high-performance digital platforms built for scale and exceptional user experiences.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="web-solutions.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-web-solutions-page">
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
                        <a href="web-solutions.php" aria-current="page">Web Solutions</a>
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

    <main class="ws-page">
        <section class="ws-hero" aria-label="Web solutions hero">
            <div class="ws-hero-inner">
                <div class="ws-hero-copy">
                    <h1 class="ws-hero-title">Modern Web Solutions for Scalable Businesses</h1>
                    <p class="ws-hero-lede">
                        We design and develop high-performance websites and web applications that deliver exceptional user
                        experiences and drive business growth.
                    </p>
                    <div class="ws-hero-actions">
                        <a class="ws-hero-cta" href="#ws-cta">Get Started</a>
                    </div>
                </div>
                <div class="ws-hero-visual">
                    <img src="assets/web-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="ws-about" aria-labelledby="ws-about-heading">
            <div class="ws-about-inner">
                <div class="ws-about-copy" data-reveal>
                    <p class="ws-section-label">Overview</p>
                    <h2 id="ws-about-heading" class="ws-about-title">What Are Web Solutions?</h2>
                    <p class="ws-about-text">
                        Web solutions include the design, development, and optimization of digital platforms that represent
                        your business online. From simple websites to complex web applications, we create systems that are
                        fast, scalable, and user-focused.
                    </p>
                </div>
                <div class="ws-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/web-ui.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="ws-services" class="ws-offerings" aria-labelledby="ws-offerings-heading">
            <div class="ws-offerings-inner">
                <p class="ai-section-eyebrow" data-reveal>Capabilities</p>
                <h2 id="ws-offerings-heading" class="ai-section-title" data-reveal style="--reveal-delay: 40ms">Core offerings</h2>
                <p class="ws-offerings-lead" data-reveal style="--reveal-delay: 60ms">
                    Structured delivery from discovery to launch—clear scope, refined UX, and engineering you can build on.
                </p>

                <div class="ai-grid">
                    <article id="ws-card-custom-website" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/web-main.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Custom Website Development</h3>
                            <p class="ai-card-desc">
                                Professionally designed websites tailored to your brand, optimized for performance and user
                                experience.
                            </p>
                            <a class="ai-btn-outline" href="custom-website-development.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ws-card-web-app" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/web-app.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Web Application Development</h3>
                            <p class="ai-card-desc">
                                Custom-built web applications with advanced functionality, designed to meet complex business
                                requirements.
                            </p>
                            <a class="ai-btn-outline" href="web-application-development.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ws-card-ecommerce" class="ai-card" data-reveal style="--reveal-delay: 120ms">
                        <div class="ai-card-media">
                            <img src="assets/web-ecommerce.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">E-Commerce Solutions</h3>
                            <p class="ai-card-desc">
                                Scalable online stores with secure payment integration and seamless shopping experiences.
                            </p>
                            <a class="ai-btn-outline" href="ecommerce-solutions.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ws-card-uiux" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/web-ux.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">UI/UX Design &amp; Optimization</h3>
                            <p class="ai-card-desc">
                                User-centered design solutions that improve usability, engagement, and overall experience.
                            </p>
                            <a class="ai-btn-outline" href="ui-ux-design.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ws-card-maintenance" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/web-maintenance.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">Website Maintenance &amp; Support</h3>
                            <p class="ai-card-desc">
                                Ongoing support, updates, and performance optimization to keep your website running smoothly.
                            </p>
                            <a class="ai-btn-outline" href="website-maintenance.php">Learn More</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="ws-features" class="ws-features" aria-labelledby="ws-features-heading">
            <div class="ws-features-inner">
                <h2 id="ws-features-heading" class="ws-features-title" data-reveal>Built for quality &amp; reliability</h2>
                <p class="ws-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Standards we apply across every engagement—so your product stays fast, findable, and maintainable.
                </p>
                <div class="ws-features-grid">
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">Responsive Design</span>
                    </div>
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">High Performance Optimization</span>
                    </div>
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">Secure &amp; Scalable Architecture</span>
                    </div>
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">SEO-Friendly Development</span>
                    </div>
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">Modern UI/UX Standards</span>
                    </div>
                    <div class="ws-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ws-feature-dot" aria-hidden="true"></span>
                        <span class="ws-feature-text">Cross-Browser Compatibility</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="ws-cta" class="ws-cta" aria-labelledby="ws-cta-heading">
            <div class="ws-cta-inner" data-reveal>
                <h2 id="ws-cta-heading" class="ws-cta-title">Build a Powerful Online Presence</h2>
                <p class="ws-cta-desc">
                    Let us create a web solution that represents your business and drives real results.
                </p>
                <div class="ws-cta-actions">
                    <a class="ws-btn-outline" href="contact.php">Contact Us</a>
                    <a class="ws-btn-outline ws-btn-invert" href="mailto:sales@infersioai.com?subject=Web%20Solutions%20Project">Start Your Project</a>
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

    <div id="ai-web-solutions-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-web-solutions-robot-container";
        window.ROBOT_ASSISTANT_KEY = "webSolutionsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-web-solutions-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="web-solutions.js"></script>
</body>
</html>
