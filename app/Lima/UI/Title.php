<?php

namespace Lima\UI;

class Title extends Element {
    private $defaultSize = 2;

    public function render() {
        $headingSize = !empty($this->elementData['size']) ? $this->elementData['size'] : $this->defaultSize;
        $headingTag = "h{$headingSize}";

        return $this->renderTag($headingTag, $this->elementData['text']);
    }
}