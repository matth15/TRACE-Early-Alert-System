<?php



class Teacher extends Controller
{
    public $classroom;
    public $request;
    public $redirect;
    public $authmodel;
    public $studentmodel;
    public $teachermodel;

    public function __construct(Request $request = null)
    {
        if (Session::getIsLoggedIn()) {
            if (Session::getUserType() !== "teacher") {
                header('Location: ' . baseurl());
                exit();
            }
        } else {
            header('Location:' . baseurl());
            exit();
        }
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        $this->authmodel = $this->model('');
        $this->studentmodel = $this->model('StudentModel');
        $this->teachermodel = $this->model('TeacherModel');
        $this->classroom = $this->model('ClassroomModel');
    }
    public function dashboard()
    {
        $data = [];

        $this->view("dashboard");
    }
    public function studentList($param1 = "", $param2 = "")
    {
        $data = [];

        if($this->request->isPost()){
            $studentCount = $this->studentmodel->getStudentCount();
            $recordsPerPage = 10;
            $totalPages = ceil($studentCount / $recordsPerPage);
            
            $page = !empty($this->request->data('page')) ? $this->request->data('page') : 1;
            $search = !empty($this->request->data('search')) ? $this->request->data('search') : '';
            $offset = ($page - 1) * $recordsPerPage;
            
            $studentData = $this->studentmodel->fetchStudentData($offset,$recordsPerPage,$search);

            $data = [
                'studentData' => $studentData,
                'totalPages' => $totalPages
            ];

            header('Content-Type: application/json');
            echo json_encode($data);
        }
        else {
        $this->view("Student-List", $data);
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
  
 
}
