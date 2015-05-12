<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Addons\Editor;
use Common\Controller\Addons;

/**
 * 编辑器插件
 * @author yangweijie <yangweijiester@gmail.com>
 */

	class EditorAddons extends Addons{

		public $info = array(
				'name'=>'Editor',
				'title'=>'二手商品详情编辑器',
				'description'=>'二手商品编辑器',
				'status'=>1,
				'author'=>'叶科忠',
				'version'=>'1.0'
			);

		public function install(){
			return true;
		}

		public function uninstall(){
			return true;
		}

		/**
		 * 编辑器挂载的文章内容钩子
		 * @param array('name'=>'表单name','value'=>'表单对应的值')
		 */
		public function documentEditFormContent($data){
			$this->assign('addons_data', $data);
			$this->assign('addons_config', $this->getConfig());
			$this->display('content');
		}

		/**
		 * 讨论提交的钩子使用编辑器插件扩展
		 * @param array('name'=>'表单name','value'=>'表单对应的值')
		 */
		public function topicComment ($data){
			$this->assign('addons_data', $data);
			$this->assign('addons_config', $this->getConfig());
			$this->display('content');
		}

		/**
		 * 后台二手商品编辑器
		 * @param array('name'=>'表单name','value'=>'表单对应的值')
		 */
		public function adminSecondHandArticleEdit($data){
			$this->assign('addons_data', $data);
			$this->assign('addons_config', $this->getConfig());
			$this->display('content');
		}

	}
