<?php

namespace Ignittion\Short;

use Config;
use Illuminate\Support\ServiceProvider;

class ShortServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/shortcm.php' => config_path('shortcm.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('short', function () {
            $api    = Config::get('shortcm.api');
            $domain = Config::get('shortcm.domain');
            $key    = Config::get('shortcm.key');

            return new Short($api, $domain, $key);
        });

        
    }
}