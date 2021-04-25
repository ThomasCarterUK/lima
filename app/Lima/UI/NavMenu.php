<?php

namespace Lima\UI;

class NavMenu {
    private $menuItems = [];

    public function __construct($menuItems) {
        $this->menuItems = $menuItems;
    }

    public function render() {
        $menuItems = $this->menuItems;

        foreach ($menuItems as $index => &$item) {
            if (empty($item['class'])) $item['class'] = '';

            $classArray = [];

            if ($item['id'] == CURRENT_PAGE) {
                $classArray[] = 'active-item';
            }

            $item['class'] = join(' ', $classArray);
        }

        $data = [
            'menu_items' => $menuItems
        ];

        return UI::RenderElement('NavMenu', $data);
    }
}