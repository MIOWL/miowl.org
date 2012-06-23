<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

    //=================================================================================
    // :private vars
    //=================================================================================



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
     * public takeOutTheTrash()
     * this function is used to do the nightly cleanup via the cron task
     * it delete's the files that were deleted 30 days ago
     */
    public function takeOutTheTrash()
    {
        print "Sorry, this function is not yet coded".PHP_EOL;
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
        print "Sorry, this function is not yet coded".PHP_EOL;
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}

// eof.