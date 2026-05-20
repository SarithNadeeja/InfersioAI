<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en" class="ai-security-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Security &amp; Monitoring — InfersioAI</title>
    <meta name="description" content="Enterprise AI security and monitoring: intelligent threat detection, real-time dashboards, anomaly analysis, and automated response—built for modern infrastructure.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="ai-security.css">
    <link rel="stylesheet" href="premium-bw-mixed.css">
</head>
<body id="page-top" class="ai-security-page">
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
                            <li><a href="ai-security.php" aria-current="page">AI Security / Monitoring</a></li>
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
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="security-page">
        <section class="security-hero" aria-label="AI security and monitoring hero">
            <div class="security-hero-inner">
                <div class="security-hero-copy">
                    <h1 class="security-hero-title">AI-Powered Security &amp; Monitoring Systems</h1>
                    <p class="security-hero-lede">
                        Enhance your security infrastructure with intelligent systems that detect threats, monitor activity,
                        and respond in real time.
                    </p>
                    <div class="security-hero-actions">
                        <a class="security-hero-cta" href="#security-cta">Get Started</a>
                    </div>
                </div>
                <div class="security-hero-visual">
                    <img src="assets/ai-security-main.jpg" alt="" width="1400" height="880" decoding="async">
                </div>
            </div>
        </section>

        <section class="security-about" aria-labelledby="security-about-heading">
            <div class="security-about-inner">
                <div class="security-about-copy" data-reveal>
                    <p class="security-section-label">Overview</p>
                    <h2 id="security-about-heading" class="security-about-title">What is AI Security &amp; Monitoring?</h2>
                    <p class="security-about-text">
                        AI security systems use advanced algorithms to monitor environments, analyze behavior, and detect
                        anomalies. These systems provide real-time insights and automated alerts, helping businesses protect
                        assets and respond quickly to potential threats.
                    </p>
                </div>
                <div class="security-about-visual" data-reveal style="--reveal-delay: 80ms">
                    <img src="assets/ai-monitoring.jpg" alt="" width="960" height="680" loading="lazy" decoding="async">
                </div>
            </div>
        </section>

        <section id="security-services" class="security-services" aria-labelledby="security-services-heading">
            <div class="security-services-inner">
                <p class="security-section-label" data-reveal>Services</p>
                <h2 id="security-services-heading" class="security-services-title" data-reveal style="--reveal-delay: 40ms">
                    Enterprise-grade monitoring &amp; detection
                </h2>
                <p class="security-services-intro" data-reveal style="--reveal-delay: 80ms">
                    Intelligent layers that fuse signals across video, access, and system telemetry—designed for
                    operations teams that need clarity, speed, and audit-ready visibility.
                </p>

                <div class="security-grid">
                    <article class="security-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="security-card-title">Intelligent Surveillance Systems</h3>
                        <p class="security-card-desc">
                            AI-powered monitoring systems that analyze video feeds and detect unusual activity.
                        </p>
                    </article>
                    <article class="security-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="security-card-title">Threat Detection Systems</h3>
                        <p class="security-card-desc">
                            Identify potential threats using pattern recognition and behavioral analysis.
                        </p>
                    </article>
                    <article class="security-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="security-card-title">Real-Time Monitoring Dashboards</h3>
                        <p class="security-card-desc">
                            Centralized dashboards to monitor systems, alerts, and activities in real time.
                        </p>
                    </article>
                    <article class="security-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="security-card-title">Automated Alert Systems</h3>
                        <p class="security-card-desc">
                            Instant notifications for suspicious activity via mobile or web platforms.
                        </p>
                    </article>
                    <article class="security-card" data-reveal style="--reveal-delay: 0ms">
                        <h3 class="security-card-title">Access Control Systems</h3>
                        <p class="security-card-desc">
                            AI-enhanced systems to manage and monitor entry points securely.
                        </p>
                    </article>
                    <article class="security-card" data-reveal style="--reveal-delay: 60ms">
                        <h3 class="security-card-title">Anomaly Detection Systems</h3>
                        <p class="security-card-desc">
                            Detect irregular patterns in data or behavior to prevent risks.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="security-features" class="security-features" aria-labelledby="security-features-heading">
            <div class="security-features-inner">
                <h2 id="security-features-heading" class="security-features-title" data-reveal>Platform capabilities</h2>
                <p class="security-features-sub" data-reveal style="--reveal-delay: 50ms">
                    Built for continuous operations: observable, integrable, and ready to scale with your footprint.
                </p>
                <div class="security-features-grid">
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Real-Time Monitoring</span>
                    </div>
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Smart Alerts &amp; Notifications</span>
                    </div>
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Video &amp; Data Analysis</span>
                    </div>
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Behavior Detection</span>
                    </div>
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 0ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Secure System Integration</span>
                    </div>
                    <div class="security-feature-item" data-reveal style="--reveal-delay: 40ms">
                        <span class="security-feature-dot" aria-hidden="true"></span>
                        <span class="security-feature-text">Scalable Security Infrastructure</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="security-cta" class="security-cta" aria-labelledby="security-cta-heading">
            <div class="security-cta-inner" data-reveal>
                <h2 id="security-cta-heading" class="security-cta-title">Secure Your Business with Intelligent Monitoring</h2>
                <p class="security-cta-desc">
                    Let us design AI-powered systems that keep your operations safe and under control.
                </p>
                <div class="security-cta-actions">
                    <a class="security-btn-outline" href="contact.php">Contact Us</a>
                    <a class="security-btn-outline security-btn-invert" href="mailto:sales@infersioai.com?subject=AI%20Security%20Consultation%20Request">Request Consultation</a>
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

    <div id="ai-security-robot-container" class="ai-page-robot" aria-hidden="true"></div>

    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script>
        window.ROBOT_CONTAINER_ID = "ai-security-robot-container";
        window.ROBOT_ASSISTANT_KEY = "aiSecurityPageRobotAssistant";
        window.ROBOT_READY_EVENT = "ai-security-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>

    <script src="script.js"></script>
    <script src="ai-security.js"></script>
</body>
</html>
