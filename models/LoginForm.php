<?php

namespace app\models;

use app\components\Identity;

class LoginForm extends BaseModel {
    public $username;
    public $password;
    private $_user = false;

	public function rules(){
		return[
			[['username', 'password'], ["string"]],
		];
	}

	public function login() {
        if ($this->validate()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                Identity::login($user);
            }

            return Identity::login($user);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->username);
        }

        return $this->_user;
    }
}

?>