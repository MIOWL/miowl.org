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

class Upload_model extends CI_Model {

//=================================================================================
// :public functions
//=================================================================================

    /**
     * public get_upload_by_id()
     * function will pull needed upload info based on the passed int upload id.
     *
     * @param int $upload_id - upload id
     */
    public function get_upload_by_id($upload_id, $deleted = FALSE)
    {
        if (!$upload_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $upload_id);
        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_ext()
     */
    public function get_upload_by_ext($ext, $deleted = FALSE)
    {
        if (!$ext)
            return FALSE;

        $this->db->select('*');
        $this->db->where('file_ext', '.' . $ext);
        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_cat()
     */
    public function get_upload_by_cat($cat = FALSE, $limit = 15, $offset = 0)
    {
        if (!$cat)
            return FALSE;

        $this->db->select('*');
        $this->db->where('upload_category', $cat);
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads', $limit, $offset);

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_owl()
     */
    public function get_upload_by_owl($owl = FALSE, $limit = 15, $offset = 0, $deleted = FALSE)
    {
        if (!$owl)
            return FALSE;

        $this->db->select('*');
        $this->db->where('owl', $owl);
        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');
        $query = $this->db->get('uploads', $limit, $offset);

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_deleted_by_owl()
     */
    public function get_deleted_by_owl($limit = 15, $offset = 0)
    {
        return $this->get_upload_by_owl($this->session->userdata('owl'), $limit, $offset, TRUE);
    }
    //------------------------------------------------------------------


    /**
     * public get_all_uploads()
     * function will get all upload info for all uploads
     */
    public function get_all_uploads($deleted = FALSE, $limit = 15, $offset = 0)
    {
        if (!$limit)
            $limit = "0";

        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');

        $query = $this->db->get('uploads', $limit, $offset);

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public add_upload()
     */
    public function add_upload(
                                $upload_user        = FALSE,
                                $owl                = FALSE,
                                $file_name          = FALSE,
                                $full_path          = FALSE,
                                $upload_category    = FALSE,
                                $upload_license     = FALSE,
                                $file_type          = FALSE,
                                $client_name        = FALSE,
                                $file_size          = FALSE,
                                $file_ext           = FALSE,
                                $description        = NULL,
                                $revDate            = NULL
                              )
    {
        if (
               !$upload_user
            || !$owl
            || !$file_name
            || !$full_path
            || !$upload_license
            || !$file_type
            || !$client_name
            || !$file_size
            || !$file_ext
        )
            return FALSE;

        $insert_data = array(
            'upload_time'       => time(),
            'upload_user'       => $upload_user,
            'owl'               => $owl,
            'file_name'         => $file_name,
            'full_path'         => $full_path,
            'upload_category'   => $upload_category,
            'upload_license'    => $upload_license,
            'file_type'         => $file_type,
            'client_name'       => $client_name,
            'file_size'         => $file_size,
            'file_ext'          => $file_ext,
            'description'       => $description,
            'revision_date'     => $revDate
        );

        $this->db->insert('uploads', $insert_data);
    }
    //------------------------------------------------------------------


    /**
     * public update_upload()
     */
    public function update_upload( $full_path = FALSE, $upload_category = FALSE, $client_name = FALSE, $description = NULL )
    {
        if (!$full_path || !$upload_category || !$client_name)
            return FALSE;

        $update_data = array(
                                'upload_category'   => $upload_category,
                                'client_name'       => $client_name,
                                'description'       => $description
                            );

        $this->db->where('full_path', $full_path);
        $this->db->update('uploads', $update_data);
    }
    //------------------------------------------------------------------


    /**
     * public get_id_by_file_name()
     */
    public function get_id_by_file_name($file_name, $deleted = FALSE)
    {
        $this->db->select('id');
        $this->db->where('file_name', $file_name);
        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query->row('id');
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public delete()
     */
    public function delete($id = NULL )
    {
        if (!$this->session->userdata('admin'))
            return FALSE;

        if (!$id)
            return FALSE;

        $update_data = array(
            'deleted' => 'true',
            'remove_timestamp' => time()
        );

        $this->db->where('id', $id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->update('uploads', $update_data);

        if ($this->db->affected_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public restore()
     */
    public function restore($id = NULL )
    {
        if (!$this->session->userdata('admin'))
            return FALSE;

        if (!$id)
            return FALSE;

        $update_data = array(
            'deleted' => 'false',
            'remove_timestamp' => NULL
        );

        $this->db->where('id', $id);
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->update('uploads', $update_data);

        if ($this->db->affected_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public total_uploads()
     */
    public function total_uploads()
    {
        $this->db->select('*');
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads');

        return $query->num_rows();
    }
    //------------------------------------------------------------------


    /**
     * public total_cat_uploads()
     */
    public function total_cat_uploads($cat = FALSE)
    {
        if (!$cat)
            return FALSE;

        $this->db->select('*');
        $this->db->where('upload_category', $cat);
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads');

        return $query->num_rows();
    }
    //------------------------------------------------------------------


    /**
     * public total_owl_uploads()
     */
    public function total_owl_uploads($owl = FALSE, $deleted = FALSE)
    {
        if (!$owl)
            return FALSE;

        $this->db->select('*');
        $this->db->where('owl', $owl);

        if (!$deleted)
            $this->db->where('deleted', 'false');
        else
            $this->db->where('deleted', 'true');

        $query = $this->db->get('uploads');

        return $query->num_rows();
    }
    //------------------------------------------------------------------


    /**
     * public total_owl_uploads()
     */
    public function total_owl_deleted_uploads($owl = FALSE)
    {
        return $this->total_owl_uploads($owl, TRUE);
    }
    //------------------------------------------------------------------



//=================================================================================
// :private functions
//=================================================================================


}

// eof.