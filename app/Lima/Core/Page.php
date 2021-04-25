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
        $pageDataFile = BASE_ROOT . '/public/pages/' . $page . '.json';

        if (!file_exists($pageDataFile)) {
            return false;
        }

        $pageData = Config::LoadJsonFile($pageDataFile);
        return $pageData;
    }

    public function loadHtml($file, $data = []) {
        $templateFile = $this->getThemeFile($file . '.php');

        if (!$templateFile) {
            return $this->loadHtml('404');
        }

        extract($data);

        ob_start();
        require($templateFile);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function renderContents($contentData) {
        $contentsHtml = '';

        foreach ($contentData as $cData) {
            $type = ucfirst($cData['type']);
            unset($cData['type']);

            $class = '\Lima\UI\\' . $type;
            $element = new $class($cData);

            $contentsHtml .= $element->render();
        }

        return $contentsHtml;
    }

    public function view($pageName) {
        $pageData = $this->getPageData($pageName);

        if (empty($pageData)) {
            $html = $this->loadHtml('404');
        }
        else {
            $pageTemplate = !empty($pageData['template']) ? $pageData['template'] : 'page';
            $pageContents = $this->renderContents($pageData['page_contents']);
            $data = ['page_contents' => $pageContents];

            $html = $this->loadHtml($pageTemplate, $data);
        }

        return $html;
    }
}