<?php

namespace User\Api;

use User\Api\Api;
use User\Model\UcenterMemberModel;

//require_cache(dirname(__FILE__) . '/Api.class.php');

class UserApi extends Api{

	protected function _init(){
		$this->model = new UcenterMemberModel();
	}

	public function register(){
		return $this->model->register();
	}

	public function login($username, $password, $type = 1){
		return $this->model->login($username, $password, $type);
	}

	public function info($uid, $is_username = false){
		return $this->model->info($uid, $is_username);
	}

	public function checkUsername($username){
		return $this->model->checkField($username, 1);
	}

	public function checkEmail($email){
		return $this->model->checkField($email, 2);
	}

	public function checkMobile($mobile){
		return $this->model->checkField($mobile, 3);
	}

	public function updateInfo($uid, $password, $data){
		if($this->model->updateUserFields($uid, $password, $data) !== false){
			$return['status'] = true;
			$return['info'] = "修改成功！";
		}else{
			$return['status'] = false;
			$return['info'] = $this->model->getError();
		}
		return $return;
	}

	public function updateAddress($uid, $data){
		if($this->model->updateUserAddress($uid, $data) !== false){
			$return['status'] = true;
			$return['info'] = "修改成功！";
		}else{
			$return['status'] = false;
			$return['info'] = $this->model->getError();
		}
		return $return;
	}

}
