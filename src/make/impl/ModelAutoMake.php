<?php

namespace laravelCurd\make\impl;

use laravelCurd\make\IAutoMake;

class ModelAutoMake implements IAutoMake
{
    public function check($table, $path)
    {
        !defined('DS') && define('DS', DIRECTORY_SEPARATOR);

        $modelName = ucfirst(camelize($table));

        $dirPath = app_path() . DS . "Models" . DS . $path;

        $modelFilePath = $dirPath . DS . $modelName . 'Model.php';

        if (!is_dir($dirPath)) mkdir($dirPath, 0755, true);

        if (file_exists($modelFilePath)) outPutError($modelName . ".php已存在");
    }

    public function make($table, $path, $other)
    {
        $modelTpl = dirname(dirname(__DIR__)) . '/tpl/model.tpl';
        $tplContent = file_get_contents($modelTpl);

        $dirPath = app_path() . DS . "Models" . DS . $path;
        $modelName = ucfirst(camelize($table));
        $modelFilePath = $dirPath . DS . $modelName . 'Model.php';


        $tplContent = str_replace('<namespace>', $path, $tplContent);
        $tplContent = str_replace('<model>', $modelName, $tplContent);
        $tplContent = str_replace('<table>', $table, $tplContent);

        file_put_contents($modelFilePath, $tplContent);

        $baseModelPath = app_path() . DS . "Models" . DS . $path . DS . "BaseModel.php";
        // 检测base是否存在
        if (!file_exists($baseModelPath)) {
            $baseModelTpl = dirname(dirname(__DIR__)) . '/tpl/baseModel.tpl';
            $tplContent = file_get_contents($baseModelTpl);
            $tplContent = str_replace('<namespace>', $path, $tplContent);
            file_put_contents($baseModelPath, $tplContent);
        }
    }
}