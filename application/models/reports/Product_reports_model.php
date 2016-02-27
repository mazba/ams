<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_list($inputs)
    {
        $CI =& get_instance();
        $CI->db->select('product.*');
        $CI->db->select('manufacture.manufacture_name');
        $CI->db->select('category.category_name');
        $CI->db->select('supplier.company_name');
        $CI->db->select('warehouse.warehouse_name');
        $CI->db->select('COUNT(product.product_name) no_of_product');
        $CI->db->from($CI->config->item('table_product').' product');
        if($inputs['category'])
            $CI->db->where('product.category_id',$inputs['category']);
        if($inputs['manufacture'])
            $CI->db->where('product.manufacture_id',$inputs['manufacture']);
        if($inputs['supplier'])
            $CI->db->where('product.supplier_id',$inputs['supplier']);
        if($inputs['warehouse'])
            $CI->db->where('product.warehouse_id',$inputs['warehouse']);
        $CI->db->order_by('product.id','ASC');
        //check product type
        if($inputs['product_type']=='unassigned')
        {
            $CI->db->where('product_assign.product_id IS NULL',NULL,true);
            $CI->db->join($CI->config->item('table_product_assign').' product_assign','product_assign.product_id = product.id', 'LEFT');
        }
        elseif($inputs['product_type']=='assigned')
        {
            $CI->db->where('product_assign.product_id IS NOT NULL',NULL,true);
            $CI->db->join($CI->config->item('table_product_assign').' product_assign','product_assign.product_id = product.id', 'LEFT');
        }
        
        $CI->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $CI->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->join($CI->config->item('table_supplier').' supplier','supplier.id = product.supplier_id', 'LEFT');
        $CI->db->join($CI->config->item('table_warehouse').' warehouse','warehouse.id = product.warehouse_id', 'LEFT');
        $CI->db->group_by('product.product_name');
        $results = $CI->db->get()->result_array();
//        echo $CI->db->last_query();
        return $results;
    }
}