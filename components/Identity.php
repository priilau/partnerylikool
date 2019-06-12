<?php
namespace app\components;

class Identity {
	public $isGuest = true;
	public $authKey = "";
	public $user = null;

	public function isLoggedIn() {
	    return (!$this->isGuest || $this->user === null);
    }

    public static function getUserId() {
        $identity = self::get();
        if($identity->user !== null) {
            return $identity->user->id;
        }
        return 0;
    }

    public static function validateIdentity() {
        session_start();
	    $identity = self::get();

	    if($identity->user == null || (isset($_COOKIE["auth_key"]) && (strlen($_COOKIE["auth_key"]) === 0 || $_COOKIE["auth_key"] != $identity->authKey))) {
	        Identity::logout();
        }
    }

    public static function login($user) { // NOTE(Caupo 11.06.2019): Kui paroolid on edukalt kontrollitud, siis kutsuda välja see funktsioon..
	    $identity = &self::get(); // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        $identity->isGuest = false;
        $identity->authKey = $user->auth_key;
        $user->password = "";
        $user->auth_key = "";
        $identity->user = $user;
        setcookie("auth_key", $user->auth_key);
    }

    public static function logout() {
        $identity = &self::get(); // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        $identity->isGuest = true;
        $identity->user = null;
        $identity->authKey = "";
    }

    public static function &get() { // NOTE(Caupo 11.06.2019): & märk self'i ees tähistab, et returnitakse referencena.
        if(!isset($_SESSION["IDENTITY_OBJ"])) {
            $_SESSION["IDENTITY_OBJ"] = new Identity();
        }

	    return $_SESSION["IDENTITY_OBJ"];
    }
}

?>