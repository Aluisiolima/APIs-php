<?php
    function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("Arquivo .env não encontrado.");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

   
            [$key, $value] = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);

            putenv("$key=$value");
        }
    }

    loadEnv(__DIR__ . '/.env');
