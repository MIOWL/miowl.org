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
        $this->load->model('upload_model');
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

        // What are the allowed file types? [seperate via pipe (|)]
        $file_types = 'txt|rtf|pdf|doc|docx';

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = $file_types;
        $config['max_size'] = '10240'; // 10MB
        $config['encrypt_name'] = TRUE;

        $page_data = array();
        $page_data['error'] = NULL;
        $page_data['allow_types'] = str_replace('|', ', ', $file_types);

        $this->load->library('upload', $config);

        // Get the POST data
        $post_back = array();
        foreach ($this->input->post() as $key => $value) {
            $post_back[$key] = $value;
        }

        if($this->form_validation->run())
        {
            if (!$this->upload->do_upload())
            {
                $page_data['page_title'] = 'Upload Failure';
                $page_data['error'] = $this->upload->display_errors();

                $this->load->view('pages/upload_form', $page_data);
            }
            else
            {
                $upload_data = $this->upload->data();

                $upload_user        = $this->session->userdata('username');
                $owl                = $this->session->userdata('owl');
                $file_name          = $upload_data['file_name'];
                $full_path          = $upload_data['full_path'];
                $upload_catagory    = 'n/a';
                $file_type          = $upload_data['file_type'];
                $client_name        = $upload_data['client_name'];
                $file_size          = $upload_data['file_size'];
                $file_ext           = $upload_data['file_ext'];
                $description        = 'n/a';

                $this->upload_model->add_upload(
                            $upload_user,
                            $owl,
                            $file_name,
                            $full_path,
                            $upload_catagory,
                            $file_type,
                            $client_name,
                            $file_size,
                            $file_ext,
                            $description
                          );

                $page_data['page_title'] = 'Upload Success';
                $page_data['upload_data'] = $upload_data;

                $this->load->view('pages/upload_success', $page_data);
            }
        }
        else
        {
            $page_data['page_title'] = 'Upload';
            $this->load->view('pages/upload_form', $page_data);
        }
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
        $config['encrypt_name'] = TRUE;

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
            $upload_data = $this->upload->data();

            $upload_user        = $this->session->userdata('username');
            $owl                = $this->session->userdata('owl');
            $file_name          = $upload_data['file_name'];
            $full_path          = $upload_data['full_path'];
            $upload_catagory    = 'n/a';
            $file_type          = $upload_data['file_type'];
            $client_name        = $upload_data['client_name'];
            $file_size          = $upload_data['file_size'];
            $file_ext           = $upload_data['file_ext'];
            $description        = 'n/a';

            $this->upload_model->add_upload(
                        $upload_user,
                        $owl,
                        $file_name,
                        $full_path,
                        $upload_catagory,
                        $file_type,
                        $client_name,
                        $file_size,
                        $file_ext,
                        $description
                      );

            $page_data['page_title'] = 'Upload Success';
            $page_data['upload_data'] = $upload_data;

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


}

