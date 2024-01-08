<?php
class ClassroomModel extends Model
{

    public function getClassroomCount($search = '')
        {
            $table = Config::get("mysql/classroom_table");
            $sql = "SELECT COUNT(*) as count FROM $table ";
            if (!empty($search)) {
                $sql .= "WHERE section LIKE '$search%'";
            }
            $this->db->prepare($sql);
            $this->db->execute();
            $result =  $this->db->fetchAssociative();
            return $result['count'];
        }
    public function create($data)
    {

        $sql = "INSERT INTO classroom 
        (unique_id,owner,invite_code,class,strand,section,grade,teacher_unique_id) VALUES
        (:unique_id,:owner,:code,:class,:strand,:section,:grade,:teacher_uniqueid)";

        $invitation_code = $this->generateInviteCode();

        $this->db->prepare($sql);
        $this->db->bindValue(':code', $invitation_code);
        $this->db->bindValue(':unique_id', $data['unique_id']);
        $this->db->bindValue(':owner', $data['teacher']);
        $this->db->bindValue(':section', $data['section']);
        $this->db->bindValue(':strand', $data['strand']);
        $this->db->bindValue(':grade', $data['grade']);
        $this->db->bindValue(':teacher_uniqueid', $data['teacher_uniqueid']);
        $this->db->bindValue(':class', $data['class']);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function generateInviteCode()
    {
        $bytes = random_bytes(4);
        $invite_code = substr(bin2hex($bytes), 0, 7);

        $sql = "SELECT * FROM classroom WHERE invite_code = :code";
        $this->db->prepare($sql);
        $this->db->bindValue(':code', $invite_code);
        $this->db->execute();
        if ($this->db->fetchAssociative() > 0) {
            $this->generateInviteCode();
        } else {
            return $invite_code;
        }
        return false;
    }

    public function getInvitationCode($uniqueId)
    {
        return $this->fetchClassroomData($uniqueId)['invite_code'];
    }

    public function showAllClassroom()
    {
    }
    public function joinSubClass($teacherUniqueId, $classroomUniqueId, $generatedUniqueId,$teacher)
    {

        try {
            $table = Config::get("mysql/otherclassroom_table");
            $sql = "SELECT * FROM $table WHERE teacher_uniqueid = :unique_id ";
            $this->db->prepare($sql);
            $this->db->bindValue(':unique_id', $teacherUniqueId);
            if ($this->db->execute()) {
                $result = $this->db->fetchAssociative();
                if ( $result !== false) {
                    for ($i = 1; $i <= 10; $i++) {
                        $classKey = 'class_' . $i;
                        
                        if ($result[$classKey] === 0) {
                            $sqlUpdate = "UPDATE $table SET $classKey = :classroomUniqueId WHERE teacher_uniqueid = :teacherUniqueId";
                            $this->db->prepare($sqlUpdate);
                            $this->db->bindValue(':classroomUniqueId', $classroomUniqueId);
                            $this->db->bindValue(':teacherUniqueId', $teacherUniqueId);
                            
                            if ($this->db->execute()) {
                                return true;  // Successfully updated
                            } else {
                                return false;  // Update failed
                            }
                        }
                    }
    
                    // No available slot, return false or handle accordingly
                    return false;
    
                } else {
                    $sqlInsert = "INSERT INTO $table (unique_id,name,teacher_uniqueid,class_1) VALUES (:uniqueId,:teacher,:teacherUniqueId,:class1) ";
                    $this->db->prepare($sqlInsert);
                    $this->db->bindValue(':uniqueId', $generatedUniqueId);
                    $this->db->bindValue(':teacher', $teacher);
                    $this->db->bindValue(':teacherUniqueId', $teacherUniqueId);
                    $this->db->bindValue(':class1', $classroomUniqueId);
                    if ($this->db->execute()) {
                        return true;
                    }
                }
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }


    public function isTeacherJoinedSubClass($teacherUniqueId, $classroomUniqueCode)
    {
        $table = Config::get("mysql/otherclassroom_table");
        try {
            for ($i = 1; $i <= 10; $i++) {
                $classColumn = "class_" . $i;

                $checkSql = "SELECT * FROM $table 
                WHERE teacher_uniqueid = :teacherUniqueId 
                AND $classColumn = :classroomUniqueCode";

                $this->db->prepare($checkSql);
                $this->db->bindValue(':teacherUniqueId', $teacherUniqueId);
                $this->db->bindValue(':classroomUniqueCode', $classroomUniqueCode);


                if ($this->db->execute()) {
                    return $this->db->countRows() > 0;
                }
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function fetchSubClassData($classroomUniqueId)
    {
        $table = Config::get("mysql/otherclassroom_table");
        $sql = "SELECT * FROM $table WHERE 
       class_1 = $classroomUniqueId OR
       class_2 = $classroomUniqueId OR 
       class_3 = $classroomUniqueId OR
       class_4 = $classroomUniqueId OR
       class_5 = $classroomUniqueId OR
       class_6 = $classroomUniqueId OR
       class_7 = $classroomUniqueId OR 
       class_8 = $classroomUniqueId OR
       class_9 = $classroomUniqueId OR
       class_10 = $classroomUniqueId";
        $this->db->prepare($sql);
        if ($this->db->execute()) {
            return $this->db->fetchAllAssociative();
        }
        return false;
    }
    public function fetchSubClassByUniqueId($teacherUniqueId){
        $table = Config::get("mysql/otherclassroom_table");
        $sql = "SELECT * FROM $table WHERE tacher_uniqueid = :teacherUniqueId";
         $this->db->prepare($sql);
         $this->db->bindValue(':teacherUniqueId',$teacherUniqueId);
         if ($this->db->execute()) {
             return $this->db->fetchAllAssociative();
         }
         return false;
    }
    public function showSubClassroom($teacherUniqueId) {
        $classroomTable = Config::get("mysql/classroom_table");
        $otherclassroomTable = $table = Config::get("mysql/otherclassroom_table");
        try {
            $subClassroom = [];
    
            // Query to get sub-classroom information
            $sql = "SELECT * FROM $otherclassroomTable WHERE teacher_uniqueid = :teacherUniqueId ";
            $this->db->prepare($sql);
            $this->db->bindValue(':teacherUniqueId', $teacherUniqueId);
            $this->db->execute();
    
            // Fetch sub-classroom data
            $subClassroomData = $this->db->fetchAssociative();
    
            if ($subClassroomData !== false) {
                // Loop through class_1 to class_10 and fetch corresponding classroom details
                for ($i = 1; $i <= 10; $i++) {
                    $classKey = 'class_' . $i;
    
                    // Check if the class is assigned
                    if ($subClassroomData[$classKey] === 0) {
                        if ($i === 1) {
                            // No assigned classes, return false
                            return false;
                        } else {
                            // Break the loop if no more assigned classes
                            break;
                        }
                    }
    
                    // Fetch classroom details for the assigned class
                    $sqlGetClass = "SELECT * FROM $classroomTable WHERE unique_id = :class";
                    $this->db->prepare($sqlGetClass);
                    $this->db->bindValue(':class', $subClassroomData[$classKey]);
                    $this->db->execute();
    
                    // Fetch and add classroom details to the result array
                    $classroomDetails = $this->db->fetchAssociative();
                    if ($classroomDetails !== false) {
                        $subClassroom[] = $classroomDetails;
                    } else {
                        // Break the loop if unable to fetch classroom details
                        break;
                    }
                }
    
                // Return the array of sub-classrooms
                return $subClassroom;
            }
    
            // No sub-classroom data found, return false
            return false;
        } catch (PDOException $e) {
            // Handle any exceptions (you may want to log or report the error)
            return false;
        }
    }
    
    public function fetchSubClassTeacher($classroomUniqueId)
    {
        $table = Config::get("mysql/teacher_table");
        $subClassData =  $this->fetchSubClassData($classroomUniqueId);
        $teachersData = [];
        foreach ($subClassData as $classData) {
            $teacherUniqueId = $classData['teacher_uniqueid'];

            $sql = "SELECT * FROM $table WHERE unique_id = :teacherUniqueId ";
            $this->db->prepare($sql);
            $this->db->bindValue(':teacherUniqueId',$teacherUniqueId);
            if ($this->db->execute()) {
                $teacherData = $this->db->fetchAssociative();
                if($teacherData !== false){
                    $teachersData[] = $teacherData;
                }
            }
        }
        return $teachersData;
    }

    public function hasClassroom($uniqueId)
    {
        $table = Config::get("mysql/classroom_table");
        $sql = "SELECT * FROM $table WHERE teacher_unique_id = :unique_id";

        $this->db->prepare($sql);
        $this->db->bindValue(':unique_id', $uniqueId);
        $this->db->execute();
        if ($this->db->fetchAssociative() > 1) {
            return true;
        }
        return false;
    }
    public function showClassroom($uniqueId, $userType)
    {
        $table = Config::get("mysql/classroom_table");
        $sql = "SELECT * FROM $table ";

        if ($userType === "student") {
            $sql .= " WHERE unique_id = :unique_id";
        } else if ($userType === "teacher") {
            $sql .= " WHERE teacher_unique_id = :unique_id";
        }

        $this->db->prepare($sql);
        $this->db->bindValue(':unique_id', $uniqueId);

        if ($this->db->execute()) {
            return $this->db->fetchAssociative();
        }
        return false;
    }
    public function fetchClassroomHolder($uniqueId)
    {
        $table = Config::get("mysql/teacher_table");
        $sql = "SELECT * FROM $table WHERE unique_id = {$uniqueId}";
        $this->db->prepare($sql);
        if ($this->db->execute()) {
            return $this->db->fetchAssociative();
        }
        return false;
    }
    public function fetchClassroomStudents($uniqueId)
    {
        $table = Config::get("mysql/student_table");
        try {
            $sql = "SELECT * FROM $table WHERE class_unique_id = {$uniqueId}";
            $this->db->prepare($sql);
            if ($this->db->execute()) {
                return $this->db->fetchAllAssociative();
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function fetchClassroomData($uniqueId)
    {
        try {
            $table = Config::get("mysql/classroom_table");
            $sql = "SELECT * FROM $table WHERE unique_id = {$uniqueId}";
            $this->db->prepare($sql);
            if ($this->db->execute()) {
                $result = $this->db->fetchAssociative();
                if ($result > 0) {
                    return $result;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function fetchClassByInviteCode($inviteCode)
    {
        try {
            $table = Config::get("mysql/classroom_table");
            $sql = "SELECT * FROM $table WHERE invite_code = :inviteCode ";
            $this->db->prepare($sql);
            $this->db->bindValue(':inviteCode', $inviteCode);
            if ($this->db->execute()) {
                $result = $this->db->fetchAssociative();

                return ($result !== false) ? $result : false;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
