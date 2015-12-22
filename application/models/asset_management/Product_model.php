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
        foreach($results as &$result)
        {
            $result['edit_link']=$CI->get_encoded_url('asset_management/product/index/edit/'.$result['id']);
            if($result['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $result['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($result['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $result['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $result['status_text']=$result['status'];
            }
        }
        return $results;
    }
}