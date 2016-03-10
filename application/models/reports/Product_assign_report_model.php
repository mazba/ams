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
        if(isset($inputs['search_type'])){
        if($inputs['search_type']=='pending')
        {
            $CI->db->where('pa.return_date <',time());
        }
        }
        if(isset($inputs['start_date']))
            $CI->db->where('pa.create_date >',strtotime($inputs['start_date']));
        if(isset($inputs['end_date']))
            $CI->db->where('pa.create_date <',strtotime($inputs['end_date']));


        if(isset($inputs['category']))
            $CI->db->where('product.category_id',$inputs['category']);
        if(isset($inputs['product_name']))
            $CI->db->where('product.id',$inputs['product_name']);

        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
        $CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
        $this->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $this->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->where('pa.status = 1');
        $CI->db->order_by("product.id", "desc");
        $results = $this->db->get()->result_array();
//        echo time();die;
        return $results;
    }
}