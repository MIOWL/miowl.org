<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owl_model extends CI_Model {


    //=================================================================================
    // :public
    //=================================================================================


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

        $this->db->where($where);
        $this->db->update('users', $update_data);
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
     * public add_owl()
     * function will begin the owl registration process, and will add the owl into the database,
     * however users will still need to confirm their owl email address.
     *
     * @param string $name          - Organization Name
     * @param string $acronym       - Organization Acronym
     * @param string $type          - Owl Type (Clinic/Hospital)
     * @param string $address       - 1st line of address
     * @param string $province      - Province
     * @param string $city          - City
     * @param string $zip           - Postal Code
     * @param string $tel           - Telephone Number      (OPTIONAL)
     * @param string $www           - Website               (OPTIONAL)
     * @param string $email         - Administrator Email
     * @param string $activation    - Activation Code
     */
    public function add_owl($name = FALSE, $acronym = FALSE, $type = FALSE, $address = FALSE, $province = FALSE, $city = FALSE, $zip = FALSE, $tel = FALSE, $www = FALSE, $email = FALSE, $activation = FALSE)
    {
        if (!$name || !$acronym || !$type || !$address || !$province || !$city || !$zip || !$email || !$activation)
            return FALSE;

        $insert_data = array(
            'owl_name'          => $name,
            'owl_name_short'    => $acronym,
            'owl_type'          => $type,
            'owl_address'       => $address,
            'owl_province'      => $province,
            'owl_city'          => $city,
            'owl_post_code'     => $zip,
            'owl_tel'           => $tel,
            'owl_site'          => $www,
            'owl_email'         => $email,
            'owl_activation'    => $activation
        );

        $this->db->insert('owls', $insert_data);

        return "'".$this->db->insert_id()."'";
    }
    //------------------------------------------------------------------


    /**
     * public choose_owl()
     */
    public function choose_owl($user_id = FALSE, $user_owl_id = FALSE)
    {
        if (!$user_id || !$user_owl_id)
            return FALSE;

        $where = array(
            'id'       => $user_id
        );

        $update_data = array(
            'user_owl_id'   => $user_owl_id
        );

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_by_id()
     * function will pull needed owl info based on the passed int owl id.
     *
     * @param int $owl_id           - owl id
     */
    public function get_owl_by_id($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $owl_id);
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_by_email()
     */
    public function get_owl_by_email($email = FALSE)
    {
        if (!$email)
            return FALSE;

        $this->db->select('*');
        $this->db->where('owl_email', $email);
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_all_owls()
     * function will get all owl info for all owls
     *
     * @param int $inc_unverified   - Include Unverified Owls
     */
    public function get_all_owls($inc_unverified = FALSE)
    {
        $this->db->select('*');

        if(!$inc_unverified)
            $this->db->where('owl_active', 'yes');

        $this->db->order_by("id", "ASC");
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_unverified_owls()
     * function will get all owl info for all unverified owls
     */
    public function get_unverified_owls()
    {
        $this->db->select('*');
        $this->db->where('owl_active', 'no');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
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

        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}
