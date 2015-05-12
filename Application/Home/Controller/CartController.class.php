<?php
// +----------------------------------------------------------------------
// | Author: 叶科忠 <yekz.qq.com> <http://www.yekezhong.com>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi as UserApi;

/**
 * 购物车控制器
 */
class CartController extends HomeController {
	// 购物车首页
	public function index(){
		$goods = null;
		if (is_login()) {
			$D = D('Cart');
			$goods = $D->getGoodsList(session('user_auth.uid'));
		} else {
			$goods = session("cart");
		}
		$M = M("Document");
		$Cover = M('Picture');
		$Category = M("Category");
		$outOfStock = 0; // 超出库存
		$empty = 0; // 购物车为空
		$schoolError = 0; // 非注册学校商品
		if (count($goods) == 0) {
			$empty = 1;
		}
        for ($i=0; $i < count($goods); $i++) {
        	$id = $goods[$i]['gid'];
        	$goodsInfo = $M->where("id = '{$id}' and status = 1")->find();
            $goods[$i]['goodsName'] = $goodsInfo["title"];
            $goods[$i]['price'] = $goodsInfo["price"];
            $goods[$i]['status'] = 1;
            if ($goods[$i]['number'] > $goodsInfo['stock']) {
            	$goods[$i]['status'] = "2";
            	$outOfStock = 1; // 超出库存
            }
            $sid = $M->where("id = '{$id}'")->getField("sid");
            if ($sid != session("sid")) {
        		$schoolError = 1;
        		$goods[$i]['status'] = 3;
        	}
            $goods[$i]['secondhand'] = $Category->where('id='.$goodsInfo["category_id"])->getField("secondhand");
            // $goods[$i]['pic'] = $Cover->where('id='.$M->where("id = '{$id}' and status = 1")->getField("cover_id"))->getField("path");
        }
        if (is_login())
        	$address = M('UcenterMember')->where('uid='.session('user_auth.uid'))->find();

        $schoolName = M('Category')->where('id='.session("sid"))->getField("name");
        $this->assign('schoolName',$schoolName);
        $this->assign('total', get_total_money_from_cart());
		$this->assign('list', $goods);
		$this->assign('outOfStock', $outOfStock);
		$this->assign('schoolError',$schoolError);
		$this->assign('empty', $empty);
		$this->assign('address', $address);
		$this->display();
	}
	// 添加商品到购物车
	public function add($gid = 0, $number = 1) {
		if (IS_POST){
			$number   =   I('post.number');
			$stock = M("Document")->where('id='.$gid)->getField("stock");
			if ($stock < $number) { // 检查库存
				$data = array("success" => 0, "msg" => "添加失败，商品库存不足！");
			} else if(($gid && $number && is_numeric($gid) && is_numeric($number))){
				if (is_login()) { // 已登录，从数据库
					if (!D('Cart')->addGoodsToCart($gid, $number)) {
						$data = array("success" => 0, "msg" => "添加失败，商品库存不足，去看看购物车里有几个吧！");
						echo json_encode($data);
						return false;
					}
				} else { // 未登陆，从session
					$okFlag = false;
					$cart = session("cart");
					for ($i=0; $i < count($cart); $i++) {
						if ($cart[$i]['gid'] == $gid) {
							if ($stock < ($cart[$i]['number'] + $number)) {
								$data = array("success" => 0, "msg" => "添加失败，商品库存不足，去看看购物车里有几个吧！");
								echo json_encode($data);
								return false;
							}
							$cart[$i]['number'] += $number; //购物车已存在，数量相加
							$okFlag = true;
						}
					}
					if (!$okFlag)
						array_push($cart, array("gid" => $gid, "number" => $number));
					session("cart", $cart);
				}
				$data = array("success" => 1, "msg" => "添加成功！");
			} else {
				$data = array("success" => 0, "msg" => "添加失败，非法数据！");
			}
			echo json_encode($data);
		}
	}

	// 改变单件商品数量
	public function changeNumber() {
		if (IS_POST){
			$gid = I('post.gid');
			$number   =   I('post.number');
			if(($gid && $number && is_numeric($gid) && is_numeric($number))){
				$stock = M("Document")->where('id='.$gid)->getField("stock");
			    if (is_login()) {
			        $goods = D('Cart')->getGoodsList(session('user_auth.uid'));
			        foreach ($goods as $key => $value) {
			        	if ($value['gid'] == $gid) {
			        		if (!D('Cart')->setGoodsNumber($gid, $number))
			        			$this->error('修改失败，商品库存不足！');
			        		break;
			        	}
			        }
			    } else {
			        $goods = session("cart");
			        for ($i=0; $i < count($goods); $i++) {
				    	if ($goods[$i]['gid'] == $gid) {
				    		if ($stock < ($goods[$i]['number'] + $number)) {
								$this->error('修改失败，商品库存不足！');
							}
				    		$goods[$i]['number'] = $number;
				    		break;
				    	}
				    }
			    	session("cart", $goods);
			    }
			    $this->success("修改成功！");
			} else {
				$this->error('修改失败！');
			}
		}
	}

	// 移除单件商品
	public function remove($gid) {
		if (($gid && is_numeric($gid))) {
			if (D('Cart')->removeGoods($gid))
				$this->success("移除成功！");
			else
				$this->error('移除失败！');
		} else {
			$this->error('移除失败！');
		}
	}

}
