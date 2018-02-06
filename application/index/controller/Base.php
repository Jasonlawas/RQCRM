<?php
namespace app\index\controller;
use \think\Controller;
class Base extends  Controller{
    //访问控制
    public function _initialize() {
        if(!isset($_COOKIE['userid'])){
            $this->error('请先登录','index/login/index');
        }
    }

}