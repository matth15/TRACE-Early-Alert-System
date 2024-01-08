<?php

class Dashboard extends Controller
{
    private $redirect;

    public function __construct()
    {
        $this->redirect = new Redirect();
        if(!Session::getIsLoggedIn()){
            header("Location: ".baseurl());
            exit();
        }
    }
    public function index()
    {
        switch (Session::getUserType()) {
            case 'admin':
                $this->redirect->to('admin/dashboard');
                break;
            case 'student';
                $this->redirect->to('student/inbox');
                break;
            case 'teacher';
                $this->redirect->to('teacher/dashboard');
                break;
        }
    }
}
