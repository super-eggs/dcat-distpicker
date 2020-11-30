<?php

namespace SuperEggs\DcatDistpicker;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;


class DcatDistpickerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'china-distpicker');

        //加载插件
        Admin::booting(function () {
            Form::extend('distpicker', \SuperEggs\DcatDistpicker\Form\Distpicker::class);
            Filter::extend('distpicker', \SuperEggs\DcatDistpicker\Filter\DistpickerFilter::class);

        });
        //

    }

}
