<?php

/**
 * Session Class
 *
 */

class Session
{

    /**
     * constructor for Session Object.
     *
     * @access private
     */
    private function __construct()
    {
    }

    /**
     * Starts the session if not started yet.
     *
     * @access public
     *
     */
    public static function init()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get IsLoggedIn value(boolean)
     *
     * @access public
     * @static static method
     * @return boolean
     *
     */
    public static function getIsLoggedIn()
    {
        return empty($_SESSION["is_logged_in"]) || !is_bool($_SESSION["is_logged_in"]) ? false : $_SESSION["is_logged_in"];
    }

    /**
     * Get User ID.
     *
     * @access public
     * @static static method
     * @return string|null
     *
     */
    public static function getUserId()
    {
        return empty($_SESSION["user_id"]) ? null : (int)$_SESSION["user_id"];
    }

    /**
     * 
     * Get User E-mail.
     * 
     * @access public 
     * @static static method
     * @return string|null
     * 
     */
    public static function getUserEmail()
    {
        return empty($_SESSION["user_email"]) ? null : $_SESSION["user_email"];
    }

    public static function getUserName(){
        return empty($_SESSION["user_name"]) ? null : $_SESSION["user_name"];
    }
    public static function getUserUniqueId(){
        return empty($_SESSION["user_uniqueid"]) ? null : $_SESSION["user_uniqueid"];
    }

    /**
     * Get User Type
     *
     * @access public
     * @static static method
     * @return string|null
     *
     */
    public static function getUserType()
    {
        return empty($_SESSION["user_type"]) ? null : $_SESSION["user_type"];
    }

    /**
     * Get CSRF Token
     *
     * @access public
     * @static static method
     * @return string|null
     *
     */
    public static function getCsrfToken()
    {
        return empty($_SESSION["csrf_token"]) ? null : $_SESSION["csrf_token"];
    }

    /**
     * Get CSRF Token generated time
     *
     * @access public
     * @static static method
     * @return string|null
     *
     */
    public static function getCsrfTokenTime()
    {
        return empty($_SESSION["csrf_token_time"]) ? null : $_SESSION["csrf_token_time"];
    }

    /**
     * Get Session key and value
     *
     * @access public
     * @static static method
     * @param $key
     * @param $value
     *
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get Session value by $key
     *
     * @access public
     * @static static method
     * @param  $key
     * @return mixed
     *
     */
    public static function get($key)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    /**
     * Get Session value by $key and destroy it
     *
     * @access public
     * @static static method
     * @param  $key
     * @return mixed
     *
     */
    public static function getAndDestroy($key)
    {

        if (array_key_exists($key, $_SESSION)) {

            $value = $_SESSION[$key];
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);

            return $value;
        }

        return null;
    }

    /**
     * matches current IP Address with the one stored in the session
     *
     * @access public
     * @static static method
     * @param  string $ip
     * @return bool
     *
     */
    private static function validateIPAddress($ip)
    {

        if (!isset($_SESSION['ip']) || !isset($ip)) {
            return false;
        }

        return $_SESSION['ip'] === $ip;
    }

    /**
     * matches current user agent with the one stored in the session
     *
     * @access public
     * @static static method
     * @param  string $userAgent
     * @return bool
     *
     */
    private static function validateUserAgent($userAgent)
    {

        if (!isset($_SESSION['user_agent']) || !isset($userAgent)) {
            return false;
        }

        return $_SESSION['user_agent'] === $userAgent;
    }


    /**
     * get CSRF token and generate a new one if expired
     *
     * @access public
     * @static static method
     * @return string
     *
     */
    public static function generateCsrfToken()
    {

        $max_time = 60 * 60 * 24; // 1 day
        $stored_time = self::getCsrfTokenTime();
        $csrf_token  = self::getCsrfToken();

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {
            $token = md5(uniqid(rand(), true));
            $_SESSION["csrf_token"] = $token;
            $_SESSION["csrf_token_time"] = time();
        }

        return self::getCsrfToken();
    }

    /**
     * Get User session Values.
     *
     * @access public
     * @static static method
     * @param  array  $data
     * @return string
     *
     */
    public static function getUserSessions($data)
    {

        $_SESSION = array();

        $_SESSION['user_email'] = $data['user_email'];
        $_SESSION["user_id"]      = (int)$data["user_id"];
        $_SESSION["user_type"] = $data["user_type"];
        $_SESSION["user_name"] = $data["user_name"];
        $_SESSION["user_uniqueid"] = $data["user_uniqueid"];
    }

    public static function setLoggedInSession()
    {
        $_SESSION["is_logged_in"] = true;
    }



    public static function success($msg)
    {
        if (isset($_SESSION[$msg])) {

            echo '<div class="alert alert-success rounded-1">' . $_SESSION[$msg] . '</div>';

            unset($_SESSION[$msg]);
        }
    }

    public static function danger($msg)
    {
        if (isset($_SESSION[$msg])) {

            echo '<div class="alert alert-danger rounded-1 alert-dismissible fade show">' . $_SESSION[$msg] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

            unset($_SESSION[$msg]);
        }
    }

    public static function warning($msg)
    {
        if (isset($_SESSION[$msg])) {

            echo '<div class="alert alert-warning rounded-1 ">' . $_SESSION[$msg] . '</div>';

            unset($_SESSION[$msg]);
        }
    }

    public static function successToast($msg)
    {
        echo '<div class=" position-fixed bottom-0 end-0 p-3" style="z-index: 5;  max-width: 300px;">
        <div id="myToast" class="toast hide bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
           <div class="d-flex ">
           <div class="toast-body">
            <strong>Success</strong>
                ' . $_SESSION[$msg] . '
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto " data-bs-dismiss="toast" aria-label="Close"></button>
           </div>
        </div>
    </div>';

        unset($_SESSION[$msg]);
    }
}
