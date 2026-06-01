<?php
/** @var string|null $navCurrent One of: home, about, services, contact */
$navCurrent = $navCurrent ?? null;
?>
<ul class="nav-menu">
    <li><a href="index.php"<?= $navCurrent === "home" ? ' aria-current="page"' : "" ?>>Home</a></li>
    <li><a href="services.php"<?= $navCurrent === "services" ? ' aria-current="page"' : "" ?>>Services</a></li>
    <li><a href="about.php"<?= $navCurrent === "about" ? ' aria-current="page"' : "" ?>>About Us</a></li>
    <li><a href="contact.php"<?= $navCurrent === "contact" ? ' aria-current="page"' : "" ?>>Contact</a></li>
</ul>
