<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MI OWL                                                     (v1) | codename dave
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

class Search_model extends CI_Model {

//=================================================================================
// :private vars
//=================================================================================

    private $units = array(
        "year"   => 29030400, // seconds in a year   (12 months)
        "month"  => 2419200,  // seconds in a month  (4 weeks)
        "week"   => 604800,   // seconds in a week   (7 days)
        "day"    => 86400,    // seconds in a day    (24 hours)
        "hour"   => 3600,     // seconds in an hour  (60 minutes)
        "minute" => 60,       // seconds in a minute (60 seconds)
        "second" => 1         // 1 second
    );

    // This is the sort/grouping we will use accross the whole search
    private $order_by = array('owls.owl_name', 'categories.parent_id', 'categories.id', 'uploads.file_type', 'license.name');


//=================================================================================
// :public functions
//=================================================================================

    /**
     * public search_all()
     */
    public function search_all($keyword = FALSE, $offset = 0, $limit = 7, $where = array())
    {
        if (!$keyword)
            return FALSE;

        return $this->search($keyword, $offset, $limit, $where);
    }
    //------------------------------------------------------------------


//=================================================================================
// :private functions
//=================================================================================

    /**
     * private search()
     */
    private function search($keyword = NULL, $offset = 0, $limit = FALSE, $having = FALSE)
    {
        // what do we want?
        $this->db->select('
                owls.id AS owl_id,
                owls.owl_name,
                owls.owl_name_short,
                owls.owl_type AS owl_type,
                owls.owl_province AS owl_province,
                categories.parent_id AS cat_pid,
                categories.id AS cat_id,
                categories.name AS cat_name,
                uploads.id AS up_id,
                uploads.file_type,
                uploads.file_name,
                uploads.description,
                uploads.file_ext,
                license.id AS lic_id,
                license.name AS lic_name,
                license.url AS lic_url
            ');

        // join the tables by the id's
        $this->db->join('users', 'uploads.upload_user = users.id', 'inner');
        $this->db->join('owls', 'uploads.owl = owls.id', 'inner');
        $this->db->join('categories', 'uploads.upload_category = categories.id', 'inner');
        $this->db->join('license', 'uploads.upload_license = license.id', 'inner');

        // find by keyword
        $this->db->like('uploads.file_name', $keyword);
        $this->db->or_like('uploads.description', $keyword);

        // don't show deleted files
        $this->db->where('uploads.deleted', 'false');

        if($having) {
            if(isset($having['owl_type']))
                $this->db->having('owl_type', $having['owl_type']);

            if(!empty($having['owl_province']))
            {
                $i=0;
                foreach ($having['owl_province'] as $value) {
                    if($i != '0')
                        $this->db->or_having('owl_province', $value);
                    else
                        $this->db->having('owl_province', $value);
                    $i++;
                }
            }

            if(!empty($having['cat']))
            {
                $i=0;
                foreach ($having['cat'] as $value) {
                    if($i != '0')
                        $this->db->or_having('cat_id', $value);
                    else
                        $this->db->having('cat_id', $value);
                    $i++;
                }
            }

            $i=0;
            foreach ($having['owl_id'] as $value) {
                if($i != '0')
                    $this->db->or_having('owl_id', $value);
                else
                    $this->db->having('owl_id', $value);
                $i++;
            }
        }

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


//=================================================================================
// :private functions
//=================================================================================


}

// eof.
