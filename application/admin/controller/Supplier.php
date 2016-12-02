<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/1 0001
 * 供应商分类及详细
 */

namespace app\admin\controller;

use app\admin\model\Supplier as SupplierModel;
use app\admin\validate\Supplier as su;


class Supplier extends Base
{
    //供应商分类
    public function category()
    {
        $category  = \Think\Db::name('supplier_category')->select();
        $this->assign('category',$category);
        return view('category');
    }
    //增加供应商分类
    public function categoryAdd()
    {
        if(request()->isPost()){
            $data = input('post.');
            $data['create_time'] = time();
            if(\Think\Db::name('supplier_category')->insert($data)){
                admin_log('添加供应商分类:'.input('post.name'));
                return json(['code'=>'0','msg'=>'添加成功']);
            }else{
                return json(['code'=>'-1','msg'=>'添加失败']);
            }
        }else{
            return view('categoryAdd');
        }
    }

    //编辑供应商分类
    public function categoryEdit()
    {
        if(request()->isPost()){
            $id = input('?post.id') ? input('post.id') : '';
            if(!$id){
                return json(['code'=>-1,'msg'=>'参数错误']);
            }
            if(db('supplier_category')->where('id',$id)->update(input('post.'))){
                admin_log('修改供应商分类:'.input('post.name'));
                return json(['code'=>'0','msg'=>'修改成功']);
            }else{
                return json(['code'=>-2,'msg'=>'修改失败']);
            }
        }else{
            $id = request()->param('id');
            if(!is_numeric($id) || empty($id)){
                return json(['code'=>-1,'msg'=>'参数非法']);
            }
            $category = \Think\Db::name('supplier_category')->where('id',$id)->find();
            if(empty($category)){
                return json(['code'=>-2,'msg'=>'供应商分类不存在']);
            }
            $this->assign('category',$category);
            return view('categoryEdit');
        }
    }
    //删除仓库
    public function categoryDel()
    {
        $id = request()->param('id');
        if(!is_numeric($id) || empty($id)){
            return json(['code'=>-1,'msg'=>'参数非法']);
        }
        $category = \Think\Db::name('supplier_category')->where('id',$id)->value('name');
        $re = \Think\Db::name('supplier_category')->where('id',$id)->delete();
        if($re){
            admin_log('删除供应商分类:'.$category);
            return json(['code'=>'0','msg'=>'删除成功']);
        }else{
            return json(['code'=>-2,'msg'=>'删除失败']);
        }
    }

    //供应商档案列表
    public function index()
    {
        return view('index');
    }

    //增加供应商
    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            print_r($data);
           /* $result = $this->validate($data,'Supplier');
            if(true !== $result){
                // 验证失败 输出错误信息
                dump($result);
            }*/
        }else{
            $category = \Think\Db::name('supplier_category')->select();
            $this->assign('category',$category);
            return view('add');
        }
    }
}