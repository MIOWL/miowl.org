<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class owlmail {


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
     * public send_activation
     * function to send out an activation code
     *
     * @return bool
     */
    public function send_activation($username = FALSE, $email = FALSE, $auth_code = FALSE)
    {
        if (!$username || !$email || !$auth_code)
            return FALSE;

        // Build up the email output
        $data = array(
            'username' => $username,
            'authcode' => $auth_code,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_activation.tpl', $data, TRUE);      // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Confirm your Owl';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public notification
     * function to send out a notification email to old and new administrator
     *
     * @return bool
     */
    public function send_notification($username = FALSE, $old_email = FALSE, $new_email = FALSE)
    {
        if (!$username || !$old_email || !$new_email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
            'old_email' => $old_email,
            'new_email' => $new_email
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_notification.tpl', $data, TRUE);      // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | New Administrator Email';

        // Email addresses
        $email = "{$old_email}; {$new_email}";

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public send_owl_welcome
     * function to send out the welcome email after successful activation
     *
     * @return bool
     */
    public function send_owl_welcome($email = FALSE)
    {
        if (!$email)
            return FALSE;

        // Build up the email output
        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', '', TRUE);      // Add email header
        $email_data .= $this->obj->load->view('email/owl_welcome_email.tpl', NULL, TRUE);       // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);      // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Welcome Owl';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public send_chosen
     * function to send out an activation code
     *
     * @return bool
     */
    public function send_chosen($username = FALSE, $owl = FALSE, $email = FALSE)
    {
        if (!$username || !$owl || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
            'owl'       => $owl,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_chosen.tpl', $data, TRUE);          // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Owl Chosen';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public inform_admin
     */
    public function inform_admin($username = FALSE, $email = FALSE)
    {
        if (!$username || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_admin_inform.tpl', $data, TRUE);    // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | New User Request';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public send_owl_accepted
     * function to send out an email to inform that the user has been accepted into the owl
     *
     * @return bool
     */
    public function send_owl_accepted($username = FALSE, $owl = FALSE, $email = FALSE)
    {
        if (!$username || !$owl || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
            'owl'       => $owl,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_accepted.tpl', $data, TRUE);        // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Owl Accepted';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


    /**
     * public send_owl_deny
     * function to send out an activation code
     *
     * @return bool
     */
    public function send_owl_deny($username = FALSE, $owl = FALSE, $reason = FALSE, $email = FALSE)
    {
        if (!$username || !$owl || !$email)
            return FALSE;

        if (!$reason || $reason == NULL)
            $reason = "No reason given...";

        // Build up the email output
        $data = array(
            'username'  => $username,
            'owl'       => $owl,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_deny.tpl', $data, TRUE);            // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MiOWL | Owl Denied';

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

        // Configure and initialize the email function
        $config = array();
        $config['useragent']    = 'MiOwl';
        $config['mailtype']     = 'html';
        $config['validate']     = TRUE;
        $this->obj->email->initialize($config);

        // Setup the email
        $this->obj->email->from('no-reply@miowl.com', 'MiOWL');
        $this->obj->email->to($email);

        $this->obj->email->subject($subject);
        $this->obj->email->message($data);

        return $this->obj->email->send();
    }
    //------------------------------------------------------------------


}

