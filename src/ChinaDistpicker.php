<?php

namespace SuperEggs\DcatDistpicker;

use Dcat\Admin\Extension;

class ChinaDistpicker extends Extension
{
    const NAME = 'china-distpicker';
    public $name = 'china-distpicker';

    protected $serviceProvider = DcatDistpickerServiceProvider::class;

    protected $assets = __DIR__.'/../resources/assets';

    protected $views = __DIR__.'/../resources/views';

}
