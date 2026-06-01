<?php
declare(strict_types=1);

$navCurrent = "services";

$serviceBlocks = [
    [
        "id" => "ai-solutions",
        "mod" => "ai",
        "category" => "🤖 AI Solutions",
        "headline" => "Still Spending Hours on Tasks That Could Be Automated?",
        "body" => "Imagine having a digital assistant that works 24/7 without breaks. Our AI solutions help businesses automate repetitive tasks, respond to customer inquiries instantly, organize information, generate insights from data, and improve overall efficiency. Whether it's custom AI chatbots, intelligent business automation, AI assistants, or workflow optimization, we build solutions that save time, reduce costs, and allow your team to focus on what truly matters.",
        "video" => "assets/aiservice.webm",
        "poster" => "assets/aiservice.webp",
        "reverse" => false,
    ],
    [
        "id" => "development-solutions",
        "mod" => "development",
        "category" => "💻 Development Solutions",
        "headline" => "Custom Web, Mobile & Software Development",
        "body" => "Every business is unique, and your software should be too. We design and develop modern websites, mobile applications, and custom software tailored to your specific goals and workflows. From customer-facing platforms to internal business systems, we create fast, secure, and user-friendly solutions that help businesses grow, improve productivity, and deliver better experiences to their customers.",
        "video" => "assets/developmentservice.webm",
        "poster" => "assets/developmentservice.webp",
        "reverse" => true,
    ],
    [
        "id" => "cloud-solutions",
        "mod" => "cloud",
        "category" => "☁️ Cloud Solutions",
        "headline" => "Is Your Business Ready for a More Secure and Scalable Future?",
        "body" => "As your business grows, your technology needs to grow with it. Our cloud solutions help businesses securely store data, improve system reliability, reduce infrastructure costs, and access information from anywhere in the world. Whether you're moving existing systems to the cloud, setting up scalable infrastructure, or improving security and backups, we ensure your business remains fast, protected, and prepared for future growth.",
        "video" => "assets/cloudservice.webm",
        "poster" => "assets/cloudservice.webp",
        "reverse" => false,
    ],
];
?>
<!DOCTYPE html>
<html lang="en" class="services-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services — InfersioAI</title>
    <meta name="description" content="AI solutions, custom development, and cloud services from InfersioAI — built to automate, scale, and grow your business.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="services.css">
</head>
<body id="page-top" class="services-page">
    <header class="site-header site-header--dark">
        <div class="container">
            <a class="logo" href="index.php">InfersioAI</a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">Menu</button>
            <nav class="navbar" id="navbar">
                <?php require __DIR__ . "/includes/site-nav.php"; ?>
            </nav>
        </div>
    </header>

    <main class="services-main">
        <section class="services-hero" aria-labelledby="services-hero-heading">
            <p class="services-hero__eyebrow">What we offer</p>
            <h1 id="services-hero-heading" class="services-hero__title">Our Services</h1>
            <p class="services-hero__lede">
                Intelligent AI, tailored development, and cloud infrastructure — designed to help your business work smarter and scale with confidence.
            </p>
        </section>

        <?php foreach ($serviceBlocks as $block): ?>
            <section
                id="<?= htmlspecialchars($block["id"]) ?>"
                class="svc-block svc-block--<?= htmlspecialchars($block["mod"]) ?><?= $block["reverse"] ? " svc-block--reverse" : "" ?>"
                aria-labelledby="<?= htmlspecialchars($block["id"]) ?>-heading"
            >
                <div class="svc-block__inner">
                    <div class="svc-block__copy">
                        <p class="svc-block__category"><?= htmlspecialchars($block["category"]) ?></p>
                        <h2 id="<?= htmlspecialchars($block["id"]) ?>-heading" class="svc-block__headline">
                            <?= htmlspecialchars($block["headline"]) ?>
                        </h2>
                        <p class="svc-block__body"><?= htmlspecialchars($block["body"]) ?></p>
                        <a class="svc-block__cta" href="contact.php">Discuss your project</a>
                    </div>
                    <div class="svc-block__media">
                        <video
                            class="svc-block__video"
                            autoplay
                            muted
                            loop
                            playsinline
                            webkit-playsinline
                            preload="metadata"
                            poster="<?= htmlspecialchars($block["poster"]) ?>"
                            aria-label="<?= htmlspecialchars($block["category"]) ?>"
                        >
                            <source src="<?= htmlspecialchars($block["video"]) ?>" type="video/webm">
                        </video>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>

        <section class="services-cta" aria-label="Get in touch">
            <div class="services-cta__inner">
                <h2 class="services-cta__title">Ready to get started?</h2>
                <p class="services-cta__text">Tell us about your goals and we’ll recommend the right mix of AI, development, and cloud solutions.</p>
                <a class="services-cta__button" href="contact.php">Contact us</a>
            </div>
        </section>
    </main>

    <?php require __DIR__ . "/includes/site-footer.php"; ?>

    <script src="script.js"></script>
</body>
</html>
