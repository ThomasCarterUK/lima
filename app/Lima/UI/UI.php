<?php

namespace Lima\UI;

class UI {
    public static function RenderElement($element, $data) {
        $platformFolder = BASE_ROOT . '/platform/UI/';
        $elementFile = $platformFolder . $element . '.php';

        $classArray = !empty($data['class']) ? $data['class'] : [];
        $data['class'] = join(' ', $classArray);

        extract($data);

        ob_start();
        require($elementFile);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}