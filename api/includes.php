<?php
    $includes = [
        "/src/core/Core.php",
        "/src/routes/main.php",
        "/src/controller/HomeController.php",
    ];

    foreach($includes as $file) {
        require_once(__DIR__.$file);
    }