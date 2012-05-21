<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miowl_model extends CI_Model {

    /*******************************************************************
     * PRIVATE VARS
     *******************************************************************/

    private $extend_error = NULL;

    private $units = array
                      (
                       "year"   => 29030400, // seconds in a year   (12 months)
                       "month"  => 2419200,  // seconds in a month  (4 weeks)
                       "week"   => 604800,   // seconds in a week   (7 days)
                       "day"    => 86400,    // seconds in a day    (24 hours)
                       "hour"   => 3600,     // seconds in an hour  (60 minutes)
                       "minute" => 60,       // seconds in a minute (60 seconds)
                       "second" => 1         // 1 second
                      );

    //------------------------------------------------------------------


    /*******************************************************************
     * PUBLIC FUNCTIONS
     *******************************************************************/

    /**
     * public get_owl_admin()
     */
    public function get_owl_admin($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('owl_admin_uid');
        $this->db->where('id', $owl_id);
        $query = $this->db->get('owls');

        if ($query->num_rows() < 1)
            return FALSE;

        //-------------------------------//

        $this->db->select('*');
        $this->db->where('id', $query->row()->owl_admin_uid);
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_members()
     */
    public function get_owl_members($owl_id = FALSE, $inclue_inactive = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);

        if (!$inclue_inactive)
            $this->db->where('user_owl_verified', 'true');

        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_admin_members()
     */
    public function get_owl_admin_members($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);
        $this->db->where('user_owl_verified', 'true');
        $this->db->where('user_admin', 'true');
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_editor_members()
     */
    public function get_owl_editor_members($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);
        $this->db->where('user_owl_verified', 'true');
        $this->db->where('user_admin', 'true');
        $this->db->or_where('user_editor', 'true');
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_user_members()
     */
    public function get_owl_user_members($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);
        $this->db->where('user_owl_verified', 'true');
        $this->db->where('user_admin', 'false');
        $this->db->where('user_editor', 'false');
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_unverified_members()
     */
    public function get_owl_unverified_members($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_owl_id', $owl_id);
        $this->db->where('user_owl_verified', 'false');
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public owl_accept_member()
     */
    public function owl_accept_member($owl_id = FALSE, $user_id = FALSE)
    {
        if (!$owl_id || !$user_id)
            return FALSE;

        $this->db->set('user_owl_verified', 'true');
        $where = array(
            'id'                => $user_id,
            'user_owl_id'       => $owl_id,
            'user_owl_verified' => 'false'
        );
        $this->db->where($where);
        $this->db->update('users');

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public owl_deny_member()
     */
    public function owl_deny_member($owl_id = FALSE, $user_id = FALSE)
    {
        if (!$owl_id || !$user_id)
            return FALSE;

        $this->db->set('user_owl_verified', 'false');
        $this->db->set('user_owl_id', 0);
        $where = array(
            'id'            => $user_id,
            'user_owl_id'   => $owl_id,
        );
        $this->db->where($where);
        $this->db->update('users');

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_categories()
     */
    public function get_owl_categories($owl_id = FALSE, $include_default = TRUE, $parent_id = FALSE)
    {
        $this->db->select('*');

        if ($include_default) {
            $this->db->where('owl_id', '0');

            if ($parent_id)
                    $this->db->where('parent_id', $parent_id);

            if ($owl_id != FALSE)
                $this->db->or_where('owl_id', $owl_id);
        }

        else {
            if ($owl_id != FALSE)
            {
                $this->db->where('owl_id', $owl_id);

                if ($parent_id)
                    $this->db->where('parent_id', $parent_id);
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
     * public get_license()
     */
    public function get_license($id = FALSE)
    {
        $this->db->select('*');

        if ($id)
            $this->db->where('id', $id);

        $query = $this->db->get('license');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


}
