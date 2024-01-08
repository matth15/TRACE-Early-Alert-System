<?php

class Student extends Controller {
    public $request;
    public $redirect;

    public function __construct(Request $request = null)
    {
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        if (Session::getIsLoggedIn()) {
            if (Session::getUserType() !== "student") {
                header('Location: ' . baseurl());
               die();
            }
        }
        else {
            header('Location: ' . baseurl());
            die();
        }
    }

    public function inbox(){
        $data = [];
        
        $this->view("Inbox",$data);
    }
    public function classroom(){
        $this->view('Classroom');
    }
}
?>