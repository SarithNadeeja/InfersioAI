<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-agents-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Agents — InfersioAI</title>
    <meta name="description" content="Autonomous AI agents for intelligent operations—systems that analyze, decide, and execute multi-step tasks without constant human input.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-agents.css">
</head>
<body id="page-top" class="ai-agents-page">
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
                            <li><a href="ai-agents.php" aria-current="page">AI Agents</a></li>
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

    <main class="agents-page">
        <section class="agents-hero" aria-label="AI agents hero">
            <div class="agents-hero-inner">
                <div class="agents-hero-copy">
                    <h1 class="agents-hero-title">Autonomous AI Agents for Intelligent Operations</h1>
                    <p class="agents-hero-lede">
                        We build AI systems that think, decide, and execute tasks independently—helping businesses
                        automate complex operations with precision and efficiency.
                    </p>
                    <a class="agents-hero-cta" href="#agents-cta">Get Started</a>
                </div>
                <div class="agents-hero-visual">
                    <img src="assets/ai-agent-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="agents-about" aria-labelledby="agents-about-heading">
            <div class="agents-about-inner">
                <div class="agents-about-copy" data-reveal>
                    <p class="agents-section-label">Foundation</p>
                    <h2 id="agents-about-heading" class="agents-about-title">What Are AI Agents?</h2>
                    <p class="agents-about-text">
                        AI agents are advanced systems designed to operate independently within your business environment.
                        Unlike traditional software, these agents can analyze data, make decisions, and execute multi-step
                        tasks without constant human input. They interact with APIs, systems, and data sources to complete
                        real-world objectives efficiently.
                    </p>
                </div>
                <div class="agents-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ai-agent-process.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section class="agents-services" aria-labelledby="agents-services-heading">
            <div class="agents-services-inner">
                <p class="agents-section-label" data-reveal>Capabilities</p>
                <h2 id="agents-services-heading" class="agents-services-title" data-reveal style="--reveal-delay: 40ms">
                    Agent systems we design
                </h2>
                <p class="agents-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Purpose-built autonomous agents—not conversational bots or single-trigger scripts. Each is engineered
                    for judgment, sequencing, and reliable execution across your stack.
                </p>

                <div class="agents-grid">
                    <article class="agents-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="agents-card-title">Task Automation Agents</h3>
                        <p class="agents-card-desc">
                            AI agents that handle repetitive and multi-step tasks such as email handling, reporting, and system updates.
                        </p>
                    </article>
                    <article class="agents-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="agents-card-title">AI Research Agents</h3>
                        <p class="agents-card-desc">
                            Agents that gather, analyze, and summarize data from multiple sources to support business decisions.
                        </p>
                    </article>
                    <article class="agents-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="agents-card-title">Personal AI Assistants</h3>
                        <p class="agents-card-desc">
                            Custom AI assistants that manage schedules, reminders, and operational workflows.
                        </p>
                    </article>
                    <article class="agents-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="agents-card-title">Multi-Step Workflow Agents</h3>
                        <p class="agents-card-desc">
                            Agents capable of executing complex processes involving multiple systems and decision points.
                        </p>
                    </article>
                    <article class="agents-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="agents-card-title">API-Integrated Agents</h3>
                        <p class="agents-card-desc">
                            AI systems that connect with your existing tools and platforms to automate operations seamlessly.
                        </p>
                    </article>
                    <article class="agents-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="agents-card-title">Decision Support Agents</h3>
                        <p class="agents-card-desc">
                            Agents that analyze data and provide actionable insights to support strategic decisions.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="agents-cta" class="agents-cta" aria-labelledby="agents-cta-heading">
            <div class="agents-cta-inner" data-reveal>
                <h2 id="agents-cta-heading" class="agents-cta-title">Ready to Deploy Intelligent AI Agents?</h2>
                <p class="agents-cta-desc">
                    Let us design and implement AI systems tailored to your business operations.
                </p>
                <div class="agents-cta-actions">
                    <a class="agents-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="agents-btn-outline agents-btn-invert" href="mailto:sales@infersioai.com?subject=AI%20Agents%20Consultation">Book Consultation</a>
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

    <div id="ai-agents-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-agents-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiAgentsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-agents-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ai-agents.js"></script>
</body>
</html>
