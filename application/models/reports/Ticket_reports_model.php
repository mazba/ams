<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_ticket_list($inputs)
    {
        $CI =& get_instance();
        $CI->db->select('ticket_issue.*');
        $CI->db->select('users.name_en user_name');
        $CI->db->select('product.product_name');
        $CI->db->from($CI->config->item('table_ticket_issue').' ticket_issue');
        if($inputs['start_date'])
            $CI->db->where('ticket_issue.create_date >',strtotime($inputs['start_date']));
        if($inputs['end_date'])
            $CI->db->where('ticket_issue.create_date <',strtotime($inputs['end_date']));
        $CI->db->order_by('ticket_issue.id','ASC');

        //check ticket type
        if($inputs['ticket_type']=='assigned')
        {
            $CI->db->where('ticket_issue.status',$CI->config->item('STATUS_ASSIGN'));
        }
        elseif($inputs['ticket_type']=='unassigned')
        {
            $CI->db->where('ticket_issue.status',$CI->config->item('STATUS_INACTIVE'));
        }
        elseif($inputs['ticket_type']=='resolved')
        {
            $CI->db->where('ticket_issue.status',$CI->config->item('STATUS_RESOLVE'));
        }
        elseif($inputs['ticket_type']=='reject')
        {
            $CI->db->where('ticket_issue.status',$CI->config->item('STATUS_REJECT'));
        }

        if($inputs['category'])
            $CI->db->where('product.category_id',$inputs['category']);


        if($inputs['user_name'])
            $CI->db->where('ticket_issue.user_id',$inputs['user_name']);

        if($inputs['product_name'])
            $CI->db->where('ticket_issue.product_id',$inputs['product_name']);

        $this->db->join($CI->config->item('table_users').' users','users.id = ticket_issue.user_id', 'LEFT');
        $this->db->join($CI->config->item('table_product').' product','product.id = ticket_issue.product_id', 'LEFT');
        $results = $this->db->get()->result_array();
  //echo $this->db->last_query();
        return $results;
    }
}