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

class Miowl_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================

    private $extend_error = NULL;

    private $units = array(
        "year"   => 29030400, // seconds in a year   (12 months)
        "month"  => 2419200,  // seconds in a month  (4 weeks)
        "week"   => 604800,   // seconds in a week   (7 days)
        "day"    => 86400,    // seconds in a day    (24 hours)
        "hour"   => 3600,     // seconds in an hour  (60 minutes)
        "minute" => 60,       // seconds in a minute (60 seconds)
        "second" => 1         // 1 second
    );


//=================================================================================
// :public functions
//=================================================================================

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
        $this->db->having('user_owl_verified', 'true');
        $this->db->having('user_admin', 'true');
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
        $this->db->having('user_owl_verified', 'true');
        $this->db->having('user_editor', 'true');
        $this->db->or_having('user_admin', 'true');
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
        $this->db->having('user_owl_verified', 'true');
        $this->db->having('user_admin', 'false');
        $this->db->having('user_editor', 'false');
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
        $this->db->having('user_owl_verified', 'false');
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
            'user_owl_id'   => $owl_id
        );
        $this->db->where($where);
        $this->db->update('users');

        if ($this->db->affected_rows() > 0)
            return TRUE;

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


//=================================================================================
// :private functions
//=================================================================================


}

// eof.