<?php
namespace app\models;

use app\components\QueryBuilder;
use app\components\ActiveRecord;

class User extends ActiveRecord {

    public $newPassword = "";
    public $newPasswordConfirm = "";

	public static function tableName() {
		return "user";
	}

	public function rules(){
		return[
			[['email', 'password', 'newPassword', 'newPasswordConfirm'], ["string"]],
			[['auth_key'], ["auto-hash-128"]],
			[['created_at'], ["created-datetime"]],
			[['id'], ["integer"]]
		];
	}

	public function attributeLabels() {
	    return [
					"newPassword" => "Uus parool",
					"newPasswordConfirm" => "Uus parool (kinnita)",
					"email" => "E-Mail",
					"password" => "Parool",
					"created_at" => "Lisatud",
        ];
    }

	public static function findByEmail($email) {
        $model = new User();
        $data = QueryBuilder::select(self::tableName())->addWhere("=", "email", $email)->query();
        if($model->load($data)){
            return $model;
        }
        return null;
    }

    public function validatePassword($password) {
        return password_verify($password, $this->password);
    }

    public function beforeSave() {
        if(strlen($this->newPassword) > 0 && $this->newPassword == $this->newPasswordConfirm) {
            $this->password = password_hash($this->newPassword, PASSWORD_DEFAULT);
        }

        unset($this->attributes["newPassword"]);
        unset($this->attributes["newPasswordConfirm"]);
        parent::beforeSave();
    }

}

?>
