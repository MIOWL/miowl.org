<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owl_model extends CI_Model {


    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public activate_user()
     * function will activate an owl via their emailed code
     *
     * @param string $owl_activation - the users activation code
     */
    public function activate_owl($owl_activation)
    {
        if (!$owl_activation)
            return FALSE;

        $where = array(
            'owl_active'       => 'no',
            'owl_activation'   => $owl_activation
        );

        $update_data = array(
            'owl_active'       => 'yes',
            'owl_activation'   => ''
        );

        $this->db->select('owl_email');
        $this->db->where($where);
        $query = $this->db->get('owls');
        $email = $query->row()->owl_email;

        $this->db->where($where);
        $this->db->update('owls', $update_data);

        return $email;
    }
    //------------------------------------------------------------------


    /**
     * public new_email()
     */
    public function new_email($old_email, $new_email)
    {
        if (!$old_email || !$new_email)
            return FALSE;

        $where = array(
            'id'        => $this->session->userdata('owl'),
            'owl_email' => $old_email
        );

        $update_data = array(
            'owl_email'       => $new_email,
            'owl_email_old'   => $old_email
        );

        $this->db->where($where);
        $this->db->update('owls', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public add_reset_data()
     * function add the reset data to the database for autherization later
     *
     * @param string $user_name         - the users name
     * @param string $user_email        - the users email address
     * @param string $owl_activation   - the users activation code
     */
    public function add_reset_data($user_name, $user_email, $owl_activation)
    {
        if (!$user_name || !$user_email  || !$owl_activation)
            return FALSE;

        $where = array(
            'user_name'         => $user_name,
            'user_email'        => $user_email
        );

        $update_data = array(
            'owl_activation'   => $owl_activation
        );

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public auth_reset()
     * function will authenticate users password change request via their emailed code
     *
     * @param string $owl_activation   - the users activation code
     * @param string $user_password     - the users new password
     * @param string $user_salt         - the users new salt
     */
    public function auth_reset($owl_activation, $user_password, $user_salt)
    {
        if (!$owl_activation)
            return FALSE;

        $update_data = array(
            'owl_active'       => 'yes',
            'owl_activation'   => '',
            'user_salt'         => $user_salt,
            'user_password'     => $user_password
        );

        $this->db->where('owl_activation', $owl_activation);
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
    public function add_owl($name = FALSE, $acronym = FALSE, $type = FALSE, $address = FALSE, $province = FALSE, $city = FALSE, $zip = FALSE, $tel = FALSE, $www = FALSE, $user_id = FALSE, $email = FALSE, $activation = FALSE)
    {
        if (!$name || !$acronym || !$type || !$address || !$province || !$city || !$zip || !$user_id || !$email || !$activation)
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
            'owl_admin_uid'     => $user_id,
            'owl_email'         => $email,
            'owl_activation'    => $activation
        );

        $this->db->insert('owls', $insert_data);

        return $this->db->insert_id();
    }
    //------------------------------------------------------------------


    /**
     * public update_owl()
     */
    public function update_owl()
    {
        $update_data = array(
            'owl_name'          => $this->input->post('name'),
            'owl_name_short'    => $this->input->post('acronym'),
            'owl_type'          => $this->input->post('type'),
            'owl_address'       => $this->input->post('address'),
            'owl_province'      => $this->input->post('province'),
            'owl_city'          => $this->input->post('city'),
            'owl_post_code'     => $this->input->post('zip'),
            'owl_tel'           => $this->input->post('tel'),
            'owl_site'          => $this->input->post('site')
        );

        $this->db->where('id', $this->session->userdata('owl'));
        $this->db->update('owls', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public choose_owl()
     */
    public function choose_owl($user_id = FALSE, $user_owl_id = FALSE, $is_admin = FALSE)
    {
        if (!$user_id || !$user_owl_id)
            return FALSE;

        $where = array(
            'id'                    => $user_id
        );

        if (!$is_admin) {
            $update_data = array(
                'user_owl_id'       => $user_owl_id
            );
        }
        else {
            $update_data = array(
                'user_owl_id'       => $user_owl_id,
                'user_admin'        => 'true',
                'user_editor'       => 'true',
                'user_owl_verified' => 'true'
            );
        }

        $this->db->where($where);
        $this->db->update('users', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public get_all_owl_info_except()
     */
    public function get_all_owl_info_except($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id !=', $owl_id);
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
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
     * public get_owl_by_type()
     * function will pull needed owl info based on the passed string owl type.
     *
     * @param string $owl_type - owl type (clinic/hospital)
     */
    public function get_owl_by_type($owl_type = 'both')
    {
        $this->db->select('*');

        if ($owl_type != 'both')
            $this->db->where('owl_type', $owl_type);

        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_owl_by_province()
     * function will pull needed owl info based on the passed string province.
     *
     * @param string $province - owl province
     */
    public function get_owl_by_province($province = FALSE)
    {
        if (!$province)
            return FALSE;

        $this->db->select('*');
        $this->db->where('owl_province', $province);
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


    /**
     * public get_owl_name()
     * function will return the Owl Name via the Owl ID.
     *
     * @param int $owl_id           - owl id
     */
    public function get_owl_name($owl_id = FALSE)
    {
        if (!$owl_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $owl_id);
        $query = $this->db->get('owls');

        if ($query->num_rows() > 0)
            return $query->row()->owl_name;
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
            $this->db->where('owl_activation', $auth_code);
        else
            $this->db->where(array('owl_activation' => $auth_code, 'owl_active' => 'no'));

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
