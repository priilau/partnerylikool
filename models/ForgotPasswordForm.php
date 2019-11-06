<?php

namespace app\models;

use app\components\Flash;
use app\components\Helper;
use app\config\App;

class ForgotPasswordForm extends BaseModel {
    public $username;

	public function rules(){
		return[
			[['username'], ["string"]],
		];
	}

	public function recover() {
	    $user = User::findByEmail($this->username);

	    if($user !== null) {
	        $newPassword = Helper::generateRandomString(14);
	        $user->newPassword = $newPassword;
            $user->newPasswordConfirm = $user->newPassword;
            $user->save();
            Helper::sendMail(App::$emailSender, $this->username, "Partnerülikool - Parooli taastamine", "Email: {$this->username}\r\nUus parool: {$newPassword}");
            Flash::setMessage("success", "Parooli taastamise email saadetud sisestatud aadressile.");
	        return true;
        }
        Flash::setMessage("error", "Sellise emailiga kontot ei eksisteeri!");
	    return false;
    }

}

?>