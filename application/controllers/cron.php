<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

//=================================================================================
// :private vars
//=================================================================================

    private $seperator = "\r\n============================================================================\r\n\r\n";


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
    public function _remap($method)
    {
        $this->header($method);
    }
    //------------------------------------------------------------------


    /**
     * public takeOutTheTrash()
     * this function is used to do the nightly cleanup via the cron task
     * it delete's the files that were deleted 30 days ago
     */
    public function takeOutTheTrash()
    {
        print $this->seperator;
        print "Sorry, this function is not yet coded" . PHP_EOL;
        print $this->seperator;
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
        print $this->seperator;
        print "Sorry, this function is not yet coded" . PHP_EOL;
        print $this->seperator;
    }
    //------------------------------------------------------------------


//=================================================================================
// :private
//=================================================================================

    /**
     * public header()
     * this function is used to print our the cron head. Date/Time and function ran
     */
    private function header($function = 'N/A')
    {
        print $this->seperator;
        print "==    FUNCTION : \t\t\t" . $function . " \t\t\t ==" . PHP_EOL;
        print "== DATE - TIME : \t\t\t" . date(DATE_RFC822) . " \t\t\t ==" . PHP_EOL;
    }
    //------------------------------------------------------------------


}

// eof.