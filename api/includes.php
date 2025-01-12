<?php
    $includes = [
        "/src/core/Core.php",
        "/src/routes/main.php",
        "/src/controller/HomeController.php",
        "/src/http/Resquest.php",
        "/src/http/Response.php",
        "/src/controller/NotFoundController.php",
    ];

    foreach($includes as $file) {
        require_once(__DIR__.$file);
    }