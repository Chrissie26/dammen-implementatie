<?php

declare(strict_types=1);

// Autoloaden van classes
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Class '$file' niet gevonden!");
    }
});

// Start het spel
$spel = new DamSpel();
$spel->start();
