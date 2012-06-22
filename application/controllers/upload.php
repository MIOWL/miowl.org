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
        $this->load->library('upload', $config);

        print '<pre>' . print_r($this->upload->data(), TRUE) . '</pre>';
        print '<pre>' . print_r($this->input->post(NULL, TRUE), TRUE) . '</pre>';

        $page_data = array();
        $page_data['allow_types'] = str_replace('|', ', ', $file_types);
        $page_data['license'] = $this->miowl_model->get_license();

        // form validation rules
        $this->form_validation->set_rules('filename', 'File Name', 'trim');
        $this->form_validation->set_rules('category', 'Upload Category', 'trim|required');
        $this->form_validation->set_rules('license', 'Upload License', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('revDate', 'Revision Date', 'trim|required');

        if (!$this->upload->do_upload())
        {
            $page_data['page_title'] = 'Upload Failure';
            $page_data['error'] = TRUE;
            $page_data['msg'] = trim($this->upload->display_errors());

            $this->load->view('pages/upload_form', $page_data);
            return;
        }
        else
        {
            print " -- good upload\n";
            if($this->form_validation->run())
            {
                print "validated\n";
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

                $revDate            = $this->input->post('revDate') == ""
                                        ? NULL
                                        : strtotime($this->input->post('revDate'));

                if (!$this->upload_model->add_upload(
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
                            $description,
                            $revDate
                          ))
                    {
                        $page_data['page_title'] = 'Upload Failure';
                        $page_data['error'] = TRUE;
                        $page_data['msg'] = "Something went wrong with the database...";
                        $this->load->view('pages/upload_form', $page_data);
                        return;
                    }
                else {
                    print " -- good db insert\n";
                }

                $page_data['page_title'] = 'Upload Success';
                $page_data['upload_data'] = $upload_data;

                // Success Message
                $page_data['success']     = TRUE;
                $page_data['msg']         = "Upload Successful, upload another?";

                $this->load->view('pages/upload_success', $page_data);
                #$this->load->view('pages/upload_form', $page_data);
                return;
            }
        }
        else
        {
            print "invalid form :(\n";
            $page_data['page_title'] = 'Upload';
            $this->load->view('pages/upload_form', $page_data);
            return;
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

