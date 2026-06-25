<?php
declare(strict_types=1);

session_start();
if (empty($_SESSION["comment_csrf"])) {
    $_SESSION["comment_csrf"] = bin2hex(random_bytes(16));
}

$navCurrent = "home";

$homeComments = [];
$homeClients = [];
$homeLeadership = [];

/**
 * Load DB-backed sections after hero HTML so a slow remote DB does not delay banner video download.
 *
 * @return array{comments: list<array>, clients: list<array>, leadership: list<array>}
 */
function infersio_load_home_page_data(): array
{
    static $data = null;
    if ($data !== null) {
        return $data;
    }

    require_once __DIR__ . "/includes/db.php";
    require_once __DIR__ . "/includes/comments.php";

    $data = [
        "comments" => [],
        "clients" => [],
        "leadership" => [],
    ];

    try {
        $data["comments"] = public_visitor_comments();
    } catch (Throwable $e) {
        $data["comments"] = [];
    }

    try {
        $data["clients"] = public_clients();
    } catch (Throwable $e) {
        error_log("home clients load failed: " . $e->getMessage());
        $data["clients"] = [];
    }

    try {
        $data["leadership"] = team_members_for_display(public_team_members());
    } catch (Throwable $e) {
        error_log("home leadership load failed: " . $e->getMessage());
        $data["leadership"] = [];
    }

    return $data;
}

?>
<!DOCTYPE html>
<html lang="en" class="home-page-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfersioAI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="client-slideshow.css">
    <link rel="stylesheet" href="home.css">
