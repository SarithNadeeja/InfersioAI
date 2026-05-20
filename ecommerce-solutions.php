<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-ecom-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Solutions — InfersioAI</title>
    <meta name="description" content="Scalable online stores with secure payments, product and order management, and shopping experiences optimized for mobile and SEO.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ecommerce-solutions.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-ecom-page">
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
                            <li><a href="ecommerce-solutions.php" aria-current="page">E-Commerce Solutions</a></li>
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

    <main class="ecom-page">
        <section class="ecom-hero" aria-label="E-commerce solutions hero">
            <div class="ecom-hero-inner">
                <div class="ecom-hero-copy">
                    <h1 class="ecom-hero-title">E-Commerce Solutions</h1>
                    <p class="ecom-hero-lede">
                        We build scalable online stores that deliver seamless shopping experiences and drive sales.
                    </p>
                    <div class="ecom-hero-actions">
                        <a class="ecom-hero-cta" href="#ecom-cta">Get Started</a>
                    </div>
                </div>
                <div class="ecom-hero-visual">
                    <img src="assets/web-ecommerce.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="ecom-about" aria-labelledby="ecom-about-heading">
            <div class="ecom-about-inner">
                <div class="ecom-about-copy" data-reveal>
                    <p class="ecom-section-label">Overview</p>
                    <h2 id="ecom-about-heading" class="ecom-about-title">Sell Smarter Online</h2>
                    <p class="ecom-about-text">
                        We create modern e-commerce platforms with secure payment systems, optimized user experience, and
                        high-performance architecture.
                    </p>
                </div>
                <div class="ecom-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/web-main.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="ecom-services" class="ecom-services" aria-labelledby="ecom-services-heading">
            <div class="ecom-services-inner">
                <p class="ecom-section-label" data-reveal>Store capabilities</p>
                <h2 id="ecom-services-heading" class="ecom-services-title" data-reveal style="--reveal-delay: 40ms">
                    What we deliver
                </h2>
                <p class="ecom-services-intro" data-reveal style="--reveal-delay: 80ms">
                    End-to-end commerce—from catalog to checkout to fulfillment hooks—presented with a clean, product-first layout.
                </p>

                <div class="ecom-grid">
                    <article class="ecom-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="ecom-card-title">Online Store Development</h3>
                        <p class="ecom-card-desc">
                            Custom storefronts and themes aligned with your brand and conversion goals.
                        </p>
                    </article>
                    <article class="ecom-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="ecom-card-title">Payment Integration</h3>
                        <p class="ecom-card-desc">
                            Trusted gateways, PCI-minded flows, and the right mix of local and global methods.
                        </p>
                    </article>
                    <article class="ecom-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="ecom-card-title">Product Management Systems</h3>
                        <p class="ecom-card-desc">
                            Structured catalogs, variants, media, and merchandising rules your team can run day to day.
                        </p>
                    </article>
                    <article class="ecom-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="ecom-card-title">Shopping Cart Systems</h3>
                        <p class="ecom-card-desc">
                            Frictionless add-to-cart, promos, and recovery patterns that protect margin.
                        </p>
                    </article>
                    <article class="ecom-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="ecom-card-title">Order Management</h3>
                        <p class="ecom-card-desc">
                            Clear order states, notifications, and integrations with shipping and inventory.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="ecom-features" class="ecom-features" aria-labelledby="ecom-features-heading">
            <div class="ecom-features-inner">
                <h2 id="ecom-features-heading" class="ecom-features-title" data-reveal>Built for conversion &amp; trust</h2>
                <p class="ecom-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Standards shoppers expect and operators need—without clutter.
                </p>
                <div class="ecom-features-grid">
                    <div class="ecom-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ecom-feature-dot" aria-hidden="true"></span>
                        <span class="ecom-feature-text">Secure Payments</span>
                    </div>
                    <div class="ecom-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ecom-feature-dot" aria-hidden="true"></span>
                        <span class="ecom-feature-text">Fast Checkout Experience</span>
                    </div>
                    <div class="ecom-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="ecom-feature-dot" aria-hidden="true"></span>
                        <span class="ecom-feature-text">Mobile Optimization</span>
                    </div>
                    <div class="ecom-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="ecom-feature-dot" aria-hidden="true"></span>
                        <span class="ecom-feature-text">Scalable Platforms</span>
                    </div>
                    <div class="ecom-feature-item ecom-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="ecom-feature-dot" aria-hidden="true"></span>
                        <span class="ecom-feature-text">SEO Optimization</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="ecom-cta" class="ecom-cta" aria-labelledby="ecom-cta-heading">
            <div class="ecom-cta-inner" data-reveal>
                <h2 id="ecom-cta-heading" class="ecom-cta-title">Launch Your Online Store</h2>
                <p class="ecom-cta-desc">
                    Tell us your catalog, markets, and stack—we’ll design a store that sells and scales.
                </p>
                <div class="ecom-cta-actions">
                    <a class="ecom-btn-outline" href="contact.php">Contact Us</a>
                    <a class="ecom-btn-outline ecom-btn-invert" href="mailto:sales@infersioai.com?subject=E-Commerce%20Solutions">Start a Project</a>
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

    <div id="ai-ecom-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-ecom-robot-container";
        window.ROBOT_ASSISTANT_KEY = "ecommerceSolutionsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-ecom-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ecommerce-solutions.js"></script>
</body>
</html>
