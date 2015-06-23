<?php

namespace Home\Model;
use Think\Model;

/**
 * 购物车模型
 */
class CartModel extends Model{

    protected $_auto = array(
        array('time', NOW_TIME),
        array('status', 1, self::MODEL_INSERT),
    );

    public function getGoodsList($uid) {
    	return $this->where("uid = '{$uid}'")->select();
    }

    // 登录用户添加商品到购物车
	public function addGoodsToCart($gid, $number) {
		$uid = session('user_auth.uid');
		$goodsInfo = $this->where("uid = '{$uid}' and gid = '{$gid}'")->find();
		$stock = M("Document")->where('id='.$gid)->getField("stock");
		if ($stock < ($goodsInfo['number'] + $number)) {
			return false;
		}
		if ($goodsInfo) {
			$this->where("uid = '{$uid}' and gid = '{$gid}'")->setInc('number',$number);
		} else {
			$data = array(
				'uid' => $uid,
				'gid' => $gid,
				'number' => $number,
			);
			$this->create($data);
			$this->add();
		}
		return true;
	}

	// 登陆时保存SESSION里的购物车数据到数据库
	public function saveSessionToCart($uid) {
		$cart = session('cart');
		for ($i=0; $i < count($cart); $i++) {
			$gid = $cart[$i]['gid'];
			if ($this->where("uid = '{$uid}' and gid = '{$gid}'")->find()) {
				$this->where("uid = '{$uid}' and gid = '{$gid}'")->setInc('number', $cart[$i]['number']);
			} else {
				$data = array(
					'uid' => $uid,
					'gid' => $cart[$i]['gid'],
					'number' => $cart[$i]['number'],
				);
				$this->create($data);
				$this->add();
			}
		}
		session('cart', null);
	}

	public function setGoodsNumber($gid, $number) {
		if (is_login()) {
			if(($gid && $number && is_numeric($gid) && is_numeric($number))) {
				$uid = is_login();
				$goodsInfo = $this->where("uid = '{$uid}' and gid = '{$gid}'")->find();
				$stock = M("Document")->where('id='.$gid)->getField("stock");
				if ($stock < ($goodsInfo['number'] + $number)) {
					return false;
				}
				$this->where(array("gid"=>$gid, "uid"=>session("user_auth.uid")))->setField("number", $number);
				return true;
			}
			return false;
		} else {
			return false;
		}
	}

	public function removeGoods($gid) {
		if (is_login()) {
			if(($gid && is_numeric($gid))) {
				$this->where(array("gid"=>$gid, "uid"=>session("user_auth.uid")))->delete();
				return true;
			}
			return false;
		} else {
			return false;
		}
	}

}
