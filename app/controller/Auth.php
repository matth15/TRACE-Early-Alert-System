<?php


/**
 *  Auth Controller
 */

class Auth extends Controller
{
    //properties

    public $request;
    public $redirect;
    public $authmodel;

    public function __construct(Request $request = null)
    {
        $this->request = $request !== null ? $request : new Request();
        $this->redirect = new Redirect();
        $this->authmodel = $this->model('AuthModel');
        if (Session::getIsLoggedIn()) {
            header('Location: ' . baseurl() . '/home');
            exit();
        }
    }
    /**
     * ============================
     *         AUTH DEFAULT
     * ============================
     */
    public function index()
    {
        if (Session::getIsLoggedIn()) {
            $this->redirect->to("Home/index");
        } else {
            $this->view('Login');
        }
    }

    /*
     * ====================================================
     *             SIGNUP CONTROLLER METHOD
     * ====================================================
     */
    public function signup()
    {
        $data = [];

        if ($this->request->isPost()) {

            //validate csrf token
            if ($this->request->data('csrf_token') !== session::generateCsrfToken()) {
                $this->redirect->to('auth');
                die;
            }

            // Declare input variable
            $lastName = $this->request->data('lastname');
            $firstName = $this->request->data('firstname');
            $email = $this->request->data('email');

            $parentPhoneNo =  $this->request->data('phoneNo');

            $password =  $this->request->data('password');
            $confirmPassword =  $this->request->data('confirm_password');
            $gradeLevel = $this->request->data('grade_level');
            $strand = $this->request->data('strand');

            // (Instatiate ValidationRules class)
            $rule = new ValidationRules();

            $data = $rule->validateStudentForm(
                [
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $email,
                    'password' => $password,
                    'confirm_password' => $confirmPassword,
                    'grade_level' => $gradeLevel,
                    'strand' => $strand,
                    'phoneNo' => $parentPhoneNo,
                ]
            );

            if (!empty($data)) {
                if (!empty($data['ValidationError'])) {
                    Session::set("Signup-Error", $data['ValidationError']);
                }
                if (!empty($data['ValidationWarning'])) {
                    Session::set("Signup-Warning", $data['']);
                }
            }

            // Login Process
            if (empty($data)) {
                $result = $this->authmodel->register($firstName . ' ' . $lastName, $email, $password, $gradeLevel, $strand);
                if ($result) {
                    Session::set('Login-Success', 'Registration successful.');
                    $this->redirect->to('auth/login');
                    die();
                }
            }
        }
        $this->view('Signup', $data);
    }
    function forgot_password()
    {

        $data  = [];
        if ($this->request->isPost()) {
            $email = $this->request->data('email');

            $rule = new ValidationRules();
            if (!$rule->isRequired($email)) {
                $data['forgot-password-err'] = "TRACE Email field is Required!";
            } elseif (!$rule->email($email)) {
                $data['forgot-password-err'] = "Enter a Valid TRACE E-mail.";
            }
            if (!empty($data)) {
                Session::set('FORGOT-PASSWORD-DANGER', $data['forgot-password-err']);
            }
            if (empty($data)) {

                if ($this->authmodel->forgot_password($email)) {



                    $otp = $this->authmodel->generateOTP();
                    $otp_expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +1 mins"));
                    $result = $this->authmodel->updateGeneratedOTP($email, $otp, $otp_expiration);

                    if ($result) {

                        Session::set('forgot-password-process', true);
                        $userName = $this->authmodel->getProfileInfo($email)['name'];
                        $data = ['email' => $email, 'otp' => $otp, "name" => $userName];

                        Email::sendEmail(Config::get('mailer/email_account_forgot-password'),  $email, $data);

                        //Redirect to OTP verification view
                        Session::set('OTP-SUCCESS', "We've sent an OTP Code from your TRACE Email");
                        $this->redirect->to('auth/verifyOTP');
                    } else {
                    }
                } else {
                    Session::set('FORGOT-PASSWORD-DANGER', "TRACE Email not found!");
                }
            }
        }
        $this->view('Forgot-Password', $data);
    }
    /**
     * 
     * 
     * 
     * 
     */
    function reset_password()
    {
        $data = [];
        if (!Session::get('forgot-password-process')) {
            $this->redirect->to('auth');
            die();
        }
        if ($this->request->isPost()) {

            if ($this->request->data('csrf_token') !== session::generateCsrfToken()) {
                $this->redirect->to('account');
                die;
            }

            $new_password = $this->request->data('n_pass');
            $new_cpassword =  $this->request->data('n_cpass');
            $email = $this->request->data("email");

            //validator
            $rule = new ValidationRules();

            //validate new password
            if (!$rule->isRequired($new_password)) {
                $data['reset-password-err'] = "New Password field is Required!";
            } elseif (!$rule->minLen($new_password, 5)) {
                $data['reset-password-err'] = "New Password must not be less than 5 Characters.";
            } elseif (!$rule->password($new_password)) {
                $data['reset-password-err'] = "New Password must have at least a lowercase, uppercase, integer, and special character";
            } else {
                //validate new confirm password
                if (empty($new_cpassword) || !$rule->equals($new_password, [$new_cpassword])) {
                    $data['reset-password-err'] = "New Password & New Confirm Password not Matched!";
                }
            }

            if (!empty($data)) {
                Session::set('RESET-PASSWORD-DANGER', $data['reset-password-err']);
            } else {
                if ($this->authmodel->reset_password($new_password, $email)) {

                    Session::set('LOGIN-SUCCESS', 'testing');
                    $this->redirect->to("auth");
                } else {

                    Session::set('RESET-PASSWORD-DANGER', "Failed to change password. Try again.");
                }
            }
        }
        $this->view('Reset-Password', $data);
    }

