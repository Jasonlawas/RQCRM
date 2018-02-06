<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use \think\response\View;
class Index extends Base{
    //显示后台首页
    public function index(){
        //访问控制

        return view();
    }

    public function welcome() {
        return $this->fetch();
    }
}