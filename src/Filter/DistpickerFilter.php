<?php

namespace SuperEggs\DcatDistpicker\Filter;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DistpickerFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $column = [];

    protected static $js = [
        '@extension/super-eggs/dcat-distpicker/dist/distpicker.min.js',
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
     * @param  string  $province
     * @param  string  $city
     * @param  string  $district
     * @param  string  $label
     */
    public function __construct($province, $city, $district, $label = '')
    {
        $this->column = compact('province', 'city', 'district');
        $this->label = $label;

        $this->setPresenter(new FilterPresenter());
    }


    public function originalColumn()
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getElementName()
    {
        return $this->parent->grid()->makeName('district');
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

        //todo 测试
        $value = array_filter([
            $this->column['province'] => Arr::get($inputs, $this->column['province']),
            $this->column['city'] => Arr::get($inputs, $this->column['city']),
            $this->column['district'] => Arr::get($inputs, $this->column['district']),
        ]);

        if (empty($value)) {
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
     * 建立关系查询
     * {@inheritdoc}
     */
    protected function buildRelationQuery($relColumn, ...$params)
    {
        $data = [];

        foreach ($relColumn as $column => $value) {
            Arr::set($data, $column, $value);
        }

        $relation = key($data);

        $args = $data[$relation];

        return [
            'whereHas' => [
                $relation, function ($relation) use ($args) {
                    call_user_func_array([$relation, $this->query], [$args]);
                },
            ],
        ];
    }

    /**
     * 格式名称
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

    /**
     * 格式编号
     * @param  array|string  $columns
     * @return array|string
     * @author guozhiyuan
     */
    protected function formatId($columns)
    {
        if (is_array($columns)) {
            $columns = 'district';
//            foreach ($columns as &$column) {
//                $column = $this->formatId($column);
//            }
//            return $columns;
        }

        return $this->parent->grid()->makeName('filter-column-'.str_replace('.', '-', $columns));
    }

    /**
     * 设置js脚本。
     * Setup js scripts.
     */
    protected function setupScript()
    {
        $province = old($this->column['province'], Arr::get($this->value, $this->column['province']));
        $city = old($this->column['city'], Arr::get($this->value, $this->column['city']));
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


    protected function defaultVariables()
    {
        $this->setupScript();

        $data = array_merge([
            'id' => $this->id,
            'name' => $this->formatName($this->column),
            'label' => $this->label,
            'value' => $this->normalizeValue(),
            'presenter' => $this->presenter(),
            'width' => $this->width,
            'style' => $this->style,
        ], $this->presenter()->variables());

        return $data;
    }

    public function render()
    {
        return view('china-distpicker::filter', $this->variables());
    }
}
