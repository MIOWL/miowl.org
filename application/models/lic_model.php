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

class Lic_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================


//=================================================================================
// :public functions
//=================================================================================

    /**
     * public get_owl_licenses()
     */
    public function get_owl_licenses($owl = FALSE, $offset = 0, $limit = FALSE)
    {
        $this->db->select('*');

        if (!$owl)
            $owl = $this->session->userdata('owl');

        $this->db->where('owl', $owl);
        $this->db->order_by("name", "ASC");

        if (!$limit)
            $query = $this->db->get('license');
        else
            $query = $this->db->get('license', $limit, $offset);

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_licenses()
     */
    public function get_owl_licenses($owl = FALSE)
    {
        $this->db->select('*');

        if (!$owl)
            $owl = $this->session->userdata('owl');

        $this->db->where('owl', $owl);
        $this->db->from('license');
        return $this->db->count_all_results();
    }
    //------------------------------------------------------------------


    /**
     * public insert_defaults()
     */
    public function insert_defaults($owl = FALSE)
    {
        if (!$owl)
            return FALSE;

        // the main array
        $default_categories = array();

        /**
         * #############################
         * || the individual licenses ||
         * #############################
         * name                 = license name
         * short_description    = license description
         * url                  = license link
         * owl                  = the owl id
         */
        $default_categories[] = array(
            'name'              => 'GPL 3.0',
            'short_description' => 'GNU General Public License, version 3',
            'url'               => 'http://www.opensource.org/licenses/gpl-3.0.html',
            'owl'               => $owl
        );
        $default_categories[] = array(
            'name'              => 'BSD',
            'short_description' => 'The BSD 3 Clause License',
            'url'               => 'http://www.opensource.org/licenses/BSD-3-Clause',
            'owl'               => $owl
        );
        $default_categories[] = array(
            'name'              => 'LGPL 3.0',
            'short_description' => 'GNU Lesser General Public License, version 3.0',
            'url'               => 'http://www.opensource.org/licenses/lgpl-3.0.html',
            'owl'               => $owl
        );
        $default_categories[] = array(
            'name'              => 'MIT',
            'short_description' => 'MIT License',
            'url'               => 'http://www.opensource.org/licenses/MIT',
            'owl'               => $owl
        );

        $this->db->insert_batch('license', $default_categories);

        if ($this->db->affected_rows() > 0)
           return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================


}

// eof.