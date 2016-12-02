<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/30 0030
 * Time: 16:47
 */

namespace app\admin\controller;

use app\admin\model\Warehouse as WarehouseModel;

class Warehouse extends Base
{
    public function index()
    {
        $ware = \think\Db::name('warehouse')->select();
        $this->assign('ware',$ware);
        return view('index');
    }
    //新增仓库
    public function add()
    {
        if(request()->isPost()){
            $WarehouseModel = new WarehouseModel();

            if($WarehouseModel->save(input('post.'))){
                admin_log('添加仓库:'.input('post.name'));
                return json(['code'=>'0','msg'=>'添加成功']);
            }else{
                return json(['code'=>'-1','msg'=>$WarehouseModel->getError()]);
            }
        }else{
            return view('add');
        }
    }
    //编辑仓库
    public function edit()
    {
        if(request()->isPost()){
            $id = input('?post.id') ? input('post.id') : '';
            if(!$id){
                return json(['code'=>-1,'msg'=>'参数错误']);
            }
            $warehouseModel = new WarehouseModel();
            if($warehouseModel->save(input('post.'),['id'=>$id])){
                admin_log('修改仓库:'.input('post.name'));
                return json(['code'=>'0','msg'=>'修改成功']);
            }else{
                return json(['code'=>-2,'msg'=>$warehouseModel->getError()]);
            }
        }else{
            $id = request()->param('id');
            if(!is_numeric($id) || empty($id)){
                return json(['code'=>-1,'msg'=>'参数非法']);
            }
            $ware = \Think\Db::name('warehouse')->where('id',$id)->find();
            if(empty($ware)){
                return json(['code'=>-2,'msg'=>'仓库不存在']);
            }
            $this->assign('ware',$ware);
            return view('edit');
        }
    }

    //删除仓库
    public function del()
    {
        $id = request()->param('id');
        if(!is_numeric($id) || empty($id)){
            return json(['code'=>-1,'msg'=>'参数非法']);
        }
        $warename = \Think\Db::name('warehouse')->where('id',$id)->value('name');
        $re = \Think\Db::name('warehouse')->where('id',$id)->delete();
        if($re){
            admin_log('删除仓库:'.$warename);
            return json(['code'=>'0','msg'=>'删除成功']);
        }else{
            return json(['code'=>-2,'msg'=>'删除失败']);
        }
    }
}