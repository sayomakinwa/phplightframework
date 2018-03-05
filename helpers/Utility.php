<?php
class Utility
{
	public static function geturl($urlarray = array(), $output=false) {
		$url = '/'.((!empty($GLOBALS['basefolder']))? $GLOBALS['basefolder'].'/' : '');
		foreach ($urlarray as $urlvar)
			$url .= $urlvar.'/';
		if ($output) echo $url;
		else return $url;
	}
	public static function filterString($string) {
		$string = str_replace(' ', '_', $string);
		$string = str_replace('&', '-and-', $string);
		$string = str_replace(':', '_colon_', $string);
		$string = str_replace('?', '_que_', $string);
		$string = str_replace('\'', '_apos_', $string);
		$string = str_replace('\\', '', $string);
		$string = str_replace('/', '', $string);
		$string = strtolower($string);
		return $string;
	}
	public static function unFilterString($string) {
		$string = str_replace('_apos_', '\'', $string);
		$string = str_replace('_que_', '?', $string);
		$string = str_replace('_colon_', ':', $string);
		$string = str_replace('-and-', '&', $string);
		$string = str_replace('_', ' ', $string);
		$string = ucwords($string);
		return $string;
	}
	public static function removePTag($string) {
		$string = str_replace('<p>', '', $string);
		$string = str_replace('</p>', '', $string);
		$string = str_replace('<p', '', $string);
		$string = str_replace('</p', '', $string);
		return $string;
	}
	public static function removeFirstLastPTag($string) {
		if (substr($string,0,3)=='<p>') $string = substr($string, 3);
		if (substr($string,-4)=='</p>') $string = substr($string, 0, -4);
		return $string;
	}
	public static function stringToHTML($string) {
		// Processes \r\n's first so they aren't converted twice.
		$search = array("\r\n", "\n", "\r");
		$replace = array("<br>", "<br>", "<br>");
		return str_replace($search, $replace, $string);
	}
	public static function htmlToString($html) {
		$search = array("<br>");
		$replace = array("\r\n");
		return str_replace($search, $replace, $html);
	}
	public static function randomPassword() {
		$alphabet = "#%&aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ@)]0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 15; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	public static function randomLetters($num) {
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < $num; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	public static function generateToken($length = 24) {
        if(function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if($strong == TRUE)
                return strtr(substr($token, 0, $length), '+/=', '-_,'); //base64 is about 33% longer, so we need to truncate the result
        }

        //fallback to mt_rand if php < 5.3 or no openssl available
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz/+'; 
        $charactersLength = strlen($characters)-1;
        $token = '';

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }        

        return $token;
	}

	public static function generateEncryptKey($length = 24) {
        if(function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if($strong == TRUE)
                return strtr(substr($token, 0, $length), '+/=', '-_,'); //base64 is about 33% longer, so we need to truncate the result
        }

        //fallback to mt_rand if php < 5.3 or no openssl available
        $characters = '#%&!$^*([-+_@;~?/.,|)]0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters)-1;
        $token = '';

        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }        
        return $token;
	}

	public static function encrypt($pure_string, $encryption_key) {
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	    return base64_encode($encrypted_string);
	}

	/**
	 * Returns decrypted original string
	 */
	public static function decrypt($encrypted_string, $encryption_key) {
		$encrypted_string = base64_decode($encrypted_string);
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
	    return $decrypted_string;
	}


	public static function generateOrderId() {
		$alphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
	    $pass = array(); //remember to declare $pass as an array
	    $pass2 = array();
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 2; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    for ($i = 0; $i < 2; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass2[] = $alphabet[$n];
	    }
	    return implode($pass).time().rand(00, 99).implode($pass2); //turn the array into a string
	}
	public static function sendMail($to, $subject, $body, $from = 'you@comeone.com') {
		$headers = "From: $from\r\n"."X-Mailer: php";
		if (mail($to, $subject, $body, $headers)) return true;
		else false;
	}
}

?>