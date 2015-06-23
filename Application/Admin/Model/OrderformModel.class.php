<?php

namespace Admin\Model;
use Think\Model;

/**
 * 购物车模型
 * @author huajie <banhuajie@163.com>
 */

class OrderformModel extends Model {

    /* 自动验证规则 */
    protected $_validate = array(
    );

    /* 自动完成规则 */
    protected $_auto = array(
    );

    public function getOrderformList($status = 1) {
        $total = $this->where('status='.$status)->count();
        $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        $page = new \COM\Page($total, $listRows, array('status'=>$status));
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p = $page->show();
		$list = $this->where('status='.$status)->limit($page->firstRow.','.$page->listRows)->order("id desc")->select();
        $goodsList = null;
        $Document = M('Document');
        $user = M('UcenterMember');
        foreach ($list as $key => $value) {
        	$list[$key]['time'] = date("Y-m-d H:i", $value['time']);
            $userinfo = $user->where('uid='.$value['uid'])->find();
            $list[$key]['username'] = $userinfo["username"];
            $goods = explode("|", substr($value['goods'], 0, -1));
            foreach ($goods as $good) {
                $good = explode(",", $good);
                $goodsList .= "<a target='_blank' href='" . U('/home/article/detail', array("id"=>$good[0])) . "'>" . $Document->where('id='.$good[0])->getField("title") . "</a> x " . $good[1] . " x ¥" . $good[2] . "<br/>";
            }
            $list[$key]['goodsList'] = $goodsList;
            $goodsList = null;
        }
        $ret['list'] = $list;
        $ret['page'] = $p;
        return $ret;
	}

}
