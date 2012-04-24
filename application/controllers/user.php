<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    //=================================================================================
    // :private vars
    //=================================================================================



    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public construct
     */
    public function __construct()
    {
        // init parent
        parent::__construct();

        // loads
        $this->load->library('usermail');
    }
    //------------------------------------------------------------------


    /**
     * public remap
     */
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }
    //------------------------------------------------------------------


    /**
     * public index()
     */
    public function index()
    {
        $this->login_check('', TRUE);
    }
    //------------------------------------------------------------------


    /**
     * public register()
     */
    public function register()
    {
        // if a user is logged in redirect...
        if ($this->session->userdata('authed'))
            redirect(site_url(), 'location');

        $page_data                     = array();
        $page_data['page_title']     = "Register";

        // form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|callback__valid_username');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password_again', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__valid_email');
        $this->form_validation->set_rules('spamcheck', 'Spam Check', 'required|callback__spam_check');

        // did the user submit
        if ($this->form_validation->run())
        {
            // generate a salt for our new user
            $salt = $this->_genSalt(5);

            // generate our authcode
            $authcode = $this->_genActCode(20);

            // register the user
            $this->User_model->add_user($this->input->post('username'), sha1(sha1($this->input->post('password')) . $salt), $this->input->post('email'), $salt, $authcode);

            $page_data['success']     = TRUE;
            $page_data['msg']        = "Successfully registered you're account. Please check your email to finish the registration process.";
            $page_data['redirect']    = '';

            // send user email
            $this->usermail->send_authcode($this->input->post('username'), $this->input->post('email'), $authcode);
        }

        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/register', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public activate()
     */
    public function validate($code = FALSE)
    {
        // if a user is logged in redirect...
        if ($this->session->userdata('authed'))
            redirect(site_url(), 'location');

        $page_data = array(
            'code'         => $code,
            'page_title' => 'Validate',
        );

        // form validation rules
        $this->form_validation->set_rules('auth_code', 'Authorization Code', 'required|callback__valid_authcode');

        // did the user submit?
        if ($this->form_validation->run())
        {
            // activate the user
            $this->User_model->activate_user($this->input->post('auth_code'));

            $page_data['success']     = TRUE;
            $page_data['msg']        = "You're account has been successfully activated.";
            $page_data['redirect']    = '';
        }

        // load the view
        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/authorize', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public forgot_password()
     */
    public function forgot_password()
    {
        // if a user is logged in redirect...
        if ($this->session->userdata('authed'))
            redirect(site_url(), 'location');

        $page_data                  = array();
        $page_data['page_title'] = "Forgot Password";

        // form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');

        // did the user submit
        if ($this->form_validation->run())
        {
            $user_query = $this->User_model->get_user($this->input->post('username'));
            if ($user_query)
            {
                // generate our authcode
                $authcode = $this->_genActCode(20);

                // add the reset info the the database
                $this->User_model->add_reset_data($user_query->row()->user_name, $user_query->row()->user_email, $authcode);

                // send user email
                if (!$this->usermail->send_forgotpass
                        (
                            $user_query->row()->user_name,
                            $user_query->row()->user_email,
                            $authcode,
                            $this->session->userdata('ip_address')
                        )
                    )
                {
                    $page_data['error']     = TRUE;
                    $page_data['msg']        = "Something went wrong";
                }
                else
                {
                    $page_data['success']     = TRUE;
                    $page_data['msg']        = "An authorization email has been sent. Please check your email to finish the process.";
                    $page_data['redirect']    = '';
                }
            }
            else
            {
                $page_data['error']     = TRUE;
                $page_data['msg']        = "Sorry but that username/email was not found in our database.";
            }
        }

        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/forgot', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public activate()
     */
    public function forgot_validate($code = FALSE)
    {
        // if a user is logged in redirect...
        if ($this->session->userdata('authed'))
            redirect(site_url(), 'location');

        $page_data = array(
            'code'          => $code,
            'page_title'    => 'Forgotten Password validation',
        );

        // form validation rules
        $this->form_validation->set_rules('auth_code', 'Authorization Code', 'required|callback__valid_reset_authcode');
        $this->form_validation->set_rules('new_password', 'Password', 'required');
        $this->form_validation->set_rules('new_password_again', 'Password Confirmation', 'required|matches[new_password]');

        // did the user submit?
        if ($this->form_validation->run())
        {
            // generate a salt for our new user
            $salt = $this->_genSalt(5);

            // hash up the new password
            $password = sha1(sha1($this->input->post('new_password')) . $salt);

            // autherize the reset
            $this->User_model->auth_reset($this->input->post('auth_code'), $password, $salt);

            $page_data['success']     = TRUE;
            $page_data['msg']         = "You're account password has been successfully changed.";
            $page_data['redirect']    = '';
        }

        // load the view
        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/forgot_auth', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public settings()
     */
    public function settings()
    {
        // Are we allowed to view this page??
        if (!$this->login_check('user-settings'))
            return;

        $page_data                  = array();
        $page_data['page_title'] = "User CP";


        /**
         * Users testing this (set as premium)
         * 1 = jnewing
         * 2 = djekl
         * 145 = Deany95
         */
        if ($this->session->userdata('premium'))
        {
            // displayed message on page
            $page_data['note']         = TRUE;
            $page_data['msg']        = "Development Testing Only, please don't use unless you know what you are doing!!!";
            $page_data['redirect']    = "";

            // form validation rules
            $this->form_validation->set_rules('password', 'Password', 'required|callback__valid_password');
            $this->form_validation->set_rules('new_password', 'Password', 'callback__new_password');
            $this->form_validation->set_rules('new_password_again', 'Password Confirmation', 'matches[new_password]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__valid_email');

            // did the user submit
            if ($this->form_validation->run())
            {
                // generate a salt for our new user
                $salt = $this->_genSalt(5);

                // generate our authcode
                $authcode = $this->_genActCode(20);

                // register the user -- NEEDS WORK
                #$this->User_model->add_user($this->input->post('username'), sha1(sha1($this->input->post('password')) . $salt), $this->input->post('email'), $salt, $authcode);

                $page_data['success']     = TRUE;
                $page_data['msg']        = "Your account has been successfully updated. If you updated your email Please check your email to finish the update process.";
                $page_data['redirect']    = '';

                // send user email -- NEEDS WORK
                #$this->usermail->send_authcode($this->input->post('username'), $this->input->post('email'), $authcode);
            }

            // Load approp view
            if (isset($page_data['success']))
                $this->load->view('messages/message_page', $page_data);
            else
                $this->load->view('auth/user_settings', $page_data);
        }
        else
        {
            // displayed message on page
            $page_data['note']         = TRUE;
            $page_data['msg']        = "This is just a view, it does noting at the moment!";
            $page_data['redirect']    = "";

            // Load approp view
            $this->load->view('auth/user_settings', $page_data);
        }
    }
    //------------------------------------------------------------------


    /**
     * public uploads()
     */
    public function uploads()
    {
        // Do we need to login??
        if (!$this->login_check('user-uploads'))
            return;

        // Load the PixlDrop Model
        $this->load->model('pixldrop_model');

        // page data array
        $page_data                  = array();
        $page_data['page_title'] = "Uploads";
        $username                  = $this->session->userdata('username');
        $page_data['image']      = $this->pixldrop_model->get_user_images($username);

        // load the approp. page view
        $this->load->view('misc/user_gallery', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public login()
     */
    public function login($location = FALSE)
    {
        // Do we need to login??
        if (!$this->login_check($location, TRUE, FALSE, TRUE))
            return;

        $page_data                  = array();
        $page_data['page_title'] = "Login";

        // form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // did the user submit?
        if ($this->form_validation->run())
        {
            // check the username & password
            $user_query = $this->User_model->get_user($this->input->post('username'));

            // did we find the user?
            if ($user_query)
            {
                // is the account active?
                if ($user_query->row()->user_active === "yes")
                {
                    // does the supplied password match?
                    if (sha1(sha1($this->input->post('password')) . $user_query->row()->user_salt) === $user_query->row()->user_password)
                    {
                        // users passed all our tests lets build em a session
                        $session_data = array(
                            'user_id'    => $user_query->row()->id,
                            'username'    => $user_query->row()->user_name,
                            'email'        => $user_query->row()->user_email,
                            'premium'    => $user_query->row()->user_premium === 'true' ? TRUE : FALSE,
                            'admin'        => $user_query->row()->user_admin === 'true' ? TRUE : FALSE,
                            'authed'    => TRUE,
                        );

                        $this->session->set_userdata($session_data);

                        // Set last login time
                        $this->User_model->login_time($user_query->row()->user_name);

                        // displayed message page and redirect
                        $page_data['success']     = TRUE;
                        $page_data['msg']        = "Login successful.";
                        $page_data['redirect']    = str_replace('-', '/', "" . $location);
                    }
                    else
                    {
                        // incorrect password
                        $page_data['error'] = TRUE;
                        $page_data['msg'] = "Invalid username or password!";
                    }
                }
                else
                {
                    // account has not been activated
                    $page_data['error'] = TRUE;
                    $page_data['msg'] = "Your account has not been validated. Please check your emails.";
                }
            }
            else
            {
                // invalid username
                $page_data['error'] = TRUE;
                $page_data['msg'] = "Invalid username or password!";
            }
        }

        if (isset($page_data['success']))
        {
            $this->load->view('messages/message_page', $page_data);
        }
        else
        {
            $this->load->view('auth/login', $page_data);
        }
    }
    //------------------------------------------------------------------


    /**
     * public logout()
     */
    public function logout()
    {
        $page_data = array();

        // destroy the session
        $this->session->sess_destroy();

        $page_data['success']     = TRUE;
        $page_data['msg']        = "You have been successfully logged out.";
        $page_data['redirect']    = '';

        $this->load->view('messages/message_page', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :custom callbacks
    //=================================================================================


    /**
     * callback _spam_check()
     * function will try and make sure we have a human that's registering an account.
     *
     * @param string $str - should be a string with "pixldrop.com"s
     */
    public function _spam_check($str)
    {
        if (strtolower($str) === "???")
            return TRUE;

        $this->form_validation->set_message('_spam_check', 'Failed spam check. Really?! Are you human?');
        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_reset_authcode()
     * function will make sure the authcode is valid
     *
     * @param string $code - users authorization code
     */
    public function _valid_reset_authcode($code)
    {
        if (!$this->User_model->validate_authcode($code, TRUE))
        {
            $this->form_validation->set_message('_valid_reset_authcode', 'The given authorization code is invalid.');
            return FALSE;
        }
        else
            return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_authcode()
     * function will make sure the authcode is valid and the account that it's attached to
     * needs to be validated.
     *
     * @param string $code - users authorization code
     */
    public function _valid_authcode($code)
    {
        if (!$this->User_model->validate_authcode($code))
        {
            $this->form_validation->set_message('_valid_authcode', 'This account has already been activated, or the given authorization code is invalid.');

            return FALSE;
        }
        else
            return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_username()
     * function will validated the passed username, making sure it does NOT currently
     * exists in our database.
     *
     * @param string $username - user name to be checked
     */
    public function _valid_username($username)
    {
        if ($this->User_model->validate_username($username))
            return TRUE;

        $this->form_validation->set_message('_valid_username', 'Sorry but that username already exists.');
        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_email()
     * function will validate the passed email address making sure it does not exists in our database.
     *
     * @param string $email - email to validate
     */
    public function _valid_email($email = FALSE)
    {
        if (!$email)
        {
            $this->form_validation->set_message('_valid_email', 'Email address is empty!');
            return FALSE;
        }

        if (!$this->valid_email($email))
        {
            $this->form_validation->set_message('_valid_email', 'This is not a valid email address!');
            return FALSE;
        }

        if ($this->User_model->validate_email($email))
            return TRUE;

        $this->form_validation->set_message('_valid_email', 'This email address is already in use.');
        return FALSE;
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private valid_email
     * This function checks if the email is correctly structured and if the domain name exists based on MX records.
     *
     * @return bool
     */
    private function valid_email($email = FALSE,  $test_mx = FALSE)
    {
        if (!$email)
            return FALSE;

        if (eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+) * (\.[a-z]{2,4})$", $email))
        {
            if ($test_mx)
            {
                list( $username, $domain ) = split( "@", $email);
                return (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'));
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    //------------------------------------------------------------------


    /**
     * private login_check()
     */
    private function login_check($location = FALSE, $redirect = FALSE, $premium_page = FALSE, $login_check = FALSE)
    {
        if ($this->session->userdata('authed'))
        {
            if ($premium_page)
            {
                if ($this->session->userdata('premium'))
                {
                    if($redirect)
                    {
                        $location = str_replace('-', '/', "" . $location);
                        redirect('/' . $location, 'location');
                        return FALSE;
                    }
                    else
                    {
                        return TRUE;
                    }
                }
                else
                {
                    // displayed message page and redirect
                    $page_data['error']     = TRUE;
                    $page_data['msg']        = "You are not authorized to view this page.";
                    $page_data['redirect']    = "";
                    $this->load->view('messages/message_page', $page_data);
                    return FALSE;
                }
            }
            else
            {
                if($redirect)
                {
                    $location = str_replace('-', '/', "" . $location);
                    redirect('/' . $location, 'location');
                    return FALSE;
                }
                else
                {
                    return TRUE;
                }
            }
        }
        else
        {
            if (!$login_check)
            {
                redirect('/user/login/' . $location, 'location');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }
    //------------------------------------------------------------------


    /**
     * private _genSalt()
     * function generates a random salt when the user signs up.
     *
     * @param int $length - optional lenght of the salt (default 10)
     */
    private function _genSalt($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^.,:;*';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
    //------------------------------------------------------------------


    /**
     * private _genActCode()
     * function generates a user activation code when the user signs up, this code will be
     * emailed to the user in order to confirm their email address.
     *
     * @param int $length - optional length of the salt (default 10)
     */
    private function _genActCode($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
    //------------------------------------------------------------------

}
