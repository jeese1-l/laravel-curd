<?php

namespace laravelCurd\Command;

use Illuminate\Console\Command;
use laravelCurd\make\impl\ControllerAutoMake;
use laravelCurd\make\impl\ServiceAutoMake;
use laravelCurd\make\impl\ModelAutoMake;


class LaravelCurdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     *   protected $commands = [
     *      LaravelCurdCommand::class
     * ];
 *
     * @var string
     */
    /**
     * model dao 会根据表名称 创建对应文件  控制器会按照输入的值创建
     *  php80 .\artisan make:curd notice admin  notice
     * */
    protected $signature = 'make:curd {table} {path} {controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键生成curd';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $table = $this->argument("table");
        if (empty($table)) outPutError("table参数缺少");

        $path = $this->argument("path");
        if (empty($path)) outPutError("path参数缺少");

        $controller = $this->argument("controller");
        if (empty($controller)) outPutError("controller参数缺少");



        (new ModelAutoMake())->check($table, $path);
        (new ModelAutoMake())->make($table, $path, '');

        (new ServiceAutoMake())->check($table,$path);
        (new ServiceAutoMake())->make($table,$path,'');

        (new ControllerAutoMake())->check($controller,$path);
        (new ControllerAutoMake())->make($controller,$path,$table);
    }
}
