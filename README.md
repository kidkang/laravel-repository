#命令

## 1.php artisan make:rep name --options

>默认生成 repository interface abstract

|参数|可选|备注|
|:--:|:--:|:--
|name|是|要生成文件的名字
|option|否|
|--i||生成Interface
|--a||生成abstract
|--r||生成Repository
|--ra||生成继承abstract的Repository
|--ri 或者--ir||生成repository和interface（之前的设计模式）
|--m||生成上述文件的通时，生成model文件
|--mf||生成上述文件的同时，生成model和factory文件

###例子：

```
php artisan make:rep;
php artisan make:rep --r; //生成repository
php artisan make:rep --m; //生成model

```



# 基类() Repository方法

## 1.1 index($where)

>获取符合条件的第一条数据

## 1.2 update($where,$data)

> 更新符合条件的数据

## 1.3 page($page)

> 分页数据


## 1.4 add($data)

> 新增数据，返回新增的模型

## 1.5findByField($field,$value)

> 查找符合field条件的第一条数据

## 1.6 list($where)
> 查找符合条件的数据 返回全部



