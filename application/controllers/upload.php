<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MiOWL                                                     (v1) | codename dave
 *
 * ------------------------------------------------------------------------------
 *
 * Copyright (c) 2012, Alan Wynn
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * ------------------------------------------------------------------------------
 */

class Upload extends CI_Controller {

//=================================================================================
// :private vars
//=================================================================================


//=================================================================================
// :public functions
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
        // do we need to login??
        if (!$this->login_check('upload'))
            return;

        // what are the allowed file types? [seperate via pipe (|)]
        $file_types = 'txt|rtf|pdf|doc|docx';

        $config['upload_path']      = './uploads/';
        $config['allowed_types']    = $file_types;
        $config['max_size']         = '102400000'; // 10MB
        $config['encrypt_name']     = TRUE;

        // setup the page_data array and add in some data
        $page_data = array();
        $page_data['allow_types'] = str_replace('|', ', ', $file_types);
        $page_data['license'] = $this->miowl_model->get_license();

        $this->load->library('upload', $config);

        // form validation rules
        $this->form_validation->set_rules('filename', 'File Name', 'trim');
        $this->form_validation->set_rules('category', 'Upload Category', 'trim|required');
        $this->form_validation->set_rules('license', 'Upload License', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('revDate', 'Revision Date', 'trim');

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

                $revDate            = $this->input->post('revDate') == ""
                                        ? NULL
                                        : strtotime($this->input->post('revDate'));

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
                            $description,
                            $revDate
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


     /**
     * public lic()
     */
    public function lic()
    {
        // do we need to login??
        if (!$this->login_check('upload-lic'))
            return;

        print '<pre>' . print_r($this->input->post(), true) . '</pre>';

        // what are the allowed file types? [seperate via pipe (|)]
        $file_types = 'txt|rtf|pdf|doc|docx';

        $config['upload_path']      = './user_license_files/';
        $config['allowed_types']    = $file_types;
        $config['max_size']         = '102400000'; // 10MB
        $config['encrypt_name']     = TRUE;

        // setup the page_data array and add in some data
        $page_data = array();
        $page_data['allow_types'] = str_replace('|', ', ', $file_types);

        $this->load->library('upload', $config);

        // form validation rules
        $this->form_validation->set_rules('name', 'License Name', 'trim|required');
        $this->form_validation->set_rules('description', 'License Short Description', 'trim');

        if($this->input->post('link') === 'link')
            $this->form_validation->set_rules('url', 'External URL to License File', 'trim|required|prep_url|callback_valid_url');

        if($this->form_validation->run())
        {
            if ( $this->input->post('uploader') === 'uploader' )
            {
                if ( !$this->upload->do_upload() )
                {
                    $page_data['page_title'] = 'Upload Failure';
                    $page_data['error'] = TRUE;
                    $page_data['msg'] = trim($this->upload->display_errors());

                    $this->load->view('pages/upload_lic_form', $page_data);
                }
                else
                {
                    $upload_data = $this->upload->data();

                    $name               = $this->input->post('name');
                    $owl                = $this->session->userdata('owl');
                    $short_description  = str_replace(array("\r\n","\r","\n"), '\n', trim($this->input->post('description')));
                    $lic_id             = '-=changeme=-';
                    $file_ext           = $upload_data['file_ext'];
                    $url                = '/download/lic/' . $lic_id . '/' . $name .  $file_ext;
                    $local_file         = $upload_data['full_path'];

                    // add the lic and get the auto increment id
                    $lic_id = $this->lic_model->add_new( array(
                        'name'              => $name,
                        'short_description' => $short_description,
                        'url'               => $url,
                        'local_file'        => $local_file,
                        'owl'               => $owl,
                    ) );

                    // update that url with the correct id if we uploaded a local file
                    $this->lic_model->fix_id($lic_id, $url);

                    $page_data['page_title'] = 'License Upload Success';
                    $page_data['upload_data'] = $upload_data;

                    // Success Message
                    $page_data['success']     = TRUE;
                    $page_data['msg']         = "License Upload Successful, upload another?";

                    $this->load->view('pages/upload_lic_form', $page_data);
                }
            }
            else
            {
                $name               = $this->input->post('name');
                $owl                = $this->session->userdata('owl');
                $short_description  = str_replace(array("\r\n","\r","\n"), '\n', trim($this->input->post('description')));
                $url                = $this->form_validation->prep_url($this->input->post('url'));
                $local_file         = 'false';

                // add the lic and get the auto increment id
                $this->lic_model->add_new( array(
                    'name'              => $name,
                    'short_description' => $short_description,
                    'url'               => $url,
                    'local_file'        => $local_file,
                    'owl'               => $owl,
                ) );

                $page_data['page_title'] = 'License Install Success';
                $page_data['upload_data'] = $upload_data;

                // Success Message
                $page_data['success']     = TRUE;
                $page_data['msg']         = "License Install Successful, upload another?";

                $this->load->view('pages/upload_lic_form', $page_data);
            }
        }
        else
        {
            $page_data['page_title'] = 'Upload New License';
            $this->load->view('pages/upload_lic_form', $page_data);
        }
    }
    //------------------------------------------------------------------


//=================================================================================
// :validation callbacks
//=================================================================================

    /**
     * public valid_url()
     */
    public function valid_url( $str = FALSE )
    {
        if( !$str )
            return FALSE;

        $str = $this->form_validation->prep_url($str);

        if( filter_var( $str, FILTER_VALIDATE_URL ) )
            return TRUE;

        $this->form_validation->set_message('valid_url', 'Invalid URL entered');
        return FALSE;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
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

// eof.