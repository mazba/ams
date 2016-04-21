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
        $user = User_helper::get_user();
        if ($user->user_group_level == $this->config->item('SUPPORT_GROUP_ID')) {
            $this->db->where('ticket_assign.user_id', $user->id);
        }
        $CI =& get_instance();
        $this->db->select("ticket_assign.id,
                            ticket_assign.ticket_issue_id,
                            ticket_assign.create_date,
                            ticket_assign.priority,
                            ticket_assign.`status`,
                            `ticket_issue`.`subject`,
                            product.product_name,product.product_code,
                            users.name_bn,
                            users_assign.name_bn support_name,
                            ticket_assign.resolved_date");
        $this->db->from($CI->config->item('table_ticket_assign') . ' ticket_assign');
        $this->db->join($CI->config->item('table_ticket_issue') . ' ticket_issue', 'ticket_issue.id = ticket_assign.ticket_issue_id', 'INNER');
        $this->db->join($CI->config->item('table_users') . ' users', 'users.id = ticket_issue.user_id', 'INNER');
        $this->db->join($CI->config->item('table_users') . ' users_assign', 'users_assign.id = ticket_assign.user_id', 'INNER');
        $this->db->join($CI->config->item('table_product') . ' product', 'product.id = ticket_issue.product_id', 'LEFT');
        $this->db->where('ticket_assign.status =' . $this->config->item('STATUS_ASSIGN'));
        $this->db->order_by('ticket_assign.ticket_issue_id', 'DESC');
        $users = $this->db->get()->result_array();
        //echo $this->db->last_query();
        $all_priority = $CI->config->item('ticket_priority');
        foreach ($users as &$user) {
            $user['edit_link'] = $CI->get_encoded_url('ticket_management/ticket_resolve/index/edit/' . $user['id']);
            $user['ticket_issue_id']=System_helper::Get_Eng_to_Bng($user['ticket_issue_id']);

            //            if($user['status']==$this->config->item('STATUS_ASSIGN'))
            //            {
            //                $user['status_text']=$CI->lang->line('ASSIGN');
            //            }
            //            else if($user['status']==$this->config->item('STATUS_RESOLVE'))
            //            {
            //                $user['status_text']=$CI->lang->line('RESOLVE');
            //            }
            //            else if($user['status']==$this->config->item('STATUS_REJECT'))
            //            {
            //                $user['status_text']=$CI->lang->line('REJECT');
            //            }
            //            else
            //            {
            //                $user['status_text']=$user['status'];
            //            }
            $user['create_date_time'] = date('h:i A - d M,y', $user['create_date']);
            $user['priority'] = isset($all_priority[$user['priority']]) ? $all_priority[$user['priority']] : '';
        }
        return $users;
    }

    public function get_ticket_assign($ticket_assign_id = 0)
    {
        if (!empty($ticket_assign_id)) {
            $this->db->where('ticket_assign.id =' . $ticket_assign_id);
        }
        $CI =& get_instance();
        $this->db->select('ticket_issue.`subject`,
                            ticket_assign.`id` ticket_assign_id,
                            ticket_assign.`status`,
                            ticket_assign.`priority`,
                            ticket_assign.user_id,
                            ticket_issue.create_date,
                            product.product_name,product.id product_id,
                              product.product_code,
                            ticket_issue.id ticket_issue_id,
                            users.name_bn,  users.id  user_id,
                            ticket_issue.ticket_issue_description,
                            ticket_assign.ticket_issue_id,
                            ticket_issue.issue_attachment,
                            ticket_issue.status ticket_issue_status
                            ');
        $CI->db->from($CI->config->item('table_ticket_assign') . ' ticket_assign');
        $CI->db->join($CI->config->item('table_ticket_issue') . ' ticket_issue', 'ticket_issue.id = ticket_assign.ticket_issue_id', 'INNER');
        $CI->db->join($CI->config->item('table_users') . ' users', 'users.id = ticket_issue.user_id', 'INNER');
        $CI->db->join($CI->config->item('table_product') . ' product', 'product.id = ticket_issue.product_id', 'LEFT');
        $CI->db->where('ticket_assign.status', $this->config->item('STATUS_ASSIGN'));
        $CI->db->order_by('ticket_issue.id', 'DESC');
        $result = $this->db->get()->row_array();
        //echo $this->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_ticket_comments($ticket_issue_id = 0)
    {

        $CI =& get_instance();
        $this->db->select('ticket_resolve_status.`name` resolve_status,
                            ticket_resolve_comment.`comment`,
                            ticket_resolve_comment.resolved_date,
                            ticket_resolve_comment.type,
                            ticket_resolve_comment.`status`,
                            users.name_en user_name,
                            users.picture_name,
                            ticket_resolve_comment.id,
                            ticket_resolve_comment.create_by,
                            ticket_resolve_comment.create_date,
                            ticket_resolve_comment.ticket_issue_id');
        $CI->db->from($CI->config->item('table_ticket_resolve_comment') . ' ticket_resolve_comment');
        $CI->db->join($CI->config->item('table_ticket_resolve_status') . ' ticket_resolve_status', 'ticket_resolve_status.id = ticket_resolve_comment.ticket_status_id', 'LEFT');
        $CI->db->join($CI->config->item('table_users') . ' users', 'users.id = ticket_resolve_comment.create_by', 'INNER');
        $CI->db->where('ticket_resolve_comment.ticket_issue_id =' . $ticket_issue_id);
        $CI->db->order_by('ticket_resolve_comment.id', 'DESC');
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

}