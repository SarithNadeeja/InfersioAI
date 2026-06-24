<?php
declare(strict_types=1);

/**
 * @var array<string, int|float> $homeCounters
 */
$homeCounters = $homeCounters ?? [];

$liveCounterItems = [
    ["key" => "ai-solutions", "label" => "AI Solutions", "format" => "int"],
    ["key" => "web-solutions", "label" => "Web Solutions", "format" => "int"],
    ["key" => "mobile-applications", "label" => "Mobile Apps", "format" => "int"],
    ["key" => "software-development", "label" => "Software Projects", "format" => "int"],
    ["key" => "clients", "label" => "Trusted Clients", "format" => "int"],
    ["key" => "today_revenue", "label" => "Today's Revenue", "format" => "currency", "highlight" => true],
];
?>
<section class="home-stats" id="homeLiveCounter" aria-label="Live project statistics">
    <div class="home-stats__grid">
        <?php foreach ($liveCounterItems as $item):
            $value = $homeCounters[$item["key"]] ?? 0;
            $format = $item["format"];
            $displayValue = $format === "currency"
                ? number_format((float) $value, 2, ".", "")
                : (string) (int) $value;
            ?>
            <article
                class="home-stats__item<?= !empty($item["highlight"]) ? " home-stats__item--highlight" : "" ?>"
                data-counter-format="<?= htmlspecialchars($format) ?>"
                data-counter-value="<?= htmlspecialchars($displayValue) ?>"
            >
                <span class="home-stats__value" data-counter-display aria-live="polite">
                    <?= $format === "currency" ? "$0.00" : "0" ?>
                </span>
                <span class="home-stats__label"><?= htmlspecialchars($item["label"]) ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>
