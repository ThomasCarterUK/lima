<?php

namespace Lima\Core;

class App {
    protected $defaultPage = 'home';

    public function __construct() {
        $config = $this->loadConfig();
        $url = $this->parseURL();

        if (!empty($config['home'])) $this->defaultPage = $config['home'];

        $page = !empty($url) ? $url[0] : $this->defaultPage;

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

        return $configArray;
    }

    public function parseURL() {
        if (empty($_GET['url'])) return false;

        $url = explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));

        return $url;
    }
}