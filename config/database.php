<?php
declare(strict_types=1);

/**
 * PostgreSQL — AWS Lightsail (production).
 * Set "host" to your Lightsail database endpoint from the console
 * (e.g. ls-xxxx.region.rds.amazonaws.com), or 127.0.0.1 if DB is on the same instance.
 *
 * Optional local overrides (not in git): config/database.local.php
 */
return [
    "host" => "127.0.0.1",
    "port" => "5432",
    "name" => "infersioai_db",
    "user" => "infersioai_user",
    "pass" => "StrongPasswordHere",
];
