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

class Cron extends CI_Controller {

//=================================================================================
// :private vars
//=================================================================================

    private $seperator = "\r\n//===============================================================================\r\n";
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
     * public construct
     */
    public function __construct()
    {
        // init parent
        parent::__construct();

        // loads
        $this->load->model('cron_model');   /* database */
        $this->load->library('cronmail');   /* email    */

        // // check if we are within CLI
        // if( !$this->input->is_cli_request() )
        //     die("Hello, is it me you're looking for?");
    }
    //------------------------------------------------------------------


    /**
     * public remap
     */
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            // print the license
            $this->lic();

            // print the header
            $this->header($method);

            // do the requested function
            return call_user_func_array(array($this, $method), $params);
        }
        $this->e404_notFound();
    }
    //------------------------------------------------------------------


    /**
     * public takeOutTheTrash()
     * this function is used to do the nightly cleanup via the cron task
     * it delete's the files that were deleted 30 days ago
     */
    public function takeOutTheTrash()
    {
        // get the delete information
        $toDelete = $this->cron_model->deleted_uploads();

        // do we have any files to delete?
        if (!$toDelete)
        {
            $this->printy("There were no files that were deleted more than 30 days ago...");
            print $this->seperator . PHP_EOL;
            return;
        }

        // count the total files to be deleted
        $count = $toDelete->num_rows();

        // start the output here
        $this->printy("Starting the removal of files that were deleted more than 30 days ago...");
        $this->printy("There are a total of {$count} files that will be removed.");
        $this->printy(PHP_EOL);

        // delete the files
        foreach ($toDelete->result() as $row)
        {
            // $this->printy("[" . $row->id . "]" . $row->file_name . " - " . $row->full_path);
            if ( file_exists( $row->full_path ) && unlink( $row->full_path ) )
                $this->printy("[" . $row->id . "]" . $row->file_name . " has been removed." . PHP_EOL);
            else
                $this->printy("Error removing file - " . $row->full_path . PHP_EOL);
        }
        $this->printy(PHP_EOL);


        // delete from the database
        $sqlDelete = $this->cron_model->cleanup_uploads();
        $this->printy($sqlDelete . " uploads have been removed from the database.");

        // print the bottom seperator
        print $this->seperator . PHP_EOL;
    }
    //------------------------------------------------------------------


    /**
     * public inactiveMembers()
     * this function is used to do the nightly members check via the cron task
     * it will check to see if a member registered over 30 days ago and re-send the activation email
     * it will also remove members and owls that were not activated and are over 90 days old
     */
    public function inactiveMembers()
    {
        // fetch the inactive members lists
        $inactive_members   = $this->cron_model->inactive_users(30);    /* these are the members we are re-sending activation to                */
        $deleted_members    = $this->cron_model->inactive_users(60);    /* these are the members we are deleteing and removing the owls from    */

        // do we have any inactive members (30 days)?
        if (!$inactive_members)
            $this->printy("There are no inactive members from within 30 days ago...");

        // do we have any inactive members (60 days)?
        if (!$deleted_members)
            $this->printy("There are no inactive members from within 60 days ago...");

        // if we have 0 inactive members then were done for today...
        if (!$inactive_members && !$deleted_members)
        {
            print $this->seperator . PHP_EOL;
            return;
        }

        //------------------------------------------------------------------
        // ok so if you are still here, lets get to work
        //------------------------------------------------------------------

        // count the total files to be deleted
        $inactiveCount  = !$inactive_members ? 0 : $inactive_members->num_rows();
        $deleteCount    = !$deleted_members ? 0 : $deleted_members->num_rows();

        // start the output here
        $this->printy(PHP_EOL);
        $this->printy("Lets start by sending out emails to the inactive members...");
        $this->printy("There are a total of {$inactiveCount} emails to be sent today.");
        $this->printy(PHP_EOL);

        // send out the emails to every member
        if ($inactiveCount > 0)
        {
            // setup the count
            $count = 0;

            foreach ($inactive_members->result() as $row)
            {
                // setup the vars
                $email_count    = ($count++) . ' of ' . $inactiveCount;
                $user_id        = $row->id;
                $username       = $row->user_name;
                $email          = $row->user_email;
                $auth_code      = $row->user_activation;

                // some output
                $this->printy("Sending reminder {$email_count}");
                $this->printy("\t[" . $user_id . "] " . $username . " - " . $email . " - " . $auth_code);

                // send the email
                if ( $this->cronmail->resend_authcode( $username, $email, $auth_code ) )
                    $this->printy("\tEmail successfully sent." . PHP_EOL);
                else
                    $this->printy("\tError sending email..." . PHP_EOL);
            }
            $this->printy(PHP_EOL);
        }

        $this->printy("Now lets cleanup the inactive members (over 60 days)...");
        $this->printy("There are a total of {$deleteCount} users to delete today.");
        $this->printy(PHP_EOL);
        // remove the inactive members
        if ($deleteCount > 0)
        {
            // setup the counts
            $owl_deleted_count  = 0;

            foreach ($deleted_members->result() as $row)
            {
                // setup the vars
                $user_id = $row->id;
                $cleanup = $this->cron_model->cleanup_owls($user_id);

                // if this user is an admin of an inactive owl, remove it
                if ( $cleanup )
                    $owl_deleted_count++;

                // do the database cleanup
                $removed = !$this->cron_model->cleanup_users() ? 0 : $this->cron_model->cleanup_users()->num_rows();
            }
            $this->printy($removed . " users were successfully deleted.");
            $this->printy($owl_deleted_count . " associated owls were also deleted.");
        }

        // print the bottom seperator
        print $this->seperator . PHP_EOL;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================

    /**
     * private lic()
     */
    private function lic()
    {
        print("
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
 * files (the \"Software\"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * 
 * ------------------------------------------------------------------------------
 */" . PHP_EOL . PHP_EOL);
    }
    //------------------------------------------------------------------


    /**
     * private e404_notFound()
     * this function is used when an invalid function is called...
     */
    private function e404_notFound()
    {
        print "Error 404 - Not Found!" . PHP_EOL;
    }
    //------------------------------------------------------------------


    /**
     * private header()
     * this function is used to print our the cron head. Date/Time and function ran
     *
     * @param function - this is the function name that we are running
     */
    private function header($function = 'N/A')
    {
        print $this->seperator;
        print "// :FUNCTION \t\"" . $function . "\"\r\n";
        print "// :DATE/TIME\t" . date(DATE_RFC822);
        print $this->seperator . PHP_EOL;
    }
    //------------------------------------------------------------------


    /**
     * private printy()
     * this is used to do the nice output for the cron
     *
     * @param string - this is the string we wish to print
     */
    private function printy($string = FALSE)
    {
        if( !$string )
            return FALSE;

        print "\t" . $string . PHP_EOL;
    }


}

// eof.