<?php

// Register the extension.
Dcat\Admin\Admin::extend(\SuperEggs\DcatDistpicker\ChinaDistpicker::class);

Dcat\Admin\Grid\Filter::extend('distpicker', \SuperEggs\DcatDistpicker\Filter\DistpickerFilter::class);
