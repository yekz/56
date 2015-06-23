<?php

namespace Home\Model;
use Think\Model;

/**
 * 订单模型
 */
class OrderformModel extends Model{

    protected $_auto = array(
        array('time', NOW_TIME),
        array('status', 1, self::MODEL_INSERT),
    );

    public function getGoodsList($uid) {
    	return $this->where("uid = '{$uid}'")->select();
    }

	// 提交订单
	public function addOrderform() {
		$money = get_total_money_from_cart();
		if ($money == 0) {
			$ret['msg'] = "订单提交失败，购物车是空的，先挑选点商品吧！";
			$ret['status'] = false;
			return $ret;
		}
		$uid = session('user_auth.uid');
		$C = D('Cart');
		$Document = M('Document');
		$cart = $C->getGoodsList($uid);
		$goods = "";
		for ($i=0; $i < count($cart); $i++) {
			$goods .= $cart[$i]['gid'] . ',' . $cart[$i]['number'];
			if ($cart[$i]['number'] > $Document->where('id='.$cart[$i]['gid'])->getField("stock")) {
				$ret['msg'] = "订单提交失败，部分商品超出库存，可能因为其它用户已购买了该商品，请修改数量或移除商品！";
				$ret['status'] = false;
				return $ret;
			}
			$sid = $Document->where("id=".$cart[$i]['gid'])->getField("sid");
            if ($sid != session("sid")) {
        		$ret['msg'] = "订单提交失败，购物车中有不是您注册学校销售的商品，请先移除！";
				$ret['status'] = false;
				return $ret;
        	}
			$goods .= ',' . $Document->where('id='.$cart[$i]['gid'])->getField("price");
			$goods .= "|";
		}
		$userinfo = M('UcenterMember')->where('uid='.$uid)->find();
		$address = $userinfo['realname'] . "<br/>" . $userinfo['mobile'] . "<br/>" . $userinfo['address'];
		$data = array(
			'uid' => $uid,
			'goods' => $goods,
			'address' => $address,
			'money' => $money,
			'number' => date("YmdHi",time()),
		);
		if ($this->create($data)) {
			$this->add();
			$C->where('uid='.$uid)->delete();
			foreach ($cart as $value) {
				$Document->where('id='.$value['gid'])->setDec("stock",$value['number']);
				$Document->where('id='.$value['gid'])->setInc("sold",$value['number']);
			}
			$ret['status'] = true;
			return $ret;
		} else {
			$ret['status'] = false;
			return $ret;
		}
	}

	public function getOrderformList() {
		return $this->where('uid='.session('user_auth.uid'))->select();
	}

}
