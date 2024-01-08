    <?php

    class StudentModel extends Model
    {

        public function register($data)
        {

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT, array('cost' => Config::get('hashing/hash_cost_factor')));
            // $phoneNumber = "+63" . ltrim($data['phone_number'], '0');
            // $phoneNumberInt = (int) $phoneNumber;
            $table = Config::get("mysql/student_table");
            $sql = "INSERT INTO $table
            (
                unique_id,
                name,
                 email ,
                 password ,
                  grade_level ,
                  strand,
                  user_type
                  )
                   VALUES 
            (
                :unique_id,
                :name,
                 :email,
                  :hashedPassword ,
                   :grade_level,
                    :strand,
                    :user_type)";

            $this->db->prepare($sql);
            $this->db->bindValue(':unique_id', $data['unique_id']);
            $this->db->bindValue(':name', $data['name']);
            $this->db->bindValue(':email', $data['email']);
            $this->db->bindValue(':hashedPassword', $hashedPassword);
            // $this->db->bindValue(':phone_no', $phoneNumberInt);
            $this->db->bindValue(':grade_level', $data['grade_level']);
            $this->db->bindValue(':strand', $data['strand']);
            $this->db->bindValue(':user_type', "student");
            if ($this->db->execute()) {
                return true;
            }
            return false;
        }
        //
        public function getStudentCount($search = '')
        {
            $table = Config::get("mysql/student_table");
            $sql = "SELECT COUNT(*) as count FROM $table ";
            if (!empty($search)) {
                $sql .= "WHERE name LIKE '$search%' OR email LIKE '$search%' ";
            }
            $this->db->prepare($sql);
            $this->db->execute();
            $result =  $this->db->fetchAssociative();
            return $result['count'];
        }
        //
        public function fetchStudentData($offset, $perPage, $search = '')
        {
            $table = Config::get("mysql/student_table");
            $sql = "SELECT * FROM $table ";
            if (!empty($search)) {
                $sql .= "WHERE name LIKE '$search%' OR email LIKE '$search%' ";
            }
            $sql .= "ORDER BY name ASC LIMIT $offset,$perPage";
            $this->db->prepare($sql);
            $this->db->execute();
            return $this->db->fetchAllAssociative();
        }
        //
        public function fetchStudentProfile($studentId)
        {
            $table = Config::get("mysql/student_table");
            $this->db->prepare("SELECT * FROM $table WHERE id = {$studentId} ");
            $this->db->execute();
            $res = $this->db->fetchAssociative();
            if ($res > 1) {
                return $res;
            }
            return false;
        }
        //
        public function updateStudentData($data)
        {
            $table = Config::get("mysql/student_table");
            $sql = "UPDATE $table SET name = :name , email = :email , strand = :strand , section = :section , grade_level = :grade , strand_class = :class WHERE id = :id ";
            $this->db->prepare($sql);
            $this->db->bindValue(":id", $data['id']);
            $this->db->bindValue(":name", $data['name']);
            $this->db->bindValue(":email", $data['email']);
            $this->db->bindValue(":strand", $data['strand']);
            $this->db->bindValue(":grade", $data['grade']);
            $this->db->bindValue(":section", $data['section']);
            $this->db->bindValue(":class", $data['class']);
            if ($this->db->execute()) {
                return true;
            }
            return false;
        }

        public function deleteStudent($studentId)
        {
            $table = Config::get("mysql/student_table");
            $sql = "DELETE FROM $table WHERE id = :id";
            $this->db->prepare($sql);
            $this->db->bindValue(":id", $studentId);
            if ($this->db->execute()) {
                return true;
            }
            return false;
        }
    }
