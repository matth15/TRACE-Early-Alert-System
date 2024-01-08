<?php

/**
 * Encryption and Decryption Class
 */

class Encryption{

    /**
     * Cipher algorithm
     *
     * @var string
     */
    const CIPHER = 'aes-256-cbc';

    /**
     * Hash function
     *
     * @var string
     */
    const HASH_FUNCTION = 'sha256';

    /**
     * constructor for Encryption object.
     *
     * @access private
     */
    private function __construct(){}

    /**
     * Encrypt an id.
     *
     * @access public
     * @static static method
     * @param  integer|string    $id
     * @return string
     */
    public static function encryptId($id){
        return self::alphaID($id, false, 3);
    }

    /**
     * Decryption for Id.
     *
     * @access public
     * @static static method
     * @param  string    $id
     * @return integer
     * @throws Exception if $id is empty
     */
    public static function decryptId($id){
        return self::alphaID($id, true, 3);
    }

    /**
     * Decryption for Ids with dash '-', Example: "feed-km1chg3"
     *
     * @access public
     * @static static method
     * @param  string    $id
     * @return integer
     * @throws Exception if $id is empty
     */
    public static function decryptIdWithDash($id){

        if(empty($id)){
            throw new Exception("the id to decrypt can't be empty");
        }

        $decryptId  = 0;
        $chars = self::getCharacters();
        $base  = strlen($chars);
        $id    = explode("-", $id)[1];

        $len = strlen($id) - 1;

        for ($t = $len; $t >= 0; $t--) {
            $bcp = bcpow($base, $len - $t);
            $decryptId = $decryptId + strpos($chars, substr($id, $t, 1)) * (int)$bcp;
        }

        return ((int)$decryptId - 1142) / 9518436;
    }

    /**
     * get characters that will be used in encryption/decryption provided by a key
     *
     * @access private
     * @static static method
     * @return string
     * @throws Exception if $id is empty
     */
    private static function getCharacters(){

        $chars  = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $i = [];
        for ($n = 0; $n < strlen($chars); $n++) {
            $i[] = substr($chars, $n, 1);
        }

        $key_hash = hash('sha256', Config::get('encryption/hash_key'));
        $key_hash = (strlen($key_hash) < strlen($chars) ? hash('sha512', Config::get('encryption/hash_key')) : $key_hash);

        for ($n = 0; $n < strlen($chars); $n++) {
            $p[] =  substr($key_hash, $n, 1);
        }

        array_multisort($p, SORT_DESC, $i);
        $chars = implode($i);

        return $chars;
    }

    /**
     * Encrypt a string.
     *
     * @access public
     * @static static method
     * @param  string    $plain
     * @return string
     * @throws Exception If functions don't exists
     */
    public static function encrypt($plain){

        if(!function_exists('openssl_cipher_iv_length') ||
            !function_exists('openssl_random_pseudo_bytes') ||
            !function_exists('openssl_encrypt')){
            throw new Exception("Encryption function don't exists");
        }

        // generate initialization vector,
        // this will make $iv different every time,
        // so, encrypted string will be also different.
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv      = openssl_random_pseudo_bytes($iv_size);

        // generate key for authentication using ENCRYPTION_KEY & HMAC_SALT
        $key = mb_substr(hash(self::HASH_FUNCTION, Config::get('encryption/encryption_key') . Config::get('encryption/hmac_salt')), 0, 32, '8bit');

        // append initialization vector
        $encrypted_string = openssl_encrypt($plain, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        $ciphertext       = $iv . $encrypted_string;

        // apply the HMAC
        $hmac = hash_hmac('sha256', $ciphertext, $key);

        return $hmac . $ciphertext;
    }

    /**
     * Decrypted a string.
     *
     * @access public
     * @static static method
     * @param  string $ciphertext
     * @return string
     * @throws Exception If $ciphertext is empty, or If functions don't exists
     */
    public static function decrypt($ciphertext){

        if(empty($ciphertext)){
            throw new Exception("the string to decrypt can't be empty");
        }

        if(!function_exists('openssl_cipher_iv_length') ||
            !function_exists('openssl_decrypt')){
            session::set('danger', 'Encryption function don\'t exists');
        }

        // generate key used for authentication using ENCRYPTION_KEY & HMAC_SALT
        $key = mb_substr(hash(self::HASH_FUNCTION, Config::get('encryption/encryption_key') . Config::get('encryption/hmac_salt')), 0, 32, '8bit');

        // split cipher into: hmac, cipher & iv
        $macSize    = 64;
        $hmac 	    = mb_substr($ciphertext, 0, $macSize, '8bit');
        $iv_cipher  = mb_substr($ciphertext, $macSize, null, '8bit');

        // generate original hmac & compare it with the one in $ciphertext
        $originalHmac = hash_hmac('sha256', $iv_cipher, $key);
        if(!self::hashEquals($hmac, $originalHmac)){
            return false;
        }

        // split out the initialization vector and cipher
        $iv_size = openssl_cipher_iv_length(self::CIPHER);
        $iv      = mb_substr($iv_cipher, 0, $iv_size, '8bit');
        $cipher  = mb_substr($iv_cipher, $iv_size, null, '8bit');

        return openssl_decrypt($cipher, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * A timing attack resistant comparison.
     *
     * @access private
     * @static static method
     * @param string $hmac The hmac from the ciphertext being decrypted.
     * @param string $compare The comparison hmac.
     * @return bool
     * @see https://github.com/sarciszewski/php-future/blob/bd6c91fb924b2b35a3e4f4074a642868bd051baf/src/Security.php#L36
     */
    private static function hashEquals($hmac, $compare){

        if (function_exists('hash_equals')) {
            return hash_equals($hmac, $compare);
        }

        // if hash_equals() is not available,
        // then use the following snippet.
        // It's equivalent to hash_equals() in PHP 5.6.
        $hashLength    = mb_strlen($hmac, '8bit');
        $compareLength = mb_strlen($compare, '8bit');

        if ($hashLength !== $compareLength) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < $hashLength; $i++) {
            $result |= (ord($hmac[$i]) ^ ord($compare[$i]));
        }

        return $result === 0;
    }

    /**
     * Translates a number to a short alhanumeric version
     *
     * Translated any number up to 9007199254740992
     * to a shorter version in letters e.g.:
     * 9007199254740989 --> PpQXn7COf
     *
     * @return mixed string or long
     */
    public static function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null) {
        $out = '';
        $index = 'abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($index);

        if ($pass_key !== null) {
            // Although this function's purpose is to just make the
            // ID short - and not so much secure,
            // with this patch by Simon Franz (http://blog.snaky.org/)
            // you can optionally supply a password to make it harder
            // to calculate the corresponding numeric ID

            for ($n = 0; $n < strlen($index); $n++) {
                $i[] = substr($index, $n, 1);
            }

            $pass_hash = hash('sha256', $pass_key);
            $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

            for ($n = 0; $n < strlen($index); $n++) {
                $p[] = substr($pass_hash, $n, 1);
            }

            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }

        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $len = strlen($in) - 1;

            for ($t = $len; $t >= 0; $t--) {
                $bcp = bcpow($base, $len - $t);
                $out = (int)$out + (int)strpos($index, substr($in, $t, 1)) * (int)$bcp;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }
        } else {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in = $in - ($a * $bcp);
            }
        }

        return $out;
    }
}
