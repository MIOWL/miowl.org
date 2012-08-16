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

class Cronmail {

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
     * public auth_code
     * function to send out a registration auth code
     *
     * @return bool
     */
    public function resend_authcode($username = FALSE, $email = FALSE, $auth_code = FALSE)
    {
        if (!$username || !$email || !$auth_code)
            return FALSE;

        // Build up the email output
        $data = array(
            'username' => $username,
            'authcode' => $auth_code,
        );

        $email_data  = $this->obj->load->view('email/head_foot/email_head.tpl', NULL, TRUE);        // Add email header
        $email_data .= $this->obj->parser->parse('email/cron/resend_activation.tpl', $data, TRUE);  // Build the email body
        $email_data .= $this->obj->load->view('email/head_foot/email_foot.tpl', '', TRUE);          // Add the email footer

        // Email Subject
        $subject = 'MI OWL | Confirm your Account';

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

// eof.