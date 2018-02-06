<?php
namespace app\index\controller;
use app\admin\model\User;
use app\index\controller\Base;
use \think\response\View;
class Index extends Base{
    public function index()
    {
            return $this->fetch('index');

    }
    //欢迎语
    public function welcome(){
        return view();
    }
}
