<?php
namespace app\admin\controller;
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
        $password=md5($arr['password']);
        $email=$arr['email'];
        $result=\think\Db::name('admin')->where('ad_email',$email)->where('ad_password',$password)->find();
        if($result){
            setcookie('username',$result['ad_name'],0,'/');
            setcookie('userid',$result['ad_id'],0,'/');
            $this->success('登录成功',url('admin/index/index'),'','1');
        }else{
            $this->error('登录失败',url('admin/login/index'),'','1');
        }

    }


    //用户安全退出
    public function logout(){
        setcookie('userid',null,-1,'/');
        setcookie('username',null,-1,'/');
        $this->redirect(url('admin/login/index'));
    }
}