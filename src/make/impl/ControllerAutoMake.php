<?php

namespace laravelCurd\make\impl;

use laravelCurd\make\IAutoMake;

class ControllerAutoMake implements IAutoMake
{
    public function check($controller, $path)
    {
        !defined('DS') && define('DS', DIRECTORY_SEPARATOR);

        $controller = ucfirst($controller);
        $dirPath = app_path() . DS . "Http" . DS . "Controllers" . DS . $path;
        $controllerFilePath = $dirPath . DS . $controller . ".php";

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        if (file_exists($controllerFilePath)) {
            outPutError($controller . "controller已存在");
            exit;
        }
    }

    public function make($controller, $path, $table)
    {
        $controllerTpl = dirname(dirname(__DIR__)) . '/tpl/controller.tpl';
        $tplContent = file_get_contents($controllerTpl);
        $controllerName = ucfirst(camelize($controller));
        $serviceName = ucfirst(camelize($table));

        $tplContent = str_replace('<namespace>', $path, $tplContent);
        $tplContent = str_replace('<path>', $path, $tplContent);
        $tplContent = str_replace('<controller>', $controllerName, $tplContent);
        $tplContent = str_replace('<service>', $serviceName, $tplContent);

        $dirPath = app_path() . DS . "Http" . DS . "Controllers" . DS . $path;
        $controllerFilePath = $dirPath . DS . $controllerName . ".php";

        file_put_contents($controllerFilePath, $tplContent);

        $baseControllerPath = app_path().DS . "Http" . DS . "Controllers" . DS . $path . DS . "Base.php";

        // 检测base是否存在
        if (!file_exists($baseControllerPath) ){
            $controllerTpl = dirname(dirname(__DIR__)) . '/tpl/baseController.tpl';
            $tplContent = file_get_contents($controllerTpl);
            $tplContent = str_replace('<namespace>', $path, $tplContent);
            file_put_contents($baseControllerPath, $tplContent);
        }
    }
}