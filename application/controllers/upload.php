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
        $config['max_size'] = '102400000'; // 10MB
        $config['encrypt_name'] = TRUE;

        $page_data = array();
        $page_data['allow_types'] = str_replace('|', ', ', $file_types);
        $page_data['license'] = $this->miowl_model->get_license();

        $this->load->library('upload', $config);

        // form validation rules
        $this->form_validation->set_rules('filename', 'File Name', 'trim');
        $this->form_validation->set_rules('category', 'Upload Category', 'required|trim');
        $this->form_validation->set_rules('license', 'Upload License', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('revDate', 'Revision Date', 'required|trim');

        if($this->form_validation->run())
        {
            if (!$this->upload->do_upload())
            {
                $page_data['page_title'] = 'Upload Failure';
                $page_data['error'] = TRUE;
                $page_data['msg'] = trim($this->upload->display_errors());

                $this->load->view('pages/upload_form', $page_data);
            }
            else
            {
                $upload_data = $this->upload->data();

                $file_name = $this->input->post('filename') == ""
                                ? $upload_data['client_name']
                                : $this->input->post('filename');

                $upload_user        = $this->session->userdata('user_id');
                $owl                = $this->session->userdata('owl');
                $full_path          = $upload_data['full_path'];
                $upload_category    = $this->input->post('category');
                $upload_license     = $this->input->post('license');
                $file_type          = $upload_data['file_type'];
                $client_name        = $upload_data['client_name'];
                $file_size          = $upload_data['file_size'];
                $file_ext           = $upload_data['file_ext'];
                $description        = str_replace(array("\r\n","\r","\n"), '\n', trim($this->input->post('description')));
                $revDate            = explode('/', $this->input->post('revDate'));
                $revDate            = $revDate[2] . $revDate[1] . $revDate[0];

                $this->upload_model->add_upload(
                            $upload_user,
                            $owl,
                            $file_name,
                            $full_path,
                            $upload_category,
                            $upload_license,
                            $file_type,
                            $client_name,
                            $file_size,
                            $file_ext,
                            $description
                          );

                $page_data['page_title'] = 'Upload Success';
                $page_data['upload_data'] = $upload_data;

                // Success Message
                $page_data['success']     = TRUE;
                $page_data['msg']         = "Upload Successful, upload another?";

                #$this->load->view('pages/upload_success', $page_data);
                $this->load->view('pages/upload_form', $page_data);
            }
        }
        else
        {
            $page_data['page_title'] = 'Upload';
            $this->load->view('pages/upload_form', $page_data);
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

