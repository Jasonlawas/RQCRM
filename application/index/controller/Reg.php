<?php
namespace app\index\controller;
use app\admin\model\User;
use \think\Controller;
use \think\response\View;
class Reg extends Controller{
    public function index()
    {
            return view('reg');
    }

    public function check(){
        //接受ajax传值验证用户唯一性
        $arr=$this->request->param();
        $email=$arr['email'];
        $result=\think\Db::table('crm_user')->where('email',$email)->select();
        if(empty($result)){
            echo 'error'; //为空 说明邮箱没有被注册
        }else{
            echo 'ok';
        }
    }
    /*
     * 通过post传输接收数据存入数据库
     * */
    public function save(){
        $arr=$this->request->param();
        $arr['password']=md5($arr['password']);
        // 过滤post数组中的非数据表字段数据 $user->allowField(true)->save(); allowFiled()括号里为true
        $user = new User($arr); // 过滤post数组中的非数据表字段数据
        $result=$user->allowField(true)->save();
        if($result){
            $this->success('注册成功',url('index/login/index'));
        }else{
            $this->error('注册失败',url('index/reg/index'));
        }

    }
}
