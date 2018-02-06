<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 12:01
 */
namespace app\index\controller;
use app\index\controller\Base;
class Account extends Base {
    function account_index() {
        //呈现 新开账户
        return $this->fetch();
    }
}