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

    public function loadHtml($template, $data = []) {
        $theme = new \Lima\UI\Theme($this->config['theme']);

        $headerFooter = !empty($data['header_footer']) ? $data['header_footer'] : true;
        $html = $theme->renderTemplate($template, $data, $headerFooter);

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
            $pageData['page_contents'] = $pageContents;

            $html = $this->loadHtml($pageTemplate, $pageData);
        }

        return $html;
    }
}