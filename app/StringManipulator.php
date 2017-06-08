<?php

namespace App;

class StringManipulator {

    public static function after($start, $inthat) {
        if (!is_bool(strpos($inthat, $start))) {
            return substr($inthat, strpos($inthat, $start) + strlen($start));
        }
    }

    public static function after_last($start, $inthat) {
        if (!is_bool(strrevpos($inthat, $start))) {
            return substr($inthat, strrevpos($inthat, $start) + strlen($start));
        }
    }

    public static function before($start, $inthat) {
        return substr($inthat, 0, strpos($inthat, $start));
    }

    public static function before_last($start, $inthat) {
        return substr($inthat, 0, strrevpos($inthat, $start));
    }

    public static function between($start, $that, $inthat) {
        return StringManipulator::before($that, StringManipulator::after($start, $inthat));
    }

    public static function between_last($start, $that, $inthat) {
        return after_last($start, before_last($that, $inthat));
    }

    public static function str_starts_with($str, $startWith) {
        return substr_compare($str, $startWith, 0, strlen($startWith)) === 0;
    }

    public static function str_ends_with($str, $startWith) {
        return substr_compare($str, $startWith, -strlen($startWith)) === 0;
    }

}
