<?php

namespace App\Service\<namespace>;

use App\Models\<path>\<table>Model;
use App\Service\BaseService;

class <serviceName>Service extends BaseService
{
    public function setModel():string
    {
        return <model>Model::class;
    }

    public function _getList($param)
    {
        $where = [];
        $with = [];
        return $this->getPageList($where,$with);
    }


    public function _detail($id)
    {
        if (empty($id)) outPutError("参数不能为空");
        $with = [];
        return $this->getOne($id,$with);
    }

    public function _del($condition)
    {
        if (empty($condition)) outPutError("参数不能为空");
        return $this->del($condition);
    }

    public function _save($data){
        if (empty($data)) outPutError("参数不能为空");
        return $this->save($data);
    }

    public function _edit($data){
        if (empty($data)) outPutError("参数不能为空");
        return $this->edit($data);
    }
}
