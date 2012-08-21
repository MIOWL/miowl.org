<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MI OWL                                                     (v1) | codename dave
 *
 * ------------------------------------------------------------------------------
 *
 * Copyright (c) 2012, Alan Wynn
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * ------------------------------------------------------------------------------
 */

class User extends CI_Controller {

//=================================================================================
// :private vars
//=================================================================================

    var $province_list = array(
                                'Alberta',
                                'British Columbia',
                                'Manitoba',
                                'New Brunswick',
                                'Newfoundland and Labrador',
                                'Northwest Territories',
                                'Nova Scotia',
                                'Nunavut',
                                'Ontario',
                                'Prince Edward Island',
                                'Quebec',
                                'Saskatchewan',
                                'Yukon'
                              );


//=================================================================================
// :public functions
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
        $this->load->library('owlmail');
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
    public function register($owl_id = FALSE)
    {
        // if a user is logged in redirect...
        if ($this->session->userdata('authed'))
            redirect(site_url(), 'location');

        $page_data                  = array();
        $page_data['page_title']    = "Register";

        // fetch the owl data we need
        $owl_data                   = $this->owl_model->get_all_owls();
        if($owl_data) {
            $owls                   = array();
            foreach ($owl_data->result() as $row) {
                $owls[$row->id] = $row->owl_name;
            }
        }
        else {
            $owls                   = FALSE;
        }
        $page_data['owls']          = $owls;

        $page_data['owl_id'] = FALSE;
        if($owl_id != FALSE)
            if(array_key_exists($owl_id, $owls))
                $page_data['owl_id'] = $owl_id;

        // form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback__valid_username');
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password_again', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback__valid_email');
        $this->form_validation->set_rules('spamcheck', 'Spam Check', 'required|trim|callback__spam_check');
        $this->form_validation->set_rules('owl', 'OWL', 'callback__valid_choice');

