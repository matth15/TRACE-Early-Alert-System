<?php
class TeacherModel extends Model
{

    public function register($data)
    {
        try {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT, array('cost' => Config::get('hashing/hash_cost_factor')));

            $table = Config::get("mysql/teacher_table");
            $sql = "INSERT INTO $table (unique_id,name,email,password,user_type) VALUES (:unique_id,:name,:email,:hashedpassword,:user_type)";
            $this->db->prepare($sql);
            $this->db->bindValue(':unique_id', $data['unique_id']);
            $this->db->bindValue(':name', $data['name']);
            $this->db->bindValue('email', $data['email']);
            $this->db->bindValue(':hashedpassword', $hashedPassword);
            $this->db->bindValue(':user_type', "teacher");
            if ($this->db->execute()) {
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            return false;
        }
    }
    public function getFacultyCount($search = '')
    {
        $table = Config::get("mysql/teacher_table");
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
    public function fetchFacultyData($offset, $perPage, $search = '')
    {
        try {
            $table = Config::get("mysql/teacher_table");
            $sql = "SELECT * FROM $table ";
            if (!empty($search)) {
                $sql .= "WHERE name LIKE '$search%' OR email LIKE '$search%' ";
            }
            $sql .= "ORDER BY name ASC LIMIT $offset,$perPage";
            $this->db->prepare($sql);
            $this->db->execute();
            return $this->db->fetchAllAssociative();
        } catch (PDOException $e) {
            // Log or handle the error without revealing sensitive details
            error_log("Database error: " . $e->getMessage());
            // Provide a generic error message to the user
            echo "An error occurred. Please try again later.";
        }
    }
    public function fetchFacultyDataById($id)
    {
        $table = Config::get("mysql/teacher_table");
        $sql = "SELECT * FROM $table WHERE id = :id";
        $this->db->prepare($sql);
        $this->db->bindValue(':id',$id);
       
        if($this->db->execute()){
            $result = $this->db->fetchAssociative();
            if($result > 1){
                return $result;
            }
        }
        return false;
    }


    public function deleteFaculty($id)
    {
        $table = Config::get("mysql/teacher_table");
        $sql = "DELETE FROM $table WHERE id = :id";
            $this->db->prepare($sql);
            $this->db->bindValue(":id", $id);
            if ($this->db->execute()) {
                return true;
            }
            return false;
    }
    public function updateFaculty($data)
    {
        $table = Config::get("mysql/teacher_table");
        $sql = "UPDATE $table SET name = :name , email = :email where id = :id";
        $this->db->prepare($sql);
        $this->db->bindValue(':name',$data['name']);
        $this->db->bindValue(':email',$data['email']);
        $this->db->bindValue(':id',$data['id']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
}
