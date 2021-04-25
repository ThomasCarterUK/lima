<?php

namespace Lima\UI;

class Paragraph extends Element {
    public function render() {
        return $this->renderTag('p', $this->elementData['text']);
    }
}