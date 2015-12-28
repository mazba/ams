<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_assign_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        $this->db->select("ticket_assign.user_id id,
                            count(ticket_assign.ticket_issue_id) ticket_issue_id,
                            users.name_bn");
        $this->db->from($CI->config->item('table_ticket_assign'));
        $this->db->join($CI->config->item('table_users').' users','users.id = ticket_assign.user_id', 'LEFT');
        $this->db->where('ticket_assign.status ='. $this->config->item('STATUS_ASSIGN'));
        $this->db->group_by('ticket_assign.user_id');
        $users = $this->db->get()->result_array();
        //echo $this->db->last_query();
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('ticket_management/ticket_assign/index/batch_details/'.$user['id']);
        }
        return $users;
    }

    public function get_user()
    {
        $CI =& get_instance();
        $this->db->select('users.id value, users.name_bn text');
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->join($CI->config->item('table_user_group').' user_group', 'user_group.id = users.user_group_id','INNER');
        $CI->db->where('users.status',$this->config->item('STATUS_ACTIVE'));
        $CI->db->where('user_group.level', $this->config->item('SUPPORT_GROUP_ID'));
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

    public function get_ticket_issue()
    {
        $CI =& get_instance();
        $this->db->select('ticket_issue.id,
                            ticket_issue.token,
                            ticket_issue.`subject`,
                            ticket_issue.ticket_issue_description,
                            ticket_issue.`status`,
                            ticket_issue.create_date,
                            users.name_bn,
                            product.product_name');
        $CI->db->from($CI->config->item('table_ticket_issue').' ticket_issue');
        $CI->db->join($CI->config->item('table_users').' users', 'users.id = ticket_issue.user_id','INNER');
        $CI->db->join($CI->config->item('table_product').' product', 'product.id = ticket_issue.product_id','LEFT');
        $CI->db->where('ticket_issue.status ='.$this->config->item('STATUS_INACTIVE').' OR ticket_issue.status ='.$this->config->item('STATUS_REJECT'));
        $CI->db->order_by('ticket_issue.id', 'DESC');
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

    public function get_ticket_assign($user_id=0)
    {
        if(!empty($user_id))
        {
            $this->db->where('ticket_assign.user_id ='.$user_id);
        }
        $CI =& get_instance();
        $this->db->select('ticket_issue.`subject`,
                            ticket_assign.`id`,
                            ticket_assign.`status`,
                            ticket_assign.user_id,
                            ticket_issue.create_date,
                            product.product_name,
                            users.name_bn,
                            ticket_assign.ticket_issue_id');
        $CI->db->from($CI->config->item('table_ticket_assign').' ticket_assign');
        $CI->db->join($CI->config->item('table_ticket_issue').' ticket_issue', 'ticket_issue.id = ticket_assign.ticket_issue_id','INNER');
        $CI->db->join($CI->config->item('table_users').' users', 'users.id = ticket_issue.user_id','INNER');
        $CI->db->join($CI->config->item('table_product').' product', 'product.id = ticket_issue.product_id','INNER');
        $CI->db->where('ticket_assign.status',$this->config->item('STATUS_ASSIGN'));
        $CI->db->order_by('ticket_issue.id', 'DESC');
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