<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 9:26
 */
namespace app\index\controller;
class Member extends Base {
    function member_index () {
        return $this->fetch();
    }
}