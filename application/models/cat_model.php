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

class Cat_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================


//=================================================================================
// :public functions
//=================================================================================

    /**
     * public get_owl_categories()
     */
    public function get_owl_categories($owl = FALSE, $include_default = TRUE, $offset = 0, $limit = FALSE)
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
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public count_owl_categories()
     */
    public function count_owl_categories($owl = FALSE, $include_default = TRUE)
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
        $this->db->from('categories');
        return $this->db->count_all_results();
    }
    //------------------------------------------------------------------


    /**
     * public add_category()
     */
    public function add_category( $insert_data = FALSE, $owl_create = FALSE )
    {
        if ( !$owl_create && !is_editor() )
            return FALSE;

        if( !$insert_data )
        {
            $insert_data = array(
                'name'      => $this->input->post('name'),
                'parent_id' => $this->input->post('sub_category'),
                'owl'       => $this->session->userdata('owl')
            );
        }

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
    public function get_roots($owl = FALSE, $pid = '0', $no_owl = FALSE)
    {
        if ($owl === FALSE)
            $owl = $this->session->userdata('owl');

        $this->db->order_by("id", "ASC");
        $this->db->where('parent_id', $pid);

        if(!$no_owl)
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
    public function get_children($owl = FALSE, $pid = '0', $no_owl = FALSE)
    {
        return $this->get_roots($owl, $pid, $no_owl);
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


    /**
     * public delete()
     * remove the cat
     */
    public function delete($id = FALSE)
    {
        if ( !is_editor() )
            return FALSE;

        if (!$id)
            return FALSE;

        if($this->in_use($id))
            return FALSE;

        $this->db->where('id', $id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->delete('categories');

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public edit()
     * edit the cat
     */
    public function edit($id = FALSE, $name = FALSE, $subcat = FALSE)
    {
        // setup the return data
        $return = array();
        $return['success']  = FALSE;
        $return['id']       = $id;
        $return['name']     = $name;
        $return['subcat']   = $subcat;

        if ( !is_editor() )
            return FALSE;

        if (!$id || !$name)
            return $return;

        if (!$subcat)
            $subcat = '0';

        $this->db->set('name', $name);
        $this->db->set('parent_id', $subcat);
        $where = array(
            'id'    => $id,
            'owl'   => $this->session->userdata('owl')
        );
        $this->db->where($where);
        $this->db->update('categories');

        if ($this->db->affected_rows() > 0)
           $return['success'] = TRUE;

        return $return;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================


}

// eof.
