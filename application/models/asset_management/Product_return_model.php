<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_return_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_list(){
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.status,user.name_en user_name, user.email,user.phone');
        $CI->db->select('user.id id');
        $CI->db->select('count(pa.id) nub_of_product');
        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
        //$CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
        $CI->db->where('pa.status = 1');

        $CI->db->group_by('user.id');
        $results = $this->db->get()->result_array();
        foreach($results as &$result)
        {
            $result['edit_link'] = $CI->get_encoded_url('asset_management/product_return/index/edit/'.$result['id']);
            $result['nub_of_product'] = System_helper::Get_Eng_to_Bng($result['nub_of_product']);

        }
        return $results;
    }

    public function get_assigend_product($id){
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.id,pa.status,pa.assign_date,pa.return_date,pa.remarks,user.name_en user_name,product.product_name,product.warranty_end_date,product.product_code');
        $CI->db->select('pa.id assign_product_id,pa.product_id');
        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
        $CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
        $CI->db->where('user.id',$id);
        $CI->db->where('pa.status = 1');

        $results = $this->db->get()->result();


        return $results;
    }

//    public function get_record_list()
//    {
//        $CI =& get_instance();
//
//        $CI->db->from($CI->config->item('table_product_assign').' pa');
//        $CI->db->select('pa.id,pa.status,pa.assign_date,pa.return_date,pa.remarks,user.name_en user_name,product.product_name');
//        $CI->db->join($CI->config->item('table_users'). ' user','user.id = pa.user_id','LEFT');
//        $CI->db->join($CI->config->item('table_product'). ' product','product.id = pa.product_id','LEFT');
//        $CI->db->where('pa.status = 1');
//
//        $results = $this->db->get()->result_array();
//
//        foreach($results as &$result)
//        {
//            $result['edit_link'] = $CI->get_encoded_url('asset_management/product_return/index/edit/'.$result['id']);
//            $result['assign_date'] = System_helper::display_date($result['assign_date']);
//            $result['return_date'] = System_helper::display_date($result['return_date']);
//            if($result['status']==$this->config->item('STATUS_ACTIVE'))
//            {
//                $result['status_text']=$CI->lang->line('ACTIVE');
//            }
//            else if($result['status']==$this->config->item('STATUS_INACTIVE'))
//            {
//                $result['status_text']=$CI->lang->line('INACTIVE');
//            }
//            else
//            {
//                $result['status_text']=$result['status'];
//            }
//        }
//        return $results;
//    }
    public function get_unassigned_products()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.id');
        $CI->db->where('pa.status', 1);
        $sub = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.product_name,product.product_code,product.id');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $results = $this->db->get()->result_array();
        $data = array();
        foreach($results as $result)
        {
            $data[] = array('text'=>$result['product_name']." (".$result['product_code'].")",
                            'value'=>$result['id']);
        }
        return $data;
    }

    public function update_assign_produce($id,$data){
        $CI =& get_instance();
        $CI->db->where('product_id', $id);
        $CI->db->update($CI->config->item('table_product_assign'), $data);
    }
}