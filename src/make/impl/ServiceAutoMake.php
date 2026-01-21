<?php

namespace laravelCurd\make\impl;

use laravelCurd\make\IAutoMake;
class ServiceAutoMake implements IAutoMake
{
    public function check($table, $path)
    {
        !defined('DS') && define('DS', DIRECTORY_SEPARATOR);
        $serviceName = ucfirst($table);
        $dirPath = app_path() . DS . "Service" . DS . $path ;
        $controllerFilePath = $dirPath . DS . $serviceName . ".php";

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        if (file_exists($controllerFilePath)) {
            outPutError($serviceName . ".php文件已存在");
            exit;
        }
    }
    public function make($table, $path, $other)
    {
        $serviceTpl = dirname(dirname(__DIR__)) . '/tpl/service.tpl';
        $serviceTplContent = file_get_contents($serviceTpl);

        $serviceName = ucfirst(camelize($table));
        $modelName = ucfirst(camelize($table));

        $dirPath = app_path() . DS . "Service" . DS . $path ;
        $serviceFilePath = $dirPath . DS . $serviceName . 'Service.php';

        $serviceTplContent = str_replace('<namespace>', $path, $serviceTplContent);
        $serviceTplContent = str_replace('<table>', $serviceName, $serviceTplContent);
        $serviceTplContent = str_replace('<model>', $modelName, $serviceTplContent);
        $serviceTplContent = str_replace('<path>', $path, $serviceTplContent);
        $serviceTplContent = str_replace('<serviceName>', $serviceName, $serviceTplContent);

        file_put_contents($serviceFilePath, $serviceTplContent);

        $baseServicePath = app_path() . DS . "Service"  . DS . "BaseService.php";
        // 检测base是否存在
        if (!file_exists($baseServicePath)) {
            $baseDaoTpl = dirname(dirname(__DIR__)) . '/tpl/baseService.tpl';
            $tplContent = file_get_contents($baseDaoTpl);
            $tplContent = str_replace('<namespace>', $path, $tplContent);
            file_put_contents($baseServicePath, $tplContent);
        }

    }
}