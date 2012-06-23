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

class Cat_model extends CI_Model {

/*******************************************************************
 * PRIVATE VARS
 *******************************************************************/


/*******************************************************************
 * PUBLIC FUNCTIONS
 *******************************************************************/

    /**
     * public get_owl_categories()
     */
    public function get_owl_categories($owl = FALSE, $include_default = TRUE, $parent_id = FALSE)
    {
        $this->db->select('*');

        if ($include_default) {
            if ($parent_id != FALSE)
                    $this->db->where('parent_id', $parent_id);

            $this->db->where('owl', '0');

            if ($owl != FALSE)
                $this->db->or_where('owl', $owl);
        }

        else {
            if ($owl != FALSE)
            {
                if ($parent_id != FALSE)
                    $this->db->where('parent_id', $parent_id);

                $this->db->where('owl', $owl);
            }
            else
                return FALSE;
        }

        $this->db->order_by("id", "ASC");
        $query = $this->db->get('categories');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public add_category()
     */
    public function add_category()
    {
        $insert_data = array(
            'name'      => $this->input->post('name'),
            'parent_id' => $this->input->post('sub_category'),
            'owl'    => $this->session->userdata('owl')
        );

        $this->db->insert('categories', $insert_data);

        return $this->db->insert_id();
    }
    //------------------------------------------------------------------


    /**
     * public get_category()
     */
    public function get_category($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('categories');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * get root categories funciton()
     */
    public function get_roots($owl = FALSE, $pid = '0')
    {
        if ($owl === FALSE)
            $owl = $this->session->userdata('owl');

        $this->db->order_by("id", "ASC");
        $this->db->where('parent_id', $pid);
        $this->db->having('owl', $owl);
        $query = $this->db->get('categories');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * get our parent cat's children()
     */
    public function get_children($owl = FALSE, $pid = '0')
    {
        return $this->get_roots($owl, $pid);
    }
    //------------------------------------------------------------------


}

// eof.