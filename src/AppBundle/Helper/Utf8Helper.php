<?php

namespace AppBundle\Helper;

class Utf8Helper
{
    public static function utf8_strlen($string) {
        return mb_strlen($string);
    }

    public static function utf8_strpos($string, $needle, $offset = 0) {
        return mb_strpos($string, $needle, $offset);
    }

    public static function utf8_strrpos($string, $needle, $offset = 0) {
        return mb_strrpos($string, $needle, $offset);
    }

    public static function utf8_substr($string, $offset, $length = null) {
        if ($length === null) {
            return mb_substr($string, $offset, self::utf8_strlen($string));
        } else {
            return mb_substr($string, $offset, $length);
        }
    }

    public static function utf8_strtoupper($string) {
        return mb_strtoupper($string);
    }

    public static function utf8_strtolower($string) {
        return mb_strtolower($string);
    }
}