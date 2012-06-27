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

    private $seperator = "\r\n//=================================================================================\r\n";
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
        $this->load->model('cron_model');

        // check if we are within CLI
        if( !$this->input->is_cli_request() )
            die("Hello, is it me you're looking for?");
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
        if (!$toDelete) {
            $this->printy("There were no files that were deleted more than 30 days ago...");
            print $this->seperator . PHP_EOL;
            return;
        }

        // count the total files to be deleted
        $count = $toDelete->num_rows();

        // start the output here
        $this->printy("Starting the removal of files that were deleted more than 30 days ago...");
        $this->printy("");
        $this->printy("There are a total of {$count} files that will be removed.");
        $this->printy("");

        // delete the files
        foreach ($toDelete->result() as $row)
        {
            // $this->printy("[" . $row->id . "]" . $row->file_name . " - " . $row->full_path);
            if ( file_exists( $row->full_path ) && unlink( $row->full_path ) )
                $this->printy("[" . $row->id . "]" . $row->file_name . " has been removed." . PHP_EOL);
            else
                $this->printy("Error removing file - " . $row->full_path . PHP_EOL);
        }
        $this->printy("");

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
        // start the output here
        $this->printy("Sorry, this function is not yet coded");

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