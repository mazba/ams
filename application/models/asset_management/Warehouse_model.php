<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        //$this->db->select('*');
        $this->db->from($CI->config->item('table_warehouse'));

        $users = $this->db->get()->result_array();
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('asset_management/warehouse/index/edit/'.$user['id']);
            if($user['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $user['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($user['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $user['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $user['status_text']=$user['status'];
            }
        }
        return $users;
    }

    public function get_user_list($tableName, $name_string)
    {
        $CI =& get_instance();
        $CI->db->from($tableName);
        $CI->db->select('name_'.$CI->get_language_code().' label');
        $CI->db->select('id value');
        $CI->db->where('status != 99');
        $CI->db->where("(name_en LIKE '%$name_string%' OR name_bn LIKE '%$name_string%')",'', false);
        $users = $CI->db->get()->result_array();
        return $users;
    }

    public function check_existence($value,$id, $field_name)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_divisions'));
        $CI->db->where($field_name,$value);
        if($id>0)
        {
            $CI->db->where('divid !=',$id);
        }

        $result = $CI->db->get()->row_array();
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}