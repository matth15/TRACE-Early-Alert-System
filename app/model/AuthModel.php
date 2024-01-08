<?php

/**=========================================================
 *               USER AUTHENTICATION MODEL
 * =========================================================
 */

class AuthModel extends Model
{
    public function register($fullname, $email, $password, $grade_level, $strand, $phoneNo)
    {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, array('cost' => Config::get('hashing/hash_cost_factor')));
        $phoneNumber = "+63".ltrim($phoneNo,'0');
        $phoneNumberInt = (int) $phoneNumber;

        $table = Config::get("mysql/student_table");
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO $table (unique_id,name, email , password , parent_phoneNo , grade_level ,strand,user_type) VALUES (:unique_id,:name, :email, :hashedPassword, :phone_no, :grade_level, :strand,:user_type)";

            $unique_id = $this->generateUniqueId($table);

            $this->db->prepare($query);
            $this->db->bindValue(':unique_id', $unique_id);
            $this->db->bindValue(':name', $fullname);
            $this->db->bindValue(':email', $email);
            $this->db->bindValue(':phone_no',$phoneNumberInt );
            $this->db->bindValue(':hashedPassword', $hashedPassword);
            $this->db->bindValue(':grade_level', $grade_level);
            $this->db->bindValue(':strand', $strand);
            $this->db->bindValue(':user_type', 'student');
            $this->db->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * it return true if the update process for user data in specific table in execute bool
     * 
     * @param string $query 
     * @param array  $bindParam 
     * @param array  $table 
     * @param array  $bindValue
     *
     * @return bool  true|false
     */
    public function updateUserData($query, $table, $bindParam, $bindValue)
    {
        $newQuery = explode(" ? ", $query);
        //iterate 3x
        for ($i = 0; $i < count($table); $i++) {

            $esql = $newQuery[0] . ' ' . $table[$i] . ' ' . $newQuery[1];
            $this->db->prepare($esql);

            //iterate 3x
            for ($x = 0; $x < count($bindParam); $x++) {
                $this->db->bindValue($bindParam[$x], $bindValue[$x]);
            }
            if ($this->db->execute()) {
                return true;
            }
        }
        return false;
    }

    public function fetchUserData($email)
    {
        
        $table = [Config::get("mysql/student_table") , Config::get("mysql/teacher_table"), Config::get("mysql/admin_table")];
        foreach ($table as $val) {
            $this->db->prepare("SELECT * FROM {$val} WHERE email = :email LIMIT 1");
            $this->db->bindValue(':email', $email);
            $this->db->execute();
            $user =  $this->db->fetchAssociative();
            if ($user) {
                return $user;
            }
        }
        return false;
    }


    public function setUserVerified($email)
    {
        $table = Config::get("mysql/teacher_table");
            $this->db->prepare("UPDATE $table SET is_email_activated = 1 WHERE email = :email ");
            $this->db->bindValue(':email', $email);
            if ($this->db->execute()) {
                return true;
            }  
        return false;
    }

