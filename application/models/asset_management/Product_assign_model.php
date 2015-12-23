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
        $CI->db->select('pa.id,pa.status,pa.assign_date,pa.return_date,pa.remarks,user.name_en user_name,product.product_name');
        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
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
        $CI->db->select('pa.id');
        $CI->db->where('pa.status', 1);
        $sub = $this->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.product_name, product.id');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $results = $this->db->get()->result_array();
        $data = array();
        foreach($results as $result)
        {
            $data[] = array('text'=>$result['product_name'],
                            'value'=>$result['id']);
        }
        return $data;
    }
}