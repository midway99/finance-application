<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 1/27/16
 * Time: 11:11 AM
 */

namespace Smorken\Sanitizer;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\ServiceProvider as SP;

class ServiceProvider extends SP
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path() . '/sanitizer.php',
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->registerResources();
        $this->app->bind(
            'Smorken\Sanitizer\Contracts\Sanitize',
            function ($app) {
                return new Handler(config('smorken/sanitizer::config', []));
            }
        );
        $this->app->bind('html.purifier', function($app) {
            $c = config('smorken/sanitizer::config.purifier_options', []);
            $config = HTMLPurifier_Config::createDefault();
            $config->loadArray($c);
            return new HTMLPurifier($config);
        });
    }

    protected function registerResources()
    {
        $userconfigfile = sprintf('%s/sanitizer.php', config_path());
        $packageconfigfile = sprintf('%s/../config/%s.php', __DIR__, 'config');
        $this->registerConfig($packageconfigfile, $userconfigfile, 'smorken/sanitizer::config');
    }

    protected function registerConfig($packagefile, $userfile, $namespace)
    {
        $config = $this->app['files']->getRequire($packagefile);
        if (file_exists($userfile)) {
            $userconfig = $this->app['files']->getRequire($userfile);
            $config = array_replace_recursive($config, $userconfig);
        }
        $this->app['config']->set($namespace, $config);
    }
}
