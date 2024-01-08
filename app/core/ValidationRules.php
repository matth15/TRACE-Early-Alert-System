<?php

class ValidationRules
{

    public $db;
    /** *********************************************** **/
    /** **************    Validations    ************** **/
    /** *********************************************** **/

    /**
     * Determine if a given value has 'required' rule
     *
     * @param  array  $value
     * @return bool
     */
    public static function isRequired($value)
    {
        if (filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            return true;
        }
        return false;
    }

    /**
     * check if value is a valid email
     *
     * @param  string  $email
     * @return bool
     */
    public static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    /**
     * min string length
     *
     * @param  string  $str
     * @param  array  $args(min)
     *
     * @return bool
     */

    public static function minLen($str, $args)
    {

        return mb_strlen($str, 'UTF-8') >= (int)$args;
    }

    /**
     * max string length
     *
     * @param  string  $str
     * @param  array  $args(max)
     *
     * @return bool
     */
    public static function maxLen($str, $args)
    {
        return mb_strlen($str, 'UTF-8') <= (int)$args;
    }

    /**
     * check if value is a valid number
     *
     * @param  string|integer  $value
     * @return bool
     */
    public static function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * check if value is contains alphabetic characters and numbers
     *
     * @param  mixed   $value
     * @return bool
     */
    public static function alphaNum($value)
    {
        return preg_match('/\A[a-z0-9]+\z/i', $value);
    }

    /**
     * check if value is contains alphabetic characters, numbers and spaces
     *
     * @param  mixed   $value
     * @return bool
     */
    public static function alphaNumWithSpaces($value)
    {
        return preg_match('/\A[a-z0-9 ]+\z/i', $value);
    }
    /**
     * 
     * student form
     * 
     */
    public function validateStudentForm($studentFormData)
    {
        $data = [];
        $confirm_password = !empty($studentFormData['confirm_password']) ?: null;

        $domainAllowed = "tracecollege.edu.ph";

        if (!$this->isRequired($studentFormData['firstname'])) {
            $data['ValidationError'] = "First name is Required.";
        } elseif (!$this->isRequired($studentFormData['lastname'])) {
            $data['ValidationError'] = "Last name is Required.";
        } elseif (!$this->isRequired($studentFormData['email'])) {
            $data['ValidationError'] = "Email is Required.";
        } elseif (!$this->isRequired($studentFormData['password'])) {
            $data['ValidationError'] = "Password is Required.";
        } elseif (!$this->isRequired($confirm_password) && !is_null($confirm_password)) {
            $data['ValidationError'] = "Confirm password is Required.";
        } elseif (!$this->isRequired($studentFormData['phone_number'])) {
            $data['ValidationError'] = "Parent Phone No Required!";
        } elseif (!$this->isRequired($studentFormData['grade_level'])) {
            $data['ValidationError'] = "Grade level is Required.";
        } elseif (!$this->isRequired($studentFormData['strand'])) {
            $data['ValidationError'] = "Strand is Required.";
        } else {
            //validate firstname and lastname 
            if (!$this->minLen($studentFormData['firstname'], 3)) {
                $data['ValidationError'] = "First name should be at least 3 Characters.";
            } elseif (!$this->minLen($studentFormData['lastname'], 3)) {
                $data['ValidationError'] = "Last name should be at least 3 Characters.";
            } else {
                //validate email
                if (!$this->checkEmailDomain($studentFormData['email'], $domainAllowed)) {
                    $data['ValidationError'] = "Trace email address only.";
                } elseif (!$this->unique($studentFormData['email'], "email",Config::get("mysql/student_table"))) {
                    $data['ValidationError'] = "Trace email address is already exist!";
                } else {
                    //validate password & confirm password
                    if (!$this->minLen($studentFormData['password'], 6)) {
                        $data['ValidationError'] = "Password must not be less than 5 Characters.";
                    } elseif (!$this->password($studentFormData['password'])) {
                        $data['ValidationError'] = "Password must have at least a lowercase, uppercase, integer, and special character.";
                    } elseif (!is_null($confirm_password) && !$this->equals($studentFormData['password'], [$confirm_password])) {
                        $data['ValidationError'] = "Password is not match!";
                    }
                }
            }
        }

        return $data;
    }
    /**
     * 
     * faculty form
     */
    public function validateFacultyForm($facultyFormData)
    {
        $data = [];

        $domainAllowed = "tracecollege.edu.ph";

        if (!$this->isRequired($facultyFormData['firstname'])) {
            $data['ValidationError'] = "First name is Required.";
        } elseif (!$this->isRequired($facultyFormData['lastname'])) {
            $data['ValidationError'] = "Last name is Required.";
        } elseif (!$this->isRequired($facultyFormData['email'])) {
            $data['ValidationError'] = "Email is Required.";
        } elseif (!$this->isRequired($facultyFormData['password'])) {
            $data['ValidationError'] = "Password is Required.";
        } else {
            //validate firstname and lastname 
            if (!$this->minLen($facultyFormData['firstname'], 3)) {
                $data['ValidationError'] = "First name should be at least 3 Characters.";
            } elseif (!$this->minLen($facultyFormData['lastname'], 3)) {
                $data['ValidationError'] = "Last name should be at least 3 Characters.";
            } else {
                //validate email
                if (!$this->checkEmailDomain($facultyFormData['email'], $domainAllowed)) {
                    $data['ValidationError'] = "Trace email address only.";
                } elseif (!$this->unique($facultyFormData['email'], "email", Config::get("mysql/teacher_table"))) {
                    $data['ValidationError'] = "Trace email address is already exist!";
                } else {
                    //validate password & confirm password
                    if (!$this->minLen($facultyFormData['password'], 6)) {
                        $data['ValidationError'] = "Password must not be less than 5 Characters.";
                    } elseif (!$this->password($facultyFormData['password'])) {
                        $data['ValidationError'] = "Password must have at least a lowercase, uppercase, integer, and special character.";
                    }
                }
            }
        }

        return $data;
    }

