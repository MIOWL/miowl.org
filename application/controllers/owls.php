<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owls extends CI_Controller {

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
    public function index($owl = FALSE)
    {
        $details = $this->owl_model->get_owl_by_id($owl);
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


    //=================================================================================
    // :uploads view
    //=================================================================================


    /**
     * public uploads()
     */
    public function uploads($owl = FALSE, $offset = 0, $limit = 7)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Uploads";
        $page_data['uploads']       = $this->upload_model->get_upload_by_owl($owl, $limit, $offset);

        // setup pagination lib
        $config['base_url']         = site_url('owls/uploads/list/' . $owl);
        $config['uri_segment']      = 5;
        $config['total_rows']       = $this->upload_model->total_owl_uploads($owl);
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


    //=================================================================================
    // :members view
    //=================================================================================


    /**
     * public members()
     */
    public function members($function = FALSE, $params = NULL)
    {
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
    public function _members_list($owl = FALSE)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "All Owl Members";
        $page_data['members']       = $this->miowl_model->get_owl_members($owl);
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($owl)->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_admin()
     */
    public function _members_admin($owl = FALSE)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Administrator Members";
        $page_data['members']       = $this->miowl_model->get_owl_admin_members($owl);
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($owl)->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_editor()
     */
    public function _members_editor($owl = FALSE)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl Editor Members";
        $page_data['members']       = $this->miowl_model->get_owl_editor_members($owl);
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($owl)->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * member function _members_user()
     */
    public function _members_user($owl = FALSE)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "Owl User Members";
        $page_data['members']       = $this->miowl_model->get_owl_user_members($owl);
        $page_data['admin_id']      = $this->owl_model->get_owl_by_id($owl)->row()->owl_admin_uid;

        // load the approp. page view
        $this->load->view('pages/owl_members', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :categories view
    //=================================================================================


    /**
     * public categories()
     */
    public function categories($owl = FALSE)
    {
        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "All Owl File Categories";
        $page_data['owl']           = $owl;
        #$page_data['categories']    = $this->gen_categories();

        // load the approp. page view
        $this->load->view('pages/owl_categories', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :custom callbacks
    //=================================================================================


    //=================================================================================
    // :private
    //=================================================================================


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
