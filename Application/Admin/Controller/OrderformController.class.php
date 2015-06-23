<?php

namespace Admin\Controller;
use Admin\Model\AuthGroupModel;
use COM\Page;
/**
 * 后台内容控制器
 * @author huajie <banhuajie@163.com>
 */

class OrderformController extends \Admin\Controller\AdminController {

    /* 左侧节点菜单定义 */
    static protected $nodes =   array(
        array(
            'title'=>'待处理', 'url'=>'orderform/index', 'group'=>'订单管理',
            'operator'=>array(
                //权限管理页面的按钮
                array('title'=>'派送','url'=>'orderform/send'),
                array('title'=>'完成','url'=>'orderform/finish'),
            ),
        ),
        array(
            'title'=>'派送中', 'url'=>'orderform/send', 'group'=>'订单管理',
        ),
    	array(
    		'title'=>'完成订单', 'url'=>'orderform/finish', 'group'=>'订单管理',
    	),
        array(
            'title'=>'关闭的订单', 'url'=>'orderform/canceled', 'group'=>'订单管理',
        ),
    );

    private $cate_id        =   null; //文档分类id

    /**
     * 控制器初始化方法
     * @see AdminController::_init()
     * @author huajie <banhuajie@163.com>
     */
    protected function _initialize(){
        //调用父类的初始化方法
        parent::_initialize();
    }

    /**
     * 显示左边菜单，进行权限控制
     * @author huajie <banhuajie@163.com>
     */
    protected function getMenu(){

    }

    /**
     * 订单管理首页
     * @param $cate_id 分类id
     * @author huajie <banhuajie@163.com>
     */
    public function index() {
        $ret = D('Orderform')->getOrderformList();
        $p = $ret['page'];
        $this->assign('_page', $p? $p: '');
        $this->assign('list', $ret['list']);
        $this->display();
    }

    public function send() {
        $ret = D('Orderform')->getOrderformList(2);
        $p = $ret['page'];
        $this->assign('list', $ret['list']);
        $this->assign('_page', $p? $p: '');
        $this->display('index');
    }

    public function finish() {
        $ret = D('Orderform')->getOrderformList(3);
        $p = $ret['page'];
        $this->assign('list', $ret['list']);
        $this->assign('_page', $p? $p: '');
        $this->display('index');
    }

    public function canceled() {
        $ret = D('Orderform')->getOrderformList(4);
        $p = $ret['page'];
        $this->assign('list', $ret['list']);
        $this->assign('_page', $p? $p: '');
        $this->display('index');
    }

    public function changeStatus() {
        $ids    =   I('request.ids');
        $status =   I('request.status');
        if (empty($ids) || !isset($status)) {
            $this->error('请选择要操作的数据');
        }
        $Model  =   'Orderform';
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', implode(',', $ids));
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        M('Orderform')->where($map)->setField("status", $status);
        $this->success('修改成功！');
    }
}
