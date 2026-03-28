<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-automation-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Automation Systems — InfersioAI</title>
    <meta name="description" content="AI-powered automation for workflows, integrations, and operations—reduce manual work and scale with intelligent systems.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-automation.css">
</head>
<body id="page-top" class="ai-automation-page">
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
                            <li><a href="ai-automation.php" aria-current="page">AI Automation Systems</a></li>
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

    <main class="automation-page">
        <section class="automation-hero" aria-label="AI automation hero">
            <div class="automation-hero-inner">
                <div class="automation-hero-copy">
                    <h1 class="automation-hero-title">AI-Powered Automation for Smarter Operations</h1>
                    <p class="automation-hero-lede">
                        We design intelligent automation systems that streamline workflows, reduce manual effort,
                        and improve operational efficiency.
                    </p>
                    <div class="automation-hero-actions">
                        <a class="automation-hero-cta" href="#automation-cta">Get Started</a>
                    </div>
                </div>
                <div class="automation-hero-visual">
                    <img src="assets/ai-automation-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="automation-about" aria-labelledby="automation-about-heading">
            <div class="automation-about-inner">
                <div class="automation-about-copy" data-reveal>
                    <p class="automation-section-label">Overview</p>
                    <h2 id="automation-about-heading" class="automation-about-title">What is AI Automation?</h2>
                    <p class="automation-about-text">
                        AI automation systems integrate artificial intelligence into your business processes to handle
                        repetitive tasks, process data, and execute workflows efficiently. These systems operate behind
                        the scenes, connecting tools and services to create seamless, automated operations.
                    </p>
                </div>
                <div class="automation-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ai-workflow.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="automation-services" class="automation-services" aria-labelledby="automation-services-heading">
            <div class="automation-services-inner">
                <p class="automation-section-label" data-reveal>Capabilities</p>
                <h2 id="automation-services-heading" class="automation-services-title" data-reveal style="--reveal-delay: 40ms">
                    Automation solutions
                </h2>
                <p class="automation-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Backend-first systems that connect your stack, move data reliably, and remove manual handoffs—without
                    replacing human judgment where it matters.
                </p>

                <div class="automation-grid">
                    <article class="automation-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="automation-card-title">Business Process Automation</h3>
                        <p class="automation-card-desc">
                            Automate repetitive tasks such as data entry, reporting, and internal workflows.
                        </p>
                    </article>
                    <article class="automation-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="automation-card-title">Document Processing Systems</h3>
                        <p class="automation-card-desc">
                            Extract, analyze, and process information from invoices, PDFs, and documents using AI.
                        </p>
                    </article>
                    <article class="automation-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="automation-card-title">Email Automation Systems</h3>
                        <p class="automation-card-desc">
                            Automatically categorize, respond, and manage emails using intelligent automation.
                        </p>
                    </article>
                    <article class="automation-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="automation-card-title">CRM &amp; System Integration</h3>
                        <p class="automation-card-desc">
                            Connect AI systems with your CRM, databases, and business tools for seamless operations.
                        </p>
                    </article>
                    <article class="automation-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="automation-card-title">Data Processing &amp; Analysis</h3>
                        <p class="automation-card-desc">
                            Automate data collection, analysis, and reporting to generate insights quickly.
                        </p>
                    </article>
                    <article class="automation-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="automation-card-title">Customer Support Automation Pipelines</h3>
                        <p class="automation-card-desc">
                            Create automated workflows that handle customer requests efficiently across systems.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="automation-features" class="automation-features" aria-labelledby="automation-features-heading">
            <div class="automation-features-inner">
                <h2 id="automation-features-heading" class="automation-features-title" data-reveal>Engineering highlights</h2>
                <p class="automation-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Built for reliability, observability, and secure integration with your existing operations.
                </p>
                <div class="automation-features-grid">
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">Workflow Automation</span>
                    </div>
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">Real-Time Data Processing</span>
                    </div>
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">API Integrations</span>
                    </div>
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">Scalable Systems</span>
                    </div>
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">Secure Data Handling</span>
                    </div>
                    <div class="automation-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="automation-feature-dot" aria-hidden="true"></span>
                        <span class="automation-feature-text">Custom Business Logic</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="automation-cta" class="automation-cta" aria-labelledby="automation-cta-heading">
            <div class="automation-cta-inner" data-reveal>
                <h2 id="automation-cta-heading" class="automation-cta-title">Optimize Your Business with Intelligent Automation</h2>
                <p class="automation-cta-desc">
                    Let us design systems that simplify your operations and maximize efficiency.
                </p>
                <div class="automation-cta-actions">
                    <a class="automation-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="automation-btn-outline automation-btn-invert" href="mailto:sales@infersioai.com?subject=AI%20Automation%20Consultation">Book Consultation</a>
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

    <div id="ai-automation-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-automation-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiAutomationPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-automation-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ai-automation.js"></script>
</body>
</html>
