<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
    	if(IS_CLI){
            $data = M('Content')->field("id,content")->select();
            foreach ($data as $value) {
                $value['content'] = ubb($value['content']);
                M('Content')->save($value);
            }
        } else {
            $Document = D('Document');
            $page = new \COM\Page($Document->where("sid=".session("sid"))->count(), C('GOODS_LIST_ROWS'));
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $category = D('Category')->getTree();
            foreach ($category as $key => $value) {
                if ($value["id"] == session("sid")) {
                    $schoolcategory = $value;
                }
            }
            $lists  = $Document->limit($page->firstRow . ',' . $page->listRows)->lists(null);
            $Cover = M('Picture');
            foreach ($lists as $key => $value) {
                $lists[$key]['pic'] = $Cover->where('id='.$value['cover_id'])->getField("path");
            }
            $this->assign('category',$schoolcategory);//栏目
            $this->assign('lists',$lists);//列表
            $this->assign('page', $page->show());//分页

            $this->display();
        }
    }

    public function upload(){
    	if(IS_POST){
            //又拍云
            // $config = array(
            //     'host'     => 'http://v0.api.upyun.com', //又拍云服务器
            //     'username' => 'zuojiazi', //又拍云用户
            //     'password' => 'thinkphp2013', //又拍云密码
            //     'bucket'   => 'thinkphp-static', //空间名称
            // );
            // $upload = new \COM\Upload(array('rootPath' => 'image/'), 'Upyun', $config);
            //百度云存储
            $config = array(
                'AccessKey'  =>'3321f2709bffb9b7af32982b1bb3179f',
                'SecretKey'  =>'67485cd6f033ffaa0c4872c9936f8207',
                'bucket'     =>'test-upload',
                'size'      =>'104857600'
            );
    		$upload = new \COM\Upload(array('rootPath' => './Uploads/bcs'), 'Bcs', $config);
    		$info   = $upload->upload($_FILES);
    	} else {
    		$this->display();
    	}
    }

    public function upyun(){
        $policydoc = array(
            "bucket"             => "thinkphp-static", /// 空间名
            "expiration"         => NOW_TIME + 600, /// 该次授权过期时间
            "save-key"            => "/{year}/{mon}/{random}{.suffix}",
            "allow-file-type"      => "jpg,jpeg,gif,png", /// 仅允许上传图片
            "content-length-range" => "0,102400", /// 文件在 100K 以下
        );

        $policy = base64_encode(json_encode($policydoc));
        $sign = md5($policy.'&'.'56YE3Ne//xc+JQLEAlhQvLjLALM=');

        $this->assign('policy', $policy);
        $this->assign('sign', $sign);
        $this->display();
    }

}
