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

class Welcome extends CI_Controller {

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
        if ($this->session->userdata('owl_verified')) {
            redirect('/', 'location');
            return;
        }

        $page_data = array();
        $page_data['page_title'] = 'Medical Interprofessional Open-source Web-based Libraries';
        $this->load->view('pages/welcome_message', $page_data);
    }
    //------------------------------------------------------------------


    /**
     * public about()
     */
    public function about()
    {
        $page_data = array();
        $page_data['page_title'] = 'About';
        $this->load->view('pages/about', $page_data);
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================


}

// eof.