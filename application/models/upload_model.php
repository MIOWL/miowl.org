<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model {


    //=================================================================================
    // :public
    //=================================================================================


    /**
     * public get_upload_by_id()
     * function will pull needed upload info based on the passed int upload id.
     *
     * @param int $upload_id - upload id
     */
    public function get_upload_by_id($upload_id)
    {
        if (!$upload_id)
            return FALSE;

        $this->db->select('*');
        $this->db->where('id', $upload_id);
        $this->db->where('deleted', 'false');
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
    public function get_upload_by_ext($ext)
    {
        if (!$ext)
            return FALSE;

        $this->db->select('*');
        $this->db->where('file_ext', '.' . $ext);
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_upload_by_owl()
     */
    public function get_upload_by_owl($owl = FALSE)
    {
        if (!$owl)
            return FALSE;

        $this->db->select('*');
        $this->db->where('owl', $owl);
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_all_uploads()
     * function will get all upload info for all uploads
     */
    public function get_all_uploads()
    {
        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        $this->db->where('deleted', 'false');
        $query = $this->db->get('uploads');

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
                                $upload_license    = FALSE,
                                $file_type          = FALSE,
                                $client_name        = FALSE,
                                $file_size          = FALSE,
                                $file_ext           = FALSE,
                                $description        = NULL
                              )
    {
        if (!$upload_user || !$owl || !$file_name || !$full_path || !$upload_license || !$file_type || !$client_name || !$file_size || !$file_ext) {

            // Debugging only
            #die("something is null<br><br>upload_user: {$upload_user}<br>owl: {$owl}<br>file_name: {$file_name}<br>full_path: {$full_path}<br>upload_category: {$upload_category}<br>upload_license: {$upload_license}<br>file_type: {$file_type}<br>client_name: {$client_name}<br>file_size: {$file_size}<br>file_ext: {$file_ext}");

            return FALSE;
        }

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
            'description'       => $description
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
    public function get_id_by_file_name($file_name)
    {
        $this->db->select('id');
        $this->db->where('file_name', $file_name);
        $this->db->where('deleted', 'false');
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
    public function delete($owl = FALSE, $id = NULL )
    {
        if (!$owl || !$id)
            return FALSE;

        $update_data = array(
            'deleted' => 'true',
            'remove_timestamp' => time()
        );

        $this->db->where('id', $id);
        $this->db->where('owl', $owl);
        $this->db->update('uploads', $update_data);

        if ($this->db->affected_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }
    //------------------------------------------------------------------


    /**
     * public get_deleted_by_owl()
     */
    public function get_deleted_by_owl()
    {
        $this->db->select('*');
        $this->db->order_by("id", "ASC");
        $this->db->where('owl', $this->session->userdata('owl'));
        $this->db->where('deleted', 'true');
        $query = $this->db->get('uploads');

        if ($query->num_rows() > 0)
            return $query;
        else
            return FALSE;
    }
    //------------------------------------------------------------------



    //=================================================================================
    // :private
    //=================================================================================


}
