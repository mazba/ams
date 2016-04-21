<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Root_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->lang->load("ticket_management", $this->get_language());
        $this->lang->load("asset_management", $this->get_language());

    }

    public function get_product_list()
    {
        $data = $this->Common_model->get_unassigned_product_list($this->input->post('warehouseId'));
        $ajax['status']= true;
        $ajax['system_content'][]=array("id"=>"#product_list","html"=>$this->load_view("product_list",array('data'=>$data),true));
        $this->jsonReturn($ajax);
    }
    public function user_info()
    {
        $id = $_POST['id'];
        $data['users']=Query_helper::get_info($this->config->item('table_users'),'*', array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$id),1);
        $ajax['system_content'][]=array("id"=>"#user_model_body","html"=>$this->load_view("common/user_info",$data,true));
        $this->jsonReturn($ajax);

    }

    public function product_info()
    {
        $id = $_POST['id'];
        //$data['product_info']=Query_helper::get_info($this->config->item('table_product'),'*', array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$id),1);
        $data['product_info']=$this->Common_model->get_product_info_by_id($id);
        $ajax['system_content'][]=array("id"=>"#product_model_body","html"=>$this->load_view("common/product_info",$data,true));
        $this->jsonReturn($ajax);
    }


}