        // did the user submit
        if ($this->form_validation->run())
        {
            // generate a salt for our new user
            $salt = $this->_genSalt(5);

            // generate our authcode
            $authcode = $this->_genActCode(20);

            // Setup the First/Second name to be humanized
            $this->load->helper('inflector');
            $firstname = humanize($this->input->post('firstname'));
            $lastname = humanize($this->input->post('lastname'));

            // register the user
            $this->user_model->add_user($this->input->post('username'), sha1(sha1($this->input->post('password')) . $salt), $this->input->post('email'), $salt, $authcode, $firstname, $lastname, $this->input->post('owl'));

            $page_data['success']   = TRUE;
            $page_data['msg']       = "Successfully registered you're account. Please check your email to finish the registration process.";
            $page_data['redirect']  = '';

            // Users name for emails
            $name = $firstname . ' ' . $lastname . ' (' . $this->input->post('username') . ')';

            if($this->input->post('owl') == 'new') {
                $new_owl    = TRUE;
                $owl_name   = FALSE;
            }
            else {
                $new_owl    = FALSE;

                $owl_info   = $this->owl_model->get_owl_by_id($this->input->post('owl'));
                $owl_name   = $owl_info->row()->owl_name;
                $this->owlmail->inform_admin($name, $owl_info->row()->owl_email);
            }

            // send user email
            $this->usermail->send_authcode($name, $this->input->post('email'), $authcode, $new_owl, $owl_name);
        }

        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/register', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public login()
     */
    public function login($location = FALSE)
    {
        // Do we need to login??
        if (!$this->login_check($location, TRUE, TRUE))
            return;

        $page_data                  = array();
        $page_data['page_title']    = "Login";

        // form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // did the user submit?
        if ($this->form_validation->run())
        {
            // check the username & password
            $user_query = $this->user_model->get_user($this->input->post('username'));

            // get the users owl info (first row found)
            $owl_user_query = $this->owl_model->get_all_owl_member_info($user_query->row()->id, TRUE);

            // did we find the user?
            if ($user_query)
            {
                // is the account active?
                if ($user_query->row()->user_active === "yes")
                {
                    // does the supplied password match?
                    if (sha1(sha1($this->input->post('password')) . $user_query->row()->user_salt) === $user_query->row()->user_password)
                    {
                        if ($owl_user_query->row()->owl != 0)
                        {
                            // users passed all our tests lets build em a session
                            $session_data = array(
                                'authed'        => TRUE,
                                'user_id'       => $user_query->row()->id,
                                'username'      => $user_query->row()->user_name,
                                'name'          => $user_query->row()->user_first_name . ' ' . $user_query->row()->user_last_name,
                                'email'         => $user_query->row()->user_email,
                                'owl'           => $owl_user_query->row()->owl
                            );
                            $this->session->set_userdata($session_data);

                            // Set last login time
                            $this->user_model->login_time($user_query->row()->user_name);

                            // displayed message page and redirect
                            $page_data['success']     = TRUE;
                            $page_data['msg']        = "Login successful.";
                            $page_data['redirect']    = str_replace('-', '/', "" . $location);
                        }
                        else
                        {
                            $session_data = array(
                                'authed'    => TRUE,
                                'user_id'   => $user_query->row()->id,
                                'name'      => $user_query->row()->user_first_name . ' ' . $user_query->row()->user_last_name,
                                'username'  => $user_query->row()->user_name,
                                'email'     => $user_query->row()->user_email,
                                'owl'       => $owl_user_query->row()->owl
                            );
                            $this->session->set_userdata($session_data);

                            // Owl Creation Required
                            $owl_selection = TRUE;
                        }
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
                    $page_data['msg'] = "Your account has not been validated. Please check your emails.\r\n<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' id='resend'>Resend validation email?</a>";
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
        elseif (isset($owl_selection) && $owl_selection)
        {
            $page_data['page_title']    = 'Choose your OWL';
            $page_data['owl_selection'] = TRUE;
            $page_data['province']      = $this->province_list;

            // fetch the owl data we need
            $owl_data                   = $this->owl_model->get_all_owls();
            if($owl_data)
            {
                $owls                   = array();
                foreach ($owl_data->result() as $row)
                {
                    $owls[$row->id] = $row->owl_name;
                }
            }
            else
            {
                $owls                   = FALSE;
            }
            $page_data['owls']          = $owls;

            $this->load->view('auth/new_owl', $page_data);
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
            $query = $this->user_model->activate_user($this->input->post('auth_code'));

            // welcome the user
            $name = $query->row()->user_first_name . ' ' . $query->row()->user_last_name . ' (' . $query->row()->user_name . ')';
            $email = $query->row()->user_email;
            $this->usermail->send_welcome($name, $email);

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
            $user_query = $this->user_model->get_user($this->input->post('username'));
            if ($user_query)
            {
                // generate our authcode
                $authcode = $this->_genActCode(20);

                // add the reset info the the database
                $this->user_model->add_reset_data($user_query->row()->user_name, $user_query->row()->user_email, $authcode);

                // send user email
                if (!$this->usermail->send_forgotpass
                        (
                            $user_query->row()->user_first_name . ' ' . $user_query->row()->user_last_name . ' (' . $user_query->row()->user_name . ')',
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
            $this->user_model->auth_reset($this->input->post('auth_code'), $password, $salt);

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
     * public resend_validation()
     */
    public function resend_validation()
    {
        $user = $this->user_model->get_user_by_username( $this->input->post( 'username' ) );
        if ( $user != FALSE )
        {
            $full_name = $user->row()->user_first_name . ' ' . $user->row()->user_last_name . ' (' . $user->row()->user_name . ')';

            $this->usermail->send_authcode(
                $full_name,                     // username
                $user->row()->user_email,       // email
                $user->row()->user_activation,  // auth_code
                FALSE,                          // new_owl
                NULL,                           // owl_name
                TRUE                            // resend
            );
            print $user->row()->user_email;
        }
    }
    //------------------------------------------------------------------


    /**
     * public join()
     */
    public function join($owl_id = FALSE)
    {
        if (!$owl_id)
            redirect('/user/register/', 'location');

        if (is_member($owl_id))
            redirect('/', 'location');

        $page_data = array(
            'owl_id'        => $owl_id,
            'owl_name'      => $this->owl_model->get_owl_by_id($owl_id)->row()->owl_name,
            'page_title'    => 'OWL Join Request'
        );

        $this->load->view('auth/join', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * ajax_search()
     */
    public function ajax_change_owl()
    {
        // ajax security check
        // checks to make sure it a) was an ajax request and b) that it came from our server
        if (!$this->input->is_ajax_request() || strpos($this->input->server('HTTP_REFERER'), 'miowl') === FALSE)
            die('Invalid request.');

        // get our owl id
        if (!$this->input->post('owl'))
            die("NOT changed");

        $this->session->unset_userdata('owl');
        $this->session->set_userdata('owl', trim($this->input->post('owl')));

        print "changed";
    }
    // -------------------------------------------------------------------------------


    /**
     * ajax_request_owl_access()
     */
    public function ajax_request_owl_access()
    {
        // ajax security check
        // checks to make sure it a) was an ajax request and b) that it came from our server
        if (!$this->input->is_ajax_request() || strpos($this->input->server('HTTP_REFERER'), 'miowl') === FALSE)
            die('Invalid request.');

        // get our owl id
        if (!$this->input->post('owl'))
            die("NOT requested");

        $this->owl_model->request_owl_access();

        $owl_info = $this->owl_model->get_owl_by_id($this->input->post('owl'));
        $this->owlmail->inform_admin($this->session->userdata('name'), $owl_info->row()->owl_email);

        print "requested";
    }
    // -------------------------------------------------------------------------------


//=================================================================================
// :custom callbacks
//=================================================================================

    /**
     * callback _spam_check()
     * function will try and make sure we have a human that's registering an account.
     *
     * @param string $str - string to validate against
     */
    public function _spam_check($str)
    {
        if (strtolower($str) === "miowl.org")
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
        if (!$this->user_model->validate_authcode($code, TRUE))
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
        if (!$this->user_model->validate_authcode($code))
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
        if ($this->user_model->validate_username($username))
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

        if (!valid_email($email))
        {
            $this->form_validation->set_message('_valid_email', 'This is not a valid email address!');
            return FALSE;
        }

        if ($this->user_model->validate_email($email))
            return TRUE;

        $this->form_validation->set_message('_valid_email', 'This email address is already in use.');
        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_choice()
     * function will validate that the user has not selected a default drop down value.
     *
     * @param string $choice - choice to validate
     */
    public function _valid_choice($choice = FALSE)
    {
        if (!$choice || $choice == 'default')
        {
            $this->form_validation->set_message('_valid_choice', 'The %s field has an invalid choice!');
            return FALSE;
        }

        return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * callback _valid_url()
     * function will validate that the user has entered a valid url.
     *
     * @param string $url - url to validate
     */
    public function _valid_url($url = FALSE)
    {
        if (!$url)
        {
            #$this->form_validation->set_message('_valid_url', '%s is empty!');
            return TRUE;
        }

        // Our regex pattern for a valid URL/URI
        $pattern = "/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";

        if(!(bool) preg_match($pattern, $url))
        {
            $this->form_validation->set_message('_valid_url', 'The %s is invalid!');
            return FALSE;
        }

        return TRUE;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================

    /**
     * private login_check()
     */
    private function login_check($location = FALSE, $redirect = FALSE, $login_check = FALSE)
    {
        if ($this->session->userdata('authed'))
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

// eof.