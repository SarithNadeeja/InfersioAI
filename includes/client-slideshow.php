<?php
declare(strict_types=1);

/**
 * Infinite logo marquee — data from admin Clients panel.
 *
 * @var list<array{id: int|string, company_name: string, company_website: string, logo_path: string}>|null $clients
 * @var string $variant 'light' | 'dark'
 */
require_once __DIR__ . "/db.php";

$variant = $variant ?? "light";
$clients = clients_for_display(isset($clients) && is_array($clients) ? $clients : null);
$hasClients = $clients !== [];

if ($hasClients) {
    $clientMarqueeMid = (int) ceil(count($clients) / 2);
    $clientMarqueeTop = array_slice($clients, 0, $clientMarqueeMid);
    $clientMarqueeBottom = array_slice($clients, $clientMarqueeMid);

    if ($clientMarqueeBottom === []) {
        $clientMarqueeBottom = $clientMarqueeTop;
    }

    $padClientMarqueeRow = static function (array $row, int $minItems = 8): array {
        if ($row === []) {
            return [];
        }
        $padded = [];
        while (count($padded) < $minItems) {
            foreach ($row as $client) {
                $padded[] = $client;
                if (count($padded) >= $minItems) {
                    break;
                }
            }
        }
        return $padded;
    };

    $clientMarqueeTop = $padClientMarqueeRow($clientMarqueeTop);
    $clientMarqueeBottom = $padClientMarqueeRow($clientMarqueeBottom);
}
$variantClass = $variant === "dark" ? "client-slideshow--dark" : "client-slideshow--light";
?>
<section class="client-slideshow <?= htmlspecialchars($variantClass) ?>" aria-labelledby="client-slideshow-heading">
    <div class="client-slideshow__head">
        <h2 id="client-slideshow-heading" class="client-slideshow__heading">
            Trusted by Leading Brands <em>Worldwide</em>
        </h2>
        <p class="client-slideshow__sub">
            Organizations across industries trust InfersioAI to build intelligent digital solutions—automating
            workflows, scaling cloud infrastructure, and delivering AI that helps businesses grow with confidence.
        </p>
    </div>

    <?php if ($hasClients): ?>
    <div class="client-slideshow__marquees">
        <?php foreach ([["row" => $clientMarqueeTop, "dir" => "left"], ["row" => $clientMarqueeBottom, "dir" => "right"]] as $marquee): ?>
            <?php if (!$marquee["row"]) {
                continue;
            } ?>
            <div class="client-slideshow__marquee client-slideshow__marquee--<?= htmlspecialchars($marquee["dir"]) ?>">
                <div class="client-slideshow__track">
                    <?php for ($dup = 0; $dup < 2; $dup++): ?>
                        <div class="client-slideshow__strip"<?= $dup ? ' aria-hidden="true"' : "" ?>>
                            <?php foreach ($marquee["row"] as $client): ?>
                                <a
                                    class="client-slideshow__logo"
                                    href="<?= htmlspecialchars((string) $client["company_website"]) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="<?= htmlspecialchars((string) $client["company_name"]) ?>"
                                    tabindex="<?= $dup ? "-1" : "0" ?>"
                                >
                                    <img
                                        src="<?= htmlspecialchars((string) $client["logo_path"]) ?>"
                                        alt="<?= htmlspecialchars((string) $client["company_name"]) ?> logo"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="client-slideshow__empty">
        Client logos from the admin panel will appear here. Add clients under <strong>Admin → Clients</strong>.
    </p>
    <?php endif; ?>
</section>
