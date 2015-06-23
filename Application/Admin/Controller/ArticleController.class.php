<?php

namespace Admin\Controller;
use Admin\Model\AuthGroupModel;
use COM\Page;
/**
 * 后台内容控制器
 */

class ArticleController extends \Admin\Controller\AdminController {

    /* 左侧节点菜单定义 */
    static protected $nodes =   array(
        array(
            'title'=>'文档列表', 'url'=>'article/index', 'group'=>'内容','hide'=>true,
            'operator'=>array(
                //权限管理页面的按钮
                array('title'=>'新增','url'=>'article/add'),
                array('title'=>'编辑','url'=>'article/edit'),
                array('title'=>'改变状态','url'=>'article/setStatus'),
                array('title'=>'保存','url'=>'article/update'),
            	array('title'=>'保存草稿','url'=>'article/autoSave'),
            	array('title'=>'移动','url'=>'article/move'),
            	array('title'=>'复制','url'=>'article/copy'),
            	array('title'=>'粘贴','url'=>'article/paste'),
            ),
        ),
    	array(
    		'title'=>'草稿箱', 'url'=>'article/draftbox', 'group'=>'个人中心',
    	),
    	array(
    		'title'=>'回收站', 'url'=>'article/recycle', 'group'=>'内容',
    		'operator'=>array(
    			//权限管理页面的按钮
    			array('title'=>'还原','url'=>'article/permit'),
    			array('title'=>'清空','url'=>'article/clear'),
    		),
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

        //获取左边菜单
        if(ACTION_NAME == 'index' || ACTION_NAME == 'add' || ACTION_NAME == 'edit' || ACTION_NAME == 'recycle' || ACTION_NAME == 'draftbox'
            || ACTION_NAME == 'mydocument'){
            $this->getMenu();
        }

        //获取回收站权限
        $show_recycle = $this->checkRule('Admin/article/recycle');
        $this->assign('show_recycle', $this->getVal('root_user') || $show_recycle);
        //获取草稿箱权限
        $show_draftbox = $this->checkRule('Admin/article/draftbox');
        $this->assign('show_draftbox', $this->getVal('root_user') || $show_draftbox);
    }

    /**
     * 显示左边菜单，进行权限控制
     * @author huajie <banhuajie@163.com>
     */
    protected function getMenu(){
        //获取动态分类
        $cate_auth  =   AuthGroupModel::getAuthCategories(is_login());	//获取当前用户所有的内容权限节点
        $cate       =   M('Category')->where(array('status'=>1))->field('id,title,pid,allow_publish')->order('pid,sort')->select();

        //没有权限的分类则不显示
        if(!$this->getVal('root_user')){
            foreach ($cate as $key=>$value){
                if(!in_array($value['id'], $cate_auth)){
                    unset($cate[$key]);
                }
            }
        }

        //筛选大学
        if(!$this->getVal('root_user')){
            foreach ($cate as $key=>$value){
                if($value['pid'] == 0 && $value['id'] != session("user_auth.sid")){
                    unset($cate[$key]);
                }
            }
        }


        $cate           =   list_to_tree($cate);	//生成分类树

        //获取分类id
        $cate_id        =   I('param.cate_id');
        $this->cate_id  =   $cate_id;

        //是否展开分类
        $hide_cate = false;
        if(ACTION_NAME != 'recycle' && ACTION_NAME != 'draftbox' && ACTION_NAME != 'mydocument'){
            $hide_cate  =   true;
        }

        //生成每个分类的url
        foreach ($cate as $key=>&$value){
            $value['url']   =   'Article/index?cate_id='.$value['id'];
            if($cate_id == $value['id'] && $hide_cate){
                $value['current'] = true;
            }else{
            	$value['current'] = false;
            }
            if(!empty($value['_child'])){
            	$is_child = false;
                foreach ($value['_child'] as $ka=>&$va){
                    $va['url']      =   'Article/index?cate_id='.$va['id'];
                    if(!empty($va['_child'])){
                        foreach ($va['_child'] as $k=>&$v){
                            $v['url']   =   'Article/index?cate_id='.$v['id'];
                            $v['pid']   =   $va['id'];
                            $is_child = $v['id'] == $cate_id ? true : false;
                        }
                    }
                    //展开子分类的父分类
                    if($va['id'] == $cate_id || $is_child){
                        $is_child = false;
                        if($hide_cate){
                            $value['current']   =   true;
                            $va['current']      =   true;
                        }else{
                        	$value['current'] 	= 	false;
                        	$va['current']      =   false;
                        }
                    }else{
                    	$va['current']      =   false;
                    }
                }
            }
        }
        $this->assign('nodes',      $cate);
        $this->assign('cate_id',    $this->cate_id);

        //获取面包屑信息
        $nav = get_parent_category($cate_id);
        $this->assign('rightNav',   $nav);
    }

    /**
     * 内容管理首页
     * @param $cate_id 分类id
     * @author huajie <banhuajie@163.com>
     */
    public function index($cate_id = null, $status = null, $title = null){
        if(is_null($cate_id)){
            $cate_id = $this->cate_id;
        }
        /* 查询条件初始化 */
        $map = array();
        if(isset($title)){
            $map['title']   =   array('like', '%'.$title.'%');
        }
        if(isset($status)){
            $map['status']  =   $status;
        }else{
            $map['status']  =   array('in', '0,1,2');
        }
        if ( isset($_GET['time-start']) ) {
            $map['create_time'][] = array('egt',strtotime(I('time-start')));

        }
        if ( isset($_GET['time-end']) ) {
            $map['create_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));

        }
        if ( isset($_GET['nickname']) ) {
            $map['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
        }

        // 构建列表数据
        if(!empty($cate_id)){   //没有权限则不查询数据
            $Document = M('Document');
            $map['category_id'] =   $cate_id;
            $map['pid']         =   I('pid',0);
            if (!$this->getVal('root_user')) { // 非管理员仅展示用户自己发布的商品
                $map['uid']         =   session("user_auth.uid");
            }
            if($map['pid']){ // 子文档列表忽略分类
                unset($map['category_id']);
            }

            $list = $this->lists($Document,$map,'level DESC,id DESC');
            intToString($list);
            if($map['pid']){
                // 获取上级文档
                $article    =   $Document->field('id,title,type')->find($map['pid']);
                $this->assign('article',$article);
            }
            //获取对应分类下的模型
            $models = get_category($cate_id, 'model');
            //检查该分类是否允许发布内容
            $allow_publish  =   get_category($cate_id, 'allow_publish');

            $this->assign('model',  $models);
            $this->assign('status', $status);
            $this->assign('list',   $list);
            $this->assign('allow',  $allow_publish);
            $this->assign('pid',    $map['pid']);

            $this->meta_title = '文档列表';
            $this->display();
        }else{
            $this->error('非法的文档分类');
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author huajie <banhuajie@163.com>
     */
    public function setStatus(){
        /*参数过滤*/
        $ids    =   I('request.ids');
        $status =   I('request.status');
        if(empty($ids) || !isset($status)){
            $this->error('请选择要操作的数据');
        }

        /*拼接参数并修改状态*/
        $Model  =   'Document';
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', implode(',', $ids));
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        switch ($status){
            case -1 :
                $this->delete($Model, $map, array('success'=>'删除成功','error'=>'删除失败'));
                break;
            case 0  :
                $this->forbid($Model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
                break;
            case 1  :
                $this->resume($Model, $map, array('success'=>'审核通过','error'=>'审核失败'));
                break;
            default :
                $this->error('参数错误');
                break;
        }
    }


    /**
     * 文档新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){
        $cate_id    =   I('get.cate_id',0);
        $model_id   =   I('get.model_id',0);

        empty($cate_id) && $this->error('参数不能为空！');
        empty($model_id) && $this->error('该分类未绑定模型！');

        //检查该分类是否允许发布
        $allow_publish = D('Document')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        /* 获取要编辑的模型模板 */
        //获取扩展模板
        $Category = M('Category');
        if ($Category->where('id='.$cate_id)->getField("secondHand")) {
            $extend = $this->fetch("secondHandArticle");
        } else
            $extend = $this->fetch("article");
        // $model      =   get_document_model($model_id);
        // $template   =   strtolower($model['name']);
        // $extend     =   $this->fetch($template);
        $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
        $info['model_id']       =   $model_id;
        $info['category_id']    =   $cate_id;
        if($info['pid']){
            // 获取上级文档
            $article            =   M('Document')->field('id,title,type')->find($info['pid']);
            $this->assign('article',$article);
        }
        $this->assign('info',       $info);
        $this->assign('template',   $template);
        $this->assign('extend',     $extend);
        $this->assign('type_list',  get_type_bycate($cate_id));

        $this->meta_title       =   '新增'.$model['title'];
        // 获取编辑页模版
        $template_edit = M("Category")->where('id='.$cate_id)->getField("template_edit");
        if ($template_edit == null) {
            $template_edit = "edit";
        }
        $this->display($template_edit);
    }

    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
        $id     =   I('get.id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }

        /*获取一条记录的详细数据*/
        $Document = D('Document');
        $data = $Document->detail($id);
        if(!$data){
            $this->error($Document->getError());
        }
        $data['create_time']    =   empty($data['create_time']) ? '' : date('Y-m-d H:i',$data['create_time']);
        $data['dateline']       =   empty($data['dateline']) ? '' : date('Y-m-d H:i',$data['dateline']);
        if($data['pid']){
            // 获取上级文档
            $article        =   M('Document')->field('id,title,type')->find($data['pid']);
            $this->assign('article',$article);
        }
        $this->assign('info', $data);
        $this->assign('model_id', $data['model_id']);

        //获取扩展模板
        $Category = M('Category');
        if ($Category->where('id='.$data['category_id'])->getField("secondHand")) {
            $extend = $this->fetch("secondHandArticle");
        } else
            $extend = $this->fetch("article");
        $this->assign('extend', $extend);
        //获取当前分类的文档类型
        $this->assign('type_list', get_type_bycate($data['category_id']));

        $this->meta_title   =   '编辑文档';

        // 获取编辑页模版
        $template_edit = M("Category")->where('id='.$data['category_id'])->getField("template_edit");
        if ($template_edit == null) {
            $template_edit = "edit";
        }
        $this->display($template_edit);
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('Document')->update();
        if(!$res){
            $this->error(D('Document')->getError());
        }else{
            if($res['id']){
                $this->success('更新成功', '/'.MODULE_NAME.'/article/index/pid/'.$res['pid'].'/cate_id/'.$res['category_id']);
            }else{
                $this->success('新增成功', '/'.MODULE_NAME.'/article/index/pid/'.$res['pid'].'/cate_id/'.$res['category_id']);
            }
        }
    }

    public function updateSecondHand(){
        $res = D('Document')->update(true);
        if(!$res){
            $this->error(D('Document')->getError());
        }else{
            if($res['id']){
                $this->success('更新成功', '/'.MODULE_NAME.'/article/index/pid/'.$res['pid'].'/cate_id/'.$res['category_id']);
            }else{
                $this->success('新增成功', '/'.MODULE_NAME.'/article/index/pid/'.$res['pid'].'/cate_id/'.$res['category_id']);
            }
        }
    }

    /**
     * 回收站列表
     * @author huajie <banhuajie@163.com>
     */
    public function recycle(){
        if ( $this->getVal('root_user') ) {
            $map        =   array('status'=>-1);
        }else{
            $cate_auth  =   AuthGroupModel::getAuthCategories(is_login());
            if($cate_auth){
                $map    =   array('uid'=>session("user_auth.uid"),'status'=>-1,'category_id'=>array('IN',implode(',',$cate_auth)));
            }else{
                $map    =   array( 'status'=>-1,'category_id'=>-1 );
            }
        }
        $list = M('Document')->where($map)->field('id,title,uid,category_id,type,update_time')->order('update_time desc')->select();
        //处理列表数据
        foreach ($list as $k=>&$v){
            $v['username']      =   get_nickname($v['uid']);
            //$v['create_time']   =   time_format($v['create_time']);
        }
        $this->assign('list', $list);
        $this->meta_title       =   '回收站';
        $this->display();
    }

    /**
     * 写文章时自动保存至草稿箱
     * @author huajie <banhuajie@163.com>
     */
    public function autoSave(){
        $res = D('Document')->autoSave();
        if($res !== false){
            $return['data']     =   $res;
            $return['info']     =   '保存草稿成功';
            $return['status']   =   1;
            $this->ajaxReturn($return);
        }else{
            $this->error('保存草稿失败：'.D('Document')->getError());
        }
    }

    /**
     * 草稿箱
     * @author huajie <banhuajie@163.com>
     */
    public function draftBox(){
        $Document   =   D('Document');
        $map        =   array('status'=>3,'uid'=>is_login());
        $list       =   $this->lists($Document,$map);
        //获取状态文字
        //intToString($list);

        $this->assign('list', $list);
        $this->meta_title = '草稿箱';
        $this->display();
    }

    /**
     * 我的文档
     * @author huajie <banhuajie@163.com>
     */
    public function mydocument($status = null, $title = null){
        $Document   =   D('Document');
        $map        =   array('status'=>array('in','0,1,2'),);
        /* 查询条件初始化 */
        $map = array('uid'=>is_login());
        if(isset($title)){
            $map['title']   =   array('like', '%'.$title.'%');
        }
        if(isset($status)){
            $map['status']  =   $status;
        }else{
            $map['status']  =   array('in', '0,1,2');
        }
        if ( isset($_GET['time-start']) ) {
            $map['create_time'][] = array('egt',strtotime(I('time-start')));

        }
        if ( isset($_GET['time-end']) ) {
            $map['create_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));

        }
        //只查询pid为0的文章
        $map['pid'] = 0;
        $list = $this->lists($Document,$map,'update_time desc');
        intToString($list);

        $this->assign('list', $list);
        $this->meta_title = '我的文档';
        $this->display();
    }

    /**
     * 还原被删除的数据
     * @author huajie <banhuajie@163.com>
     */
    public function permit(){
        /*参数过滤*/
        $ids = I('param.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }

        /*拼接参数并修改状态*/
        $Model  =   'Document';
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', implode(',', $ids));
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        $this->restore($Model,$map);
    }

    /**
     * 清空回收站
     * @author huajie <banhuajie@163.com>
     */
    public function clear(){
        $res = D('Document')->remove();
        if($res !== false){
            $this->success('清空回收站成功！');
        }else{
            $this->error('清空回收站失败！');
        }
    }

    /**
     * 移动文档
     * @author huajie <banhuajie@163.com>
     */
    public function move() {
        if(empty($_POST['ids'])) {
            $this->error('请选择要移动的文档！');
        }
        $_SESSION['moveArticle']    =   $_POST['ids'];
        unset($_SESSION['copyArticle']);
        $this->success('请选择要移动到的分类！');
    }

    /**
     * 拷贝文档
     * @author huajie <banhuajie@163.com>
     */
    public function copy() {
        if(empty($_POST['ids'])) {
            $this->error('请选择要复制的文档！');
        }
        $_SESSION['copyArticle']    =   $_POST['ids'];
        unset($_SESSION['moveArticle']);
        $this->success('请选择要复制到的分类！');
    }

    /**
     * 粘贴文档
     * @author huajie <banhuajie@163.com>
     */
    public function paste() {
        if(empty($_SESSION['moveArticle']) && empty($_SESSION['copyArticle'])) {
            $this->error('没有选择文档！');
        }
        if(!isset($_POST['cate_id'])) {
            $this->error('请选择要粘贴到的分类！');
        }
        $cate_id = I('post.cate_id');	//当前分类
        $pid = I('post.pid', 0);		//当前父类数据id
        $moveList = $_SESSION['moveArticle'];
        $copyList = $_SESSION['copyArticle'];

        //检查所选择的数据是否符合粘贴要求
        $check = $this->checkPaste(empty($moveList) ? $copyList : $moveList, $cate_id, $pid);
        if(!$check['status']){
        	$this->error($check['info']);
        }

        if(!empty($moveList)) {// 移动
        	foreach ($moveList as $key=>$value){
        		$Model              =   M('Document');
        		$map['id']          =   $value;
        		$data['category_id']=   $cate_id;
				$data['pid'] 		=   $pid;
				$res = $Model->where($map)->save($data);
        	}
        	unset($_SESSION['moveArticle']);
        	if(false !== $res){
        		$this->success('文档移动成功！');
        	}else{
        		$this->error('文档移动失败！');
        	}
        }elseif(!empty($copyList)){ // 复制
            foreach ($copyList as $key=>$value){
            	$Model  =   M('Document');
            	$data   =   $Model->find($value);
            	unset($data['id']);
            	$data['category_id']    =   $cate_id;
            	$data['pid'] 			=   $pid;
            	$data['create_time']    =   NOW_TIME;
            	$data['update_time']    =   NOW_TIME;

            	$result   =  $Model->add($data);
            	if($result){
            		$logic      =   D(get_document_model($data['model_id'],'name'),'Logic');
            		$data       =   $logic->detail($value); //获取指定ID的扩展数据
            		$data['id'] =   $result;
            		$res 		= 	$logic->add($data);
            	}
            }
            unset($_SESSION['copyArticle']);
            if($res){
            	$this->success('文档复制成功！');
            }else{
            	$this->error('文档复制失败！');
            }
        }
    }

    /**
     * 检查数据是否符合粘贴的要求
     * @author huajie <banhuajie@163.com>
     */
    protected function checkPaste($list, $cate_id, $pid){
    	$return = array('status'=>1);

    	// 检查支持的文档模型
    	$modelList =   M('Category')->getFieldById($cate_id,'model');	// 当前分类支持的文档模型
    	foreach ($list as $key=>$value){
    		//不能将自己粘贴为自己的子内容
    		if($value == $pid){
    			$return['status'] = 0;
    			$return['info'] = '不能将编号为 '.$value.' 的数据粘贴为他的子内容！';
    			return $return;
    		}
    		// 移动文档的所属文档模型
    		$modelType  =   M('Document')->getFieldById($value,'model_id');
    		if(!in_array($modelType,explode(',',$modelList))) {
    			$return['status'] = 0;
    			$return['info'] = '当前分类的“文档模型“不支持编号为 '.$value.' 的数据！';
    			return $return;
    		}
    	}

    	// 检查支持的文档类型
    	$typeList =   M('Category')->getFieldById($cate_id,'type');	// 当前分类支持的文档模型
    	foreach ($list as $key=>$value){
    		// 移动文档的所属文档模型
    		$modelType  =   M('Document')->getFieldById($value,'type');
    		if(!in_array($modelType,explode(',',$typeList))) {
    			$return['status'] = 0;
    			$return['info'] = '当前分类的“文档类型“不支持编号为 '.$value.' 的数据！';
    			return $return;
    		}
    	}

    	return $return;
    }
}
