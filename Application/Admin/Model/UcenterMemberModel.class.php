<?php

namespace Admin\Model;

use Think\Model;

/**
 * 用户模型
 */

class UcenterMemberModel extends Model {

    protected $_validate = array(
        array('username', '1,16', '昵称长度为1-16个字符', self::EXISTS_VALIDATE, 'length'),
        array('username', '', '昵称被占用', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
    );

    public function lists($status = 1, $order = 'uid DESC', $field = true){
        $map = array('status' => $status);
        return $this->field($field)->where($map)->order($order)->select();
    }

    public function login($uid){
        /* 检测是否在当前应用注册 */
        $user = $this->field(true)->find($uid);
        if(!$user || 1 != $user['status']) {
            $this->error = '用户不存在或已被禁用！'; //应用级别禁用
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);
        return true;
    }

    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'uid'             => $user['uid'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        $this->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['uid'],
            'username'        => $user['username'],
            'last_login_time' => $user['last_login_time'],
            'sid'             => $user['sid'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
    }

    public function getUserName($uid){
        return $this->where(array('uid'=>(int)$uid))->getField('username');
    }

    public function getUserInfo($uid){
        return $this->where(array('uid'=>(int)$uid))->find();
    }


}
