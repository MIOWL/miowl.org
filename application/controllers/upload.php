<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

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
        // Do we need to login??
        if (!$this->login_check('upload'))
            return;

        $page_data = array();
        $page_data['page_title'] = 'Upload';
        $page_data['error'] = NULL;
        $this->load->view('pages/upload_form', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public do_upload()
     */
    function do_upload()
    {
        // Do we need to login??
        if (!$this->login_check('upload-do_upload'))
            return;

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'txt|pdf|doc|docx|rtf';
        $config['max_size'] = '10240'; // 10MB

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        }
        else
        {
            $data = array('page_title' => 'Upload Success', 'upload_data' => $this->upload->data());

            $this->load->view('upload_success', $data);
        }
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private login_check()
     */
    private function login_check($location = FALSE, $redirect = FALSE)
    {
        if ($this->session->userdata('authed'))
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
            redirect('/user/login/' . $location, 'location');
            return FALSE;
        }
    }
    //------------------------------------------------------------------



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */