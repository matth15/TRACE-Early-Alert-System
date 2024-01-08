<?php

/**
 * --------------------------------------------------------------
 *  Base URL 
 * --------------------------------------------------------------
 */

function baseurl()
{

  return 'http://localhost:3000';
}



/**
 * --------------------------------------------------------------
 *  WEB GENERAL CONFIGURATION 
 * --------------------------------------------------------------
 */


$GLOBALS['config'] = array(

  //configuration for database connection

  "mysql" => array(
    "DB_HOST" => "localhost",
    "DB_USERNAME" => "root",
    "DB_PASSWORD" => "",
    "DB_DATABASE" => "early-alert-system",
    "db_charset" => "utf8",
    "teacher_table" => "teachers_data",
    "student_table" => "students_data",
    "classroom_table" => "classroom",
    "admin_table" => "admin",
    "otherclassroom_table" => "sub_classroom"
  ),

  /**
   * Configuration for: Email server credentials
   * Emails are sent using SMTP, Don"t use built-in mail() function in PHP.
   *
   */
  "mailer" => array(
    "email_smtp_debug" => 2,
    "email_smtp_auth" => true,
    "email_smtp_secure" => "ssl",
    "email_smtp_host" => "smtp.gmail.com",
    "email_smtp_username" => "traceearlyalert0@gmail.com",
    "email_smtp_password" => "bvonxiccuswzknkt",
    "email_smtp_port" => 465,
    "email_from" => "traceearlyalert0@gmail.com",
    "email_from_name" => "TRACE Early Alert",
    "email_reply_to" => "no-reply@gmail.com",
    "admin_email" => "traceearlyalert0@gmail.com",


    /**
     * Configuration for: OTP Confirmation
     *
     *
     */

    "email_otp_confirmation" => "1",
    "email_account_verified" => "2",
    "email_account_forgot-password" => "3",
    "email_send_alert" => "4",

    "email_subject_loginOTP" => "Login OTP",
    "email_subject_verified" => "TRACE Early Alert Account Verified",
    "email_subject_forgot-password" => "TRACE Early Alert Request reset password.",
    // "email_subject_earlyalert" => "",



  ),

  /**
   * Configuration for: Hashing strength
   *
   */

  "hashing" => array(

    "hash_cost_factor" => "10"
  ),

);
