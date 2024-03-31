<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkuserAdmin($conditions)
    {
        $this->db->select('*');
        $this->db->from('snr_admins');
        $this->db->where($conditions);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_settings_info()
    {
        $this->db->select('*');
        $this->db->from('snr_company_info');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_users_info($conditions = null)
    {
        $this->db->select('*');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->from('snr_users');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_admins_info($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->from('snr_admins');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_booking_info($btype = null)
    {
        if ($btype == '') {
            $query = $this->db->query("SELECT * FROM `snr_booking` WHERE EXISTS (SELECT 1 FROM snr_users WHERE snr_users.id=snr_booking.user_id) ORDER BY `id` DESC");
        } else {
            $query = $this->db->query("SELECT * FROM `snr_booking` WHERE EXISTS (SELECT 1 FROM snr_users WHERE snr_users.id=snr_booking.user_id) AND `booking_type`='" . $btype . "' ORDER BY `id` DESC");
        }

        return $query->result_array();
    }

    public function get_user_info($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_users');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_admin_info($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_admins');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_policies()
    {
        $this->db->select('*');
        // $this->db->where("policy_status", '1');
        $this->db->from('snr_policies');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_policy_info($condition)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->from('snr_policies');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_file_details($condition)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->from('snr_policyfiles');
        $query = $this->db->get();
        return $query->row();
    }

    public function deletefile($condition)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->delete('snr_policyfiles');
        return $this->db->affected_rows();
    }

    public function update_company_info($data = null)
    {
        $this->db->truncate('snr_company_info');
        $this->db->insert('snr_company_info', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_policy_files($data = null)
    {
        $this->db->insert('snr_policyfiles', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_policy($data = null)
    {
        $this->db->insert('snr_policies', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }


    public function get_country_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('country_name', 'ASC');
        $this->db->from('snr_countries');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_info_resetpass($condition = null)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->from('snr_users');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_branch_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('branch_name', 'ASC');
        $this->db->from('snr_branches');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_cell_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('cell_name', 'ASC');
        $this->db->from('snr_cells');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_province_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('ProvinceName', 'ASC');
        $this->db->from('snr_province');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_policies_list()
    {
        $this->db->select('*');
        $this->db->where("final_status", '1');
        $this->db->from('snr_transactions');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_province($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_province');
        $query = $this->db->get();
        return $query->row();
    }

    public function getperiodnotedata($uid = null)
    {
        $this->db->select('*');
        $this->db->where('user_id', $uid);
        $this->db->order_by('added_on', 'DESC');
        $this->db->from('snr_period_note');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_city_info($pid = null)
    {
        $this->db->select('*');
        $this->db->where('ProvinceID', $pid);
        $this->db->where('status', '1');
        $this->db->order_by('RegionName', 'ASC');
        $this->db->from('snr_region');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_user($data)
    {
        $this->db->insert('snr_users', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_admin($data)
    {
        $this->db->insert('snr_admins', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function update_user($data, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_users', $data);
        return $this->db->affected_rows();
    }

    public function update_policy($data, $pid)
    {
        $this->db->where('id', $pid);
        $this->db->update('snr_policies', $data);
        return $this->db->affected_rows();
    }

    public function update_adminprofile($data, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_admins', $data);
        return $this->db->affected_rows();
    }

    public function save_region($data)
    {
        $this->db->insert('snr_province', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function update_region($data, $rid)
    {
        $this->db->where('ProvinceID', $rid);
        $this->db->update('snr_province', $data);
        return $this->db->affected_rows();
    }

    public function get_cities()
    {
        $this->db->select('snr_region.*');
        $this->db->from('snr_region');
        $this->db->join('snr_province', 'snr_region.ProvinceID=snr_province.ProvinceID');
        $this->db->where('snr_province.status', '1');
        $this->db->order_by('snr_region.RegionName', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_city($data)
    {
        $this->db->insert('snr_region', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function get_city($conditions)
    {
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where($conditions);
        $this->db->from('snr_region');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_city_list($conditions)
    {
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where($conditions);
        $this->db->from('snr_region');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_country_lists()
    {
        $this->db->select('*');
        $this->db->from('snr_countries');
        $this->db->order_by('country_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_province_lists()
    {
        $this->db->select('*');
        $this->db->from('snr_province');
        $this->db->order_by('provincename', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_district_lists()
    {
        $this->db->select('*');
        $this->db->from('snr_districts');
        $this->db->order_by('district_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_branch_lists()
    {
        $this->db->select('*');
        $this->db->from('snr_branches');
        $this->db->order_by('branch_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_cell_lists()
    {
        $this->db->select('*');
        $this->db->from('snr_cells');
        $this->db->order_by('cell_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_city($data, $cid)
    {
        $this->db->where('RegionID', $cid);
        $this->db->update('snr_region', $data);
        return $this->db->affected_rows();
    }

    public function get_category_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('cat_name', 'ASC');
        $this->db->from('snr_category');
        $query = $this->db->get();
        return $query->result();
    }

    public function deletecatandevent($cat_id)
    {
        $this->db->where('category', $cat_id);
        $this->db->delete('snr_topics');

        $this->db->where('id', $cat_id);
        $this->db->delete('snr_category');
        return true;
    }

    public function get_donation_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('added_on', 'DESC');
        $this->db->from('snr_donation');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_transaction_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('added_on', 'DESC');
        $this->db->from('snr_transactions');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_notice_category_info()
    {
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->order_by('cat_name', 'ASC');
        $this->db->from('snr_category_notice');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_category($data)
    {
        $this->db->insert('snr_category', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_notice_category($data)
    {
        $this->db->insert('snr_category_notice', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_branch($data)
    {
        $this->db->insert('snr_branches', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_cell($data)
    {
        $this->db->insert('snr_cells', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function get_category($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_category');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_notice_category($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_category_notice');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_branch($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_branches');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_cell($conditions)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_cells');
        $query = $this->db->get();
        return $query->row();
    }

    public function update_category($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_category', $data);
        return $this->db->affected_rows();
    }

    public function update_donations($conditions, $transid)
    {
        $this->db->where('transaction_id', $transid);
        $this->db->update('snr_donation', $conditions);
        return $this->db->affected_rows();
    }

    public function update_transaction($conditions, $transid)
    {
        $this->db->where('transaction_id', $transid);
        $this->db->update('snr_transactions', $conditions);
        return $this->db->affected_rows();
    }

    public function update_policypurchase($conditions, $purchaseid)
    {
        $this->db->where('id', $purchaseid);
        $this->db->update('snr_policypurchase', $conditions);
        return $this->db->affected_rows();
    }

    public function update_branch($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_branches', $data);
        return $this->db->affected_rows();
    }

    public function update_cell($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_cells', $data);
        return $this->db->affected_rows();
    }

    public function get_subcategory_info()
    {
        $this->db->select('*');
        //$this->db->where('status', '1');
        $this->db->order_by('subcat_name_en', 'ASC');
        $this->db->from('snr_subcategory');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_subcategory($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->where('status', '1');
        $this->db->from('snr_subcategory');
        $query = $this->db->get();
        return $query->row();
    }

    public function save_subcategory($data)
    {
        $this->db->insert('snr_subcategory', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function savesmsdata($data)
    {
        $this->db->insert('snr_smslog', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_notfication($data)
    {
        $this->db->insert('snr_smslog', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function update_subcategory($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_subcategory', $data);
        return $this->db->affected_rows();
    }

    public function getsubcats($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->where('status', '1');
        $this->db->from('snr_subcategory');
        $query = $this->db->get();
        return $query->result();
    }

    public function checkslug($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->where('status', '1');
        $this->db->from('snr_topics');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_topics_list($conditions = null)
    {
        $this->db->select('*');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->order_by('featured', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->from('snr_topics');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_notice_list($conditions = null)
    {
        $this->db->select('*');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->from('snr_notices');
        $query = $this->db->get();
        return $query->result();
    }

    public function savetopic($data)
    {
        $this->db->insert('snr_topics', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function savenotice($data)
    {
        $this->db->insert('snr_notices', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function getmyarticle($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->where('status', '1');
        $this->db->from('snr_topics');
        $query = $this->db->get();
        return $query->row();
    }

    public function getmynotice($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->where('status', '1');
        $this->db->from('snr_notices');
        $query = $this->db->get();
        return $query->row();
    }

    public function getprovincelist($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_province');
        $query = $this->db->get();
        return $query->result();
    }

    public function getdistrictlist($pid = null)
    {
        $this->db->select('provincename');
        $this->db->where('provinceid', $pid);
        $this->db->from('snr_province');
        $query = $this->db->get();
        $res = ($query->row());

        $this->db->select('*');
        $this->db->from('snr_districts');
        $this->db->where('province_name', $res->provincename);
        $query2 = $this->db->get();
        return $query2->result();
    }

    public function get_topics_byid($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        // $this->db->where('status', '1');
        $this->db->from('snr_topics');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_notice_byid($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        // $this->db->where('status', '1');
        $this->db->from('snr_notices');
        $query = $this->db->get();
        return $query->row();
    }

    public function updatetopic($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_topics', $data);
        return $this->db->affected_rows();
    }

    public function updatenotice($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_notices', $data);
        return $this->db->affected_rows();
    }

    public function get_centres($conditions = null)
    {
        $this->db->select('*');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        //$this->db->where('status', '1');
        $this->db->from('snr_centres');
        $query = $this->db->get();
        if (!empty($conditions)) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    public function save_centre($data)
    {
        $this->db->insert('snr_centres', $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function save_timing($data)
    {
        $this->db->insert('snr_centre_timing', $data);
        $insertId = $this->db->insert_id();
    }

    public function getShow($cid)
    {
        $this->db->select('*');
        $this->db->where('centre_id', $cid);
        $this->db->from('snr_centre_timing');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_centre($data, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_centres', $data);
        return $this->db->affected_rows();
    }

    public function update_timing($data, $conditions)
    {
        $this->db->where($conditions);
        $this->db->update('snr_centre_timing', $data);
        return $this->db->affected_rows();
    }

    public function changeuserstatus($val, $uid, $role)
    {
        if ($role == 1) {
            $this->db->where('id', $uid);
            $this->db->update('snr_admins', $val);
        } else {
            $this->db->where('id', $uid);
            $this->db->update('snr_users', $val);
        }
        return $this->db->affected_rows();
    }

    public function changepolicystatus($val, $pid)
    {
        $this->db->where('id', $pid);
        $this->db->update('snr_policies', $val);
        return $this->db->affected_rows();
    }

    public function changecentrestatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_centres', $val);
        return $this->db->affected_rows();
    }

    public function changeprovincestatus($val, $uid)
    {
        $this->db->where('ProvinceID', $uid);
        $this->db->update('snr_province', $val);
        return $this->db->affected_rows();
    }

    public function changecitystatus($val, $uid)
    {
        $this->db->where('RegionID', $uid);
        $this->db->update('snr_region', $val);
        return $this->db->affected_rows();
    }

    public function changecatstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_category', $val);
        $this->db->where('category', $uid);
        $this->db->update('snr_topics', $val);
        return true;
    }

    public function changecatstatus_notice($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_category_notice', $val);
        $this->db->where('category', $uid);
        $this->db->update('snr_notices', $val);
        return true;
    }

    public function deletenoticecat($uid)
    {
        $this->db->where('category', $uid);
        $this->db->delete('snr_notices');
        $this->db->where('id', $uid);
        $this->db->delete('snr_category_notice');
        return true;
    }

    public function changebranchstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_branches', $val);
        return $this->db->affected_rows();
    }

    public function deletebranchentry($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete('snr_branches');
    }

    public function deletecellentry($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete('snr_cells');
    }

    public function changecellstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_cells', $val);
        return $this->db->affected_rows();
    }

    public function changesubcatstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_subcategory', $val);
        return $this->db->affected_rows();
    }

    public function changetopicstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_topics', $val);
        return $this->db->affected_rows();
    }

    public function changenotificationstatus($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_notifications', $val);
        return $this->db->affected_rows();
    }

    public function getadmindetails()
    {
        $this->db->select('*');
        $this->db->from('snr_admin');
        $query = $this->db->get();
        return $query->row();
    }

    public function getcalendardetails()
    {
        $this->db->select('*');
        $this->db->from('snr_calendar');
        $query = $this->db->get();
        return $query->row();
    }

    public function update_admin($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_admin', $val);
        return $this->db->affected_rows();
    }

    public function update_calendar($val, $uid)
    {
        if (isset($uid)) {
            $this->db->where('id', $uid);
            $this->db->update('snr_calendar', $val);
            return $this->db->affected_rows();
        } else {
            $this->db->insert('snr_calendar', $val);
            return $this->db->insert_id();
        }
    }

    public function get_call_logs()
    {
        $this->db->select('*');
        $this->db->order_by('call_time', 'DESC');
        $this->db->from('snr_api_call_log');
        $this->db->limit(20);
        $query = $this->db->get();
        return $query->result();
    }

    public function find_user($conditions = null)
    {
        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->from('snr_users');
        $query = $this->db->get();
        return $query->row();
    }

    public function verify_user($val, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_users', $val);
        return $this->db->affected_rows();
    }

    public function getregionrestrictstatus($pid)
    {
        $this->db->select('geo_restriction');
        $this->db->where('ProvinceID', $pid);
        $this->db->from('snr_province');
        $query = $this->db->get();
        return $query->row();
    }

    public function change_restriction($val, $pid)
    {
        $this->db->where('ProvinceID', $pid);
        $this->db->update('snr_province', $val);
        return $this->db->affected_rows();
    }

    public function restrict_column_a_status($cid)
    {
        $this->db->select('column_a');
        $this->db->where('id', $cid);
        $this->db->from('snr_centres');
        $query = $this->db->get();
        return $query->row();
    }

    public function restrict_column_b_status($cid)
    {
        $this->db->select('column_b');
        $this->db->where('id', $cid);
        $this->db->from('snr_centres');
        $query = $this->db->get();
        return $query->row();
    }

    public function change_restriction_a($val, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_centres', $val);
        return $this->db->affected_rows();
    }

    public function change_restriction_b($val, $cid)
    {
        $this->db->where('id', $cid);
        $this->db->update('snr_centres', $val);
        return $this->db->affected_rows();
    }

    public function save_notification($data)
    {
        $this->db->insert('snr_notifications', $data);
        return $this->db->affected_rows();
    }

    public function save_announcement($data)
    {
        $this->db->insert('snr_announcement', $data);
        return $this->db->affected_rows();
    }

    public function update_announcement($data, $uid)
    {
        $this->db->where('id', $uid);
        $this->db->update('snr_announcement', $data);
        return $this->db->affected_rows();
    }

    public function get_region_id($region)
    {
        $this->db->select('RegionID');
        $this->db->like('RegionName', $region);
        $this->db->from('snr_region');
        $query = $this->db->get();
        return $query->row();
    }

    public function getbookinginfo($bid)
    {
        $this->db->select('*');
        $this->db->where('id', $bid);
        $this->db->from('snr_booking');
        $query = $this->db->get();
        return $query->row();
    }

    public function getbookinglist($uid)
    {
        $this->db->select('*');
        $this->db->where('user_id', $uid);
        $this->db->order_by('schedule_date', 'DESC');
        $this->db->from('snr_booking');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_booking($val, $bid)
    {
        $this->db->where('id', $bid);
        $this->db->update('snr_booking', $val);
        return $this->db->affected_rows();
    }

    public function get_all_reviews()
    {
        //         SELECT snr_reviews.*, snr_centres.centre_name, snr_centres.centre_city, snr_users.userfname, snr_region.RegionName 
        // FROM `snr_reviews` 
        // JOIN snr_centres ON snr_reviews.centre_id=snr_centres.id
        // JOIN snr_region ON snr_centres.centre_city=snr_region.RegionID
        // JOIN snr_users ON snr_reviews.user_id=snr_users.id

        $this->db->select('snr_reviews.*, snr_centres.centre_name, snr_users.userfname, snr_region.RegionName, snr_booking.booking_type, snr_booking.schedule_date, snr_booking.booking_time');
        $this->db->from('snr_reviews');
        $this->db->join('snr_centres', 'snr_reviews.centre_id=snr_centres.id');
        $this->db->join('snr_region', 'snr_centres.centre_city=snr_region.RegionID');
        $this->db->join('snr_users', 'snr_reviews.user_id=snr_users.id');
        $this->db->join('snr_booking', 'snr_reviews.booking_id=snr_booking.id');
        $qry = $this->db->get();
        return $qry->result();
    }

    public function get_all_notification()
    {
        $this->db->select('*');
        $this->db->order_by('id', 'DESC');
        $qry = $this->db->get('snr_notifications');
        return $qry->result();
    }

    public function get_all_announcements()
    {
        $this->db->select('*');
        $this->db->order_by('id', 'DESC');
        $qry = $this->db->get('snr_announcement');
        return $qry->result();
    }

    public function approve_review($val, $rid)
    {
        $this->db->where('id', $rid);
        $this->db->update('snr_reviews', $val);
        return $this->db->affected_rows();
    }

    public function get_api_info($aid)
    {
        $this->db->select('*');
        $this->db->where('id', $aid);
        $qry = $this->db->get('snr_apilists');
        return $qry->row();
    }

    public function get_tem_trans_data($condition = null)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->order_by('added_on', 'DESC');
        $qry = $this->db->get('snr_temp_trans');
        return $qry->row();
    }

    public function get_trans_data($condition = null)
    {
        $this->db->select('*');
        $this->db->where($condition);
        $this->db->order_by('added_on', 'DESC');
        $qry = $this->db->get('snr_transactions');
        return $qry->row();
    }
}
