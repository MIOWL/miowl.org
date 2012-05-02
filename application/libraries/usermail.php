<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usermail {


    //=================================================================================
    // :private vars
    //=================================================================================


    // private CI Object
    private $obj = NULL;


    //=================================================================================
    // :public
    //=================================================================================


    public function __construct()
    {
        // fetch ci object
        $this->obj =& get_instance();
    }
    //------------------------------------------------------------------


    /**
     * public auth_code
     * function to send out a registration auth code
     *
     * @return bool
     */
    public function send_authcode($username = FALSE, $email = FALSE, $auth_code = FALSE, $new_owl = FALSE, $owl_name = NULL)
    {
        if (!$username || !$email || !$auth_code)
            return FALSE;

        // Build up the email output
        $data = array(
            'username' => $username,
            'authcode' => $auth_code,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', '', TRUE);  // Add email header
        $email_data .= $this->obj->parser->parse('email/auth_email.tpl', $data, TRUE);      // Build the email body
        
        if ($new_owl)  // New Owl
            $email_data .= $this->obj->parser->parse('email/owl_new.tpl', NULL, TRUE);
        else  // Chosen Owl
            $email_data .= $this->obj->parser->parse('email/owl_chosen.tpl', array('owl' => $owl_name), TRUE);
        
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);  // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Confirm your Account';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public welcome
     * function to send out the welcome email after successful registration
     *
     * @return bool
     */
    public function send_welcome($username = FALSE, $email = FALSE)
    {
        if (!$username || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username' => $username,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', '', TRUE);  // Add email header
        $email_data .= $this->obj->parser->parse('email/welcome_email.tpl', $data, TRUE);   // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);  // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Welcome';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public forgot_pass
     * function to send out a forgot pass email
     *
     * @return bool
     */
    public function send_forgotpass($username = FALSE, $email = FALSE, $authcode = FALSE, $ip = FALSE)
    {
        if (!$username || !$authcode || !$ip)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
            'email'     => $email,
            'authcode' => $authcode,
            'ip'        => $ip
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', '', TRUE);      // Add email header
        $email_data .= $this->obj->parser->parse('email/forgot_pass_email.tpl', $data, TRUE);   // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);      // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Password Reset';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public lockout
     * function to send out an account lockout email
     *
     * @return bool
     */
    public function send_lockout($username = FALSE, $email = FALSE)
    {
        if (!$username || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username' => $username,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', '', TRUE);  // Add email header
        $email_data .= $this->obj->parser->parse('email/lockout_email.tpl', $data, TRUE);   // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);  // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Account Lockout';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


    /**
     * private send_email
     * function to send the email
     *
     * @return bool
     */
    private function send_email($email = FALSE, $subject = FALSE, $data = FALSE)
    {
        if (!$email || !$subject || !$data)
            return FALSE;

        // Setup the email
        $this->obj->email->from('no-reply@miowl.com', 'MiOWL');
        $this->obj->email->to($email);

        $this->obj->email->subject($subject);
        $this->obj->email->message($data);

        return $this->obj->email->send();
    }
    //------------------------------------------------------------------


    /**
     * private valid_email
     * This function checks if the email is correctly structured and if the domain name exists based on MX records.
     *
     * @return bool
     */
    private function valid_email($email = FALSE,  $test_mx = FALSE)
    {
        if (!$email)
            return FALSE;

        if (eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+) * (\.[a-z]{2,4})$", $email))
        {
            if ($test_mx)
            {
                list( $username, $domain ) = split( "@", $email);
                return (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'));
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    //------------------------------------------------------------------


}

