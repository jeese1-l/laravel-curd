<?php

namespace App\Http\Controllers\<namespace>;

use App\Service\<path>\<service>Service;
use Illuminate\Http\Request;


// Route::get('<controller>List',[\App\Http\Controllers\<path>\<controller>::class,"getList"]);
// Route::get('<controller>Detail',[\App\Http\Controllers\<path>\<controller>::class,"detail"]);
// Route::get('<controller>Insert',[\App\Http\Controllers\<path>\<controller>::class,"save"]);
// Route::get('<controller>Del',[\App\Http\Controllers\<path>\<controller>::class,"del"]);
// Route::get('<controller>Edit',[\App\Http\Controllers\<path>\<controller>::class,"edit"]);

class <controller> extends Base
{

    //查询
    public function getList(Request $request)
    {
        $input =  $request->all();
        $list =  (new <service>Service())->_getList($input);
        outPutSucc($list);
    }

    //详情
    public function detail(Request $request)
    {
        $id = $request->get("id");
        $info = (new <service>Service())->_detail($id);
        outPutSucc($info);
    }

    //删除
    public function del(Request $request)
    {
        $id = $request->post("id");
        $info = (new <service>Service())->_del($id);
        outPutSucc($info, "操作成功");
    }

    //插入
    public function save(Request $request)
    {
        $data = $request->post();
        $res = (new <service>Service())->_save($data);
        outPutSucc($res, "请求成功");
    }



    public function edit(Request $request){
        $data = $request->post();
        $res = (new <service>Service())->_edit($data);
        outPutSucc($res, "请求成功");
    }
}
