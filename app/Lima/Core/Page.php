<?php

namespace Lima\Core;

class Page {
    private $config = [];

    public function __construct($config) {
        $this->config = $config;
    }

    public function getThemeFile($file) {
        $currentTheme = $this->config['theme'];
        $themeFile = THEMES . $currentTheme . '/' . $file;

        if (!file_exists($themeFile)) {
            return false;
        }

        return $themeFile;
    }

    public function getPageData($page) {
        $pageDataFile = PUBLIC_ROOT . '/pages/' . $page . '.json';

        if (!file_exists($pageDataFile)) {
            return false;
        }

        $pageData = Config::LoadJsonFile($pageDataFile);
        return $pageData;
    }

    public function loadHtml($file, $data = []) {
        $templateFile = $this->getThemeFile($file . '.php');

        if (!$templateFile) {
            return false;
        }

        extract($data);

        ob_start();
        require($templateFile);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function view($pageName) {
        $pageData = $this->getPageData($pageName);

        if (empty($pageData)) {
            $html = $this->loadHtml('404');
        }
        else {
            $pageTemplate = $pageData['template'];
            $html = $this->loadHtml($pageTemplate, $pageData['page_contents']);
        }

        return $html;
    }
}