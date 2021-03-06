<?php

namespace Xdm\Ipnet;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class IpnetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/ipnet.php' => config_path('ipnet.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Xdm\Ipnet\Commands\UpdateCommand');
    }
}