<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        //$this->db->select('*');
        $this->db->from($CI->config->item('table_product'));

        $results = $this->db->get()->result_array();
        $product_condition=$this->config->item('product_condition');
//            print_r($product_condition);die;
        foreach($results as &$result)
        {
            $result['edit_link']=$CI->get_encoded_url('asset_management/product/index/edit/'.$result['id']);
            if($result['condition']==0)
            {
                $result['status_text']=$product_condition[0];
            }
            else if($result['status']==1)
            {
                $result['status_text']=$product_condition[1];
            }
            else
            {
                $result['status_text']=$result['condition'];
            }
        }
        return $results;
    }
    public function get_product_name_by_str($str){
        $CI =& get_instance();
        //$this->db->select('*');
        $CI->db->from($CI->config->item('table_product'));
        $this->db->like('product_name', $str, 'after');
        $this->db->group_by('product_name');
//        $CI->db->where();
        $CI->db->select('product_name as label');
        $results = $this->db->get()->result_array();
        return $results;
    }
}