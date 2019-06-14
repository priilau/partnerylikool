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

    public static function getDegrees() {
        return [
            1 => "Bakalaureus",
            2 => "Magister",
            3 => "Doktor",
        ];
    }

    public static function generateSemesters($howManyYears = 3) {
        $month = intval(date("m"));
        $semesterYear = intval(date("Y"));
        $semesterCountToGenerate = $howManyYears * 2;
        $options = [];
        $whichSemester = "S";
        if($month >= 8 && $month <= 12) {
            $whichSemester = "K";
        }

        for($i = 0; $i < $semesterCountToGenerate; $i++) {
            $semestrLabel = "{$whichSemester}{$semesterYear}";
            $options[] = $semestrLabel;

            if($whichSemester == "S") {
                $semesterYear++;
            }

            $whichSemester == "K" ? $whichSemester = "S" : $whichSemester = "K";
        }

        return $options;
    }

    public static function sendMail($from, $to, $subject, $message) {
        $headers = "From: {$from}\r\n".
            "Reply-To: webmaster@example.com\r\n".
            "X-Mailer: PHP/".phpversion();

        mail($to, $subject, $message, $headers);
    }

    public static function setTitle($name) {
        $GLOBALS["title"] = $name;
    }

    public static function getTitle() {
        if(!isset($GLOBALS["title"])) {
            $GLOBALS["title"] = "Partnerülikooli valimine";
        }
        return $GLOBALS["title"];
    }

    public static function getClassName($obj) {
        return strtolower((new \ReflectionClass($obj))->getShortName());
    }

    public static function isStringClean($str, $maxLength = 128) {
		$alphabet = "abcdefghijklmnopqrstuvwxyz1234567890_üõöä,.";
		$strLen = strlen($str);
		$strLenX = strlen($alphabet);
		
		if($strLen >= $maxLength) {
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