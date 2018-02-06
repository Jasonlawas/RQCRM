<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 11:11
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\User;
use app\admin\model\Account;
class Member extends Base {
    /*@param  clientlist  直接客户页面
     *@param  material    客户列表中 个人资料 详细模板
     * */
    public function  client_list() {
        $user = new User();
        $result = $user->paginate(3);
        foreach($result as $k=>$v){
            $agency = $user->where('u_id',$v->u_ib_id)->where('u_roles',1)->find();
            $result[$k]['agency']= $agency['u_name'];

            $sales = $user->where('u_id',$v->u_sales_id)->where('u_roles',2)->find();
            $result[$k]['sales']= $sales['u_name'];
        }
        $count = $user->count();
        $this->assign('count',$count);
        $this->assign('result',$result);
        return $this->fetch();
    }
    public function material() {
        $id = $this->request->param('id');
        $user = new User();
        $result = $user->where('u_id',$id)->find();
        $agency = $user->where('u_id',$result->u_ib_id)->find();
        $sales = $user->where('u_id',$result->u_sales_id)->where('u_roles',2)->find();
        $result['agency'] = $agency['u_name'];
        $result['seles'] = $sales['u_name'];
        $this->assign('result',$result);
        return $this->fetch();
    }
    /*@param iblist 代理客户
     *@param ib_client 名下客户弹窗模板
     *@param ib_account 名下账户弹窗模板
     * */
    public function iblist() {
        $user = new User();
        $account = new Account();
        // 根据 账户表所关联用户表的userid查询 到上级代理
       $result = $user->alias('u')
                ->join('crm_account a','u.u_id=a.a_userid')
                ->where('u_roles',1)
                ->field('u.*,a.a_name as agency')
                ->paginate(10);
            foreach ($result as $k=>$v){
                $num = 0;
                $clientNum = $user ->where('u_ib_id',$v->u_id)->where('u_roles',0)->count();
                //查找名下账户,根据名下客户u_id 到  账户表中 a_uereid 所关联的字段
                $client = $user->where('u_ib_id',$v->u_id)->where('u_roles',0)->select();
                foreach ($client as $k2=>$v2){
                    $accountNum = $account->where('a_userid',$v2['u_id'])->count();
                    $num += $accountNum;
                    $result[$k]['accountNum'] = $num;
                    if($clientNum != 0){
                        $result[$k]['clientNum'] = $clientNum;
                    }
                }

            }

                $count = $user->where('u_roles',0)->count();
                $this->assign('count',$count);
                $this->assign('result',$result);
                return $this->fetch();
    }
    public function ib_client() {
        $user = new User();
        $id = $this->request->param('id');
        //根据 传过来的用户id  , 查询到 名下为客户的数据;
        $clientArr = $user->where('u_ib_id',$id)->where('u_roles',0)->paginate(4);
        foreach ($clientArr as $k=>$v){
            $agency = $user->where('u_id',$v->u_ib_id)->find();
            //查询是否为销售状态
            $sales = $user->where('u_id',$v->u_sales_id)->where('u_roles',2)->find();
            $clientArr[$k]['sales'] = $sales['u_name'];
            $clientArr[$k]['agency'] = $agency['u_name'];
        }
        $this->assign('clientArr',$clientArr);
        return $this->fetch();
    }
    public function ib_account() {
        $user = new User();
        $account = new Account();
        $u_id = $this->request->param('id');
        $clientArr = $user ->where('u_ib_id',$u_id)->where('u_roles',0)->paginate(4);
        foreach ($clientArr as $k=>$v){
            $accountArr = $account->where('a_userid',$v->u_id)->find();
            $agency = $user ->where('u_id',$v->u_ib_id)->find();
            $clientArr[$k]['u_account'] = $accountArr['a_account'];
            $clientArr[$k]['u_agency']  = $agency['u_name'];
            $clientArr[$k]['accountCreateDate'] = $accountArr['a_createdate'];

        }
        $this->assign('clientArr',$clientArr);
        return $this->fetch();
    }
    /*@param pendingevent 待处理项
     * */
    public function pendingevent() {

        return $this->fetch();
    }
}