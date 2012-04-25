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

        $upload_path = './uploads/';

        // Generate the random filename and check it is unique
        $rand = FALSE;
        do {
            $rand = $this->_genRand();

            if(file_exists($upload_path . $rand))
                $rand = FALSE;

        } while (!$rand);

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'txt|pdf|doc|docx|rtf';
        $config['max_size'] = '10240'; // 10MB

        $page_data = array();
        $page_data['error'] = NULL;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $page_data['page_title'] = 'Upload Failure';
            $page_data['error'] = $this->upload->display_errors();

            $this->load->view('pages/upload_form', $page_data);
        }
        else
        {
            $page_data['page_title'] = 'Upload Success';
            $page_data['upload_data'] = $this->upload->data();

            $this->load->view('pages/upload_success', $page_data);
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


    /**
     * private _genRand()
     * function generates a random string used for the uploaded file name.
     * This is unique and is used for file protection.
     *
     * @param int $length - optional length of the salt (default 20)
     */
    private function _genRand($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
    //------------------------------------------------------------------


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */