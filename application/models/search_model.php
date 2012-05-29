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

    // This is the sort/grouping we will use accross the whole search
    private $order_by = array('owls.owl_name', 'categories.parent_id', 'categories.id', 'uploads.file_type', 'license.name');
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


    /**
     * public search_uploads()
     */
    public function search_uploads($keyword = FALSE, $offset = 0, $limit = FALSE, $where = array())
    {
        if (!$keyword)
            return FALSE;

        // what do we want?
        $this->db->select('*');

        // find by keyword
        $this->db->like('file_name', $keyword);
        $this->db->or_like('client_name', $keyword);
        $this->db->or_like('description', $keyword);

        // don't show deleted files
        $this->db->where('deleted', 'false');

        // if extra where items are set, include them
        if(!empty($where))
            $this->db->where($where);

        // group the data
        $this->db->group_by($this->group_by);

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


    //=================================================================================
    // :PRIVATE FUNCTIONS
    //=================================================================================


    /**
     * private search()
     */
    private function search($keyword = NULL, $offset = 0, $limit = FALSE, $where = array())
    {
        // what do we want?
        $this->db->select('
                categories.id,
                categories.name,
                categories.parent_id,
                owls.id,
                owls.owl_name,
                owls.owl_name_short,
                users.id,
                users.user_name,
                uploads.id,
                uploads.file_type,
                uploads.client_name,
                uploads.file_ext,
                license.id,
                license.name,
                license.url,
                users.user_name,
                users.user_first_name,
                users.user_last_name
            ');

        // join the tables by the id's
        $this->db->join('users', 'uploads.upload_user = users.id', 'inner');
        $this->db->join('owls', 'uploads.owl = owls.id', 'inner');
        $this->db->join('categories', 'uploads.upload_category = categories.id', 'inner');
        $this->db->join('license', 'uploads.upload_license = license.id', 'inner');

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

        // order the data
        foreach ($this->order_by as $sort) {
            $this->db->order_by($sort, 'ASC');
        }

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


}
