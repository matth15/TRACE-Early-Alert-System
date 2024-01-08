<?php

/**
 * Cookie Class
 *
 */

class Cookie{

    /**
     * @access public
     * @var string User ID
     */
    private static $userId = null;

    /**
     * @access public
     * @var string Cookie Token
     */
    private static $token = null;

    /**
     * @access public
     * @var string Hashed Token = hash(User ID . ":" . Token . Cookie Secret)
     */
    private static $hashedCookie = null;

    /**
     * This is the constructor for Cookie object.
     *
     * @access private
     */
    private function __construct() {}

    /**
     * Getters for $userId
     *
     * @access public
     * @static static method
     * @return string   User ID
     */
    public static function getUserId(){
        return (int)self::$userId;
    }

    /**
     * Extract and validate cookie
     *
     * @access public
     * @static static method
     * @return bool
     */
    public static function isCookieValid(){

        // "auth" or "remember me" cookie
        if(empty($_COOKIE['auth'])) {
            return false;
        }

        // check the count before using explode
        $cookie_auth = explode(':', $_COOKIE['auth']);
        if(count ($cookie_auth) !== 3){
            self::remove();
            return false;
        }

        list ($encryptedUserId, self::$token, self::$hashedCookie) = $cookie_auth;

        // Remember? $hashedCookie was generated from the original user Id, NOT from the encrypted one.
        self::$userId = Encryption::decrypt($encryptedUserId);

        if (self::$hashedCookie === hash('sha256', self::$userId . ':' . self::$token . Config::get('cookie/cookie_secret_key')) && !empty(self::$token) && !empty(self::$userId)) {

            $database = Database::open_db();
            $query    = "SELECT id, cookie_token FROM users WHERE id = :id AND cookie_token = :cookie_token LIMIT 1";
            $database->prepare($query);
            $database->bindValue(':id', self::$userId);
            $database->bindValue(':cookie_token', self::$token);
            $database->execute();

            $isValid = $database->countRows() === 1? true: false;

        }else{

           $isValid = false;
        }

        if(!$isValid){
            
            self::remove(self::$userId);
        }

        return  $isValid;
    }

    /**
     * Remove cookie from the database of a user(if exists),
     * and also from the browser.
     *
     * @static static  method
     * @param  string  $userId
     *
     */
    public static function remove($userId = null){

        if(!empty($userId)){

            $database = Database::open_db();
            $query    = "UPDATE users SET cookie_token = NULL WHERE id = :id";
            $database->prepare($query);
            $database->bindValue(":id", $userId);
            $result = $database->execute();
           
        }

        self::$userId = self::$token = self::$hashedCookie = null;

        // How to kill/delete a cookie in a browser?
        setcookie('auth', false, time() - (3600 * 3650), Config::get('cookie/cookie_path'), Config::get('cookie/cookie_domain'), Config::get('cookie/cookie_secure'), Config::get('cookie/cookie_http'));
    }

    /**
     * Reset Cookie,
     * resetting is done by updating the database,
     * and resetting the "auth" cookie in the browser
     *
     * @static  static method
     * @param   string $userId
     */
    public static function reset($userId){

        self::$userId = $userId;
        self::$token = hash('sha256', mt_rand());
        $database = Database::open_db();

        $query = "UPDATE users SET cookie_token = :cookie_token WHERE id = :id";
        $database->prepare($query);

        // generate random hash for cookie token (64 char string)
        $database->bindValue(":cookie_token", self::$token);
        $database->bindValue(":id", self::$userId);
        $result = $database->execute();

        // generate cookie string(remember me)
        // Don't expose the original user id in the cookie, Encrypt It!
        $cookieFirstPart = Encryption::encrypt(self::$userId) . ':' . self::$token ;

        // $hashedCookie generated from the original user Id, NOT from the encrypted one.
        self::$hashedCookie = hash('sha256', self::$userId . ':' . self::$token  . Config::get('cookie/cookie_secret_key'));
        $authCookie = $cookieFirstPart . ':' . self::$hashedCookie;

        setcookie('auth', $authCookie, time() + Config::get('cookie/cookie_expiry'), Config::get('cookie/cookie_path'), Config::get('cookie/cookie_domain'), Config::get('cookie/cookie_secure'), Config::get('cookie/cookie_http'));
    }

}