    public function login($email, $password)
    {

        // 1. instantiate the validation class
        $rule = new ValidationRules();

        // check to the 3 table user if email exist and return user col table
        $user = $this->fetchUserData($email);

        //2. Retrieve user data 
        $userId = isset($user["id"]) ? $user["id"] : null;
        $user_type = isset($user['user_type']) ? $user['user_type'] : null;
        $user_name = isset($user['name']) ? $user['name'] : null;
        $user_uniqueid = isset($user['unique_id']) ? $user['unique_id'] : null;
        $hashedPassword = isset($user["password"]) ? $user["password"] : null;

        // 4. validate data returned from users table
        if (empty($user['email'])) {
            Session::set('LOGIN-ERROR', "Failed to log in. TRACE Email not found!");
            return false;
        }

        if (!$rule->credentials(["user_id" => $userId, "hashed_password" => $hashedPassword, "password" => $password])) {
            session::set('LOGIN-ERROR', 'Incorrect Password or TRACE E-mail address. Please try again.');
            return false;
        } else {

            //5. Get Logged User session Values.
            Session::getUserSessions(["user_id" => $userId, "user_type" => $user_type, "user_email" => $email, "user_name" => $user_name, 'user_uniqueid' => $user_uniqueid ]);
            //6. If the validation succeeds, return the user data
            return true;
        }
    }
    public function reset_password($np, $email)
    {
        $newPassword = password_hash($np, PASSWORD_DEFAULT);
        $table = [Config::get("mysql/student_table"), Config::get("mysql/teacher_table"), Config::get("mysql/admin")];
        try {
            foreach ($table as $val) {
                $sql = "UPDATE {$val} SET password = :password WHERE email = :email";
                $this->db->prepare($sql);
                $this->db->bindValue(':email', $email);
                $this->db->bindValue(':password', $newPassword);
                if ($this->db->execute()) {
                    return true;
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
        return false;
    }
    public function forgot_password($email)
    {
        $userData = $this->fetchUserData($email);

        $userEmail = isset($userData['email']) ? $userData['email'] : NULL;
        if (!empty($userEmail)) {
            Session::getUserSessions(["user_email" => $email]);
            return true;
        }
        return false;
    }

    public function verifyOTP($email, $enteredOTP)
    {
        // 1. Get the user's stored OTP from the database
        $user = $this->fetchUserData($email);

        // 2. return stored OTP expiration 
        $otpExpiration = isset($user["otp_expiration"]) ? strtotime($user["otp_expiration"]) : null;

        // 3. Check OTP expiration
        if ($otpExpiration !== null && time() > $otpExpiration) {
            session::set('OTP-ERROR', 'OTP has expired. Please request a new OTP.');
            return false;
        }
        // 4. Compare the entered OTP with the stored OTP
        $storedOTP = isset($user["otp"]) ? $user["otp"] : null;
        if ($enteredOTP == $storedOTP) {

            // OTP is correct, return true


            //login for login,forgot-password

            $this->updateOTP($email);
            return true;
        } else {
            Session::set('OTP-ERROR', "Invalid OTP Code!");
        }
    }

    public function generateUniqueId($table)
    {
        try {
            $generatedId = $this->generateOTP(7);
            $this->db->prepare("SELECT * FROM {$table} WHERE unique_id = :generatedId");
            $this->db->bindValue(":generatedId", $generatedId);
            $this->db->execute();
            $row = $this->db->fetchAssociative();
            if ($row) {
                $this->generateUniqueId($table);
            }
            return $generatedId;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return false;
    }
    function generateOTP($length = 6)
{
    // Ensure the specified length is at least 1
    $length = max(1, $length);

    // Define the characters that can be used in the OTP
    $characters = '0123456789';
    $otp = '';

    // Generate random OTP
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $otp;
}

    public function updateGeneratedOTP($email, $otp, $otp_expiration)
    {
        try {
            $this->db->beginTransaction();
            $table = [Config::get("mysql/student_table"), Config::get("mysql/teacher_table"), Config::get("mysql/admin_table")];
            foreach ($table as $t) {

                $this->db->prepare("UPDATE {$t} SET otp = :otp , otp_expiration = :otp_expiration WHERE email = :email");
                $this->db->bindValue(":otp", $otp);
                $this->db->bindValue(":otp_expiration", $otp_expiration);
                $this->db->bindValue(":email", $email);
                $this->db->execute();
            }
            $this->db->commit();
        } catch (PDOException $e) {
            var_dump(print_r($e->getMessage()));
            return false;
        }
        return true;
    }
    public function updateOTP($email)
    {
        $this->db->beginTransaction();

        $query = "UPDATE ? SET otp = NULL, otp_expiration = NULL WHERE email = :email";
        $bindParam = array(":email");
        $bindValue = array($email);
        $con = $this->updateUserData($query, [Config::get("mysql/student_table"), Config::get("mysql/teacher_table"), Config::get("mysql/admin_table")], $bindParam, $bindValue);
        $this->db->commit();
        return $con;
    }


    public function getProfileInfo($email)
    {
        $table = [Config::get("mysql/student_table"), Config::get("mysql/teacher_table"), Config::get("mysql/admin_table")];
        // 
        for ($i = 0; $i < count($table); $i++) {
            $this->db->getByUserEmail($table[$i], $email);
            // Check if the user exists
            if ($this->db->countRows() > 0) {
                return $user = $this->db->fetchAssociative();
            }
        }

        return null;
    }


    public function logout($userId)
    {
        Session::init();
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();
    }
}
