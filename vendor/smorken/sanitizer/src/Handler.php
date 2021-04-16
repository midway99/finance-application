<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 8:30 AM
 */

namespace Smorken\Sanitizer;

use Smorken\Sanitizer\Contracts\Sanitize;
use Smorken\Sanitizer\Contracts\Sanitizer;

class Handler implements Sanitize
{

    protected $default;

    protected $sanitizers = [];

    public function __construct(array $options)
    {
        $this->setupSanitizers($options);
    }

    protected function setupSanitizers($options)
    {
        $this->default = array_get($options, 'default', 'standard');
        $sans = array_get($options, 'sanitizers', []);
        foreach ($sans as $k => $s) {
            $this->add($k, new $s);
        }
    }

    public function add($name, Sanitizer $sanitizer)
    {
        $this->sanitizers[$name] = $sanitizer;
    }

    /**
     * Call a sanitizer directly, defaults to the default sanitizer
     * @param string $type
     * @param mixed $value
     * @param null|string $sanitizer
     * @return mixed
     * @throws SanitizerException
     */
    public function sanitize($type, $value, $sanitizer = null)
    {
        $args = func_get_args();
        unset($args[2]);
        return $this->sanitizeCall($sanitizer, $args);
    }

    protected function sanitizeCall($sanitizer, $params)
    {
        $s = $this->get($sanitizer);
        return call_user_func_array([$s, 'sanitize'], $params);
    }

    /**
     * @param null|string $sanitizer
     * @return Sanitizer
     * @throws \Smorken\Sanitizer\SanitizerException
     */
    public function get($sanitizer = null)
    {
        if ($sanitizer === null) {
            $sanitizer = $this->default;
        }
        if ($this->exists($sanitizer)) {
            return $this->sanitizers[$sanitizer];
        }
        throw new SanitizerException("Unable to locate $sanitizer.");
    }

    /**
     * @param $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->sanitizers);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __call($name, $params)
    {
        $sanitizer = null;
        $args = [$name];
        if (isset($params[1]) && $this->exists($params[1])) {
            $sanitizer = $params[1];
            unset($params[1]);
        }
        $args = array_merge($args, $params);
        return $this->sanitizeCall($sanitizer, $args);
    }
}
