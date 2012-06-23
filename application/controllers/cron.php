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
 * ------------------------------------------------------------------------------ */

class Cron extends CI_Controller {

//=================================================================================
// :private vars
//=================================================================================

    private $seperator = "\r\n//=================================================================================\r\n";


//=================================================================================
// :public
//=================================================================================

    /**
     * public construct
     */
    public function __construct()
    {
        // init parent
        parent::__construct();

        // loads

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
            $this->header($method);
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
        // print the top seperator
        print $this->seperator . PHP_EOL;

        // start the output here
        $this->printy("Sorry, this function is not yet coded");

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
        // print the top seperator
        print $this->seperator . PHP_EOL;

        // start the output here
        $this->printy("Sorry, this function is not yet coded");

        // print the bottom seperator
        print $this->seperator . PHP_EOL;
    }
    //------------------------------------------------------------------


    /**
     * public lic()
     */
    public function lic()
    {
        // print the top seperator
        print $this->seperator . PHP_EOL;

        // start the output here
        print("/**
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


//=================================================================================
// :private
//=================================================================================

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