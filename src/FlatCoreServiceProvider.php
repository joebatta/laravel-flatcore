<?php

namespace Flatcore;

use Illuminate\Support\ServiceProvider;

class FlatCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/flatcore.php', 'flatcore');
    }

    public function boot()
    {

    }
}
