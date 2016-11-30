<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/30 0030
 * Time: 14:59
 */

namespace app\admin\controller;


class Index extends Base
{
    public function index(){
        return view('index');
    }
}