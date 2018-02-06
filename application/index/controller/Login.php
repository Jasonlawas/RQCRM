<?php
namespace app\index\controller;
use \think\Controller;
use app\admin\model\User;
use \think\response\View;
class Login extends Controller{
    //显示登录页
    public function index(){
        /* return $this->fetch();*/
        return view();
    }
    //将用户数据与数据库比对
    public function save(){
        $arr=$this->request->param();
        print_($arr);
        $password=md5($arr['password']);
        $email=$arr['email'];
        $user = new User();
        $result=$user->where('email',$email)->where('password',$password)->find();
        if($result){
           // setcookie('username',$result['u_name'],0,'/');
            setcookie('userid',$result['id'],0,'/');
           /* $this->success('登录成功',url('/'),'','1');*/
           return redirect(url('/'));
        }else{
            $this->error('账号或密码不正确',url('index/login/index'),'','2');
        }
    }
    //用户安全退出
    public function logout(){
        setcookie('userid',null,-1,'/');
        setcookie('username',null,-1,'/');
        $this->redirect(url('index/login/index'));
    }
}