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

class Cron_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================

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
     * public deleted_uploads()
     * this function is used to get uploads that were deleted over 30 days ago
     *
     * @return object - the database query object
     */
    public function deleted_uploads()
    {
        $this->db->select('*');
        $this->db->having("deleted", "true");
        $this->db->where("remove_timestamp <=", ( time() - $this->units['month'] ) );
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public cleanup_uploads()
     * this function is used to delete uploads that were deleted over 30 days ago
     *
     * @return int - the number of deleted uploads
     */
    public function cleanup_uploads()
    {
        $this->db->having("deleted", "true");
        $this->db->where("remove_timestamp <=", ( time() - $this->units['month'] ) );
        $this->db->delete('uploads');

        return $this->db->affected_rows();
    }
    //------------------------------------------------------------------


    /**
     * public inactive_users()
     * this function is used to get users who have not activated after given $days
     *
     * @param $days - this is the number of days we want to check (default 30)
     * @return object - the database query object
     */
    public function inactive_users($days = 30)
    {
        $this->db->select('*');
        $this->db->having("user_active", "no");
        $this->db->where("user_registration_date", ( time() - ( $days * $this->units['day'] ) ) );
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public cleanup_users()
     * this function is used to delete users who have not activated after 60 days
     *
     * @return int - the number of deleted users
     */
    public function cleanup_users()
    {
        $this->db->having("user_active", "no");
        $this->db->where("user_registration_date <=", ( time() - ( $this->units['month'] * 2 ) ) );
        $this->db->delete('users');

        return $this->db->affected_rows();
    }
    //------------------------------------------------------------------


    /**
     * public cleanup_owls()
     * this function is used to delete owls who have not activated with the given ADMIN UID
     *
     * @param $user_id - this is the admin user id that we want to check the owl of
     * @return bool
     */
    public function cleanup_owls($user_id = FALSE)
    {
        if (!$user_id)
            return FALSE;

        $this->db->having("owl_active", "no");
        $this->db->where("owl_admin_uid", $user_id;
        $this->db->delete('owls');

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