<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_return_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_list($inputs)
    {
        $CI =& get_instance();
        $CI->db->select('product_return.*');
        $CI->db->select('users.username');
        $CI->db->select('product.product_name,product.purchase_date,product.status');
        $CI->db->select('manufacture.manufacture_name');
        $CI->db->select('category.category_name');
        $CI->db->select('supplier.company_name');
        $CI->db->select('warehouse.warehouse_name');
        $CI->db->where("product_return.status", 0);
        $CI->db->from($CI->config->item('table_product_assign').' product_return');

        if($inputs['start_date'])
            $CI->db->where('product_return.create_date >',strtotime($inputs['start_date']));
        if($inputs['end_date'])
            $CI->db->where('product_return.create_date <',strtotime($inputs['end_date']));

        if($inputs['category'])
            $CI->db->where('product.category_id',$inputs['category']);

        if($inputs['user_name'])
            $CI->db->where('product_return.user_id',$inputs['user_name']);

        if($inputs['product_name'])
            $CI->db->where('product_return.product_id',$inputs['product_name']);

        $this->db->join($CI->config->item('table_product').' product','product.id = product_return.product_id', 'LEFT');
        $this->db->join($CI->config->item('table_users').' users','users.id = product_return.user_id', 'LEFT');
        $CI->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $CI->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->join($CI->config->item('table_supplier').' supplier','supplier.id = product.supplier_id', 'LEFT');
       $CI->db->join($CI->config->item('table_warehouse').' warehouse','warehouse.id = product.warehouse_id', 'LEFT');
//        $CI->db->order_by("product.id", "desc");
       // $CI->db->group_by('product.product_name');
        $results = $CI->db->get()->result_array();
    //   echo $CI->db->last_query();
        return $results;
    }
}