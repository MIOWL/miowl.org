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

class Lic_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================


//=================================================================================
// :public functions
//=================================================================================

    /**
     * public add_license()
     */
    public function add_new( $insert_data = FALSE )
    {
        if ( !is_editor() )
            return FALSE;

        $this->db->insert('license', $insert_data);
        return $this->db->insert_id();
    }
    //------------------------------------------------------------------


    /**
     * public fix_id()
     * fix_id the license URL
     */
    public function fix_id($id = FALSE, $url = FALSE)
    {
        if ( !is_editor() )
            return FALSE;

        if ( !$id || !$url )
            return FALSE;

        $this->db->set('url', $url);
        $where = array(
            'id'    => $id,
            'owl'   => $this->session->userdata('owl')
        );
        $this->db->where($where);
        $this->db->update('license');

        if ($this->db->affected_rows() > 0)
           return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


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
     * public get_license()
     */
    public function get_license($id = FALSE)
    {
        if (!$id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('license');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public count_owl_licenses()
     */
    public function count_owl_licenses($owl = FALSE)
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
     * public in_use()
     * is this cat in use?
     */
    public function in_use($id = FALSE)
    {
        if (!$id)
            return FALSE;

        // does the cat have files attached to it?
        $this->db->where('upload_license', $id);
        $query = $this->db->get('uploads');
        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public edit()
     * edit the license
     */
    public function edit($id = FALSE, $name = FALSE, $desc = FALSE, $url = FALSE)
    {
        // setup the return data
        $return = array();
        $return['success']  = FALSE;
        $return['id']       = $id;
        $return['name']     = $name;
        $return['desc']     = $desc;
        $return['url']      = $url;

        if ( !is_editor() )
            return FALSE;

        if ( !$id || !$name || !$desc || !$url )
            return $return;

        $this->db->set('name', $name);
        $this->db->set('short_description', $desc);
        $this->db->set('url', $url);
        $where = array(
            'id'    => $id,
            'owl'   => $this->session->userdata('owl')
        );
        $this->db->where($where);
        $this->db->update('license');

        if ($this->db->affected_rows() > 0)
           $return['success'] = TRUE;

        return $return;
    }
    //------------------------------------------------------------------


    /**
     * public delete()
     * remove the lic
     */
    public function delete($id = FALSE)
    {
        if ( !is_editor() )
            return FALSE;

        if (!$id)
            return FALSE;

        if($this->in_use($id))
            return FALSE;

        if( !(( $data = $this->get_license( $id ) )) )
            return FALSE;

        $this->db->where('id', $id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->delete('license');

        if ($this->db->affected_rows() > 0)
            return $data->row();

        return FALSE;
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
        $license_file = file(realpath(APPPATH . 'licenses.csv'));
        foreach ($license_file as $license)
        {
            // get the 3 elements from the string
            list($name, $short_description, $url) = explode(',', $license);

            // add the elements in an array to the insert array
            $default_categories[] = array(
                'name'              => $name,
                'short_description' => $short_description,
                'url'               => $url,
                'owl'               => $owl
            );
        }

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