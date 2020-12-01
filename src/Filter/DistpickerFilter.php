<?php

namespace SuperEggs\DcatDistpicker\Filter;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dcat\Admin\Grid\Filter;

class DistpickerFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $column = [];

    protected static $js = [
        'vendor/super-eggs/dcat-distpicker/dist/distpicker.min.js'
    ];

    /**
     * @var array
     */
    protected $value = [];

    /**
     * @var array
     */
    protected $defaultValue = [];

    /**
     * DistpickerFilter constructor.
     *
     * @param string $province
     * @param string $city
     * @param string $district
     * @param string $label
     */
    public function __construct($province, $city, $district, $label = '')
    {
        $this->column = compact('province', 'city', 'district');
        $this->label  = $label;

        $this->setPresenter(new FilterPresenter());
    }

    public function setParent(Filter $filter)
    {
        $this->parent = $filter;

        $this->id = $this->formatId($this->column);
    }


    /**
     * {@inheritdoc}
     */
    public function getColumn()
    {
        $columns = [];

        $parentName = $this->parent->getName();

        foreach ($this->column as $column) {
            $columns[] = $parentName ? "{$parentName}_{$column}" : $column;
        }

        return $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function condition($inputs)
    {
        $value = array_filter([
            $this->column['province'] => Arr::get($inputs, $this->column['province']),
            $this->column['city']     => Arr::get($inputs, $this->column['city']),
            $this->column['district'] => Arr::get($inputs, $this->column['district']),
        ]);

        if (!isset($value)) {
            return;
        }

        $this->value = $value;

         if (!$this->value) {
            return [];
        }


        if (Str::contains(key($value), '.')) {
            return $this->buildRelationQuery($value);
        }

        return [$this->query => [$value]];
    }

    /**
     * {@inheritdoc}
     */
    protected function buildRelationQuery(...$columns)
    {
        $data = [];

        foreach ($columns as $column => $value) {
            Arr::set($data, $column, $value);
        }

        $relation = key($data);

        $args = $data[$relation];

        return ['whereHas' => [$relation, function ($relation) use ($args) {
            call_user_func_array([$relation, $this->query], [$args]);
        }]];
    }

    /**
     * {@inheritdoc}
     */
    public function formatName($column)
    {
        $columns = [];

        foreach ($column as $col => $name) {
            $columns[$col] = parent::formatName($name);
        }

        return $columns;
    }

    protected function formatId($columns)
    {
        return str_replace('.', '_', $columns);
    }

    /**
     * Setup js scripts.
     */
    protected function setupScript()
    {
        $province = old($this->column['province'], Arr::get($this->value, $this->column['province']));
        $city     = old($this->column['city'], Arr::get($this->value, $this->column['city']));
        $district = old($this->column['district'], Arr::get($this->value, $this->column['district']));

        $script = <<<JS
$("#{$this->id}").distpicker({
  province: '$province',
  city: '$city',
  district: '$district'
});
JS;
        Admin::script($script);
        Admin::js(static::$js);
    }

    /**
     * {@inheritdoc}
     */
    public function variables()
    {
        $this->id = 'distpicker-filter-' . uniqid();

        $this->setupScript();

        return array_merge([
            'id'        => $this->id,
            'name'      => $this->formatName($this->column),
            'label'     => $this->label,
            'value'     => $this->value ?: $this->defaultValue,
            'presenter' => $this->presenter(),
        ], $this->presenter()->variables());
    }

    public function render()
    {
        return view('china-distpicker::filter', $this->variables());
    }
}
