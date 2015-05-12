<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 叶科忠 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 搜索控制器
 */
class SearchController extends HomeController {

	//搜索结果页
    public function index(){
        $k = I("get.k");
        $Document = D('Document');
        $page = new \COM\Page($Document->where("sid=".session("sid"))->count(), C('GOODS_LIST_ROWS'));
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $lists = $Document->limit($page->firstRow . ',' . $page->listRows)->where('sid = '.session("sid").' and status = 1 and title LIKE "%'.$k.'%"')->select();
        $Cover = M('Picture');
        foreach ($lists as $key => $value) {
            $lists[$key]['pic'] = $Cover->where('id='.$value['cover_id'])->getField("path");
        }
        if ($lists === false) {
            $this->assign('error',"啊哦，什么都没有找到哦！");
        }
        $this->assign('lists',$lists);//列表
        $this->assign('page', $page->show());//分页
        $this->assign('keyword', $k);
        $this->display();
    }
}
