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

        if (!$this->session->userdata('owl_verified')) {
            redirect('/welcome', 'location');
            return;
        }
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
        // Do we need to login??
        if (!$this->login_check('owl'))
            return;

        $details = $this->owl_model->get_owl_by_id($this->session->userdata('owl'));
        $address = $details->row()->owl_address . "\n" . 
                   $details->row()->owl_city . "\n" . 
                   $details->row()->owl_province . "\n" . 
                   $details->row()->owl_post_code;

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Details";
        $page_data['details']       = $details;
        $page_data['google_maps']   = TRUE;
        $page_data['address']       = str_replace("\n", '<br>', $address);
        $page_data['location']      = $this->get_coordinates(str_replace("\n", ',', $address));

        // load the approp. page view
        $this->load->view('pages/owl_details', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public edit_details()
     */
    public function edit_details()
    {
        // Do we need to login??
        if (!$this->login_check('owl-edit_details'))
            return;

        $details    = $this->owl_model->get_owl_by_id($this->session->userdata('owl'));
        $owl_id     = $this->session->userdata('owl');

        // form validation rules
        $this->form_validation->set_rules('name', 'Organization Name', "required|trim|callback__is_this_unique[{$owl_id}]");
        $this->form_validation->set_rules('acronym', 'Organization Acronym', "required|trim|alpha_numeric|callback__is_this_unique[{$owl_id}]");
        $this->form_validation->set_rules('type', 'Owl Type', 'callback__valid_choice');
        $this->form_validation->set_rules('address', 'Organization Address', 'required|trim');
        $this->form_validation->set_rules('province', 'Province', 'callback__valid_choice');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('zip', 'Postal Code', 'required|trim|alpha_numeric');
        $this->form_validation->set_rules('tel', 'Phone Number', "trim");
        $this->form_validation->set_rules('site', 'Website', "trim|prep_url|callback__valid_url|callback__is_this_unique[{$owl_id}]");
        $this->form_validation->set_rules('email', 'Administrator Email', "required|trim|valid_email|callback__is_this_unique[{$owl_id}]");

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "[EDIT] Owl Details";
        $page_data['details']       = $details;
        $page_data['province']      = $this->province_list;

        if (!$this->form_validation->run())
        {
            // load the approp. page view
            $this->load->view('pages/owl_details_edit', $page_data);
        }
        else
        {
            $name = $this->session->userdata('name') . ' (' . $this->session->userdata('username') . ')';

            $owl_id = $this->owl_model->update_owl();

            if ($this->input->post('email') != $details->row()->owl_email)
            {
                $authcode = $this->_genActCode();
                $this->owlmail->send_notification($name, $details->row()->owl_email, $this->input->post('email'));
                $this->owl_model->new_email($details->row()->owl_email, $this->input->post('email'));
            }

            $page_data['success']     = TRUE;
            $page_data['msg']         = "Successfully updated you're owl.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you updated your admin email please check your email to finish the update process.";

            // load the approp. page view
            $this->load->view('pages/owl_details_edit', $page_data);
        }
    }
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

            $this->load->view('auth/new_owl', $page_data);
        }
        else
        {
            $name = $this->session->userdata('name') . ' (' . $this->session->userdata('username') . ')';

            if(!$this->input->post('new_owl'))                          // Existing Owl
            {
                $owl_info = $this->owl_model->get_owl_by_id($this->input->post('owl'));
                $this->owl_model->choose_owl($this->session->userdata('user_id'), $this->input->post('owl'));
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

                $owl_id = $this->owl_model->add_owl(
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
                $this->owl_model->choose_owl($this->session->userdata('user_id'), $owl_id, TRUE);
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
            $email = $this->owl_model->activate_owl($this->input->post('auth_code'));

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


    //=================================================================================
    // :uploads view
    //=================================================================================


    /**
     * public uploads()
     */
    public function uploads($function = FALSE, $params = NULL)
    {
        // Do we need to login??
        if (!$this->login_check('owl-uploads-' . $function))
            return;

        if (!$function)
            $function = 'list';

        if (method_exists($this, '_uploads_' . $function))
            return call_user_func(array($this, '_uploads_' . $function), $params);

        show_404();
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :upload view functions
    //=================================================================================


    /**
     * upload function _uploads_list()
     */
    public function _uploads_list($offset = 0, $limit = 7)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Uploads";
        $page_data['uploads']       = $this->upload_model->get_upload_by_owl($this->session->userdata('owl'), $limit, $offset);

        // setup pagination lib
        $config['base_url']         = site_url('owl/uploads/list');
        $config['uri_segment']      = 4;
        $config['total_rows']       = $this->upload_model->total_owl_uploads($this->session->userdata('owl'));
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load the approp. page view
        $this->load->view('pages/owl_uploads', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * upload function _uploads_bin()
     */
    public function _uploads_bin($offset = 0, $limit = 7)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Recycle Bin";
        $page_data['uploads']       = $this->upload_model->get_deleted_by_owl($limit, $offset);

        // setup pagination lib
        $config['base_url']         = site_url('owl/uploads/bin');
        $config['uri_segment']      = 4;
        $config['total_rows']       = $this->upload_model->total_owl_deleted_uploads($this->session->userdata('owl'));
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load the approp. page view
        $this->load->view('pages/owl_uploads_bin', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _uploads_remove()
     */
    public function _uploads_remove($id = FALSE)
    {
        print $this->upload_model->delete($id)?1:0;
    }
    //------------------------------------------------------------------


    /**
     * member function _uploads_restore()
     */
    public function _uploads_restore($id = FALSE)
    {
        print $this->upload_model->restore($id)?1:0;
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :members view
    //=================================================================================


    /**
     * public members()
     */
    public function members($function = FALSE, $params = NULL)
    {
        // Do we need to login??
        if (!$this->login_check('owl-members-' . $function))
            return;

        if (!$function)
            $function = 'list';

        if (method_exists($this, '_members_' . $function))
            return call_user_func(array($this, '_members_' . $function), $params);

        show_404();
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :members view functions
    //=================================================================================


    /**
     * member function _members_list()
     */
    public function _members_list()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "All Owl Members";
        $page_data['members']       = $this->miowl_model->get_owl_members($this->session->userdata('owl'));
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($this->session->userdata('owl'))->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_admin()
     */
    public function _members_admin()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Administrator Members";
        $page_data['members']       = $this->miowl_model->get_owl_admin_members($this->session->userdata('owl'));
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($this->session->userdata('owl'))->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_editor()
     */
    public function _members_editor()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Editor Members";
        $page_data['members']       = $this->miowl_model->get_owl_editor_members($this->session->userdata('owl'));
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($this->session->userdata('owl'))->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_user()
     */
    public function _members_user()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl User Members";
        $page_data['members']       = $this->miowl_model->get_owl_user_members($this->session->userdata('owl'));
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($this->session->userdata('owl'))->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
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
        $page_data['members']       = $this->miowl_model->get_owl_unverified_members($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('pages/owl_members_requests', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_accept()
     */
    public function _members_accept($user_id = FALSE)
    {
        print $this->miowl_model->owl_accept_member($this->session->userdata('owl'), $user_id)?1:0;
    }
    //------------------------------------------------------------------


    /**
     * member function _members_deny()
     */
    public function _members_deny($user_id = FALSE)
    {
        print $this->miowl_model->owl_deny_member($this->session->userdata('owl'), $user_id)?1:0;
    }
    //------------------------------------------------------------------


    /**
     * member function _members_promote()
     */
    public function _members_promote($group = FALSE, $user_id = FALSE)
    {
        print json_encode(array('success'=>'true'));
    }
    //------------------------------------------------------------------


    /**
     * member function _members_demote()
     */
    public function _members_demote($group = FALSE, $user_id = FALSE)
    {
        print json_encode(array('success'=>'true'));
    }
    //------------------------------------------------------------------


    /**
     * member function _members_invite()
     */
    public function _members_invite()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Member Invite";
        $page_data['owl_info']      = $this->owl_model->get_owl_by_id($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('pages/owl_members_invite', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :categories view
    //=================================================================================


    /**
     * public categories()
     */
    public function categories($function = FALSE, $params = NULL)
    {
        // Do we need to login??
        if (!$this->login_check('owl-categories-' . $function))
            return;

        if (!$function)
            $function = 'list';

        if (method_exists($this, '_categories_' . $function))
            return call_user_func(array($this, '_categories_' . $function), $params);

        show_404();
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :categories view functions
    //=================================================================================


    /**
     * categories function _categories_list()
     */
    public function _categories_list()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "All Owl File Categories";
        $page_data['categories']    = gen_categories();

        // load the approp. page view
        $this->load->view('pages/owl_categories', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _categories_organize()
     */
    public function _categories_organize()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Organize Owl File Categories";
        $page_data['categories']    = $this->cat_model->get_owl_categories($this->session->userdata('owl'));

        // load the approp. page view
        $this->load->view('pages/owl_categories_organize', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _categories_create()
     */
    public function _categories_create()
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Create New Owl File Category";
        $page_data['categories']    = $this->cat_model->get_owl_categories($this->session->userdata('owl'), FALSE);

        // form validation rules
        $this->form_validation->set_rules('name', 'Category Name', "required|trim|callback__unique_category[{$this->session->userdata('owl')}]");

        if ($this->form_validation->run())
        {
            // add the new category
            $this->cat_model->add_category();

            $page_data['success']     = TRUE;
            $page_data['msg']         = "You're new category has now been created.";
        }

        // load the approp. page view
        $this->load->view('pages/owl_categories_create', $page_data);
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
        if (!$this->owl_model->validate_authcode($code))
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


    /**
     * callback _unique_category()
     */
    public function _unique_category($value = FALSE, $owl_id)
    {
        $categories = $this->cat_model->get_owl_categories($owl_id, FALSE);

        if (!$categories)
            return TRUE;

        if(in_array($value, $categories->row_array()))
        {
            $this->form_validation->set_message('_unique_category', 'The %s is not unique!');
            return FALSE;
        }

        return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * callback _is_this_unique()
     */
    public function _is_this_unique($value = FALSE, $owl_id)
    {
        if (!$value)
        {
            #$this->form_validation->set_message('_is_this_unique', '%s is empty!');
            return FALSE;
        }

        if(in_array($value, $this->owl_model->get_all_owl_info_except($owl_id)->row_array()))
        {
            $this->form_validation->set_message('_is_this_unique', 'The %s is not unique!');
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


    /**
     * private get_coordinates()
     */
    private function get_coordinates($address = FALSE)
    {
        if (!$address)
            return FALSE;

        $url = 'https://maps.google.com/maps/geo?q=';
        $url .= urlencode($address);
        $url .= '&output=csv&oe=utf8&sensor=false';

        $ch = curl_init();
        $timeout = 600;
        curl_setopt($ch, CURLOPT_URL,               $url);
        curl_setopt($ch, CURLOPT_USERAGENT,         'MiOwl ~djeklDevelopments');
        curl_setopt($ch, CURLOPT_TIMEOUT,           $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,    $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,    TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,    FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,    FALSE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    //------------------------------------------------------------------


}
