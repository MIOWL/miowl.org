<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    //=================================================================================
    // :private vars
    //=================================================================================


    private $per_page_limit = 7;
    private $province_list = array(
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
        // setup our page data
        $page_data = array();
        $page_data['page_title']    = 'Search Form';
        $page_data['search_page']   = FALSE; // Used in the footer for jQuery code
        $page_data['search_data']   = $this->session->userdata('search');
        $page_data['province_list'] = $this->province_list;

        // set some session data for use later, and clear 1st
        $this->session->unset_userdata('find_arr');
        $this->session->set_userdata('find_arr', array('file_ext-', 'owls-', 'lic-'));

        // form validation rules
        $this->form_validation->set_rules('keyword', 'Search Term', 'required|trim|callback__valid_search');
        $this->form_validation->set_rules('type', 'Owl Type', 'callback__valid_choice');

        // print '<pre>' . print_r($this->input->post(NULL, TRUE), TRUE) . '</pre>';
        // print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';

        // did the user submit
        if ($this->form_validation->run())
        {
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
        if(!isset($search['keyword']) || $search['keyword'] === NULL)
            redirect(site_url('search'), 'location');

        // setup our page data
        $page_data = array();
        $page_data['page_title'] = 'Search Results';
        $page_data['keyword'] = $search['keyword'];
        $page_data['query'] = $this->gen_results($offset, $this->per_page_limit);

        // print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';

        // setup pagination lib
        $config['base_url']         = base_url('search/results');
        $config['uri_segment']      = 3;
        $config['total_rows']       = (($rows = $this->gen_results())) ? $rows->num_rows() : 0;
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


    /**
     * public get_results()
     *
     * Used in the search form to get the relivent information
     */
    public function get_results($type = FALSE, $value = FALSE)
    {
        // set our default
        $return_data = FALSE;

        // lets see what we want to get results for
        if ($type == 'type') {
                if(($data = $this->owl_model->get_owl_by_type($value))) {
                    $return_data = array();
                    foreach ($data-results() as $row) {
                        $return_data[] = $row->owl_province;
                    }
                }
            }

        elseif ($type == 'province') {
                if(($data = $this->owl_model->get_owl_by_province($value))) {
                    $return_data = array();
                    foreach ($data-results() as $row) {
                        $return_data[$row->id] = $row->owl_name;
                    }
                }
            }

        // do we have a valid output
        $output = $return_data === FALSE ? array() : $output;

        // set our JSON header
        @header('Content-type: application/json');

        // print out our output in JSON
        print json_encode($output);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private gen_results()
     *
     * Private function to do the search via the vars given in the post.
     */
    private function gen_results($offset = 0, $limit = FALSE)
    {
        $search = $this->input->post(NULL, TRUE);

        if($search)
            $this->build_search();

        $search = $this->session->userdata('search');

        $query = $this->search_model->search_all($search['keyword'], $offset, $limit, $search['having']);
        print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';
        return $query;
    }
    //------------------------------------------------------------------


    /**
     * private build_search()
     *
     * This is used to build up the search data.
     */
    private function build_search()
    {
        // save the post data for ref later
        $this->session->unset_userdata('post');
        $this->session->set_userdata('post', $this->input->post(NULL, TRUE));

        // remove the search data if it exists (to avoid any issues)
        $this->session->unset_userdata('search');

        // build up the session data from the post data
        $post_data = $this->input->post(NULL, TRUE);
        $search_array = array();
        $search_array['keyword']                     = $post_data['keyword'];
        $search_array['having']['owls.owl_province'] = $post_data['province'];
        $search_array['having']['owls.id']           = $post_data['owl'];

        // build the post data into the session
        $this->session->set_userdata('search', $search_array);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :custom callbacks
    //=================================================================================


    /**
     * callback _valid_search()
     */
    public function _valid_search($keyword)
    {
        if($this->gen_results())
            return TRUE;
        
        $this->form_validation->set_message('_valid_search', 'No results found...');
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


}

// EOF
