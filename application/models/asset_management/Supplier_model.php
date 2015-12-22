<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        //$this->db->select('*');
        $this->db->from($CI->config->item('table_supplier'));

        $users = $this->db->get()->result_array();
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('asset_management/supplier/index/edit/'.$user['id']);
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

}