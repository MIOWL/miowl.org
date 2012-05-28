<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

    /*******************************************************************
     * PRIVATE VARS
     *******************************************************************/

    private $units = array(
        "year"   => 29030400, // seconds in a year   (12 months)
        "month"  => 2419200,  // seconds in a month  (4 weeks)
        "week"   => 604800,   // seconds in a week   (7 days)
        "day"    => 86400,    // seconds in a day    (24 hours)
        "hour"   => 3600,     // seconds in an hour  (60 minutes)
        "minute" => 60,       // seconds in a minute (60 seconds)
        "second" => 1         // 1 second
    );

    //------------------------------------------------------------------


    /*******************************************************************
     * PUBLIC FUNCTIONS
     *******************************************************************/

    /**
     * public search_all()
     */
    public function search_all($keyword = FALSE)
    {
        if (!$keyword)
            return FALSE;

        return $this->search($keyword);
    }
    //------------------------------------------------------------------


    //=================================================================================
    // :PRIVATE FUNCTIONS
    //=================================================================================


    /**
     * private search()
     */
    private function search($keyword = NULL, $offset = 0, $limit = FALSE, $where = array())
    {
        // what do we want?
        $this->db->select('uploads.*, owls.*, users.*, license.*, categories.*');

        // join the tables by the id's
        $this->db->join('uploads', 'uploads.upload_user = users.id');
        $this->db->join('uploads u1', 'u1.owl = owl.id');
        $this->db->join('uploads u2', 'u2.upload_category = categories.id');
        $this->db->join('uploads u3', 'u3.upload_license = license.id');

        // find by keyword
        $this->db->like('owls.owl_name', $keyword);
        $this->db->or_like('owls.owl_name_short', $keyword);
        $this->db->or_like('categories.name', $keyword);
        $this->db->or_like('uploads.file_type', $keyword);
        $this->db->or_like('license.name', $keyword);
        $this->db->or_like('license.short_description', $keyword);

        // don't show deleted files
        $this->db->where('uploads.deleted', 'false');

        // if extra where items are set, include them
        if(!empty($where))
            $this->db->where($where);

        // group the data
        $this->db->group_by(array('uploads.owl', 'uploads.upload_category', 'uploads.file_type', 'uploads.upload_license'));

        // fetch this thing
        if($limit != FALSE)
            $query = $this->db->get('uploads', $limit, $offset);
        else
            $query = $this->db->get('uploads');

        // do we have any results?
        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * search_saves()
     */
    public function search_saves($keyword, $limit = 15, $offset = 0)
    {
        $this->db->select('savesdb.id, savesdb.uid, savesdb.title_id, savesdb.title_save, savesdb.title_name, savesdb.save_file, savesdb.save_oname, savesdb.save_desc, savesdb.save_size, savesdb.date_added, savesdb.uploaded_by, savesdb.downloads, savesdb.rating, savesdb.`status`, users.user_name, users.user_alias');
        $this->db->join('users', 'savesdb.uploaded_by = users.id', 'inner');
        $this->db->like('savesdb.title_save', $keyword);
        $this->db->or_like('savesdb.title_id', $keyword);
        $this->db->or_like('savesdb.title_id_int', $keyword);
        $this->db->or_like('savesdb.title_name', $keyword);
        $this->db->or_like('savesdb.save_file', $keyword);
        $this->db->or_like('users.user_name', $keyword);
        $this->db->or_like('users.user_alias', $keyword);
        $this->db->order_by('savesdb.date_added', 'desc');
        $query = $this->db->get('savesdb', $limit, $offset);

        if ($query->num_rows() > 0)
            return $query;

        return FALSE;
    }
    // -------------------------------------------------------------------------------
    
    
}
