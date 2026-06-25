<?php
declare(strict_types=1);

$liveCounterItems = [
    ["value" => 40, "suffix" => "+", "label" => "AI Solutions"],
    ["value" => 100, "suffix" => "+", "label" => "IT Solutions"],
    ["value" => 100, "suffix" => "+", "label" => "Cloud Solutions"],
];
?>
<section class="home-stats" id="homeLiveCounter" aria-label="Project statistics">
    <div class="home-stats__grid">
        <?php foreach ($liveCounterItems as $item): ?>
            <article
                class="home-stats__item"
                data-counter-format="int"
                data-counter-value="<?= (int) $item["value"] ?>"
                data-counter-suffix="<?= htmlspecialchars($item["suffix"]) ?>"
            >
                <span class="home-stats__value" data-counter-display aria-live="polite">0</span>
                <span class="home-stats__label"><?= htmlspecialchars($item["label"]) ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>
