<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_unassigned_product_list($warehouse_id)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.product_id');
        $CI->db->where('pa.status', 1);
        $sub = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.id, product.product_name ,product.product_code,product.serial_number, product.model_no');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $CI->db->where("product.warehouse_id",$warehouse_id);
        $result = $CI->db->get()->result_array();
        return $result;

    }

    public function get_product_info_by_id($id){
        $CI =& get_instance();
        $CI->db->select('product.*');
        $CI->db->select('manufacture.manufacture_name');
        $CI->db->select('category.category_name');
        $CI->db->select('supplier.company_name,supplier.company_address,supplier.company_office_phone,supplier.contact_person,supplier.contact_person_phone');
        $CI->db->select('warehouse.warehouse_name');
        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->join($CI->config->item('table_manufacture').' manufacture','manufacture.id = product.manufacture_id', 'LEFT');
        $CI->db->join($CI->config->item('table_product_category').' category','category.id = product.category_id', 'LEFT');
        $CI->db->join($CI->config->item('table_supplier').' supplier','supplier.id = product.supplier_id', 'LEFT');
        $CI->db->join($CI->config->item('table_warehouse').' warehouse','warehouse.id = product.warehouse_id', 'LEFT');
        $CI->db->where("product.id",$id);
        $results = $CI->db->get()->row_array();
        //echo $CI->db->last_query();
        return $results;
    }
}