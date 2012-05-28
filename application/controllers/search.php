<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
        $page_data['page_title'] = 'Search';
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
