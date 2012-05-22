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
    public function get_owl_categories($owl_id = FALSE, $include_default = TRUE, $parent_id = FALSE)
    {
        $this->db->select('*');

        if ($include_default) {
            if ($parent_id != FALSE)
                    $this->db->where('parent_id', $parent_id);

            $this->db->where('owl_id', '0');

            if ($owl_id != FALSE)
                $this->db->or_where('owl_id', $owl_id);
        }

        else {
            if ($owl_id != FALSE)
            {
                if ($parent_id != FALSE)
                    $this->db->where('parent_id', $parent_id);

                $this->db->where('owl_id', $owl_id);
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
            'owl_id'    => $this->session->userdata('owl')
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
        if (!$owl)
            $owl = $this->session->userdata('owl');

        $this->db->order_by("id", "ASC");
        $this->db->where('parent_id', $pid);
        $query = $this->db->get('categories');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * get our parent cat's children()
     */
    public function get_children($pid, $owl = FALSE)
    {
        return $this->get_roots($owl, $pid);
    }
    //------------------------------------------------------------------


}
