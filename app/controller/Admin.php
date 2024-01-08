<?php



class Admin extends Controller
{
    public $request;
    public $redirect;
    public $adminmodel;
    public $authmodel;
    public $studentmodel;
    public $teachermodel;

    public function __construct(Request $request = null)
    {
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        $this->authmodel = $this->model('AuthModel');
        $this->adminmodel = $this->model('AdminModel');
        $this->studentmodel = $this->model('StudentModel');
        $this->teachermodel = $this->model('TeacherModel');
        if (Session::getIsLoggedIn()) {
            if (Session::getUserType() !== "admin") {
                header('Location: ' . baseurl());
                exit();
            }
        } else {
            header('Location: ' . baseurl());
            exit();
        }
    }

    /**
     * 
     * 
     * 
     */

    public function index()
    {
        $this->redirect->to('admin/dashboard');
    }

    public function dashboard()
    {
        $data = [];
        $studentCount = $this->studentmodel->getStudentCount();
        $facultyCount = $this->teachermodel->getFacultyCount();
        $data = ['studentCount' => $studentCount, 'teacherCount' => $facultyCount];

        $this->view("Dashboard", $data);
    }
    /**
     * 
     * 
     */
    public function studentList($param1 = "", $param2 = "")
    {
        $data = [];

        if ($this->request->isPost()) {
            $studentCount = $this->studentmodel->getStudentCount();
            $recordsPerPage = 10;
            $totalPages = ceil($studentCount / $recordsPerPage);

            $page = !empty($this->request->data('page')) ? $this->request->data('page') : 1;
            $search = !empty($this->request->data('search')) ? $this->request->data('search') : '';
            $offset = ($page - 1) * $recordsPerPage;

            $studentData = $this->studentmodel->fetchStudentData($offset, $recordsPerPage, $search);

            $data = [
                'studentData' => $studentData,
                'totalPages' => $totalPages
            ];

            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $this->view("Student-List", $data);
        }
    }
    public function facultyList($param1 = '', $param2 = '')
    {
        $data = [];

        if ($this->request->isPost()) {
            $facultyCount = $this->teachermodel->getFacultyCount();
            $recordsPerPage = 10;
            $totalPages = ceil($facultyCount / $recordsPerPage);

            $page = !empty($this->request->data('page')) ? $this->request->data('page') : 1;
            $search = !empty($this->request->data('search')) ? $this->request->data('search') : '';
            $offset = ($page - 1) * $recordsPerPage;

            $facultyData = $this->teachermodel->fetchFacultyData($offset, $recordsPerPage, $search);

            $data = [
                'facultyData' => $facultyData,
                'totalPages' => $totalPages
            ];

            header('Content-Type: application/json');
            echo json_encode($data);
        } else {

            $this->view("Faculty-List", $data);
        }
    }
    public function classroom()
    {
        $this->view('Classroom');
    }
    public function configuration()
    {
        $this->view('Configuration');
    }
    /**
     * 
     * 
     * 
     */
    //add student data
    public function addStudent()
    {

        $data = [];
        if ($this->request->isPost()) {
            if ($this->request->data('action') === 'add') {

                $rule = new ValidationRules();


                $serializedFormData = $this->request->data('data');
                parse_str($serializedFormData, $formData);

                $data = [
                    'firstname' => $formData['firstname'],
                    'lastname' => $formData['lastname'],
                    'email' => $formData['email'],
                    'password' => $formData['password'],
                    'strand' => !empty($formData['strand']) ? $formData['strand'] : null,
                    'grade_level' => !empty($formData['grade_level']) ? $formData['grade_level'] : null,
                    'phone_number' => $formData['phoneNo']
                ];
                $Validation = $rule->validateStudentForm($data);

                if ($Validation) {
                    if ($Validation['ValidationError']) {
                        $data = ['Failed' => true, 'Message' => $Validation['ValidationError']];
                    } else {
                        if ($Validation['ValidationWarning']) {
                            $data = ['Failed' => true, 'Message' => $Validation['ValidationWarning']];
                        }
                    }
                } else {
                    $data['name'] = $data['firstname'] . ' ' . $data['lastname'];
                    $data['unique_id'] = $this->authmodel->generateUniqueId(Config::get("mysql/student_table"));
                    $result = $this->studentmodel->register($data);

                    if ($result) {
                        $data = ['Success' => true, 'Message' => "Register successfully!"];
                    } else {
                    }
                }


                header('Content-Type: application/json');
                echo json_encode($data);
            }
        } else {
            $this->view('Add-Student');
        }
    }

    public function getStudentData()
    {
        $data = [];

        if($this->request->isPost()){
            if($this->request->data('fetch')){
                $id = filter_var($this->request->data('id'), FILTER_SANITIZE_NUMBER_INT);
                $result = $this->studentmodel->fetchStudentProfile($id);
                if ($result) {
                    $data = [
                        'Success' => true,
                        'studentData' => $result
                    ];
                } else {
                    $data = [
                        'Failed' => true,
                        'Message' => "Failed"
                    ];
                }
                header('Content-Type: application/json');
                echo json_encode($data);
               }
        }
      
    }

