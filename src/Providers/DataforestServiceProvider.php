<?php

namespace Dataforest\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Dataforest\Components\DataforestTable;

class DataforestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../../config/dataforest.php' => config_path('dataforest.php'),
        ], 'dataforest-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/dataforest'),
        ], 'dataforest-views');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'dataforest');

        // Register Livewire components
        Livewire::component('dataforest-table', DataforestTable::class);
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/dataforest.php', 'dataforest'
        );
    }
}
