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
     * this function is used to do the nightly cleanup via the cron task.
     * it delete's the files that were deleted 30 days ago
     */
    public function takeOutTheTrash()
    {
        print "Sorry, this function is not yet coded";
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :private
    //=================================================================================


}

// eof.