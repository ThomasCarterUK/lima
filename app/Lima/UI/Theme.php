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
            if (is_array($style)) {
                $rel = !empty($style['rel']) ? $style['rel'] : 'stylesheet';
                $location = !empty($style['location']) ? $style['location'] : 'local';
                $type = !empty($style['type']) ? $style['type'] : 'text/css';
                $href = !empty($style['href']) ? $style['href'] : null;

                if (empty($href)) continue;

                if ($rel != 'stylesheet') $type = null;

                $styleUrl = $location == 'external' ? $href : BASE_URL . '/themes/' . $this->themeName . '/' . $href . '?v=' . $this->themeConfig['version'];

                $styleHtml .= '<link rel="' . $rel . '" ';

                if (!empty($type)) {
                    $styleHtml .= 'type="' . $type . '" ';
                }

                $styleHtml .= 'href="' . $styleUrl . '" />';
            }
            else {
                $styleUrl = BASE_URL . '/themes/' . $this->themeName . '/' . $style . '?v=' . $this->themeConfig['version'];
                $styleHtml .= '<link rel="stylesheet" type="text/css" href="' . $styleUrl . '" />';
            }

        }

        echo $styleHtml;
    }

    public function themeScripts() {
        $scripts = !empty($this->themeConfig['scripts']) ? $this->themeConfig['scripts'] : [];
        $scriptsHtml = '';

        foreach ($scripts as $script) {
            if (is_array($script)) {
                $location = !empty($script['location']) ? $script['location'] : 'local';
                $type = !empty($script['type']) ? $script['type'] : 'text/javascript';
                $src = !empty($script['src']) ? $script['src'] : null;

                $scriptUrl = $location == 'external' ? $src : BASE_URL . '/themes/' . $this->themeName . '/' . $src . '?v=' . $this->themeConfig['version'];
                $scriptsHtml .= '<script type="' . $type . '" src="' . $scriptUrl . '"></script>';
            }
            else {
                $scriptUrl = BASE_URL . '/themes/' . $this->themeName . '/' . $script . '?v=' . $this->themeConfig['version'];
                $scriptsHtml .= '<script type="text/javascript" src="' . $scriptUrl . '"></script>';
            }
        }

        echo $scriptsHtml;
    }

    public function menuLocation($location) {
        $siteConfig = \Lima\Core\Config::LoadSiteConfig();
        $menuItems = !empty($siteConfig['menus'][$location]) ? $siteConfig['menus'][$location] : null;

        if (empty($menuItems)) {
            return;
        }

        $navMenu = new NavMenu($menuItems);
        echo $navMenu->render();
    }

    public function renderComponent($componentName, $data = []) {
        $templateFile = 'components/' . $componentName;

        return $this->renderTemplate($templateFile, $data, false);
    }

    public function renderTemplate($templateFile, $data = [], $headerFooter = true) {
        $templatePath = $this->themeDir . '/' . $templateFile . '.php';

        $defaultData = [
            'theme_version' => $this->themeConfig['version']
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