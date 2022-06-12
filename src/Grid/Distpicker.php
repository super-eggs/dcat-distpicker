<?php

namespace SuperEggs\DcatDistpicker\Grid;

use Dcat\Admin\Grid\Displayers\AbstractDisplayer;
use SuperEggs\DcatDistpicker\DcatDistpickerHelper;

class Distpicker extends AbstractDisplayer
{
    public function display()
    {
        return DcatDistpickerHelper::getAreaName($this->value);
    }
}
