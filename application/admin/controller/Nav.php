<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use \think\response\View;
class Nav extends Base{
    public function index(){
        //查询数据库
        $category=new \app\admin\model\Category();
        $categoryArray=$category->paginate(5);
        foreach ($categoryArray as $key => $value) {
            if ($value['c_p_id']==0) {
                $categoryArray[$key]['p_name']="顶级分类";
            }else{
                $re=$category->where("c_id='".$value['c_p_id']."'")->find();
                $categoryArray[$key]['p_name']=$re['c_name'];
            }
        }
        return view('index',['categoryArray'=>$categoryArray]);
        //1.// 查询状态为1的用户数据 并且每页显示10条数据
        //2.$list = Db::name('user')->where('status',1)->paginate(10);
        //3.// 把分页数据赋值给模板变量list
        //4.$this->assign('list', $list);
        //5.// 渲染模板输出6.return $this->fetch();
    }
    //导航添加显示页面
    public function navAdd(){
        //实例化type
        $category=new \app\admin\model\Category();
        $str=$category->getOneToOption();
        $this->assign('str',$str);
        return $this->fetch();
    }
    //保存导航添加的数据
    public function navSave(){
        $arr=$this->request->param();
        //添加时间
        $arr['c_createdate']=date('Y-m-d H:i:s',time());
        $category=new \app\admin\model\Category();
        $result=$category->save($arr);
        if($result){
            return redirect('admin/nav/index');
        }else{
            $this->error('添加失败',url('admin/nav/index'));
        }
    }
    //编辑导航
    public function navUpdate() {
            $category = new \app\admin\model\Category();
            $id = $this->request->param('id');
            $cateArr  = $category->where('c_id',$id)->find();
            $str = $category->getOneToOption($cateArr['c_p_id']);
            $this->assign('cateArr',$cateArr);
            $this->assign('categoryArr',$str);
            return $this->fetch();
        }

    public function navUsave(){
        $category = new \app\admin\model\Category();
        $arr =$this->request->param();
        //修改时间
        $arr['c_createdate'] = date('Y-m-d H:i:s',time());
        $id = $arr['c_id'];
        $result = $category->where('c_id',$id)->update($arr);
        if($result){
            return redirect('admin/nav/index');
        }else{
            $this->error('修改失败',url('admin/nav/index'));
        }
    }
    //删除
    public function navDel() {
        $id = $this->request->param('id');
        $category = new \app\admin\model\Category();
        $result = $category->where('c_p_id',$id)->find();
        if($result) {
            echo "<script>alert('存在下级导航,删除失败');window.location.href='".url('admin/nav/index')."'</script>";
        }else{
            $re = $category->where('c_id',$id)->delete();
            if($re) {
                return redirect('admin/nav/index');
            }else{
                $this->error('删除失败',url('admin/nav/index'));
            }

        }
    }
}