<?php

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
	$verify = new \COM\Verify();
	return $verify->check($code, $id);
}

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_child_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->childCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
            break;
        case '#' === substr($url, 0, 1):
            break;
        default:
            $url = U($url);
            break;
    }
    return $url;
}

// 从购物车获取订单总金额
function get_total_money_from_cart() {
    $M = M('Document');
    if (is_login()) {
        $goods = D('Cart')->getGoodsList(session('user_auth.uid'));
    } else {
        $goods = session("cart");
    }
    $total = 0;
    for ($i=0; $i < count($goods); $i++) {
        $total += $goods[$i]['number'] * $M->where('id=' . $goods[$i]['gid'])->getField("price");
    }
    return $total;
}
