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
            1 => "Bachelor",
            2 => "Master",
            3 => "Doctorate",
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

    public static function isContentClean($str, $maxLength = 1024) {
        $alphabet = "abcdefghijklmnopqrstuvwxyz1234567890_üõöä,.+*-–/():!?\"'";
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

    public static function getCountries() {
        return ["-", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda",
            "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus",
            "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil",
            "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada",
            "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands",
            "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)",
            "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
            "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France",
            "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany",
            "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti",
            "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia",
            "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
            "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia",
            "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia",
            "The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands",
            "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco",
            "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles",
            "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman",
            "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico",
            "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines",
            "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)",
            "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena",
            "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic",
            "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia",
            "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
            "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)",
            "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];
    }
}

?>