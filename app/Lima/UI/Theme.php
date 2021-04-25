<?php

namespace Lima\UI;

class Theme {
    private $themeName = 'default';
    private $themeDir = '';
    private $themeConfig = [];

    public function __construct($themeName) {
        $this->themeName = $themeName;
        $this->themeDir = BASE_ROOT . '/themes/' . $this->themeName;

        $this->themeConfig = \Lima\Core\Config::LoadJsonFile($this->themeDir . '/theme.json');
    }

    public function themeStyles() {
        $styles = !empty($this->themeConfig['styles']) ? $this->themeConfig['styles'] : [];
        $styleHtml = '';

        foreach ($styles as $style) {
            $styleUrl = BASE_URL . '/themes/' . $this->themeName . '/' . $style;
            $styleHtml .= '<link rel="stylesheet" type="text/css" href="' . $styleUrl . '" />';
        }

        return $styleHtml;
    }

    public function themeScripts() {
        $scripts = !empty($this->themeConfig['scripts']) ? $this->themeConfig['scripts'] : [];
        $scriptsHtml = '';

        foreach ($scripts as $script) {
            $scriptUrl = BASE_URL . '/themes/' . $this->themeName . '/' . $script;
            $styleHtml .= '<script type="text/javascript" src="' . $scriptUrl . '"></script>';
        }

        return $scriptsHtml;
    }

    public function renderComponent($componentName, $data = []) {
        $templateFile = 'components/' . $componentName;

        return $this->renderTemplate($templateFile, $data, false);
    }

    public function renderTemplate($templateFile, $data = [], $headerFooter = true) {
        $templatePath = $this->themeDir . '/' . $templateFile . '.php';

        $defaultData = [
            'theme_version' => $this->themeConfig['version'],
            'theme_styles' => $this->themeStyles(),
            'theme_scripts' => $this->themeScripts()
        ];

        $data = array_merge($defaultData, $data);

        extract($data);

        $html = '';

        if ($headerFooter) $html .= $this->renderComponent('header', $data);

        ob_start();
        require($templatePath);
        $html .= ob_get_contents();
        ob_end_clean();

        if ($headerFooter) $html .= $this->renderComponent('footer', $data);

        return $html;
    }
}