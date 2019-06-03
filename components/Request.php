<?php
namespace app\components;

class Request {
	public $params = [];
	public $headers = [];
	public $userAgent = "";
	public $userIP = "";

    public $controller = "site";
    public $action = "index";

    public static function InitializeIfNotSet() {
        if(!isset($GLOBALS["SYSTEM_REQUEST"]) || !($GLOBALS["SYSTEM_REQUEST"] instanceof Request)) {
            $GLOBALS["SYSTEM_REQUEST"] = new Request();
        }
    }

    // setters

    public static function setParams($params) {
        self::InitializeIfNotSet();
        $GLOBALS["SYSTEM_REQUEST"]->params = $params;
    }

    public static function setCookie($name, $value) {
        self::InitializeIfNotSet();
        setcookie($name, $value);
    }

    public static function setHeaders($headers) {
        self::InitializeIfNotSet();
        $GLOBALS["SYSTEM_REQUEST"]->headers = $headers;
    }

    public static function setUserAgent($userAgent) {
        self::InitializeIfNotSet();
        $GLOBALS["SYSTEM_REQUEST"]->userAgent = $userAgent;
    }

    public static function setUserIP() {
        self::InitializeIfNotSet();
        $userIP = "None";

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) { // NOTE (Caupo 03.06.2019): If website uses Cloudflare then real user IP address is located here.
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $userIP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $userIP = $_SERVER['REMOTE_ADDR'];
        }

        $GLOBALS["SYSTEM_REQUEST"]->userIP = $userIP;
    }

    public static function setController($controller) {
        self::InitializeIfNotSet();
        $GLOBALS["SYSTEM_REQUEST"]->controller = $controller;
    }

    public static function setAction($action) {
        self::InitializeIfNotSet();
        $GLOBALS["SYSTEM_REQUEST"]->action = $action;
    }

    // getters

    public static function getParams() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->params;
    }

    public static function getCookies() {
        self::InitializeIfNotSet();
        return $_COOKIE;
    }

    public static function getCookie($name) {
        self::InitializeIfNotSet();
        if(isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return null;
    }

    public static function getHeaders() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->headers;
    }

    public static function getUserAgent() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->userAgent;
    }

    public static function getUserIP() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->userIP;
    }

    public static function getController() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->controller;
    }

    public static function getAction() {
        self::InitializeIfNotSet();
        return $GLOBALS["SYSTEM_REQUEST"]->action;
    }

    // misc

    public static function applyHeaders() {
        self::InitializeIfNotSet();

        if(!is_array($GLOBALS["SYSTEM_REQUEST"]->headers) || count($GLOBALS["SYSTEM_REQUEST"]->headers) <= 0) {
            return;
        }

        foreach($GLOBALS["SYSTEM_REQUEST"]->headers as $value) {
            header($value);
        }
    }
}

?>