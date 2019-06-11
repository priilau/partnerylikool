<?php
namespace app\components;

class Helper {
    public static function generateRandomString($length = 128) { // NOTE(Caupo 11.06.2019): Source: https://stackoverflow.com/questions/4356289/php-random-string-generator
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function isStringClean($str) {
		$alphabet = "abcdefghijklmnopqrstuvwxyz1234567890_üõöä,.";
		$strLen = strlen($str);
		$strLenX = strlen($alphabet);
		
		if($strLen >= 128) {
			return false;
		}
		$str = mb_strtolower($str);
		
		for($i = 0; $i < $strLen; $i++) {
			$myError = true;
			
			for($x = 0; $x < $strLenX; $x++) {
				if(strcmp($str[$i], $alphabet[$x])) {
					$myError = false;
					break;
				}
			}
			
			if($myError) {
				return false;
			}
		}
		return true;
    }
}

?>