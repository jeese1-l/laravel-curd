# laravel_curd

#### 介绍
laravel   curd 



#### 软件架构
php 扩展包

#### 安装教程

1.  composer require jeese/laravel_curd

#### 使用说明

1. 创建表格需要带有 create_time、update_time、delete_time 字段
2. 使用前须在 App\Console\Kernel 加入

    use laravelCurd\Command\LaravelCurdCommand;
    
    protected $commands = [
          LaravelCurdCommand::class
    ];

3. php artisan make:curd 表名 路径名称 控制器名称
4. 在控制器上方有路由注释，可以粘贴到路由文件里
5. 所有核心方法在baseService文件里
#### 借鉴
tp6 curd
https://github.com/nick-bai/tp6-curd
