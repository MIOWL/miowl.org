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
    public function get_owl_categories($owl = FALSE, $include_default = TRUE, $offset = 0, $limit = FALSE, $count = FALSE)
    {
        $this->db->select('*');

        if ($include_default) {
            $this->db->where('owl', '0');
            if ($owl != FALSE)
                $this->db->or_where('owl', $owl);
        }

        else {
            if ($owl != FALSE)
            {
                $this->db->where('owl', $owl);
            }
            else
                return FALSE;
        }

        $this->db->order_by("owl", "ASC");
        $this->db->order_by("parent_id", "ASC");
        $this->db->order_by("name", "ASC");
        if (!$limit)
            $query = $this->db->get('categories');
        else
            $query = $this->db->get('categories', $limit, $offset);

        if ($query->num_rows() > 0)
            if ($count)
                return $this->db->count_all_results();
            else
                return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_categories()
     */
    public function count_owl_categories($owl = FALSE, $include_default = TRUE)
    {
        return $this->get_owl_categories($owl, $include_default, 0, FALSE, TRUE);
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
     * public get_roots()
     * get root categories
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
     * public get_children()
     * get our parent cat's children
     */
    public function get_children($owl = FALSE, $pid = '0')
    {
        return $this->get_roots($owl, $pid);
    }
    //------------------------------------------------------------------


    /**
     * public in_use()
     * is this cat in use?
     */
    public function in_use($id = FALSE)
    {
        if (!$id)
            return FALSE;

        // does the cat have children?
        $this->db->where('parent_id', $id);
        $query = $this->db->get('categories');
        if ($query->num_rows() > 0)
            return TRUE;

        // does the cat have files inside it?
        $this->db->where('upload_category', $id);
        $query = $this->db->get('uploads');
        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


}

// eof.