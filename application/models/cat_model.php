<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

        print $owl;

        $this->db->order_by("id", "ASC");
        $this->db->where('parent_id', $pid);
        $this->db->having('owl', $owl);
        $query = $this->db->get('categories');

        print '<pre>' . print_r($this->db->last_query(), TRUE) . '</pre>';

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
