<?php
declare(strict_types=1);
require_once __DIR__ . "/includes/db.php";
$clientLogos = public_clients();

$homeCounters = [
    "ai-solutions" => 0,
    "web-solutions" => 0,
    "mobile-applications" => 0,
    "software-development" => 0,
    "today_revenue" => 0.0,
];

try {
    bootstrap_database();
    $pdo = db();

    $countStmt = $pdo->query(
        "SELECT service_type, COUNT(*) AS total
         FROM service_projects
         GROUP BY service_type"
    );
    foreach ($countStmt->fetchAll() as $row) {
        $serviceType = (string) ($row["service_type"] ?? "");
        if (array_key_exists($serviceType, $homeCounters)) {
            $homeCounters[$serviceType] = (int) $row["total"];
        }
    }

    $revenueStmt = $pdo->query(
        "SELECT COALESCE(SUM(project_value), 0) AS today_revenue
         FROM service_projects
         WHERE DATE(created_at) = CURRENT_DATE"
    );
    $homeCounters["today_revenue"] = (float) ($revenueStmt->fetchColumn() ?: 0);
} catch (Throwable $e) {
    // Keep homepage resilient if DB is unavailable.
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfersioAI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="services.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a class="logo" href="#home">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <ul class="nav-menu">
                    <li><a href="#home">Home</a></li>
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

    <main>
        <section id="home" class="hero section">
            <div class="hero-media" aria-hidden="true">
                <video class="hero-video" autoplay muted loop playsinline>
                    <source src="assets/banner.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <div class="section-inner">
            <div class="container hero-content">
                <div class="hero-card">
                    <div class="hero-badge">AI for Modern Businesses</div>

                    <div class="hero-rotator" aria-label="Featured capabilities">
                        <div id="hero-slide-1" class="hero-rotator-item is-active">
                            <h1>
                                Intelligent <span class="gradient-text">AI</span> Solutions for a
                                <span class="gradient-text">Smarter</span> <span class="gradient-text">Future</span>
                            </h1>
                            <p>
                                We design and build advanced web, mobile, and AI-powered systems
                                that help businesses grow, automate, and stay ahead in a rapidly
                                evolving digital world.
                            </p>
                        </div>

                        <div id="hero-rotator-ai" class="hero-rotator-item">
                            <h1>
                                Transforming Businesses with <span class="gradient-text">AI</span> Innovation
                            </h1>
                            <p>
                                From intelligent automation to custom AI agents, InfersioAI delivers
                                cutting-edge solutions that redefine how businesses operate and scale.
                            </p>
                        </div>

                        <div id="software-engineering" class="hero-rotator-item">
                            <h1>
                                Engineering the <span class="gradient-text">Future</span> of Digital Experiences
                            </h1>
                            <p>
                                We combine modern development with artificial intelligence to create
                                powerful, scalable, and user-focused solutions for forward-thinking businesses.
                            </p>
                        </div>
                    </div>

                    <a class="cta-btn hero-cta" href="contact.php">Contact Us</a>
                </div>
            </div>
            </div>

            <!-- Banner robot: stays with the banner and scrolls away with it -->
            <div id="robot-container" class="robot-container" aria-label="Robot assistant viewer"></div>
        </section>

        <section id="ai-solutions" class="section service-slide" aria-label="AI Solutions">
            <div class="section-inner">
                    <div class="service-layout">
                        <div class="service-robot-slot">
                            <div id="service-robot-container" class="service-robot-container" aria-label="Service robot viewer"></div>
                        </div>
                        <div class="service-copy">
                            <h2><span class="gradient-text">AI</span> Solutions</h2>
                            <p class="service-lede">
                                Intelligent systems that understand your workflows, reduce manual work, and
                                scale with your business—from first prototype to production-grade deployment.
                            </p>
                            <ul class="service-list">
                                <li><a class="service-list-link" href="ai-chatbots.php">Custom AI Chatbots</a></li>
                                <li>AI Agents &amp; Automation</li>
                                <li>Machine Learning Solutions</li>
                                <li>AI Integration for Web &amp; Apps</li>
                            </ul>
                            <a class="service-cta" href="contact.php">Get More Details</a>
                        </div>
                    </div>
            </div>
        </section>

        <section id="web-solutions" class="section service-slide service-slide--reverse" aria-label="Web Solutions">
            <div class="section-inner">
                    <div class="service-layout">
                        <div class="service-robot-slot"></div>
                        <div class="service-copy">
                            <h2>Web <span class="gradient-text">Solutions</span></h2>
                            <p class="service-lede">
                                Fast, accessible, and conversion-focused experiences built on modern stacks—
                                engineered for performance, SEO, and long-term maintainability.
                            </p>
                            <ul class="service-list">
                                <li>Custom Websites</li>
                                <li>Web Applications</li>
                                <li>E-Commerce Platforms</li>
                                <li>UI/UX Design</li>
                            </ul>
                            <a class="service-cta" href="contact.php">Get More Details</a>
                        </div>
                    </div>
            </div>
        </section>

        <section id="mobile-applications" class="section service-slide" aria-label="Mobile Applications">
            <div class="section-inner">
                    <div class="service-layout">
                        <div class="service-robot-slot"></div>
                        <div class="service-copy">
                            <h2>Mobile <span class="gradient-text">Applications</span></h2>
                            <p class="service-lede">
                                Native-quality apps for Android and iOS, plus efficient cross-platform delivery—
                                polished UI, solid architecture, and clear analytics hooks.
                            </p>
                            <ul class="service-list">
                                <li>Android Apps</li>
                                <li>iOS Apps</li>
                                <li>Cross-Platform Apps</li>
                                <li>App UI/UX</li>
                            </ul>
                            <a class="service-cta" href="contact.php">Get More Details</a>
                        </div>
                    </div>
            </div>
        </section>

        <section id="software" class="section service-slide service-slide--reverse" aria-label="Software Engineering">
            <div class="section-inner">
                    <div class="service-layout">
                        <div class="service-robot-slot"></div>
                        <div class="service-copy">
                            <h2>Software <span class="gradient-text">Engineering</span></h2>
                            <p class="service-lede">
                                Reliable desktop and cloud software, APIs, and automation—designed for security,
                                observability, and the realities of enterprise operations.
                            </p>
                            <ul class="service-list">
                                <li>Desktop Applications</li>
                                <li>Business Software</li>
                                <li>API Development</li>
                                <li>System Automation</li>
                            </ul>
                            <a class="service-cta" href="contact.php">Get More Details</a>
                        </div>
                    </div>
            </div>
        </section>

        <section id="client-showcase" class="section client-showcase-slide" aria-label="Client Logos">
            <div class="section-inner">
                <div class="client-showcase-wrap">
                    <div class="client-showcase-header">
                        <div class="client-showcase-title-area">
                            <h2>Trusted by Our <span class="gradient-text">Clients</span></h2>
                            <p class="client-showcase-subtitle">Logos are managed from Admin Panel and appear here automatically.</p>
                        </div>
                        <div class="client-showcase-stats">
                            <div class="client-stat-item">
                                <span class="client-stat-value"><?= (int) $homeCounters["ai-solutions"] ?></span>
                                <span class="client-stat-label">AI Solutions</span>
                            </div>
                            <div class="client-stat-item">
                                <span class="client-stat-value"><?= (int) $homeCounters["web-solutions"] ?></span>
                                <span class="client-stat-label">Web Solutions</span>
                            </div>
                            <div class="client-stat-item">
                                <span class="client-stat-value"><?= (int) $homeCounters["mobile-applications"] ?></span>
                                <span class="client-stat-label">Mobile Apps</span>
                            </div>
                            <div class="client-stat-item">
                                <span class="client-stat-value"><?= (int) $homeCounters["software-development"] ?></span>
                                <span class="client-stat-label">Software</span>
                            </div>
                            <div class="client-stat-item highlight-stat">
                                <span class="client-stat-value">$<?= number_format((float) $homeCounters["today_revenue"], 2) ?></span>
                                <span class="client-stat-label">Today's Revenue</span>
                            </div>
                        </div>
                    </div>
                    <div class="client-logo-grid">
                        <?php if (!$clientLogos): ?>
                            <div class="client-logo-empty">No client logos yet. Add clients from the admin panel.</div>
                        <?php else: ?>
                            <?php foreach ($clientLogos as $client): ?>
                                <a class="client-logo-card"
                                   href="<?= htmlspecialchars((string) $client["company_website"]) ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   title="<?= htmlspecialchars((string) $client["company_name"]) ?>">
                                    <div class="client-logo-card-inner">
                                        <img src="<?= htmlspecialchars((string) $client["logo_path"]) ?>"
                                             alt="<?= htmlspecialchars((string) $client["company_name"]) ?> logo"
                                             loading="lazy">
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="section about-slide">
            <div class="section-inner">
            <div class="container">
                <div class="project-cta premium-cta">
                    <span class="premium-cta-badge">Get Started</span>
                    <h2 class="premium-cta-title">Let’s Build Something <span class="gradient-text">Intelligent</span></h2>
                    <div class="premium-cta-line" aria-hidden="true"></div>
                    <p class="premium-cta-description">
                        Partner with InfersioAI to design and develop intelligent systems that scale with your business.
                    </p>
                    <a class="premium-cta-btn" href="contact.php">Start Your Project</a>
                </div>
            </div>
            </div>
        </section>

        <section id="review" class="section review-slide" aria-label="Add a review">
            <div class="section-inner">
                <div class="container review-strip-inner">
                    <div class="review-robot-wrap">
                        <div id="review-robot-container" class="review-robot-container" aria-label="Review robot viewer"></div>
                    </div>
                    <div class="review-card">
                        <h3>Add a Review</h3>
                        <p>Rate your experience with InfersioAI.</p>
                        <div class="star-rating" id="starRating" role="radiogroup" aria-label="Star rating">
                            <button type="button" class="star-btn" data-rating="1" aria-label="1 star">★</button>
                            <button type="button" class="star-btn" data-rating="2" aria-label="2 stars">★</button>
                            <button type="button" class="star-btn" data-rating="3" aria-label="3 stars">★</button>
                            <button type="button" class="star-btn" data-rating="4" aria-label="4 stars">★</button>
                            <button type="button" class="star-btn" data-rating="5" aria-label="5 stars">★</button>
                        </div>
                        <div id="ratingText" class="rating-text">Select a star rating</div>
                        <label for="reviewComment" class="review-comment-label">Comment</label>
                        <textarea id="reviewComment" class="review-comment" rows="4" placeholder="Share your feedback..."></textarea>
                        <button type="button" id="reviewSubmitBtn" class="cta-btn review-submit-btn">Submit Review</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="section footer-slide" aria-label="Footer">
            <div class="section-inner">
            <footer class="site-footer" aria-label="Footer">
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
                        <a class="footer-backtop" href="#home" aria-label="Back to top">↑</a>
                    </div>
                </div>
            </div>
        </footer>
            </div>
        </section>
    </main>

    <script src="services.js"></script>
    <script src="script.js"></script>

    <!-- Three.js (non-module CDN) -->
    <script src="https://unpkg.com/three@0.126.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js"></script>
    <script src="robot-viewer.js"></script>
    <script>
        // Second renderer for the service-slide robot canvas
        window.ROBOT_CONTAINER_ID = "service-robot-container";
        window.ROBOT_ASSISTANT_KEY = "serviceRobotAssistant";
        window.ROBOT_READY_EVENT = "service-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
    <script>
        // Third renderer for review strip robot
        window.ROBOT_CONTAINER_ID = "review-robot-container";
        window.ROBOT_ASSISTANT_KEY = "reviewRobotAssistant";
        window.ROBOT_READY_EVENT = "review-robot-ready";
    </script>
    <script src="robot-viewer.js"></script>
    <script src="review.js"></script>
</body>
</html>
