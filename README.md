# dcat-distpicker

[Distpicker](https://github.com/fengyuanchen/distpicker) 是一个中国省市区三级联动选择组件，这个包是基于 `Distpicker` 的 `dcat-admin`
扩展，用来将 `Distpicker` 集成进 `dcat-admin`的表单中。如果此插件给你带来的帮助，麻烦给我一个 `star`。如果在使用过程中发现地区不完整的情况，欢迎随时反馈给我。

## 推荐环境

- php >= 7.4
- laravel >= v8.0.0
- dcat-admin >= v2.2.0

## 截图

![image-20200628150204971](https://tva1.sinaimg.cn/large/007S8ZIlly1gg80kgiwpcj32000iajt9.jpg)

## 安装

首先

```shell
# jqhph/dcat-admin 1.x
composer require "super-eggs/dcat-distpicker:^1.0"

# jqhph/dcat-admin 2.x
composer require "super-eggs/dcat-distpicker:^2.0"
```

然后: (dcat-admin 2.x 无需执行!!!)

```shell
php artisan admin:import dcat-distpicker
```

## 开启扩展

后台开启

- dcat-admin 1.x
  ![image-20200628150337687](https://tva1.sinaimg.cn/large/007S8ZIlly1gg80m0xbf8j321m0iaq5b.jpg)
- dcat-admin 2.x
  ![image-20201201230850804](https://i.loli.net/2020/12/01/cqbR7FIiErZTzeY.png)

## 使用

### 数据表单中使用

比如在表中有三个字段`province_id`, `city_id`, `district_id`, 在form表单中使用它：

```php
$form->distpicker(['province_id', 'city_id', 'district_id']);
```

设置默认值

```php
$form->distpicker([
    'province_id' => '省份',
    'city_id' => '市',
    'district_id' => '区'
], '地域选择')->default([
    'province' => 130000,
    'city'     => 130200,
    'district' => 130203,
]);
```

可以设置每个字段的placeholder

```php
// 省、市、区
$form->distpicker([
    'province_id' => '省',
    'city_id'     => '市',
    'district_id' => '区'
]);
// 省、市 (Available in v2.1.0+)
$form->distpicker([
    'province_id' => '省',
    'city_id'     => '市',
]);
// 只显示省 (Available in v2.1.0+)
$form->distpicker([
    'province_id' => '省',
]);
```

设置label

```php
$form->distpicker(['province_id', 'city_id', 'district_id'], '请选择区域');
```

设置自动选择, 可以设置1,2,3 表示自动选择到第几级

```php
$form->distpicker(['province_id', 'city_id', 'district_id'])->autoselect(1);
```

### 表格筛选中使用

```php
$filter->distpicker('province_id', 'city_id', 'district_id', '地域选择');
```

筛选同样支持多级选择:

```php
// 省、市 (Available in v2.1.0+)
$filter->distpicker('province_id', 'city_id','', '地域选择');
//or
$filter->distpicker('province_id', 'city_id');
// 只显示省 (Available in v2.1.0+)
$filter->distpicker('province_id','','', '地域选择');
//or
$filter->distpicker('province_id');
```

### 数据表格中使用

省市区名称回显 (Available in v2.1.0+):

```php
$grid->column('province_id')->distpicker();
$grid->column('city_id')->distpicker();
$grid->column('district_id')->distpicker();
```

并且提供了一个全局可用的辅助函数:

```php
use SuperEggs\DcatDistpicker\DcatDistpickerHelper;

DcatDistpickerHelper::getAreaName($code); // return string
```

## 地区编码数据

[Distpicker](https://github.com/fengyuanchen/distpicker) 所使用的地域编码是基于国家统计局发布的数据, 数据字典为`china_area.json`文件.

## 鸣谢

由衷感谢以下开源软件、框架等（包括但不限于）

- [laravel](https://laravel.com)
- [jqhph/dcat-admin](https://github.com/jqhph/dcat-admin)
- [fengyuanchen/distpicker](https://github.com/fengyuanchen/distpicker)
- [laravel-admin-extensions/china-distpicker](https://github.com/laravel-admin-extensions/china-distpicker)

License
------------
licensed under [The MIT License (MIT)](LICENSE).
