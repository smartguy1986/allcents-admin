<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLogModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function log_activity($data)
    {
        $this->db->insert('snr_activity_log', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }
}