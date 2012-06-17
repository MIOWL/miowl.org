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
        $page_data['search_data']   = $this->session->userdata('search');
        $page_data['province_list'] = $this->province_list;

        // form validation rules
        $this->form_validation->set_rules('keyword', 'Search Term', 'required|trim|callback__valid_search');
        $this->form_validation->set_rules('type', 'Owl Type', 'callback__valid_choice');

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

        print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';

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
     * Used in the search form to get the relivent information
     *
     * @param $type - this is the type of search we are wanting to do. (type or province)
     * @param $value - this is the search data for the SQL
     * @return JSON output
     */
    public function get_results($type = FALSE, $value = FALSE)
    {
        // set our default
        $return_data = array();

        // lets see what we want to get results for
        if ($type == 'type') {
            if(($data = $this->owl_model->get_owl_by_type($value)))
                foreach ($data->result() as $row)
                    $return_data['names'][] = $row->owl_province;
        }

        elseif ($type == 'province') {
            $province_list = explode('-', str_replace('null-', NULL, $value));
            foreach ($province_list as $value) {
                if(($data = $this->owl_model->get_owl_by_province($value))) {
                    foreach ($data->result() as $row) {
                        $return_data['owls'][] = array('id'=>$row->id, 'name'=>$row->owl_name);
                    }
                }
            }
        }

        // do we have a valid output
        $output = ($return_data == FALSE) || empty($return_data) ? array() : array_unique($return_data);
        #$output = ($return_data == FALSE) || empty($return_data) ? array() : $return_data;

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
        // print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';
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
        $post_data = $this->urldecode_array($this->input->post(NULL, TRUE));
        $search_array = array();
        $search_array['keyword']                     = $post_data['keyword'];

        if($post_data['type'] != 'both')
            $search_array['having']['owl_type'] = $post_data['type'];

        $search_array['having']['owl_province'] = $post_data['province'];
        $search_array['having']['owl_id']           = $post_data['owl'];

        // build the post data into the session
        $this->session->set_userdata('search', $search_array);
    }
    //------------------------------------------------------------------


    /**
     * private urldecode_array()
     *
     * This is used to url decode array data. i.e. POST data
     */
    private function urldecode_array($input = FALSE)
    {
        // if(!$input)
        //     return FALSE;

        $output = array();
        foreach ($input as $key => $value) {
            if(is_array($value))
                $output[$key] = $this->urldecode_array($value);
            else
                $output[$key] = urldecode($value);
        }
        return $output;
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
