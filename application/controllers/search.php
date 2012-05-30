<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    //=================================================================================
    // :private vars
    //=================================================================================


    private $per_page_limit = 7;


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
        $this->load->model('search_model');
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
     *
     * This is the default search page.
     * Used to do the initial query.
     */
    public function index()
    {
        $this->build_search();
            print '<pre>' . print_r($this->input->post(),  TRUE) . '</pre>';
            print '<pre>' . print_r($this->session->userdata('search'),  TRUE) . '</pre>';

        // setup our page data
        $page_data = array();
        $page_data['page_title'] = 'Search Form';

        // form validation rules
        $this->form_validation->set_rules('keyword', 'Search Term', 'required|trim|callback__valid_search');

        // did the user submit
        if ($this->form_validation->run())
        {
            // build the search data
            $this->build_search();

            // redirect to the results page
            redirect(site_url('search/results'), 'location');
        }
        else
        {
            // load our view
            $this->load->view('search/form', $page_data);
        }
    }
    //------------------------------------------------------------------


    /**
     * public results()
     *
     * Search Results Page
     */
    public function results($offset = 0)
    {
        // get our search data
        $search = $this->session->userdata('search');

        // if we don't have a keyword, send them to the search page
        if(!isset($search['keyword']))
            redirect(site_url('search'), 'location');

        // setup our page data
        $page_data = array();
        $page_data['page_title'] = 'Search Results';
        $page_data['keyword'] = $search['keyword'];
        $page_data['query'] = $this->search_model->search_all($search['keyword'], $offset, $this->per_page_limit);

        // setup pagination lib
        $config['base_url']         = base_url('search/results');
        $config['uri_segment']      = 3;
        $config['total_rows']       = (($rows = $this->search_model->search_all($search['keyword'], FALSE, FALSE))) ? $rows->num_rows() : 0;
        $config['per_page']         = $this->per_page_limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('search/general', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private gen_results()
     *
     * Private function to do the search via the vars given above...
     */
    private function gen_results()
    {
        $page_data = array();
        $page_data['page_title'] = 'Search Results';
        $this->load->view('search/general', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * private build_search()
     *
     * This is used to build up the search data.
     */
    private function build_search()
    {
        // remove the search data if it exists (to avoid any issues)
        $this->session->unset_userdata('search');

        // build the post data into the session
        $this->session->set_userdata('search', $this->input->post(NULL, TRUE));
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :custom callbacks
    //=================================================================================


    /**
     * callback _valid_search()
     */
    public function _spam_check($str)
    {
        return $this->search_model->search_all($search['keyword'], FALSE, FALSE);
    }
    //------------------------------------------------------------------


}

// EOF
