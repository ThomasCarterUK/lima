<?php

define("BASE_ROOT", dirname(__DIR__));
define("THEMES", BASE_ROOT . '/themes'. DIRECTORY_SEPARATOR);

define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '' , str_replace('\\', '/', BASE_ROOT)));
define("PUBLIC_ROOT", BASE_URL . '/public');

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $coreFile = BASE_ROOT  . "/app/" . $class . ".php";

    if (file_exists($coreFile)) include $coreFile;
});

?>