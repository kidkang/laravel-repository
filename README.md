#1.命令

## 1.1php artisan make:rep name --options

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
|--t||生成上述文件的同时，生成test文件

###例子：
```
php artisan make:rep User;

```
>生成以下文件

1. app/Repositories/User.php 
2. app/Repositories/Contracts/UserInterface.php
3. app/Repositories/Eloquent/UserRepository.php

```
php artisan make:rep --r; 
```
>生成以下文件

1.app/Repositories/Eloquent/UserRepository.php


```
php artisan make:rep --a; 
```
>生成以下文件

1.app/Repositories/User.php

```
php artisan make:rep --i;
```
>生成以下文件

1. app/Repositories/Contracts/UserInterface.php

```
php artisan make:rep User --m;

```
> 生成以下文件

1. app/Repositories/User.php 
2. app/Repositories/Contracts/UserInterface.php
3. app/Repositories/Eloquent/UserRepository.php
4. app/Models/User

```
php artisan make:rep Test --t; 
```
>生成以下文件

1. app/Repositories/User.php 
2. app/Repositories/Contracts/UserInterface.php
3. app/Repositories/Eloquent/UserRepository.php
4. test/Repositories/UserTest.php

```
php artisan make:rep Test --mf --t; 
```
>生成以下文件

1. app/Repositories/User.php 
2. app/Repositories/Contracts/UserInterface.php
3. app/Repositories/Eloquent/UserRepository.php
4. test/Repositories/UserTest.php
5. test/Models/UserTest.php
6. database/factories/UserFactory.php

##1.2 php artisan rep:publish
> 如果手动创建repositories 当中的文件，请手动进行发布文件，不然会报错



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



