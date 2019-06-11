<?php
namespace app\components;

class Identity {
	public $isGuest = true;
	public $authKey = "";
	public $user = null;

	public function isLoggedIn() {
	    return (!$this->isGuest || $this->user === null);
    }

    public static function validateIdentity() {
	    $user = self::get();
	    if(isset($_COOKIE["auth_key"]) && (strlen($_COOKIE["auth_key"]) === 0 || $_COOKIE["auth_key"] != $user->auth_key)) {
	        Identity::logout();
        }
    }

    public static function login($user) { // NOTE(Caupo 11.06.2019): Kui paroolid on edukalt kontrollitud, siis kutsuda välja see funktsioon.
        $identity = &self::get(); // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        $identity->isGuest = false;
        $identity->user = $user;
        setcookie("auth_key", $user->auth_key);
    }

    public static function logout() {
        $identity = &self::get(); // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        $identity->isGuest = true;
        $identity->user = null;
    }

    public static function &get() { // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        session_start();

        if(!isset($SESSION["IDENTITY_OBJ"])) {
            $SESSION["IDENTITY_OBJ"] = new Identity();
        }

	    return $SESSION["IDENTITY_OBJ"];
    }
}

?>