<?php

namespace Home\Controller;
use User\Api\UserApi as UserApi;

/**
 * 订单控制器
 */
class OrderformController extends HomeController {
	// 订单首页
	public function index(){
		if (is_login()) {
			$goodsList = null;
			$list = D('Orderform')->getOrderformList();
			$Document = M('Document');
			foreach ($list as $key => $value) {
				$goods = explode("|", substr($value['goods'], 0, -1));
				foreach ($goods as $good) {
					$good = explode(",", $good);
					$goodsList .= "<a target='_blank' href='" . U('article/detail', array("id"=>$good[0])) . "'>" . $Document->where('id='.$good[0])->getField("title") . "</a> x " . $good[1] . " x ¥" . $good[2] . "<br/>";
				}
				$list[$key]['goodsList'] = $goodsList;
				$list[$key]['time'] = date("Y-m-d H:i", $value['time']);
				$goodsList = null;
			}
			$this->assign('list',$list);
			$this->display();
		} else {
			$this->error('您还没有登录，请先登录！', U('User/login'));
		}
	}
	// 提交订单
	public function submit() {
		if (is_login()) {
			$ret = D('Orderform')->addOrderform();
			if ($ret['status'])
				$this->success('订单提交成功！', U('Orderform/index'));
			else {
				$this->error($ret['msg'], U('Cart/index'));
			}
		} else {
			$this->error('您还没有登录，请先登录！', U('User/login'));
		}
	}

	protected function getGoodsList() {

	}

}
