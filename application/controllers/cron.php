<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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


//=================================================================================
// :private
//=================================================================================

    /**
     * private header()
     * this function is used to print our the cron head. Date/Time and function ran
     */
    private function header($function = 'N/A')
    {
        print $this->seperator;
        print "// :FUNCTION \t\"" . $function . "\"\r\n";
        print "// :DATE/TIME\t" . date(DATE_RFC822);
    }
    //------------------------------------------------------------------


    /*
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