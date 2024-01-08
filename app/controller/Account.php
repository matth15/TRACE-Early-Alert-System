<?php

class Account extends Controller
{
    private $redirect;
    private $authmodel;
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        $this->authmodel = $this->model('AuthModel');
        if(!session::getIsLoggedIn()){
            header("Location: ".baseurl());
            exit();
        }
    }
    /**
     * 
     * 
     * 
     * 
     */
    public function index()
    {

    }
    public function settings(){
        $this->view("Settings");
    }
    /**
     * 
     * 
     * 
     */
    
    /**================== //improve soon
     * Handle user logout
     * ==================
     */
    public function logout()
    {
        // Log the user out and redirect to the login page
        $this->authmodel->logout(Session::getUserId());
        return $this->redirect->to('auth');
    }
}
