<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends CI_Controller {

//=================================================================================
// :vars
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
		print '<pre>' . print_r($this->session->all_userdata(), TRUE) . '</pre>';
    }
    //------------------------------------------------------------------


//=================================================================================
// :private
//=================================================================================


}

/* End of file scraper.php */
/* Location: ./application/controllers/scraper.php */