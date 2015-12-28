<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Requisition_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        $user = User_helper::get_user();
        $CI->db->from($CI->config->item('table_requisition').' requisition');
        $CI->db->select('requisition.status,requisition.id,users.name_en user_name,requisition.requisition_type,requisition.requisition_title,requisition.requisition_id');
        if($user->user_group_id != $CI->config->item('SUPER_ADMIN_GROUP_ID') && $user->user_group_id != $CI->config->item('ADMIN_GROUP_ID') && $user->user_group_id != $CI->config->item('TOP_MANAGEMENT_GROUP_ID'))
        {
            $CI->db->where('requisition.user_id',$user->id);
        }
        $CI->db->join($CI->config->item('table_users'). ' users','users.id = requisition.user_id','LEFT');
        $results = $this->db->get()->result_array();

        $requisition_type = $CI->config->item('requisition_type');
        foreach($results as &$result)
        {
            $result['link']=$CI->get_encoded_url('asset_management/requisition/index/batch_details/'.$result['id']);
            $result['requisition_type']= $requisition_type[$result['requisition_type']];
        }
        return $results;
    }
    public function get_requisitons_details($selected_ids)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_requisition').' requisition');
        $CI->db->select('requisition.status,requisition.description,requisition.id,users.name_en user_name,requisition.requisition_type,requisition.requisition_title,requisition.requisition_id');
        $CI->db->join($CI->config->item('table_users'). ' users','users.id = requisition.user_id','LEFT');
        $CI->db->where_in('requisition.id',$selected_ids);
        $results = $this->db->get()->result_array();
        return $results;
    }
}