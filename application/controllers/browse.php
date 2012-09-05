<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MI OWL                                                     (v1) | codename dave
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

class Browse extends CI_Controller {

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
    public function index($offset = 0, $limit = 10)
    {
        // Do we need to login??
        #if (!$this->login_check('browse'))
        #    return;

        $page_data = array();
        $page_data['page_title'] = 'File Browser';
        $page_data['data'] = $this->upload_model->get_all_uploads(FALSE, $limit, $offset);

        // setup pagination lib
        $config['base_url']         = site_url('browse/index');
        $config['total_rows']       = $this->upload_model->total_uploads();
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('pages/browse', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public owl()
     */
    public function owl($owl = FALSE, $offset = 0, $limit = 10)
    {
        $page_data = array();
        $page_data['page_title'] = 'File Browser | by OWL (' . $this->owl_model->get_owl_by_id($owl)->row()->owl_name . ')';
        $page_data['browse_by_owl'] = TRUE;
        $page_data['data'] = $this->upload_model->get_upload_by_owl($owl, $limit, $offset);

        // setup pagination lib
        $config['base_url']         = site_url('browse/owl/' . $owl);
        $config['uri_segment']      = 4;
        $config['total_rows']       = $this->upload_model->total_owl_uploads($owl);
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('pages/browse', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public cat()
     */
    public function cat($cat = FALSE, $offset = 0, $limit = 10)
    {
        $page_data                  = array();
        $page_data['page_title']    = 'File Browser | by category (' . $this->cat_model->get_category($cat)->row()->name . ')';
        $page_data['browse_by_cat'] = TRUE;
        $page_data['data']          = $this->upload_model->get_upload_by_cat(get_cat_children_arr($cat), $limit, $offset);

        print '<pre>' . $this->db->last_query() . '</pre>';

        // setup pagination lib
        $config['base_url']         = site_url('browse/cat/' . $cat);
        $config['uri_segment']      = 4;
        $config['total_rows']       = $this->upload_model->total_cat_uploads(get_cat_children_arr($cat));
        $config['per_page']         = $limit;
        $config['anchor_class']     = 'class="button" ';
        $config['cur_tag_open']     = '&nbsp;<div class="button danger current">';
        $config['cur_tag_close']    = '</div>';

        // init pagination
        $this->pagination->initialize($config);

        // load our view
        $this->load->view('pages/browse', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public download()
     */
    public function download($file_id = FALSE)
    {
        if(!$file_id)
            redirect(site_url(), 'location');

        // Get the file info for this ID
        $upload_info = $this->upload_model->get_upload_by_id($file_id);

        // Check the file has an ext, if not add it.
        $file_name = $upload_info->row()->file_name;
        $file_ext  = $upload_info->row()->file_ext;
        if (!$this->endswith($file_name, $file_ext))
            $file_name = $file_name . $file_ext;

        $data = array();
        $data['file_path'] = $upload_info->row()->full_path;
        $data['file_name'] = $file_name;
        $this->load->view('pages/download_file', $data);
    }
    //------------------------------------------------------------------


    /**
     * public download_lic()
     */
    public function download_lic($lic_id = FALSE, $file_name = FALSE)
    {
        if(!$lic_id)
            redirect(site_url(), 'location');

        // Get the file info for this ID
        $lic_info = $this->lic_model->get_license($lic_id);

        // Check the file has an ext, if not add it.
        $data = array();
        $data['file_path'] = $lic_info ? $lic_info->row()->local_file : '';
        $data['file_name'] = $file_name;
        $this->load->view('pages/download_file', $data);
    }
    //------------------------------------------------------------------


    /**
     * public info()
     */
    public function info($file_id = FALSE, $deleted = FALSE)
    {
        if(!$file_id)
            redirect(site_url(), 'location');

        // Get the file info for this ID
        $upload_info = $this->upload_model->get_upload_by_id($file_id, $deleted);

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "File Info | " . $upload_info->row()->file_name;
        $page_data['upload_info']   = $upload_info;
        $page_data['deleted']       = $deleted;

        if( ( !is_null( $upload_info->row()->revision_date ) ) && ( time() >= $upload_info->row()->revision_date ) )
        {
            $page_data['info']      = TRUE;
            $nbsp                   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $page_data['msg']       = "This file needs to be reviewed!\n<br />\n{$nbsp}Review date was <strong>" . date("d/m/Y", $upload_info->row()->revision_date) . "</strong>";

            // TODO: Email admin members about review
        }

        // load the approp. page view
        $this->load->view('pages/file_info', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public info_edit()
     */
    public function info_edit($file_id = FALSE, $deleted = FALSE)
    {
        if( !$file_id || !is_editor() )
            redirect(site_url(), 'location');

        // Get the file info for this ID
        $upload_info = $this->upload_model->get_upload_by_id($file_id, $deleted);

        // is this your file?
        if( $this->session->userdata('owl') !== $upload_info->row()->owl )
            redirect(site_url(), 'location');

        // page data array
        $page_data                  = array();
        $page_data['page_title']    = "File Info Editor | " . $upload_info->row()->file_name;
        $page_data['upload_info']   = $upload_info;
        $page_data['deleted']       = $deleted;
        $page_data['license_data']  = $this->lic_model->get_owl_licenses();

        if( ( !is_null( $upload_info->row()->revision_date ) ) && ( time() >= $upload_info->row()->revision_date ) )
        {
            $page_data['info']      = TRUE;
            $nbsp                   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $page_data['msg']       = "This file needs to be reviewed!\n<br />\n{$nbsp}Review date was <strong>" . date("d/m/Y", $upload_info->row()->revision_date) . "</strong>";

            // TODO: Email admin members about review
        }

        // load the approp. page view
        $this->load->view('pages/file_info_edit', $page_data);
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


    /**
     * private endswith()
     *
     * This function is used to check if a string ends with another string
     *
     * @param $string - This is the string we are wanting to check against
     * @param $test   - This is the string we wish to find in $string
     *
     * @return bool
     */
    private function endswith($string, $test)
    {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) return false;
        return substr_compare($string, $test, -$testlen) === 0;
    }
    //------------------------------------------------------------------


}

// eof.