</head>
<body id="page-top" class="home-page is-loading">
<?php
if (function_exists("flush")) {
    flush();
}
?>
    <div
        id="ai-loader"
        class="ai-loader"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="100"
        aria-valuenow="0"
        aria-label="Loading website"
    >
        <div class="ai-loader__grid" aria-hidden="true"></div>
        <div class="ai-loader__glow" aria-hidden="true"></div>

        <div class="ai-loader__core">
            <div class="ai-loader__orb" aria-hidden="true">
                <svg class="ai-loader__nodes" viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <line class="ai-loader__line" x1="80" y1="80" x2="30" y2="40" />
                    <line class="ai-loader__line" x1="80" y1="80" x2="130" y2="35" />
                    <line class="ai-loader__line" x1="80" y1="80" x2="140" y2="100" />
                    <line class="ai-loader__line" x1="80" y1="80" x2="50" y2="125" />
                    <line class="ai-loader__line" x1="80" y1="80" x2="80" y2="20" />
                    <circle class="ai-loader__node" cx="30" cy="40" r="4" />
                    <circle class="ai-loader__node" cx="130" cy="35" r="4" />
                    <circle class="ai-loader__node" cx="140" cy="100" r="4" />
                    <circle class="ai-loader__node" cx="50" cy="125" r="4" />
                    <circle class="ai-loader__node" cx="80" cy="20" r="4" />
                    <circle class="ai-loader__node" cx="80" cy="80" r="5" />
                </svg>
                <span class="ai-loader__ring ai-loader__ring--1"></span>
                <span class="ai-loader__ring ai-loader__ring--2"></span>
                <span class="ai-loader__ring ai-loader__ring--3"></span>
                <span class="ai-loader__brain">AI</span>
            </div>

            <p class="ai-loader__brand">INFERSIOAI</p>
            <p class="ai-loader__status" id="ai-loader-status">Initializing…</p>

            <div class="ai-loader__track">
                <span class="ai-loader__bar" id="ai-loader-bar"></span>
            </div>
            <span class="ai-loader__pct" id="ai-loader-pct">0%</span>
        </div>
    </div>

    <header class="site-header site-header--dark">
        <div class="container">
            <a class="logo" href="index.php">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <?php require __DIR__ . "/includes/site-nav.php"; ?>
            </nav>
        </div>
    </header>

    <main class="site-main site-main--fullscreen">
        <section id="home" class="hero-banner" aria-label="Banner">
            <div class="hero-banner__media" aria-hidden="true">
                <img
                    class="hero-banner__image"
                    src="assets/banner.webp"
                    alt=""
                    decoding="async"
                    fetchpriority="high"
                >
                <img
                    class="hero-banner__mobile-image"
                    src="assets/mobilebanner.webp"
                    alt=""
                    decoding="async"
                    fetchpriority="high"
                >
            </div>
            <div class="hero-banner__shade" aria-hidden="true"></div>
        </section>

        <?php
        $homeData = infersio_load_home_page_data();
        $homeComments = $homeData["comments"];
        $homeClients = $homeData["clients"];
        $homeLeadership = $homeData["leadership"];
        ?>

        <section id="services" class="home-services" aria-hidden="true" aria-label="Our services">
            <div class="home-services__inner">
                <h2 class="home-services__heading">OUR SERVICES</h2>

                <ul class="home-services__grid">
                    <li class="home-services__card">
                        <div class="home-services__media">
                            <img
                                class="home-services__image"
                                src="assets/ai.webp"
                                alt="AI services"
                                decoding="async"
                            >
                        </div>
                        <p class="home-services__title">AI</p>
                    </li>
                    <li class="home-services__card">
                        <div class="home-services__media">
                            <img
                                class="home-services__image"
                                src="assets/development.webp"
                                alt="Development services"
                                decoding="async"
                            >
                        </div>
                        <p class="home-services__title">Development</p>
                    </li>
                    <li class="home-services__card">
                        <div class="home-services__media">
                            <img
                                class="home-services__image"
                                src="assets/cloud.webp"
                                alt="Cloud services"
                                decoding="async"
                            >
                        </div>
                        <p class="home-services__title">Cloud</p>
                    </li>
                </ul>

                <div class="home-services__actions">
                    <a href="contact.php" class="home-services__btn home-services__btn--primary">Contact us</a>
                    <a href="services.php" class="home-services__btn home-services__btn--secondary">Explore Services</a>
                </div>
            </div>
        </section>

        <?php require __DIR__ . "/includes/home-live-counter.php"; ?>

        <section id="why-choose" class="home-why" aria-labelledby="home-why-heading">
            <div class="home-why__inner">
                <div class="home-why__copy">
                    <h2 id="home-why-heading" class="home-why__title">Why Choose Infersio AI?</h2>
                    <div class="home-why__text">
                        <p>
                            At Infersio AI, we believe technology should be a growth engine, not just a business expense.
                            We combine artificial intelligence, custom software development, and cloud technologies to create
                            solutions that help businesses operate more efficiently, reduce manual effort, and unlock new
                            opportunities for growth. Every project is designed with a strong focus on performance, security,
                            scalability, and long-term value.
                        </p>
                        <p>
                            From intelligent business automation and AI-powered assistants to modern web applications,
                            enterprise software, and cloud infrastructure, we build solutions that are tailored to the unique
                            needs of each organization. Rather than offering one-size-fits-all products, we take the time to
                            understand your business processes, challenges, and goals to deliver technology that creates
                            measurable results.
                        </p>
                        <p>
                            Our commitment goes beyond development. We focus on building reliable digital ecosystems that can
                            evolve alongside your business, ensuring that your technology remains efficient, secure, and ready
                            for the future. Whether you're a startup looking to innovate or an established company seeking digital
                            transformation, Infersio AI provides the expertise and solutions needed to help you stay competitive
                            in an increasingly digital world.
                        </p>
                    </div>
                </div>
                <div class="home-why__media">
                    <video
                        class="home-why__video"
                        autoplay
                        muted
                        loop
                        playsinline
                        webkit-playsinline
                        preload="metadata"
                        poster="assets/whychooseus.webp"
                        aria-label="Why choose Infersio AI"
                    >
                        <source src="assets/whychooseus.webm" type="video/webm">
                    </video>
                </div>
            </div>
        </section>

        <?php
        $clients = clients_for_display($homeClients);
        $variant = "light";
        require __DIR__ . "/includes/client-slideshow.php";
        ?>

        <?php if ($homeLeadership): ?>
        <section class="home-leadership" aria-labelledby="home-leadership-heading">
            <div class="home-leadership__inner">
                <h2 id="home-leadership-heading" class="home-leadership__heading">Our leadership</h2>
                <p class="home-leadership__sub">The people behind InfersioAI.</p>
                <div class="home-leadership__grid">
                    <?php foreach ($homeLeadership as $member): ?>
                        <?php
                        $imgSrc = (string) ($member["image_url"] ?? "");
                        $profile = trim((string) ($member["profile_link"] ?? ""));
                        $hasProfile = $profile !== "" && $profile !== "#";
                        ?>
                        <article class="home-leadership__card">
                            <?php if ($hasProfile): ?>
                                <a
                                    class="home-leadership__photo"
                                    href="<?= htmlspecialchars($profile) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="<?= htmlspecialchars((string) $member["name"]) ?> — profile"
                                >
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" loading="lazy" decoding="async">
                                </a>
                            <?php else: ?>
                                <div class="home-leadership__photo">
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" loading="lazy" decoding="async">
                                </div>
                            <?php endif; ?>
                            <h3 class="home-leadership__name"><?= htmlspecialchars((string) $member["name"]) ?></h3>
                            <p class="home-leadership__role"><?= htmlspecialchars((string) $member["role"]) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <section class="home-project-cta" aria-label="Project inquiry">
            <div class="home-project-cta__inner">
                <h2 class="home-project-cta__title">HAVE A PROJECT?</h2>
                <div class="home-project-cta__divider" aria-hidden="true">
                    <span class="home-project-cta__line"></span>
                    <span class="home-project-cta__chevron">⌄</span>
                    <span class="home-project-cta__line"></span>
                </div>
                <p class="home-project-cta__text">Our experts deliver innovative, secure, and scalable solutions.</p>
                <a href="contact.php" class="home-project-cta__button">Request a call-back</a>
            </div>
        </section>

        <section id="home-comments" class="home-comments" aria-label="Comments">
            <div
                id="home-comments-marquee"
                class="home-comments__marquee-section"
                aria-label="Client testimonials"
                <?= $homeComments ? "" : "hidden" ?>
            >
                <h2 class="home-comments__marquee-heading">What people say</h2>
                <div class="home-comments__marquee">
                    <div class="home-comments__track">
                        <?php if ($homeComments): ?>
                            <?php for ($commentDup = 0; $commentDup < 2; $commentDup++): ?>
                                <div class="home-comments__strip"<?= $commentDup ? ' aria-hidden="true"' : "" ?>>
                                    <?php foreach ($homeComments as $item): ?>
                                        <article class="home-comments__card">
                                            <blockquote class="home-comments__quote">
                                                <?= nl2br(htmlspecialchars($item["comment_text"])) ?>
                                            </blockquote>
                                            <footer class="home-comments__meta">
                                                <strong><?= htmlspecialchars($item["name"]) ?></strong>
                                                <span class="home-comments__company"><?= htmlspecialchars($item["company"]) ?></span>
                                            </footer>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="home-comments__inner">
                <?php if (!$homeComments): ?>
                    <p class="home-comments__empty">Be the first to share your experience with Infersio AI.</p>
                <?php endif; ?>

                <div class="home-comments__form-wrap">
                    <h2 class="home-comments__heading">Leave a comment</h2>
                    <p class="home-comments__sub">Tell us about your project or experience.</p>

                    <p id="home-comment-flash" class="home-comments__flash" role="status" hidden></p>

                    <form id="home-comment-form" class="home-comments__form" method="post" action="submit-comment.php" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["comment_csrf"]) ?>">

                        <label class="home-comments__field">
                            <span>Name</span>
                            <input type="text" name="name" required maxlength="120" autocomplete="name">
                        </label>

                        <label class="home-comments__field">
                            <span>Company</span>
                            <input type="text" name="company" required maxlength="180" autocomplete="organization">
                        </label>

                        <label class="home-comments__field">
                            <span>Comment</span>
                            <textarea name="comment" rows="4" required maxlength="2000" placeholder="Your message…"></textarea>
                        </label>

                        <button type="submit" class="home-comments__submit">Submit comment</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php require __DIR__ . '/includes/site-footer.php'; ?>

    <script src="script.js"></script>
    <script src="home.js"></script>
</body>
</html>
