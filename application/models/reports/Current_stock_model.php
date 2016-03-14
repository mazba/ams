<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Current_stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_list($inputs)
    {
        $data = [];
        $CI =& get_instance();

        //select all from assign_product
        $CI->db->from($CI->config->item('table_product_assign').' product_ass');
        $CI->db->select('product_ass.product_id');
        $CI->db->where("product_ass.status", 1);
        $product_ass = $CI->db->get_compiled_select();

        //should returns no.of product from product table that not assign yet.
        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.id');
        $CI->db->select('count(product.id) nub_of_product');
        $CI->db->select('product.*');
        $CI->db->where("product.id NOT IN ($product_ass)", NULL, FALSE);
        $CI->db->group_by('product.product_name');
        $CI->db->join($CI->config->item('table_product_assign').' assign_product','assign_product.product_id = product.id', 'LEFT');
        $results = $CI->db->get()->result_array();
        foreach($results as $result){
            $data['current_product'][$result['product_name']] = $result;
           // $result['nub_of_product'] = System_helper::Get_Eng_to_Bng($result['unit_price']);

        }

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.id');
        $CI->db->select('count(product.id) nub_of_product');
        $CI->db->select('product.*');
        $CI->db->select('manufacture.manufacture_name');
        $CI->db->select('category.category_name');
        $CI->db->select('supplier.company_name');
        $CI->db->select('warehouse.warehouse_name');
        if($inputs['category'])
            $CI->db->where('product.category_id',$inputs['category']);
        if($inputs['product_name'])
            $CI->db->where('product.product_name',$inputs['product_name']);
        if($inputs['manufacture'])
            $CI->db->where('product.manufacture_id',$inputs['manufacture']);
        if($inputs['supplier'])
            $CI->db->where('product.supplier_id',$inputs['supplier']);
        if($inputs['warehouse'])
            $CI->db->where('product.warehouse_id',$inputs['warehouse']);
        $CI->db->order_by("product.id", "desc");
        $CI->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $CI->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->join($CI->config->item('table_supplier').' supplier','supplier.id = product.supplier_id', 'LEFT');
        $CI->db->join($CI->config->item('table_warehouse').' warehouse','warehouse.id = product.warehouse_id', 'LEFT');
        $CI->db->group_by('product.product_name');

        $data['products'] = $CI->db->get()->result_array();
        return $data;



    }
}