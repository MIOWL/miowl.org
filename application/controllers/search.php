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
        $page_data = array();
        $page_data['page_title'] = 'Search Form';

        $this->load->view('search/form', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public results()
     *
     * Search Results Page
     */
    public function results($offset = 0)
    {
        print "<pre>uri_string()\n" . $this->uri->uri_string() . '</pre><br />';
        print "<pre>ruri_string()\n" . $this->uri->ruri_string() . '</pre><br />';
        print "<pre>segment_array()\n" . $this->uri->segment_array() . '</pre><br />';
        print "<pre>rsegment_array()\n" . $this->uri->rsegment_array() . '</pre><br />';

        // fetch the data from the get param
        $keyword    = $this->input->get('keyword');

        // setup our page data
        $page_data = array();
        $page_data['page_title'] = 'Search Results';
        $page_data['keyword'] = $keyword;
        $page_data['query'] = $this->search_model->search_all($keyword, $offset, $this->per_page_limit);

        // setup pagination lib
        $config['base_url']         = base_url('search/' . $offset . '/results.php?keyword=' . $keyword);
        // $config['base_url']         = base_url('search/results/' . $offset . '/?keyword=' . $keyword);
        $config['uri_segment']      = 3;
        $config['total_rows']       = (($rows = $this->search_model->search_all($keyword, FALSE, FALSE))) ? $rows->num_rows() : 0;
        $config['per_page']         = $this->per_page_limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

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


}

// EOF