    /**
     * check if password has at least
     * - one lowercase letter
     * - one uppercase letter
     * - one number
     * - one special(non-word) character
     *
     * @param  mixed   $value
     * @return bool
     * @see http://stackoverflow.com/questions/8141125/regex-for-password-php
     * @see http://code.runnable.com/UmrnTejI6Q4_AAIM/how-to-validate-complex-passwords-using-regular-expressions-for-php-and-pcre
     */
    public static function password($value)
    {
        return preg_match_all('$\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $value);
    }

    /**
     * check if value is equals to another value(strings)
     *
     * @param  string  $value
     * @param  array   $args(value)
     * @return bool
     */
    public function equals($value, $args)
    {
        return $value === $args[0];
    }

    /**
     * check if value is not equal to another value(strings)
     *
     * @param  string  $value
     * @param  array   $args(value)
     * @return bool
     */
    public static function notEqual($value, $args)
    {
        return $value !==  $args[0];
    }


    /** *********************************************** **/
    /** ************  Database Validations  *********** **/
    /** *********************************************** **/




    /**
     * this method check if email exist to specific and return fetchAssociative() method
     * 
     * @param string $table
     * @param string $value
     * @return boolean
     * 
     */
    public function is_email_exist_to($table, $value)
    {

        $this->db->prepare("SELECT * FROM {$table} WHERE email = :email LIMIT 1");
        $this->db->bindValue(':email', $value);
        $this->db->execute();
        return $user =  $this->db->fetchAssociative();
    }

    /**
     * check if a value of a column is unique.
     *
     * @param  string  $value
     * @param  array   $col
     * @param string   $table
     * @return bool
     */
    public function unique($value, $col, $table)
    {

        $this->db = Database::open_db();
        $this->db->prepare("SELECT * FROM {$table} WHERE {$col} = :{$col}");
        $this->db->bindValue(":{$col}", $value);
        $this->db->execute();

        return $this->db->countRows() === 0;
    }
    /**
     * this method check if the email is verified or not
     * @param $string
     * @param $string
     * @return bool
     */
    public function is_email_verified($email)
    {
        $table = [Config::get("mysql/student_table"), Config::get("mysql/teacher_table")];
        try {
            $this->db = Database::open_db();
            foreach ($table as $val) {
                $this->db->prepare("SELECT * FROM {$val} WHERE email = :email");
                $this->db->bindValue(":email", $email);
                if ($this->db->execute()) {
                    $user = $this->db->fetchAssociative() !== false ? $this->db->fetchAssociative() : false;
                    if ($user && $user['is_email_verified'] > 0) {
                        return true;
                    }
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return false;
    }

    /**
     * check if email is unique
     * This will check if email exists and activated.
     *
     * @param  string  $string
     * @return bool
     */
    public function emailUnique($email)
    {

        $this->db = Database::open_db();

        // email is unique in the database, So, we can't have more than 2 same emails
        $table = Config::get("mysql/student_table");
        $this->db->prepare("SELECT * FROM $table WHERE email = :email LIMIT 1");
        $this->db->bindValue(':email', $email);
        $this->db->execute();
        $user =  $this->db->fetchAssociative();

        if ($this->db->countRows() === 1) {
            return false;
        }
        return true;
    }

    /**
     * 
     * check if the email is equal to allowed domain
     * @param string
     * @return bool
     * 
     */
    public function checkEmailDomain($email, $domain)
    {
        return substr(strrchr($email, "@"), 1) === $domain;
    }



    /** *********************************************** **/
    /** ************    Login Validations   *********** **/
    /** *********************************************** **/

    /**
     * check if user credentials are valid or not.
     *
     * @param  array   $user
     * @return bool
     * @see Login::doLogin()
     */
    public function credentials($user)
    {
        if (empty($user["hashed_password"]) || empty($user["user_id"])) {
            return false;
        } elseif (password_verify($user["password"], $user["hashed_password"])) {
            return true;
        } elseif ($user['password'] == $user['hashed_password']) {
            return true;
        }

        return false;
    }

    /**
     * check if user has exceeded number of failed logins or number of forgotten password attempts.
     *
     * @param  array   $attempts
     * @return bool
     */
    public function attempts($attempts)
    {

        if (empty($attempts['last_time']) && empty($attempts['count'])) {
            return true;
        }

        $block_time = (10 * 60);
        $time_elapsed = time() - $attempts['last_time'];

        // TODO If user is Blocked, Update failed logins/forgotten passwords
        // to current time and optionally number of attempts to be incremented,
        // but, this will reset the last_time every time there is a failed attempt

        if ($attempts["count"] >= 3 && $time_elapsed < $block_time) {

            // here i can't define a default error message as in defaultMessages()
            // because the error message depends on variables like $block_time & $time_elapsed
            Session::set('danger', "You exceeded number of possible attempts, please try again later after " .

                date("i", $block_time - $time_elapsed) . " minutes");
            return false;
        } else {

            return true;
        }
    }

    /** *********************************************** **/
    /** ************    File Validations    *********** **/
    /** *********************************************** **/

    /**
     * checks if file unique.
     *
     * @param  array  $path
     * @return bool
     *
     * @see
     */
    private function fileUnique($path)
    {
        // return !file_exists($path);
    }

    /**
     * checks for file errors
     *
     * @param  array   $file
     * @return bool
     */
    private function fileErrors($file)
    {
        return (int)$file['error'] === UPLOAD_ERR_OK;
    }

    /**
     * checks if file uploaded successfully via HTTP POST
     *
     * @param  array   $file
     * @return bool
     *
     * @see
     */
    private function fileUploaded($file)
    {
        return is_uploaded_file($file["tmp_name"]);
    }

    /**
     * checks from file size
     *
     * @param  array   $file
     * @param  array   $args(min,max)
     * @return bool
     */
    public function fileSize($file, $args)
    {

        // size in bytes,
        // 1 KB = 1024 bytes, and 1 MB = 1048,576 bytes.
        $size = array("min" => (int)$args[0], "max" => (int)$args[1]);

        if ($file['size'] > $size['max']) {
            Session::set('danger', "File size can't exceed max limit (" . ($size['max'] / 102400) . " MB)");
            return false;
        }

        // better not to say the min limits.
        if ($file['size'] < $size['min']) {
            Session::set('danger', "File size either is too small or corrupted");
            return false;
        }
        return true;
    }

    /**
     * checks from image size(dimensions)
     *
     * @param  array   $file
     * @param  array   $dimensions(width,height)
     * @return bool
     */
    public function imageSize($file, $dimensions)
    {

        $imageSize  = array('width' => 0, 'height' => 0);
        list($imageSize['width'], $imageSize['height'])   = getimagesize($file["tmp_name"]);

        if ($imageSize["width"] < 10 || $imageSize["height"] < 10) {
            return false;
        }
        if ($imageSize["width"] > $dimensions[0] || $imageSize["height"] > $dimensions[1]) {
            return false;
        }
        return true;
    }


    /**
     * validate file extension returned from pathinfo() Vs mapped mime type to extension
     *
     * This reveal un desired errors in case of files with extension: zip, csv, ..etc
     *   
     */

    public function fileExtension($image, $allowed = array())
    {
        $image = $_FILES['image']['name'];
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        if (!in_array($extension, $allowed)) {
            return false;
        }
        return true;
    }
}
