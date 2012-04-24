<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
     */
    public function index()
    {
        $page_data = array();
        $page_data['page_title'] = 'Medical Interprofessional Open-source Web-based Libraries';
        $this->load->view('pages/welcome_message', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public about()
     */
    public function about()
    {
        $page_data = array();
        $page_data['page_title'] = 'About';
        $this->load->view('pages/about', $page_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */