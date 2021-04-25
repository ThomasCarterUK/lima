<?php

namespace Lima\Core;

class App {
    protected $defaultPage = 'home';
    protected $enviroment = 'production';

    public function __construct() {
        $config = $this->loadConfig();
        $url = $this->parseURL();

        if (!empty($config['environment'])) {
            $this->environment = $config['environment'];
        }

        if ($this->environment == 'development') {
            ini_set('display_errors', 'on');
            error_reporting(E_ALL);
        }

        if (!empty($config['home'])) $this->defaultPage = $config['home'];

        $page = !empty($url) ? $url[0] : $this->defaultPage;

        define('CURRENT_PAGE', $page);

        $pageRenderer = new Page($config);
        echo $pageRenderer->view($page);
    }

    public function loadConfig() {
        $configFile = BASE_ROOT . '/config.json';
        $configArray = Config::LoadJsonFile($configFile);

        if (!$configArray) {
            echo "failed to load config file";
            exit;
        }

        define('SITE_TITLE', $configArray['name']);
        define('SITE_DESCRIPTION', $configArray['description']);

        return $configArray;
    }

    public function parseURL() {
        if (empty($_GET['url'])) return false;

        $url = explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));

        return $url;
    }
}