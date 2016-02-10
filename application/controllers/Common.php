<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Root_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Common_model");

    }

    public function get_product_list()
    {
        $data = $this->Common_model->get_unassigned_product_list($this->input->post('warehouseId'));
        $ajax['status']= true;
        $ajax['system_content'][]=array("id"=>"#product_list","html"=>$this->load_view("product_list",array('data'=>$data),true));
        $this->jsonReturn($ajax);
    }

}
