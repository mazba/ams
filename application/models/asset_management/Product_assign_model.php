<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_assign_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.id,pa.received_by,pa.status,pa.assign_date,pa.return_date,pa.remarks,user.name_en user_name,product.product_name,received_by.name_en receiver_name');
        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
        $CI->db->join($CI->config->item('table_users'). ' received_by','received_by.id = pa.received_by','LEFT');
        $CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
        $CI->db->where('pa.status = 1');
        $results = $this->db->get()->result_array();

        foreach($results as &$result)
        {
            $result['edit_link'] = $CI->get_encoded_url('asset_management/product_assign/index/edit/'.$result['id']);
            $result['assign_date'] = System_helper::display_date($result['assign_date']);
            $result['return_date'] = System_helper::display_date($result['return_date']);
            if($result['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $result['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($result['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $result['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $result['status_text']=$result['status'];
            }
        }
        return $results;
    }
    public function get_unassigned_products()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.product_id');
        $CI->db->where('pa.status =', 1);
        $sub = $CI->db->get_compiled_select();


        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.product_name,product.product_code,product.id');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $CI->db->where("product.status !=",99);
        $results = $this->db->get()->result_array();
 //      echo $CI->db->last_query();die();
        $data = array();
        foreach($results as $result)
        {
            $data[] = array('text'=>$result['product_name']." (".$result['product_code'].")",
                            'value'=>$result['id']);
        }

        return $data;
    }
}