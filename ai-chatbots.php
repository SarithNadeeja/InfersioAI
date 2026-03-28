<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-chatbots-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbots — InfersioAI</title>
    <meta name="description" content="Intelligent conversational AI chatbots for support, sales, lead capture, and messaging platforms—built for modern businesses.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-chatbots.css">
</head>
<body id="page-top" class="ai-chatbots-page">
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
                            <li><a href="ai-chatbots.php" aria-current="page">AI Chatbots</a></li>
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

    <main class="chatbots-page">
        <section class="chatbots-hero" aria-label="AI chatbots hero">
            <div class="chatbots-hero-inner">
                <div class="chatbots-hero-copy">
                    <h1 class="chatbots-hero-title">Intelligent AI Chatbots for Modern Businesses</h1>
                    <p class="chatbots-hero-lede">
                        We build smart conversational systems that engage users, automate support, and convert
                        interactions into real business value.
                    </p>
                    <div class="chatbots-hero-actions">
                        <a class="chatbots-hero-cta" href="#chatbots-cta">Get Started</a>
                    </div>
                </div>
                <div class="chatbots-hero-visual">
                    <img src="assets/ai-chatbot-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="chatbots-about" aria-labelledby="chatbots-about-heading">
            <div class="chatbots-about-inner">
                <div class="chatbots-about-copy" data-reveal>
                    <p class="chatbots-section-label">Overview</p>
                    <h2 id="chatbots-about-heading" class="chatbots-about-title">What Are AI Chatbots?</h2>
                    <p class="chatbots-about-text">
                        AI chatbots are intelligent conversational systems designed to interact with users in real time.
                        They can answer questions, guide users, and assist with tasks—providing instant support and
                        improving customer experience across websites and messaging platforms.
                    </p>
                </div>
                <div class="chatbots-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ai-chatbot-ui.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section class="chatbots-services" aria-labelledby="chatbots-services-heading">
            <div class="chatbots-services-inner">
                <p class="chatbots-section-label" data-reveal>Use cases</p>
                <h2 id="chatbots-services-heading" class="chatbots-services-title" data-reveal style="--reveal-delay: 40ms">
                    Chatbot solutions
                </h2>
                <p class="chatbots-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Every deployment is conversation-first: natural dialogue, your brand voice, and measurable outcomes
                    on the channels your customers already use.
                </p>

                <div class="chatbots-grid">
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="chatbots-card-title">Customer Support Chatbots</h3>
                        <p class="chatbots-card-desc">
                            Provide instant answers to customer queries and reduce support workload with 24/7 AI assistance.
                        </p>
                    </article>
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="chatbots-card-title">Lead Generation Chatbots</h3>
                        <p class="chatbots-card-desc">
                            Capture, qualify, and convert website visitors into potential customers through intelligent conversations.
                        </p>
                    </article>
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="chatbots-card-title">Sales Assistant Chatbots</h3>
                        <p class="chatbots-card-desc">
                            Guide users through products or services and help them make informed purchasing decisions.
                        </p>
                    </article>
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="chatbots-card-title">Booking &amp; Appointment Bots</h3>
                        <p class="chatbots-card-desc">
                            Allow customers to schedule appointments and manage bookings directly through chat.
                        </p>
                    </article>
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="chatbots-card-title">Website Navigation Assistants</h3>
                        <p class="chatbots-card-desc">
                            Help users explore your website and quickly find the information they need.
                        </p>
                    </article>
                    <article class="chatbots-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="chatbots-card-title">WhatsApp &amp; Messenger Bots</h3>
                        <p class="chatbots-card-desc">
                            Deploy AI chatbots on messaging platforms to interact with customers where they already are.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="chatbots-features" class="chatbots-features" aria-labelledby="chatbots-features-heading">
            <div class="chatbots-features-inner">
                <h2 id="chatbots-features-heading" class="chatbots-features-title" data-reveal>Platform capabilities</h2>
                <p class="chatbots-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Enterprise-ready conversational infrastructure—without the noise of generic automation promises.
                </p>
                <div class="chatbots-features-grid">
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Natural Language Conversations (GPT-powered)</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Multi-language Support</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Custom Knowledge Training</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">CRM Integration</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Lead Capture Forms</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Real-time Responses</span>
                    </div>
                    <div class="chatbots-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="chatbots-feature-dot" aria-hidden="true"></span>
                        <span class="chatbots-feature-text">Platform Integration (Web, WhatsApp, etc.)</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="chatbots-cta" class="chatbots-cta" aria-labelledby="chatbots-cta-heading">
            <div class="chatbots-cta-inner" data-reveal>
                <h2 id="chatbots-cta-heading" class="chatbots-cta-title">Ready to Upgrade Your Customer Experience?</h2>
                <p class="chatbots-cta-desc">
                    Let’s build a chatbot tailored to your business needs.
                </p>
                <div class="chatbots-cta-actions">
                    <a class="chatbots-btn-outline" href="index.php#contact">Contact Us</a>
                    <a class="chatbots-btn-outline chatbots-btn-invert" href="mailto:sales@infersioai.com?subject=AI%20Chatbot%20Consultation">Book Consultation</a>
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

    <div id="ai-chatbots-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="script.js"></script>
    <script src="ai-chatbots.js"></script>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-chatbots-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiChatbotsPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-chatbots-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
</body>
</html>
