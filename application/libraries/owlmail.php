<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

class owlmail {

//=================================================================================
// :private vars
//=================================================================================

    // private CI Object
    private $obj = NULL;


//=================================================================================
// :public functions
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
        $subject = 'MI OWL | Confirm your OWL';

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
        $subject = 'MI OWL | New Administrator Email';

        // Send the email
        $email = "{$old_email}, {$new_email}";
        $this->send_email($email, $subject, $email_data);
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
        $subject = 'MI OWL | Welcome OWL';

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
        $subject = 'MI OWL | OWL Chosen';

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
        $subject = 'MI OWL | New User Request';

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
        $subject = 'MI OWL | OWL Accepted';

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
    public function send_owl_deny($username = FALSE, $owl = FALSE, $email = FALSE)
    {
        if (!$username || !$owl || !$email)
            return FALSE;

        // Build up the email output
        $data = array(
            'username'  => $username,
            'owl'       => $owl,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);    // Add email header
        $email_data .= $this->obj->parser->parse('email/owl_deny.tpl', $data, TRUE);            // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', NULL, TRUE);    // Add the email footer

        // Email Subject
        $subject = 'MI OWL | OWL Denied';

        // Send the email
        return $this->send_email($email, $subject, $email_data);
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
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
        $config['useragent']    = 'MI OWL';
        $config['mailtype']     = 'html';
        $config['validate']     = TRUE;
        $this->obj->email->initialize($config);

        // Setup the email
        $this->obj->email->from('no-reply@miowl.com', 'MI OWL');
        $this->obj->email->to($email);

        $this->obj->email->subject($subject);
        $this->obj->email->message($data);

        return $this->obj->email->send();
    }
    //------------------------------------------------------------------


}

// eof.