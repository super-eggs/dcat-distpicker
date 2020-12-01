# dcat-distpicker

[Distpicker](https://github.com/fengyuanchen/distpicker)是一个中国省市区三级联动选择组件，这个包是基于 `Distpicker` 的 `dcat-admin` 扩展，用来将 `Distpicker` 集成进 `dcat-admin`的表单中.

## 截图

![image-20200628150204971](https://tva1.sinaimg.cn/large/007S8ZIlly1gg80kgiwpcj32000iajt9.jpg)

## 安装

首先

```shell script
# jqhph/dcat-admin 1.x
composer require "super-eggs/dcat-distpicker:^1.0"

# jqhph/dcat-admin 2.x
composer require "super-eggs/dcat-distpicker:^2.0"
```

然后: (dcat-admin 2.x 无需执行!!!)

```shell script
php artisan admin:import dcat-distpicker
```

## 开启扩展

后台开启

- dcat-admin 1.x
![image-20200628150337687](https://tva1.sinaimg.cn/large/007S8ZIlly1gg80m0xbf8j321m0iaq5b.jpg)
- dcat-admin 2.x
![image-20201201230850804](https://i.loli.net/2020/12/01/cqbR7FIiErZTzeY.png)

## 使用

### 表单中使用

比如在表中有三个字段`province_id`, `city_id`, `district_id`, 在form表单中使用它：

```
$form->distpicker(['province_id', 'city_id', 'district_id']);
```

设置默认值

```
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

```
$form->distpicker([
    'province_id' => '省',
    'city_id'     => '市',
    'district_id' => '区'
]);
```

设置label

```
$form->distpicker(['province_id', 'city_id', 'district_id'], '请选择区域');
```

设置自动选择, 可以设置1,2,3 表示自动选择到第几级

```
$form->distpicker(['province_id', 'city_id', 'district_id'])->autoselect(1);
```

### 表格筛选中使用

```
$filter->distpicker('province_id', 'city_id', 'district_id', '地域选择');
```

## 地区编码数据

[Distpicker](https://github.com/fengyuanchen/distpicker)所使用的地域编码是基于国家统计局发布的数据, 数据字典为`china_area.sql`文件.
