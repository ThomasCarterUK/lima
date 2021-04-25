<?php

namespace Lima\Core;

class Config {
    public static function LoadJsonFile($jsonFile) {
        if (!file_exists($jsonFile)) return false;

        $jsonFileContents = file_get_contents($jsonFile);
        $jsonIterator = new \RecursiveArrayIterator(json_decode($jsonFileContents, TRUE));

        $jsonArray = [];

        foreach ($jsonIterator as $key => $val) {
            $jsonArray[$key] = $val;
        }

        return $jsonArray;
    }
}