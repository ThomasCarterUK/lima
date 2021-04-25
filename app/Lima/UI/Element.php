<?php

namespace Lima\UI;

class Element {
    protected $elementData = [];

    public function __construct($data) {
        $this->elementData = $data;
    }

    public function renderTag($tag, $contents, $attributes = []) {
        $class = !empty($this->elementData['class']) ? $this->elementData['class'] : '';
        $id = !empty($this->elementData['id']) ? $this->elementData['id'] : '';

        $classString = '';
        $idString = '';

        if (!empty($class)) {
            if (is_array($class)) {
                $classString = 'class="' . join(' ', $class) . '"';
            }
            else {
                $classString = 'class="' . $class . '"';
            }
        }

        if (!empty($id)) {
            $idString = 'id="' . $id . '"';
        }

        $tagAttributes = [$classString, $idString];

        if (!empty($attributes)) {
            foreach ($attributes as $attr => $value) {
                $tagAttributes[] = $attr . '="' . $value . '"';
            }
        }

        $tagAttributesString = join(' ', $tagAttributes);

        if (!empty($tagAttributesString)) {
            $tagAttributesString = ' ' . $tagAttributesString;
        }

        $tagString = "<$tag" . $tagAttributesString . ">$contents</$tag>";

        return $tagString;
    }
}