    public function updateStudent()
    {
        $data = [];
        if($this->request->isPost()){
            if($this->request->data('update')){
                
                $data = 
                [
                  'id' => $this->request->data('id'),
                  'name' => $this->request->data('name'),
                  'email' => $this->request->data('email'),
                  'strand' => $this->request->data('strand'),
                  'grade' => $this->request->data('grade'),
                  'section' => $this->request->data('section'),
                  'class' => $this->request->data('class'),
                ];
  
                  $result = $this->studentmodel->updateStudentData($data);
                  if($result){
                      $data = ['Success' => true , 'Message' => "Update successfully."];
                  }
                  else {
                      $data = ['Failed' => true , 'Message' => "Failed to update."];
                  }
  

                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
        
    }
    public function deleteStudent()
    {
        $data = [];

        if ($this->request->isPost()) {
            if($this->request->data('delete')){

                $unique_id = $this->request->data('unique_id');
                $id = $this->request->data('id');

                $rule = new ValidationRules();
                $studentData = $this->studentmodel->fetchStudentProfile($id);


                if(!$rule->isRequired($unique_id)){
                    $data= ['Failed' => true, 'Message' => 'Unique id is required!'];
                }
                elseif($unique_id != $studentData['unique_id']){
                    $data= ['Failed' => true, 'Message' => "Unique id is not matched!"];
                }
                else{
                $result = $this->studentmodel->deleteStudent($id);
                if($result){
                        $data= ['Success' => true, 'Message' => 'Delete successfully!'];
                    }
                    else{
                        $data= ['Failed' => true, 'Message' => 'Failed to delete student data!'];
                    }
                }

                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }

    /**
     * 
     * faculty
     * 
     * 
     * 
     */


    public function addFaculty()
    {
        if ($this->request->isPost()) {

            if ($this->request->data('action') === 'add') {

                $rule = new ValidationRules();

                $serializedFormData = $this->request->data('data');
                parse_str($serializedFormData, $formData);

                $data = [
                    'firstname' => $formData['firstname'],
                    'lastname' => $formData['lastname'],
                    'email' => filter_var($formData['email'], FILTER_SANITIZE_EMAIL),
                    'password' => $formData['password'],
                ];
                $Validation = $rule->validateFacultyForm($data);

                if ($Validation) {
                    if ($Validation['ValidationError']) {
                        $data = ['Failed' => true, 'Message' => $Validation['ValidationError']];
                    } else {
                        if ($Validation['ValidationWarning']) {
                            $data = ['Failed' => true, 'Message' => $Validation['ValidationWarning']];
                        }
                    }
                } else {
                    $data['name'] = $data['firstname'] . ' ' . $data['lastname'];
                    $data['unique_id'] = $this->authmodel->generateUniqueId(Config::get("mysql/teacher_table"));
                    $result = $this->teachermodel->register($data);

                    if ($result) {
                        $data = ['Success' => true, 'Message' => "Register successfully!"];
                    } else {
                    }
                    
                }


                header('Content-Type: application/json');
                echo json_encode($data);
            }
        } else {
            $this->view('Add-Faculty');
        }
    }
    public function deleteFaculty()
    {
        $data = [];

      if($this->request->isPost()){
            if($this->request->data('delete')){

                $unique_id = $this->request->data('unique_id');
                $id = $this->request->data('id');

                $rule = new ValidationRules();
                $facultyData = $this->teachermodel->fetchFacultyDataById($id);


                if(!$rule->isRequired($unique_id)){
                    $data= ['Failed' => true, 'Message' => 'Unique id is required!'];
                }
                elseif($unique_id != $facultyData['unique_id']){
                    $data= ['Failed' => true, 'Message' => "Unique id is not matched!"];
                }
                else{
                $result = $this->teachermodel->deleteFaculty($id);
                if($result){
                        $data= ['Success' => true, 'Message' => 'Delete successfully!'];
                    }
                    else{
                        $data= ['Failed' => true, 'Message' => 'Failed to delete student data!'];
                    }
                }
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }
    public function getFacultyData()
    {
        $data = [];
        if ($this->request->isPost()) {

           if($this->request->data('fetch')){
            $id = filter_var($this->request->data('id'), FILTER_SANITIZE_NUMBER_INT);
            $result = $this->teachermodel->fetchFacultyDataById($id);
            if ($result) {
                $data = [
                    'Success' => true,
                    'facultyData' => $result
                ];
            } else {
                $data = [
                    'Failed' => true,
                    'Message' => "Failed"
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($data);
           }
        }
    }
    public function updateFaculty()
    {
        $data = [];
        if($this->request->isPost()){
            if($this->request->data('update')){

              $data = 
              [
                'id' => $this->request->data('id'),
                'name' => $this->request->data('name'),
                'email' => $this->request->data('email')
              ];

                $result = $this->teachermodel->updateFaculty($data);
                if($result){
                    $data = ['Success' => true , 'Message' => "Update successfully."];
                }
                else {
                    $data = ['Failed' => true , 'Message' => "Failed to update."];
                }

                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }
}
