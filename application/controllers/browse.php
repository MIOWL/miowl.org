<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends CI_Controller {

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
        if (!$this->login_check('browse'))
            return;

        $page_data = array();
        $page_data['page_title'] = 'File Browser';


        #$uploads = $this->upload_model->get_amount(100);
        $uploads = $this->upload_model->get_all_uploads();
        $this->load->library('table');
        $tmpl = array (
                            'table_open'          => '<table width="100%" cellspacing="0" cellpadding="4" border="1">',

                            'heading_row_start'   => '<tr>',
                            'heading_row_end'     => '</tr>',
                            'heading_cell_start'  => '<th>',
                            'heading_cell_end'    => '</th>',

                            'row_start'           => '<tr>',
                            'row_end'             => '</tr>',
                            'cell_start'          => '<td>',
                            'cell_end'            => '</td>',

                            'row_alt_start'       => '<tr>',
                            'row_alt_end'         => '</tr>',
                            'cell_alt_start'      => '<td>',
                            'cell_alt_end'        => '</td>',

                            'table_close'         => '</table>'
                      );
        $this->table->set_template($tmpl);
        $this->table->set_heading('ID', 'Timestamp (GMT)', 'Filename', 'Catagory', 'File Type', 'Owl');
        $this->table->set_empty("N/A");

        if($uploads)
        {
            foreach($uploads->result() as $row)
            {
                $timestamp = date("H:i:s d/m/Y", $row->upload_time);

                $this->table->add_row(
                                        $row->id,
                                        $timestamp,
                                        $row->file_name,
                                        $row->upload_catagory,
                                        $row->file_type,
                                        $row->owl
                                    );
            }
        }

        $page_data['table'] = $this->table->generate();

        $this->load->view('pages/browse', $page_data);
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
