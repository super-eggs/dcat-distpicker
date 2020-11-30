<?php

namespace Dcat\Admin\Extension\ChinaDistpicker;

use Dcat\Admin\AdminException;

class ChinaDistpicker extends Extension
{
    const NAME = 'china-distpicker';
    public $name = 'china-distpicker';

    protected $serviceProvider = ChinaDistpickerServiceProvider::class;

    protected $assets = __DIR__.'/../resources/assets';

    protected $views = __DIR__.'/../resources/views';

}
