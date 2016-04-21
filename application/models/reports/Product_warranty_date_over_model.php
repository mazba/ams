<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_warranty_date_over_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_list($inputs)
    {

        $CI =& get_instance();
        $CI->db->select('product.*');
        $CI->db->select('product.product_name,product.purchase_date,product.condition,product.warranty_end_date,product.purchase_date,product.warranty_end_date,product.product_code');
        $CI->db->select('manufacture.manufacture_name');
        $CI->db->select('category.category_name');
        $CI->db->select('supplier.company_name,supplier.contact_person,supplier.contact_person_phone');
        $CI->db->select('warehouse.warehouse_name');

        $CI->db->from($CI->config->item('table_product') . ' product');

        if ($inputs['start_date'] == $inputs['end_date'])
            $CI->db->where('product.warranty_end_date >=', strtotime($inputs['start_date']));
        else {

            if ($inputs['start_date'])
                $CI->db->where('product.warranty_end_date >=', strtotime($inputs['start_date']));
            if ($inputs['end_date'])
                $CI->db->where('product.warranty_end_date <=', strtotime($inputs['end_date']));
        }

//        if(!empty($inputs['start_date']) && !empty($inputs['end_date']) )
//        {
//            $CI->db->where('product_return.update_date >='. strtotime($inputs['start_date']).' AND product_return.update_date <='. strtotime($inputs['end_date']));
//        }

        if ($inputs['category'])
            $CI->db->where('product.category_id', $inputs['category']);


        if ($inputs['product_name'])
            $CI->db->where('product.id', $inputs['product_name']);

        if ($inputs['manufacture'])
            $CI->db->where('product.manufacture_id', $inputs['manufacture']);
        if ($inputs['supplier'])
            $CI->db->where('product.supplier_id', $inputs['supplier']);
        if ($inputs['warehouse'])
            $CI->db->where('product.warehouse_id', $inputs['warehouse']);

        $CI->db->join($CI->config->item('table_manufacture') . ' manufacture', 'manufacture.id = product.manufacture_id', 'LEFT');
        $CI->db->join($CI->config->item('table_product_category') . ' category', 'category.id = product.category_id', 'LEFT');
        $CI->db->join($CI->config->item('table_supplier') . ' supplier', 'supplier.id = product.supplier_id', 'LEFT');
        $CI->db->join($CI->config->item('table_warehouse') . ' warehouse', 'warehouse.id = product.warehouse_id', 'LEFT');
        $CI->db->where('product.warranty_end_date <',time() );
        $CI->db->where('product.warranty_end_date != ',0 );

        // $CI->db->group_by('product.product_name');
        $results = $CI->db->get()->result_array();
        // echo $CI->db->last_query();
        return $results;
    }
}