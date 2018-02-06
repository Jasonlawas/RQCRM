<?php
namespace app\admin\model;
use think\Model;
class Category extends Model{
    function getOneToOption($pid=''){
        //获取一级分类
        $oneArr=$this->where('c_p_id',0)->select();
        $str='';
        //循环遍历
        foreach($oneArr as $v){//此处$v是个对象
            if($pid==$v->c_id){
                $str .="<option selected='selected' value='{$v->c_id}'>{$v->c_name}</option>";
            }else{
                $str .="<option value='{$v->c_id}'>{$v->c_name}</option>";
            }
        }
        return $str;
    }
    function getToOption($c_id=''){
        //获取一级分类的名字
        $str='';//声明一个变量为空.为了等下去接收值
        //可以使用两个where ,因为有两个where条件,当后面的where变成whereOr就相当于或,否者就是and(与)的意思
        $oneArr=$this->where('c_p_id',0)->select();
        foreach($oneArr as  $v){
            $str .="<optgroup label='{$v->c_name}'>";
            //获取当前分类的子
            $id="{$v->c_id}";//当前一级分类的id
            //根据当前id值去查找子分类的名字
            $sonArr=$this->where('c_p_id',$id)->select();
            foreach($sonArr as $sv){
                if($sv->c_id==$c_id){
                    $str .= "<option selected='selected' value='{$v->c_id}-{$sv->c_id}'>{$sv->c_name}</option>";
                }else{
                    $str .="<option value='{$v->c_id}-{$sv->c_id}'>{$sv->c_name}</optionvalue>";
                }

            }
            $str.="</optgroup>";
        }
        return $str;
    }


}