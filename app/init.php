<?php

define("BASE_ROOT", dirname(__DIR__));
define("THEMES", BASE_ROOT . '/themes'. DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $coreFile = BASE_ROOT  . "/app/" . $class . ".php";

    if (file_exists($coreFile)) include $coreFile;
});

// Get root path for frontend
$publicRoot = "https://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "" , str_replace("\\", "/'", BASE_ROOT) . '/public');
define("PUBLIC_ROOT", $publicRoot);

?>