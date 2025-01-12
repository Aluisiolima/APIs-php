<?php
    $includes = [
        "/src/core/Core.php",
        "/src/routes/main.php",
        "/src/controller/HomeController.php",
        "/src/http/Resquest.php",
        "/src/http/Response.php",
        "/src/utils/Validate.php",
        "/src/controller/NotFoundController.php",
        "/src/model/Database.php",
        "/src/controller/UserController.php",
        "/src/services/UserServices.php",
        "/src/model/UserModel.php",
    ];

    foreach($includes as $file) {
        require_once(__DIR__.$file);
    }