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
    public function index($keyword = 'djekl', $offset = 0)
    {
        $page_data = array();
        $page_data['page_title'] = 'Search';
        $page_data['query'] = $this->search_model->search_all($keyword, $offset, $this->per_page_limit);

        // setup pagination lib
        $config['base_url']         = site_url('search/index/' . $keyword);
        $config['uri_segment']      = 4;
        $config['total_rows']       = (($rows = $this->search_model->search_all($keyword, FALSE, FALSE))) ? $rows->num_rows() : 0;
        $config['per_page']         = $this->per_page_limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        $this->load->view('search/general', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public owl()
     *
     * Search via Owl
     */
    public function owl()
    {
        $this->gen_results();
    }
    //------------------------------------------------------------------


    /**
     * public user()
     *
     * Search via Username (username / firstname / lastname)
     */
    public function user()
    {
        $this->gen_results();
    }
    //------------------------------------------------------------------


    /**
     * public general()
     *
     * General Site Wide Search
     */
    public function general()
    {
        $this->gen_results();
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
