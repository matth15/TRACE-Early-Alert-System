<?php 

class AdminModel extends Model {


    
   


public function fetchAdminData($email){
    $table = Config::get("mysql/admin_table");
    $this->db->prepare("SELECT * FROM $table WHERE email = :email");
    $this->db->bindValue(':email',$email);
    $this->db->execute();

    return $this->db->fetchAllAssociative();
}

}

?>