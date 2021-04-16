<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:31 AM
 */

namespace Smorken\Sanitizer\Sanitizers;

use Smorken\Sanitizer\Contracts\Sanitizer;
use Smorken\Sanitizer\SanitizerException;

abstract class Base implements Sanitizer
{

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     * @throws SanitizerException
     */
    public function sanitize($key, $value)
    {
        $m = camel_case($key);
        if (method_exists($this, $m)) {
            $args = func_get_args();
            unset($args[0]);
            return call_user_func_array([$this, $m], $args);
        }
        throw new SanitizerException("$key cannot be sanitized.");
    }

    public function __call($name, $params)
    {
        array_unshift($params, $name);
        return call_user_func_array([$this, 'sanitize'], $params);
    }

    protected function string($value)
    {
        return htmlentities(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8', false);
    }

    protected function int($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    protected function float($value)
    {
        return (float)$value;
    }

    protected function alphaNum($value)
    {
        return preg_replace('/[^A-z0-9]/', '', $value);
    }

    protected function alphaNumDash($value)
    {
        return preg_replace('/[^A-z0-9-]/', '', $value);
    }

    protected function alphaNumDashSpace($value)
    {
        return preg_replace('/[^A-z0-9- ]', '', $value);
    }

    protected function alpha($value)
    {
        return preg_replace('/[^A-z]/', '', $value);
    }

    protected function boolean($value)
    {
        return $this->bool($value);
    }

    protected function bool($value)
    {
        return (bool)$value;
    }

    /**
     * Note that this method is NOT guaranteed to be safe!
     * @param $value
     * @param array|string $tags
     * @return mixed
     */
    protected function stripTags($value, $tags)
    {
        if (is_string($tags)) {
            $tags = [$tags];
        }
        foreach ($tags as $tag) {
            $pattern = sprintf('/<%s.*>.*<\/%s>/', $tag, $tag);
            $value = preg_replace($pattern, '', $value);
        }
        return $value;
    }

    protected function purify($value)
    {
        $purifier = app('html.purifier');
        return $purifier->purify($value);
    }

    protected function url($value)
    {
        return filter_var($value, FILTER_SANITIZE_URL);
    }

    protected function email($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
}
