<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 9:18 AM
 */
if (!function_exists('camel_case')) {
    /**
     * Borrowed from @link http://www.mendoweb.be/blog/php-convert-string-to-camelcase-string/
     * @param $str
     * @param array $noStrip
     * @return mixed|string
     */
    function camel_case($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        $str = lcfirst($str);

        return $str;
    }
}

if (!function_exists('array_get')) {
    function array_get($arr, $key, $default = null)
    {
        if (isset($arr[$key])) {
            return $arr[$key];
        }
        return $default;
    }
}
