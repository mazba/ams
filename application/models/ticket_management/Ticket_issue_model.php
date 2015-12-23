<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_issue_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $user=User_helper::get_user();
        if($user->user_group_level==$this->config->item('END_GROUP_ID') || $user->user_group_level==$this->config->item('TOP_MANAGEMENT_GROUP_ID') || $user->user_group_level==$this->config->item('SUPPORT_GROUP_ID') || $user->user_group_level==$this->config->item('OPERATOR_GROUP_ID'))
        {
            $this->db->where('ticket_issue.user_id',$user->id);
        }
        else
        {

        }

        $CI =& get_instance();
        $this->db->select("core_01_users.name_bn,
                            ticket_issue.id,
                            ticket_issue.token,
                            product.product_name,
                            ticket_issue.`subject`,
                            ticket_issue.`create_date`,
                            ticket_issue.`status`");
        $this->db->from($CI->config->item('table_ticket_issue'));
        $this->db->join($CI->config->item('table_users').' core_01_users','core_01_users.id = ticket_issue.user_id', 'LEFT');
        $this->db->join($CI->config->item('table_product').' product','product.id = ticket_issue.product_id', 'LEFT');

        $users = $this->db->get()->result_array();
        //echo $this->db->last_query();
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('ticket_management/ticket_issue/index/batch_details/'.$user['id']);
            if($user['status']==$this->config->item('STATUS_PENDING'))
            {
                $user['status_text']=$CI->lang->line('PENDING');
            }
            else if($user['status']==$this->config->item('STATUS_RESOLVE'))
            {
                $user['status_text']=$CI->lang->line('RESOLVE');
            }
            else
            {
                $user['status_text']=$user['status'];
            }
            $user['create_date_time']=date('h:i A - d M,y',$user['create_date']);
        }
        return $users;
    }

    public function get_product($user_id, $product_id=0)
    {
        if(!empty($product_id))
        {
            $this->db->where('product.id',$product_id);
        }
        $CI =& get_instance();
        $this->db->select('product.id value, product.product_name text');
        $CI->db->from($CI->config->item('table_product_assign').' product_assign');
        $CI->db->join($CI->config->item('table_product').' product','product.id = product_assign.product_id', 'LEFT');
        $CI->db->join($CI->config->item('table_users').' users','users.id = product_assign.user_id', 'LEFT');
        $CI->db->where('product_assign.status',$this->config->item('STATUS_ACTIVE'));
        $CI->db->where('users.id', $user_id);
        $result=$this->db->get()->result_array();
        //echo $this->db->last_query();
        if(sizeof($result)>0)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

}