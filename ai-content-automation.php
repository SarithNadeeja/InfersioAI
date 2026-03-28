<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-content-auto-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Content Automation — InfersioAI</title>
    <meta name="description" content="AI-powered content automation: create, schedule, optimize, and distribute marketing content at scale—consistent brand voice across channels.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-content-automation.css">
</head>
<body id="page-top" class="ai-content-auto-page">
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
                            <li><a href="ai-content-automation.php" aria-current="page">AI Content Automation</a></li>
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

    <main class="content-auto-page">
        <section class="content-auto-hero" aria-label="AI content automation hero">
            <div class="content-auto-hero-inner">
                <div class="content-auto-hero-copy">
                    <h1 class="content-auto-hero-title">AI-Powered Content Automation</h1>
                    <p class="content-auto-hero-lede">
                        Create, manage, and scale your content effortlessly with intelligent AI systems designed for
                        modern businesses.
                    </p>
                    <div class="content-auto-hero-actions">
                        <a class="content-auto-hero-cta" href="#content-auto-cta">Get Started</a>
                    </div>
                </div>
                <div class="content-auto-hero-visual">
                    <img src="assets/ai-content-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="content-auto-about" aria-labelledby="content-auto-about-heading">
            <div class="content-auto-about-inner">
                <div class="content-auto-about-copy" data-reveal>
                    <p class="content-auto-section-label">Overview</p>
                    <h2 id="content-auto-about-heading" class="content-auto-about-title">What is AI Content Automation?</h2>
                    <p class="content-auto-about-text">
                        AI content automation systems generate, optimize, and manage content across multiple platforms.
                        From blog posts to social media updates, these systems help businesses maintain consistent and
                        high-quality content without manual effort.
                    </p>
                </div>
                <div class="content-auto-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ai-content-system.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="content-auto-services" class="content-auto-services" aria-labelledby="content-auto-services-heading">
            <div class="content-auto-services-inner">
                <p class="content-auto-section-label" data-reveal>Services</p>
                <h2 id="content-auto-services-heading" class="content-auto-services-title" data-reveal style="--reveal-delay: 40ms">
                    Content systems for creation &amp; distribution
                </h2>
                <p class="content-auto-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Production, optimization, and publishing pipelines built for marketing teams—so you ship more quality
                    content with less overhead.
                </p>

                <div class="content-auto-grid">
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="content-auto-card-title">AI Blog Content Generation</h3>
                        <p class="content-auto-card-desc">
                            Automatically generate high-quality blog posts tailored to your business and audience.
                        </p>
                    </article>
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="content-auto-card-title">Social Media Content Automation</h3>
                        <p class="content-auto-card-desc">
                            Create and schedule engaging social media posts across platforms.
                        </p>
                    </article>
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="content-auto-card-title">Email Content Automation</h3>
                        <p class="content-auto-card-desc">
                            Generate personalized email campaigns and automated sequences.
                        </p>
                    </article>
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="content-auto-card-title">Content Scheduling Systems</h3>
                        <p class="content-auto-card-desc">
                            Plan and publish content consistently using automated scheduling tools.
                        </p>
                    </article>
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="content-auto-card-title">SEO Content Optimization</h3>
                        <p class="content-auto-card-desc">
                            Optimize content using AI to improve visibility and search rankings.
                        </p>
                    </article>
                    <article class="content-auto-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="content-auto-card-title">Multi-Platform Content Distribution</h3>
                        <p class="content-auto-card-desc">
                            Automatically distribute content across websites, social media, and marketing channels.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="content-auto-features" class="content-auto-features" aria-labelledby="content-auto-features-heading">
            <div class="content-auto-features-inner">
                <h2 id="content-auto-features-heading" class="content-auto-features-title" data-reveal>What you get</h2>
                <p class="content-auto-features-sub" data-reveal style="--reveal-delay: 50ms">
                    End-to-end support for producing and publishing content that stays on-brand and measurable.
                </p>
                <div class="content-auto-features-grid">
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">Automated Content Creation</span>
                    </div>
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">Content Scheduling &amp; Publishing</span>
                    </div>
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">SEO Optimization</span>
                    </div>
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">Multi-Platform Integration</span>
                    </div>
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">Consistent Brand Voice</span>
                    </div>
                    <div class="content-auto-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="content-auto-feature-dot" aria-hidden="true"></span>
                        <span class="content-auto-feature-text">Scalable Content Systems</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="content-auto-cta" class="content-auto-cta" aria-labelledby="content-auto-cta-heading">
            <div class="content-auto-cta-inner" data-reveal>
                <h2 id="content-auto-cta-heading" class="content-auto-cta-title">Scale Your Content Strategy with AI</h2>
                <p class="content-auto-cta-desc">
                    Let us build a content system that keeps your brand active and visible.
                </p>
                <div class="content-auto-cta-actions">
                    <a class="content-auto-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="content-auto-btn-outline content-auto-btn-invert" href="mailto:sales@infersioai.com?subject=AI%20Content%20Automation%20Project">Start a Project</a>
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

    <div id="ai-content-auto-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-content-auto-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiContentAutomationPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-content-auto-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ai-content-automation.js"></script>
</body>
</html>
