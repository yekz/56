<?php

namespace Admin\Controller;
/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */

class FileController extends AdminController {

    /* 左侧节点菜单定义,用户生成权限 */
    static protected $nodes = array(
            array(
                'title'=>'上传控件', 'url'=>'file/upload', 'group'=>'上传','hide'=>true,
                'operator'=>array(
                        //权限管理页面的五种按钮
                        array('title'=>'上传','url'=>'file/upload'),
                        array('title'=>'上传图片','url'=>'file/uploadPicture'),
                        array('title'=>'下载','url'=>'file/download'),
                ),
            ),
    );

    /* 文件上传 */
    public function upload(){
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $File = D('File');
        $info = $File->upload($_FILES, C('DOWNLOAD_UPLOAD')); //TODO:上传到远程服务器

        /* 记录附件信息 */
        if($info){
            $return['data'] = think_encrypt(json_encode($info['download']));
            $return['info'] = $info['download']['name'];
        } else {
            $return['status'] = 0;
            $return['info']   = $File->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }

    /* 下载文件 */
    public function download($id = null){
        if(empty($id) || !is_numeric($id)){
            $this->error('参数错误！');
        }

        $logic = D('Download', 'Logic');
        if(!$logic->download($id)){
            $this->error($logic->getError());
        }

    }

    /**
     * 上传图片
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPicture(){
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $info = $Picture->upload($_FILES, C('PICTURE_UPLOAD')); //TODO:上传到远程服务器

        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            $return = array_merge($info['download'], $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }
}
