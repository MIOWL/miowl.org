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

class User_model extends CI_Model {

//=================================================================================
// :public functions
//=================================================================================

    /**
     * public get_owls()
     */
    public function get_owls($user_id = FALSE)
    {
        if (!$user_id)
            $user_id = $this->session->userdata('user_id');

        $this->db->select('*');
        $this->db->where('user', $user_id);
        $query = $this->db->get('owl_users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_user_by_id()
     * function will pull needed user info based on the passed int user id.
     *
     * @param int $user_id - user id
     */
    public function get_user_by_id($user_id)
    {
        if (!$user_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_user_by_username()
     */
    public function get_user_by_username($username)
    {
        if (!$username)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_name', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_all_users()
     * function will get all user info for all users
     */
    public function get_all_users()
    {
        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_unverified_users()
     * function will get all user info for all unverified users
     */
    public function get_unverified_users()
    {
        $this->db->select('*');
        $this->db->where('user_active', 'no');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_user()
     * function will get needed user info via the passed username or email address
     *
     * @param string $user_name - this can be the user's username OR email address.
     */
    public function get_user($user_name = FALSE)
    {
        if (!$user_name)
            return FALSE;

        $this->db->select('*');
        $this->db->where('user_name', $user_name);
        $this->db->or_where('user_email', $user_name);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public add_user()
     * function will begin the user registration process, and will add the user into the database,
     * however users will still need to confirm their email address.
     *
     * @param string $user_name - requested username
     * @param string $user_password - users password sha1 hashed with salt
     * @param string $user_email - users email address
     * @param string $user_salt - randomly generated user salt
     * @param string $user_activation - the randomly generated user activation code
     */
    public function add_user($user_name = FALSE, $user_password = FALSE, $user_email = FALSE, $user_salt = FALSE, $user_activation = FALSE, $firstname = FALSE, $lastname = FALSE, $owl_id = FALSE)
    {
        if (!$user_name || !$user_password || !$user_email || !$user_salt || !$user_activation || !$firstname || !$lastname || !$owl_id)
            return FALSE;

        if ($owl_id == 'new')   // Are we looking at a user with no Owl?
            $owl_id = 0;        // 0 means that the user has no owl.

        $insert_data = array(
            'user_name'                 => $user_name,
            'user_first_name'           => $firstname,
            'user_last_name'            => $lastname,
            'user_email'                => $user_email,
            'user_salt'                 => $user_salt,
            'user_password'             => $user_password,
            'user_activation'           => $user_activation,
            'user_registration_date'    => time()
        );

        // add the user to the users table
        $this->db->insert('users', $insert_data);

        // add the user to the owl_users database
        $this->db->insert('owl_users', array('user' => $this->db->insert_id(), 'owl' => $owl_id));
    }
    //------------------------------------------------------------------


    /**
     * public activate_user()
     * function will activate a users account via their emailed code
     *
     * @param string $user_activation - the users activation code
     */
    public function activate_user($user_activation)
    {
        if (!$user_activation)
            return FALSE;

        $where = array(
            'user_active'       => 'no',
            'user_activation'   => $user_activation
        );

        $update_data = array(
            'user_active'       => 'yes',
            'user_activation'   => ''
        );

        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('users');

        $this->db->where($where);
        $this->db->update('users', $update_data);

        return $query;
    }
    //------------------------------------------------------------------


    /**
     * public add_reset_data()
     * function add the reset data to the database for autherization later
     *
     * @param string $user_name         - the users name
     * @param string $user_email        - the users email address
     * @param string $user_activation   - the users activation code
     */
    public function add_reset_data($user_name, $user_email, $user_activation)
    {
        if (!$user_name || !$user_email  || !$user_activation)
            return FALSE;

        $where = array(
            'user_name'         => $user_name,
            'user_email'        => $user_email
        );

        $update_data = array(
            'user_activation'   => $user_activation
        );

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public auth_reset()
     * function will authenticate users password change request via their emailed code
     *
     * @param string $user_activation   - the users activation code
     * @param string $user_password     - the users new password
     * @param string $user_salt         - the users new salt
     */
    public function auth_reset($user_activation, $user_password, $user_salt)
    {
        if (!$user_activation)
            return FALSE;

        $update_data = array(
            'user_active'       => 'yes',
            'user_activation'   => '',
            'user_salt'         => $user_salt,
            'user_password'     => $user_password
        );

        $this->db->where('user_activation', $user_activation);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public login_time()
     * function will set last login time
     *
     * @param string $user - the username
     */
    public function login_time($user)
    {
        $this->db->set('user_lastlogin', time());
        $this->db->where('user_name', $user);
        $this->db->update('users');
    }
    //------------------------------------------------------------------


    /**
     * public promote()
     * function will promote the user to a given group
     *
     * @param string $group   - the users activation code
     * @param string $user_id     - the users new password
     * @return bool
     */
    public function promote($group = FALSE, $user_id = FALSE)
    {
        // is this an admin requesting it??
        if(!is_admin())
            return FALSE;

        // whats the user group?
        switch ( $group )
        {
            case 'admin':
                $update_data = array(
                    'admin'    => 'true',
                    'editor'   => 'true'
                );
                break;

            case 'editor':
                $update_data = array(
                    'admin'    => 'false',
                    'editor'   => 'true'
                );
                break;

            default:
                $group = FALSE;
                break;
        }

        if (!$group || !$user_id)
            return FALSE;

        $this->db->where('user', $user_id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->update('owl_users', $update_data);

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public demote()
     * function will demote the user from a given group
     *
     * @param string $group   - the users activation code
     * @param string $user_id     - the users new password
     * @return bool
     */
    public function demote($group = FALSE, $user_id = FALSE)
    {
        // is this an admin requesting it??
        if(!is_admin())
            return FALSE;

        // whats the user group?
        switch ( $group )
        {
            case 'admin':
                $update_data = array(
                    'admin'    => 'false',
                    'editor'   => 'true'
                );
                break;

            case 'editor':
                $update_data = array(
                    'admin'    => 'false',
                    'editor'   => 'false'
                );
                break;

            default:
                $group = FALSE;
                break;
        }

        if (!$group || !$user_id)
            return FALSE;

        $this->db->where('user', $user_id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->update('owl_users', $update_data);

        if ($this->db->affected_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


//=================================================================================
// :validation callbacks
//=================================================================================

    /**
     * public validate_authcode()
     * function will return a bool value if the auth code is valid and the user acccount
     * needs to be adcivated.
     *
     * @param string $auth_code  - user auth code
     * @param string $pass_reset - are we checking a password reset?
     */
    public function validate_authcode($auth_code, $pass_reset = FALSE)
    {
        $this->db->select('id');

        if ($pass_reset)
            $this->db->where('user_activation', $auth_code);
        else
            $this->db->where(array('user_activation' => $auth_code, 'user_active' => 'no'));

        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public validate_username()
     * function will make sure that the provided username does NOT already exists, and will return a
     * bool value. FALSE if the username does exists, TRUE otherwise.
     *
     * @param string $user_name - username to validate.
     */
    public function validate_username($user_name)
    {
        $this->db->select('id');
        $this->db->where('user_name', $user_name);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return FALSE;

        return TRUE;
    }
    //------------------------------------------------------------------


    /**
     * public validate_email()
     * function will check and make sure the provided email does not already exists in our database.
     * will then return a bool value, FALSE if the email does exists, TRUE otherwise.
     *
     * @param string $user_email - email to validate.
     */
    public function validate_email($user_email)
    {
        $this->db->select('id');
        $this->db->where('user_email', $user_email);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return FALSE;

        return TRUE;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================


}

// eof.