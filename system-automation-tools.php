<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-sat-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Automation Tools — InfersioAI</title>
    <meta name="description" content="System automation tools: task and workflow automation, data processing, email automation, and integration automation for reliable operations.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="system-automation-tools.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-sat-page">
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
                            <li><a href="desktop-application-development.php">Desktop Application Development (Windows / macOS)</a></li>
                            <li><a href="custom-business-software.php">Custom Business Software</a></li>
                            <li><a href="system-automation-tools.php" aria-current="page">System Automation Tools</a></li>
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

    <main class="sat-page">
        <section class="sat-hero" aria-label="System automation tools hero">
            <div class="sat-hero-inner">
                <div class="sat-hero-copy">
                    <h1 class="sat-hero-title">System Automation Tools</h1>
                    <p class="sat-hero-lede">
                        Automate repetitive tasks and streamline operations with intelligent software tools.
                    </p>
                    <div class="sat-hero-actions">
                        <a class="sat-hero-cta" href="#sat-cta">Get Started</a>
                    </div>
                </div>
                <div class="sat-hero-visual">
                    <img src="assets/automation-tools.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="sat-about" aria-labelledby="sat-about-heading">
            <div class="sat-about-inner">
                <div class="sat-about-copy" data-reveal>
                    <p class="sat-section-label">About</p>
                    <h2 id="sat-about-heading" class="sat-about-title">Automate Your Workflow</h2>
                    <p class="sat-about-text">
                        We build automation tools that reduce manual work, improve efficiency, and ensure consistency across operations.
                    </p>
                </div>
                <div class="sat-about-visual" data-reveal style="--reveal-delay: 90ms">
                    <img src="assets/automation-tools.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="sat-services" class="sat-services" aria-labelledby="sat-services-heading">
            <div class="sat-services-inner">
                <p class="sat-section-label" data-reveal>Services</p>
                <h2 id="sat-services-heading" class="sat-services-title" data-reveal style="--reveal-delay: 45ms">
                    What we automate
                </h2>
                <p class="sat-services-intro" data-reveal style="--reveal-delay: 90ms">
                    Reliable pipelines and schedulers with observability—so your team trusts what runs in the background.
                </p>

                <div class="sat-grid">
                    <article class="sat-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="sat-card-title">Task Automation Tools</h3>
                        <p class="sat-card-desc">
                            Cron-style jobs, queues, and bots that replace copy-paste work with repeatable, auditable runs.
                        </p>
                    </article>
                    <article class="sat-card" data-reveal style="--reveal-delay: 70ms">
                        <h3 class="sat-card-title">Workflow Automation</h3>
                        <p class="sat-card-desc">
                            Multi-step flows with approvals, branching, and SLAs—designed so teams see status without chasing updates.
                        </p>
                    </article>
                    <article class="sat-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="sat-card-title">Data Processing Systems</h3>
                        <p class="sat-card-desc">
                            ETL, validation, and enrichment pipelines that keep downstream systems clean and consistent.
                        </p>
                    </article>
                    <article class="sat-card" data-reveal style="--reveal-delay: 70ms">
                        <h3 class="sat-card-title">Email Automation Tools</h3>
                        <p class="sat-card-desc">
                            Templated sends, triggers, and routing rules that scale without sacrificing compliance or deliverability.
                        </p>
                    </article>
                    <article class="sat-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="sat-card-title">Integration Automation</h3>
                        <p class="sat-card-desc">
                            Connect SaaS, APIs, and on-prem systems with resilient sync, retries, and idempotent handlers.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="sat-features" class="sat-features" aria-labelledby="sat-features-heading">
            <div class="sat-features-inner">
                <h2 id="sat-features-heading" class="sat-features-title" data-reveal>Built for dependable automation</h2>
                <p class="sat-features-sub" data-reveal style="--reveal-delay: 55ms">
                    Operations that stay fast as volume grows—and fail gracefully when something goes wrong.
                </p>
                <div class="sat-features-grid">
                    <div class="sat-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="sat-feature-dot" aria-hidden="true"></span>
                        <span class="sat-feature-text">Time Efficiency</span>
                    </div>
                    <div class="sat-feature-item" data-reveal style="--reveal-delay: 45ms">
                        <span class="sat-feature-dot" aria-hidden="true"></span>
                        <span class="sat-feature-text">Error Reduction</span>
                    </div>
                    <div class="sat-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="sat-feature-dot" aria-hidden="true"></span>
                        <span class="sat-feature-text">Scalable Systems</span>
                    </div>
                    <div class="sat-feature-item" data-reveal style="--reveal-delay: 45ms">
                        <span class="sat-feature-dot" aria-hidden="true"></span>
                        <span class="sat-feature-text">Seamless Integration</span>
                    </div>
                    <div class="sat-feature-item sat-feature-item--wide" data-reveal style="--reveal-delay: 0ms">
                        <span class="sat-feature-dot" aria-hidden="true"></span>
                        <span class="sat-feature-text">High Reliability</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="sat-cta" class="sat-cta" aria-labelledby="sat-cta-heading">
            <div class="sat-cta-inner" data-reveal>
                <h2 id="sat-cta-heading" class="sat-cta-title">Automate Your Systems</h2>
                <p class="sat-cta-desc">
                    Describe the tasks you want off your plate—we’ll map triggers, owners, and safeguards before we write a line of code.
                </p>
                <div class="sat-cta-actions">
                    <a class="sat-btn-outline" href="contact.php">Contact Us</a>
                    <a class="sat-btn-outline sat-btn-invert" href="mailto:sales@infersioai.com?subject=System%20Automation%20Tools">Start a Project</a>
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

    <div id="ai-sat-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-sat-robot-container";
        window.ROBOT_ASSISTANT_KEY = "systemAutomationToolsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-sat-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="system-automation-tools.js"></script>
</body>
</html>
