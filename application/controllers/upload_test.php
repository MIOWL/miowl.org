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
    }
    //------------------------------------------------------------------


    public function upload()
    {
        print '<pre>' . print_r($_FILES, TRUE) . '</pre>';
        print '<pre>' . print_r($this->input->post(NULL, TRUE), TRUE) . '</pre>';

        $page_data = array();

        // What are the allowed file types? [seperate via pipe (|)]
        $file_types = 'txt|rtf|pdf|doc|docx';

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = $file_types;
        $config['max_size'] = '102400000'; // 10MB
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        // form validation rules
        $this->form_validation->set_rules('filename', 'File Name', 'trim');

        if($this->form_validation->run())
        {
            if (!$this->upload->do_upload())
            {
                $page_data['page_title'] = 'Upload Failure';
                $page_data['error'] = TRUE;
                $page_data['msg'] = trim($this->upload->display_errors());

                $this->load->view('testing/upload_form', $page_data);
            }
            else
            {
                $upload_data = $this->upload->data();

                $page_data['page_title'] = 'Upload Success';
                $page_data['upload_data'] = $upload_data;

                // Success Message
                $page_data['success']     = TRUE;
                $page_data['msg']         = "Upload Successful, upload another?";

                $this->load->view('testing/upload_success', $page_data);
                #$this->load->view('testing/upload_form', $page_data);
            }
        }
        else
        {
            $page_data['page_title'] = 'Upload';
            $this->load->view('testing/upload_form', $page_data);
        }
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}

