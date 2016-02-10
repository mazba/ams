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
}