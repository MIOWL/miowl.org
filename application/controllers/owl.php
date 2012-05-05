<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owl extends CI_Controller {

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
    #public function index()
    #{
    #    #$this->login_check('', TRUE);
    #}
    //------------------------------------------------------------------


    /**
     * public create()
     */
    public function create()
    {
        // New or existing Owl?
        if(!$this->input->post('new_owl'))
        { // Existing Owl
            // form validation rules
            $this->form_validation->set_rules('owl', 'Owl', 'callback__valid_choice');
        }
        else
        { // New Owl
            // form validation rules
            $this->form_validation->set_rules('name', 'Organization Name', 'required|trim|is_unique[owls.owl_name]');
            $this->form_validation->set_rules('acronym', 'Organization Acronym', 'required|trim|alpha_numeric|is_unique[owls.owl_name_short]');
            $this->form_validation->set_rules('type', 'Owl Type', 'callback__valid_choice');
            $this->form_validation->set_rules('address', 'Organization Address', 'required|trim');
            $this->form_validation->set_rules('province', 'Province', 'callback__valid_choice');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('zip', 'Postal Code', 'required|trim|alpha_numeric');
            $this->form_validation->set_rules('tel', 'Phone Number', 'trim|numeric|is_unique[owls.owl_tel]');
            $this->form_validation->set_rules('site', 'Website', 'trim|prep_url|callback__valid_url|is_unique[owls.owl_site]');
            $this->form_validation->set_rules('email', 'Administrator Email', 'required|trim|valid_email|is_unique[owls.owl_email]');
        }

        // Are you supposed to see this?
        if (!$this->input->post('existing_owl') && !$this->input->post('new_owl'))
            redirect('user/login', 'location');

        // Are you supposed to see this?
        if (!$this->form_validation->run())
        {
            $page_data                  = array();
            $page_data['page_title']    = "[ERROR] Choose your Owl";
            $page_data['province']      = $this->province_list;

            // fetch the owl data we need
            $owl_data                   = $this->Owl_model->get_all_owls();
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

            $this->load->view('auth/new_owl', $page_data);
        }
        else
        {
            $name = $this->session->userdata('name') . ' (' . $this->session->userdata('username') . ')';

            if(!$this->input->post('new_owl'))                          // Existing Owl
            {
                $owl_info = $this->Owl_model->get_owl_by_id($this->input->post('owl'));
                $this->Owl_model->choose_owl($this->session->userdata('user_id'), $this->input->post('owl'));
                $this->owlmail->send_chosen($name, $owl_info->row()->owl_name, $this->session->userdata('email'));
                $this->owlmail->inform_admin($name, $owl_info->row()->owl_email);

                $page_data['success']     = TRUE;
                $page_data['msg']        = "Successfully chosen you're owl. Please check your email to finish the registration process.";
                $page_data['redirect']    = '';
                $this->load->view('messages/message_page', $page_data);
           }
            else                                                        // New Owl
            {
                $authcode = $this->_genActCode();

                $owl_id = $this->Owl_model->add_owl(
                                $this->input->post('name'),
                                $this->input->post('acronym'),
                                $this->input->post('type'),
                                $this->input->post('address'),
                                $this->input->post('province'),
                                $this->input->post('city'),
                                $this->input->post('zip'),
                                $this->input->post('tel'),
                                $this->input->post('site'),
                                $this->session->userdata('user_id'),
                                $this->input->post('email'),
                                $authcode
                            );
                $this->Owl_model->choose_owl($this->session->userdata('user_id'), $owl_id, TRUE);
                $this->owlmail->send_activation($name, $this->input->post('email'), $authcode);

                $page_data['success']     = TRUE;
                $page_data['msg']        = "Successfully registered you're owl. Please check your email to finish the registration process.";
                $page_data['redirect']    = '';
                $this->load->view('messages/message_page', $page_data);
            }
        }
    }
    //------------------------------------------------------------------


    /**
     * public activate()
     */
    public function activate($code = FALSE)
    {
        $page_data = array(
            'code'          => $code,
            'page_title'    => 'Owl Activate',
        );

        // form validation rules
        $this->form_validation->set_rules('auth_code', 'Authorization Code', 'required|callback__valid_authcode');

        // did the user submit?
        if ($this->form_validation->run())
        {
            // activate the user's owl
            $email = $this->Owl_model->activate_owl($this->input->post('auth_code'));

            // welcome the user's owl
            $this->owlmail->send_owl_welcome($email);

            $page_data['success']     = TRUE;
            $page_data['msg']         = "You're owl has been successfully activated.";
            $page_data['redirect']    = '';
        }

        // load the view
        if (isset($page_data['success']))
            $this->load->view('messages/message_page', $page_data);
        else
            $this->load->view('auth/owl_authorize', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public uploads()
     */
    public function uploads()
    {
        // Do we need to login??
        if (!$this->login_check('owl-uploads'))
            return;

        // Load the MiOwl Model
        $this->load->model('miowl_model');

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Uploads";
        $page_data['uploads']       = $this->miowl_model->get_owl_uploads($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('misc/owl_uploads', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public uploads()
     */
    public function members($function = FALSE, $params = array())
    {
        // Do we need to login??
        if (!$this->login_check('owl-members-' . $function))
            return;

        if (!$function)
            $function = 'list';

        if (method_exists($this, '_members_' . $function))
            return call_user_func_array(array($this, '_members_' . $function), $params);

        else
            show_404();
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :member view functions
    //=================================================================================


    /**
     * member function _members_list()
     */
    public function _members_list()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Members";
        $page_data['members']       = $this->miowl_model->get_owl_members($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('misc/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_requests()
     */
    public function _members_requests()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Member Requests";
        $page_data['members']       = $this->miowl_model->get_owl_uploads($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('misc/owl_members_requests', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :custom callbacks
    //=================================================================================


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
        if (!$this->Owl_model->validate_authcode($code))
        {
            $this->form_validation->set_message('_valid_authcode', 'This account has already been activated, or the given authorization code is invalid.');

            return FALSE;
        }
        else
            return TRUE;
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

        if ($this->User_model->validate_email($email))
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
    // :private
    //=================================================================================


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
