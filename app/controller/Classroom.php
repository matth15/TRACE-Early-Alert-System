<?php

class Classroom extends Controller
{
    public $classroommodel;
    public $studentmodel;
    public $teachermodel;
    public $request;
    public $authmodel;
    public $redirect;
    public function __construct(Request $request = null)
    {
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        $this->authmodel = $this->model('AuthModel');
        $this->studentmodel = $this->model('StudentModel');
        $this->teachermodel = $this->model('TeacherModel');
        $this->classroommodel = $this->model('ClassroomModel');
        if(!Session::getIsLoggedIn()){
            header("Location: ".baseurl());
            exit();
        }
    }
    public function index()
    {
        $this->view('Classroom');
    }
    public function main($param1 = '')
    {
        $data = [];
        if ($this->classroommodel->fetchClassroomData($param1)) {

            $classroomData = $this->classroommodel->fetchClassroomData($param1);
            $students = $this->classroommodel->fetchClassroomStudents($param1);
            $teachers = $this->classroommodel->fetchSubClassTeacher($param1);
            $holder = $this->classroommodel->fetchClassroomHolder($classroomData['teacher_unique_id']);
            $userType = Session::getUserType();


            $data = ['class' => $classroomData, 'students' => $students, 'teachers' => $teachers, 'owner' => $holder, 'userType' => $userType];

            $this->view('Main-Classroom', $data);
        } else {
            header("Location: " . baseurl() . "/classroom");
            exit();
        }
    }
    public function create()
    {
        $data = [];
        if ($this->request->isPost()) {
            if ($this->request->data('create')) {
                if (!$this->classroommodel->hasClassroom(Session::getUserUniqueId())) {
                    $data = [
                        'teacher' => Session::getUserName(),
                        'section' => $this->request->data('section'),
                        'grade' => $this->request->data('grade'),
                        'strand' => $this->request->data('strand'),
                        'class' => $this->request->data('class'),
                        'teacher_uniqueid' =>  Session::getUserUniqueId()
                    ];

                    $data['unique_id'] = $this->authmodel->generateUniqueId("classroom");
                    $Validation = [];
                    $rule = new ValidationRules();
                    if(!$rule->isRequired($data['section'])){
                        $Validation['Error'] = "Section is required!";
                    }
                    else{
                        if((!$rule->isRequired($data['grade']))){
                        $Validation['Error'] = "Grade is required!";
                        } else
                    {
                        if(!$rule->isRequired($data['strand'])){
                        $Validation['Error'] = "Strand is required!";
                        }
                    }
                    }
                   
                   
                    if(empty($Validation['Error'])){
                    $result = $this->classroommodel->create($data);
                    if ($result) {
                        $data = ['Success' => true, 'Message' => "Classroom created!"];
                    } else {
                        $data = ['Failed' => true, 'Message' => "Failed to create classroom."];
                    }
                } 
                 else{
                    $data = ['Failed' => true, 'Message' => $Validation['Error']];
                }
                }else {
                    $data = ['Failed' => true, 'Message' => "Failed to create, you have already main classroom."];
                }
               

                header('Content-Type: application/json');
                echo json_encode($data);
            }
        } else {
            $this->view('Create-Classroom');
        }
    }
    public function show()
    {
        if ($this->request->isPost()) {
            if ($this->request->data('show')) {
                $data = [];

                $unique_id = Session::getUserUniqueId();

                if (Session::getUserType() === "student") {
                    $unique_id = $this->studentmodel->fetchStudentProfile(Session::getUserId())['class_unique_id'];
                }

                $data = $this->classroommodel->showClassroom(
                    $unique_id,
                    Session::getUserType()
                );

                if ($data) {
                    $data['teacher'] = $this->classroommodel->fetchClassroomHolder($data['teacher_unique_id'])['name'];
                    $data = ['Success' => true, 'Classroom' => $data, 'userType' => Session::getUserType()];
                } else {
                    $data = ['Failed' => true, 'Message' => "No classroom found."];
                }
            }
            if ($this->request->data('showsub')) {
                $data = [];
                if (Session::getUserType() === "teacher" && $this->request->isPost()) {
                    $teacherUniqueId = Session::getUserUniqueId();

                        $data = $this->classroommodel->showSubClassroom($teacherUniqueId);
                    
                    
                    
                    if ($data) {
                        
                        $teachersName = [];
                        foreach($data as $class){
                         $teachersName[] = $this->classroommodel->fetchClassroomData($class['unique_id'])['owner'];
                        }
                        $data = ['Success' => true, 'Classroom' => $data , 'Teachers' => $teachersName];
                    } else {
                        $data = ['Failed' => true, 'Message' => "No classroom found."];
                    }
                    
                
                }

            }

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    public function join()
    {
        if ($this->request->isPost() &&  $this->request->data('join')) {
            $data = [];

            $invitation_code = $this->request->data('code');

            $classroom = $this->classroommodel->fetchClassByInviteCode($invitation_code);


            if (Session::getUserType() === "teacher") {
                if ($classroom) {
                    if ($classroom['teacher_unique_id'] !== Session::getUserUniqueId()) {
                        $classroomUniqueId = $classroom['unique_id'];
                        if (!$this->classroommodel->isTeacherJoinedSubClass(Session::getUserUniqueId(), $classroomUniqueId)) {
                            $generatedUniqueid = $this->authmodel->generateUniqueId(Config::get("mysql/otherclassroom_table"));
                            $result = $this->classroommodel->joinSubClass(Session::getUserUniqueId(), $classroomUniqueId,  $generatedUniqueid,Session::getUserName());
                            if ($result) {
                                $data = ['Success' => true, 'Message' => 'Joined successfully'];
                            } else {
                                $data = ['Success' => true, 'Message' => 'Failed to join classroom.'];
                            }
                        } else {
                            $data = ['Failed' => true, 'Message' => "Already joined."];
                        }
                    } else {
                        $data = ['Failed' => true, 'Message' => "You can't join to your own classroom."];
                    }
                } else {
                    $data = ['Failed' => true, 'Message' => "Invalid Code!"];
                }
            }

            


            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
}