    /*
     * ======================================================
     *              LOGIN CONTROLLER METHOD
     * ======================================================
     */
    public function login($params1 = '')
    {

        $data = [];

        if ($this->request->isPost()) {

            if ($this->request->data('csrf_token') !== session::generateCsrfToken()) {
                $this->redirect->to('auth');
                die;
            }

            // Extract input fields' values
            $email = $this->request->data("email");
            $password = $this->request->data("password");

            // Instantiate validation rules
            $rule = new ValidationRules();

            // Validate email field
            if (!$rule->isRequired($email)) {
                $data['login-err'] = 'Email cannot be empty.';
            } elseif (!$rule->email($email)) {
                $data['login-err'] = 'Enter a valid TRACE Email address';
            } else {
                // Validate password field
                if (!$rule->isRequired($password)) {
                    $data['login-err'] = 'Password cannot be empty.';
                }
            }
            //
            if (!empty($data)) {
                Session::set('LOGIN-ERROR', $data['login-err']);
            }
            //
            if (empty($data)) {

                // Check the password against the database
                if ($this->authmodel->login($email, $password)) {
                    //Set Session login process 
                    Session::set('login-process', true);

                    // Password is correct, proceed to generate and send OTP
                    $otp = $this->authmodel->generateOTP();
                    $otp_expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +5 mins"));
                    $result = $this->authmodel->updateGeneratedOTP($email, $otp, $otp_expiration);

                    if ($result) {
                       
                        $data = ['email' => $email, 'otp' => $otp];
                        $res = Email::sendEmail(Config::get('mailer/email_otp_confirmation'),$email, $data);
                        if ($res) {
                            // Redirect to OTP verification view
                            Session::set('OTP-SUCCESS', "We've sent an OTP Code from your TRACE Email");
                            $this->redirect->to('auth/verifyOTP');
                        } else {
                            
                        }

                    } else {
                        Session::set('LOGIN-ERROR', "Failed to generateOTP and send to your E-mail");
                    }
                }
            }
        }


        $this->view('Login', $data);
    }

    /*
     * ===================================================
     *             VERIFY OTP CONTROLLER METHOD
     * ===================================================
     */
    public function verifyOTP()
    {

        $data = [];

        //Identify if Session is in Login OR Forgot-Password Process
        if (!Session::get('login-process')) {
            if (!Session::get('forgot-password-process')) {
                $this->redirect->to("account");
                die();
            }
        }

        if ($this->request->isPost()) {
            if ($this->request->data('csrf_token') !== session::generateCsrfToken()) {
                $this->redirect->to('auth');
                die();
            }
            // Extract input fields' values
            $email = $this->request->data("email");
            $otp = $this->request->data("otp_data");



            // Instantiate validation rules
            $rule = new ValidationRules();

            // Validate OTP field
            if (!$rule->isRequired($otp)) {
                $data['otp-err'] = 'OTP cannot be empty.';
            }

            if (!empty($data['otp-err'])) {
                Session::set('OTP-ERROR', $data['otp-err']);
            }


            if (empty($data)) {
                // Verify User OTP
                if ($this->authmodel->verifyOTP($email, $otp)) {
                    // If user is in Session of Forgot-Password Process
                    if (Session::get('forgot-password-process')) {

                        $this->redirect->to('auth/reset_password');
                    } else {
                        // Check if User email is Verified
                        if (!$rule->is_email_verified($email) && Session::getUserType() !== "admin") {

                            //Set User email Verified
                            $this->authmodel->setUserVerified($email);
                            $userInfo = $this->authmodel->getProfileInfo($email);
                            // Send notif of TRACE College Account Verified
                            $data = ["email" => $email, "user_type" => $userInfo["user_type"]];
                            Email::sendEmail(Config::get('mailer/email_account_verified'), $email, $data);
                        }

                        if (Session::get("login-process")) {

                            // Destroy login process Session :
                            Session::getAndDestroy('login-process');

                            Session::set('LOGIN-SUCCESS', 'Login Successfully!');
                            // TO set logged in session :
                            Session::setLoggedInSession();
                            $this->redirect->to('auth');
                        }
                    }
                }
            }
        }

        $this->view('Email-Verification', $data);
    }


    /*
     * ========================================================
     *                RESEND OTP CONTROLLER METHOD
     * ========================================================
     */
    public function resendOTP()
    {
        if ($this->request->data('csrf_token') !== session::generateCsrfToken()) {
            $this->redirect->to('auth');
            die;
        }
        // Get the user's email from the session or user input
        $email = $this->request->data("email");
        $userName = $this->request->data('name');

        // Update the OTP and OTP expiration time in the database
        $otp = $this->authmodel->generateOTP();
        $otp_expiration = date("Y-m-d H:i", strtotime(date('Y-m-d H:i') . " +5 mins"));
        //
        $result = $this->authmodel->updateGeneratedOTP($email, $otp, $otp_expiration);

        if ($result) {
            // Send the new OTP to the user's email
            if (Session::get('forgot-password-process')) {
                $data = ['email' => $email, 'otp' => $otp, 'name' => $userName];
                Email::sendEmail(Config::get('mailer/email_account_forgot-password'), $email, $data);
            } else {
                $data = ['email' => $email, 'otp' => $otp];
                Email::sendEmail(Config::get('mailer/email_otp_confirmation'), $email, $data);
            }

            session::set('OTP-SUCCESS', 'New OTP have been sent to your email.');
            $this->redirect->to('auth/verifyOTP');
        }

        $this->view('verifyOTP', $data);
    }
}
