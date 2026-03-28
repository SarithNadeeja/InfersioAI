<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-solutions-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Solutions — InfersioAI</title>
    <meta name="description" content="Premium AI solutions for modern businesses: chatbots, automation, agents, lead generation, content, and security.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-solutions.css">
</head>
<body id="page-top" class="ai-solutions-page">
    <header class="site-header">
        <div class="container">
            <a class="logo" href="index.php#home">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <ul class="nav-menu">
                    <li><a href="index.php#home">Home</a></li>
                    <li class="has-dropdown">
                        <a href="ai-solutions.php" aria-current="page">AI Solutions</a>
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

    <main class="ai-page">
        <section class="ai-hero" aria-label="AI solutions hero">
            <div class="ai-hero-inner">
                <div class="ai-hero-copy">
                    <h1 class="ai-hero-title">AI Solutions for Modern Businesses</h1>
                    <p class="ai-hero-subtitle">
                        We design intelligent systems that automate workflows, enhance decision-making,
                        and scale your business with cutting-edge AI.
                    </p>
                </div>
                <div class="ai-hero-visual">
                    <img src="assets/ai-hero.jpg" alt="" width="1600" height="900" decoding="async">
                </div>
            </div>
        </section>

        <section class="ai-services" aria-labelledby="ai-services-heading">
            <div class="ai-services-inner">
                <p class="ai-section-eyebrow">Capabilities</p>
                <h2 id="ai-services-heading" class="ai-section-title">What we build</h2>

                <div class="ai-grid">
                    <article id="ai-chatbots" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-chatbot.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Chatbots</h3>
                            <p class="ai-card-desc">
                                Conversational AI systems designed to engage customers, automate support, and improve response efficiency.
                            </p>
                            <a class="ai-btn-outline" href="ai-chatbots.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ai-automation-systems" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-automation.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Automation Systems</h3>
                            <p class="ai-card-desc">
                                Automate repetitive business processes and workflows using intelligent AI-driven systems.
                            </p>
                            <a class="ai-btn-outline" href="ai-automation.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ai-agents" class="ai-card" data-reveal style="--reveal-delay: 120ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-agents.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Agents</h3>
                            <p class="ai-card-desc">
                                Smart AI agents that perform tasks, make decisions, and operate independently.
                            </p>
                            <a class="ai-btn-outline" href="ai-agents.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ai-lead-generation" class="ai-card" data-reveal style="--reveal-delay: 0ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-lead-gen.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Lead Generation Systems</h3>
                            <p class="ai-card-desc">
                                AI-powered systems that capture, qualify, and convert leads automatically.
                            </p>
                            <a class="ai-btn-outline" href="ai-lead-generation.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ai-content-automation" class="ai-card" data-reveal style="--reveal-delay: 60ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-content.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Content Automation</h3>
                            <p class="ai-card-desc">
                                Generate and manage content using AI to improve efficiency and consistency.
                            </p>
                            <a class="ai-btn-outline" href="ai-content-automation.php">Learn More</a>
                        </div>
                    </article>

                    <article id="ai-security-monitoring" class="ai-card" data-reveal style="--reveal-delay: 120ms">
                        <div class="ai-card-media">
                            <img src="assets/ai-security.jpg" alt="" width="800" height="520" loading="lazy" decoding="async">
                        </div>
                        <div class="ai-card-body">
                            <h3 class="ai-card-title">AI Security &amp; Monitoring</h3>
                            <p class="ai-card-desc">
                                AI-based monitoring systems to detect threats and ensure system security in real-time.
                            </p>
                            <a class="ai-btn-outline" href="ai-security.php">Learn More</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="ai-contact-cta" class="ai-cta" aria-labelledby="ai-cta-heading">
            <div class="ai-cta-inner" data-reveal>
                <h2 id="ai-cta-heading" class="ai-cta-title">Not Sure Which AI Solution Fits Your Business?</h2>
                <p class="ai-cta-desc">
                    Our team will help you choose the right solution based on your needs.
                </p>
                <div class="ai-cta-actions">
                    <a class="ai-btn-outline ai-btn-wide" href="index.php#contact">Contact Us</a>
                    <a class="ai-btn-outline ai-btn-wide ai-btn-invert" href="mailto:sales@infersioai.com?subject=Consultation%20Request">Book Consultation</a>
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

    <div id="ai-page-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="script.js"></script>
    <script src="ai-solutions.js"></script>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-page-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-page-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
</body>
</html>
