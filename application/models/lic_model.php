<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lic_model extends CI_Model {

    /*******************************************************************
     * PRIVATE VARS
     *******************************************************************/



    /*******************************************************************
     * PUBLIC FUNCTIONS
     *******************************************************************/

    /**
     * public get_owl_licenses()
     */
    public function get_owl_licenses($owl = FALSE)
    {
        $this->db->select('*');

        // if ($owl != FALSE)
        //     $this->db->where('owl', $owl);
        // else
        //     return FALSE;

        $this->db->order_by("id", "ASC");
        $query = $this->db->get('license');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


}
