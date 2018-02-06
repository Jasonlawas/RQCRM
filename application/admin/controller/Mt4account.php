<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/15
 * Time: 12:12
 */
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Account;
use app\admin\model\User;
class Mt4account extends Base {
    /*@param clientaccount 客户账号
     * */
    public function clientaccount() {
        $account = new Account();
        $user    = new User();
        $accountArr = $account->paginate(10);
        foreach ($accountArr as $k=>$v){
            $userArr = $user -> where('u_id',$v->a_userid)->select();
            foreach ($userArr as $value) {
                $agencyArr = $user -> where('u_id',$value->u_ib_id)->find();
                $salesArr = $user->where('u_id',$value->u_sales_id)->where('u_roles',2)->find();
                $accountArr[$k]['a_agency'] = $agencyArr['u_name'];
                $accountArr[$k]['a_sales']  = $salesArr['u_name'];
            }
        }
        $this->assign('accountArr',$accountArr);
        return $this->fetch();
    }
}