<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 17:26
 */
namespace app\admin\controller;
use app\admin\controller\Base;
class Order extends Base {
    function index () {
        return $this->fetch();
    }
    function ok(){

    }
}