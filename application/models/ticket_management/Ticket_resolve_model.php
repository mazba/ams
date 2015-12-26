<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_resolve_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $user=User_helper::get_user();
        if($user->user_group_level==$this->config->item('SUPPORT_GROUP_ID'))
        {
            $this->db->where('ticket_assign.user_id', $user->id);
        }
        $CI =& get_instance();
        $this->db->select("ticket_assign.id,
                            ticket_assign.ticket_issue_id,
                            ticket_assign.create_date,
                            ticket_assign.`status`,
                            `ticket_issue`.`subject`,
                            product.product_name,
                            users.name_bn,
                            ticket_assign.resolved_date");
        $this->db->from($CI->config->item('table_ticket_assign').' ticket_assign');
        $this->db->join($CI->config->item('table_ticket_issue').' ticket_issue','ticket_issue.id = ticket_assign.ticket_issue_id', 'INNER');
        $this->db->join($CI->config->item('table_users').' users','users.id = ticket_issue.user_id', 'INNER');
        $this->db->join($CI->config->item('table_product').' product','product.id = ticket_issue.product_id', 'INNER');
        $this->db->where('ticket_assign.status ='. $this->config->item('STATUS_PENDING'));
        $this->db->order_by('ticket_assign.ticket_issue_id', 'DESC');
        $users = $this->db->get()->result_array();
        //echo $this->db->last_query();
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('ticket_management/ticket_resolve/index/edit/'.$user['id']);
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
        $CI->db->where('ticket_issue.status',$this->config->item('STATUS_PENDING'));
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

    public function get_ticket_assign($ticket_assign_id=0)
    {
        if(!empty($ticket_assign_id))
        {
            $this->db->where('ticket_assign.id ='.$ticket_assign_id);
        }
        $CI =& get_instance();
        $this->db->select('ticket_issue.`subject`,
                            ticket_assign.`id`,
                            ticket_assign.`status`,
                            ticket_assign.user_id,
                            ticket_issue.create_date,
                            product.product_name,
                            users.name_bn,
                            ticket_issue.ticket_issue_description,
                            ticket_assign.ticket_issue_id');
        $CI->db->from($CI->config->item('table_ticket_assign').' ticket_assign');
        $CI->db->join($CI->config->item('table_ticket_issue').' ticket_issue', 'ticket_issue.id = ticket_assign.ticket_issue_id','INNER');
        $CI->db->join($CI->config->item('table_users').' users', 'users.id = ticket_issue.user_id','INNER');
        $CI->db->join($CI->config->item('table_product').' product', 'product.id = ticket_issue.product_id','INNER');
        $CI->db->where('ticket_assign.status',$this->config->item('STATUS_PENDING'));
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