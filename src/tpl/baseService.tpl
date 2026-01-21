<?php

namespace App\Service;

abstract class BaseService
{
    abstract public function setModel(): string;

    public function getModel()
    {
        return app()->make($this->setModel());
    }


    public function getList($where = [], $pageInfo = [], $isall = false, $with = [], $relation = "", $hasWhere = [],$order='',$orderSort='desc')
    {
        $query = $this->getModel()->whereNull("delete_time");
        if ($where) $query = $query->where($where);
        if ($with) $query = $query->with($with);
        if ($hasWhere && $relation) $query = $query->whereHas($relation, $hasWhere);
        if ($order) $query = $query->orderBy($order,$orderSort);
        if (!$isall) $query = $query->skip($pageInfo['begin'])->take($pageInfo["limit"]);
        return $query->get()->toArray();
    }


    public function getPageInfo()
    {
        $request = $_REQUEST;
        $page = isset($request['page']) ? $request["page"] : 1;
        $limit = isset($request['limit']) ? $request["limit"] : 10;
        if ($page) $begin = ($page - 1) * $limit;
        return ['page' => $page ?? 1, 'limit' => $limit ?? 10, 'begin' => $begin ?? 0];
    }

    public function getCount($where = [], $with = [], $relation = "", $hasWhere = [])
    {
        $query = $this->getModel()->whereNull("delete_time");
        if ($where) $query = $query->where($where);
        if ($with) $query = $query->with($with);
        if ($hasWhere && $relation) $query = $query->whereHas($relation, $hasWhere);
        return $query->count();
    }

    public function getPageList($where, $with = [], $relation = "", $hasWhere = [])
    {
        $pageInfo = $this->getPageInfo();
        $list = $this->getList($where, $pageInfo, false, $with, $relation, $hasWhere);
        $count = $this->getCount($where, $with, $relation, $hasWhere);
        return ["list" => $list, "total" => $count];
    }

    public function getOne($condition, $with = [], $hasWhere = [])
    {
        !is_array($condition) ? $where["id"] = $condition : $where = $condition;
        $query = $this->getModel()->whereNull("delete_time");
        if ($with) $query = $query->with($with);
        if ($hasWhere) $query = $query->hasWhere($hasWhere);
        return $query->where($where)->get();
    }

    public function del($condition)
    {
        !is_array($condition) ? $where["id"] = $condition : $where = $condition;
        $query = $this->getModel();
        return $query->where($where)->update(["delete_time" =>date("Y-m-d H:i:s")]);
    }


    public function save($data)
    {
        if (empty($data)) return outPutError("参数不能为空");
        $data["create_time"] = date("Y-m-d H:i:s");
        $data["update_time"] = date("Y-m-d H:i:s");
        return $this->getModel()->insert($data);
    }


    public function edit($data){
        if (empty($data)) return outPutError("参数不能为空");
        if (empty($this->getOne($data['id']))) return outPutError("数据不存在");
        return $this->getModel()->whereNull("delete_time")->where([["id","=",$data["id"]]])->update($data);
    }

}