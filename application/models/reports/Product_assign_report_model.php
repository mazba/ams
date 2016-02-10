<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_assign_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_list($inputs)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.id,pa.status,pa.assign_date,pa.return_date,pa.remarks,user.name_en user_name,product.product_name');
        $CI->db->select('product.product_code,product.serial_number,product.model_no,product.warranty_start_date,product.warranty_end_date');
        $CI->db->select('manufacture.manufacture_name,category.category_name');
        if($inputs['search_type']=='pending')
        {
            $CI->db->where('pa.return_date <',time());
        }
        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
        $CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
        $this->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $this->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->where('pa.status = 1');
        $results = $this->db->get()->result_array();
//        echo time();die;
        return $results;
    }
}