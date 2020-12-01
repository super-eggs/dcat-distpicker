<?php

namespace SuperEggs\DcatDistpicker;

use Illuminate\Support\ServiceProvider;
use Dcat\Admin\Form;
use SuperEggs\DcatDistpicker\Form\Distpicker;

class DcatDistpickerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = ChinaDistpicker::make();


        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, ChinaDistpicker::NAME);
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/super-eggs/dcat-distpicker')],
                'dcat-distpicker'
            );
        }
        Form::extend('distpicker', Distpicker::class);
    }

}
