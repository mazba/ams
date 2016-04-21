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

    public function get_product_name($str){
        $CI =& get_instance();
        //$this->db->select('*');
        $CI->db->from($CI->config->item('table_product'));
        $this->db->like('product_name', $str, 'after');
//        $CI->db->where();
        $CI->db->select("CONCAT(product_name, '.',product_code) as label",FALSE);
        $CI->db->select('product_name as product_name,product_code as product_code,serial_number as serial_numb,unit_price as unit_price,model_no as model_no,warranty_start_date as warranty_start_date,warranty_end_date as warranty_end_date,condition as status');


        $results = $this->db->get()->result_array();

        foreach($results as &$val){
            if($val['status']==0){
            $val['status']="সক্রিয়";
            }else{
                $val['status']="ত্রুটিপূর্ণ";
            }
            if($val['warranty_start_date']>0){
                $val['warranty_start_date']= System_helper::display_date( $val['warranty_start_date']);
            }
            if($val['warranty_end_date']>0){
                $val['warranty_end_date']= System_helper::display_date( $val['warranty_end_date']);
            }
        }
        return $results;
    }

}