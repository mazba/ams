<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_assign_report extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions = Menu_helper::get_permission('reports/product_assign_report');
        $this->controller_url = 'reports/product_assign_report';
        $this->load->model("reports/Product_assign_report_model");
    }

    public function index($action='list',$id=0)
    {
        $this->current_action=$action;

        if($action=='list')
        {
            $this->system_list();
        }
        else
        {
            $this->system_list();
        }
    }

    private function system_list()
    {
        if($this->permissions['list'])
        {
            $this->current_action='list';
            $data['manufactures'] = Query_helper::get_info($this->config->item('table_manufacture'),array('id value','manufacture_name text'),array('status !=99'));
            $data['suppliers'] = Query_helper::get_info($this->config->item('table_supplier'),array('id value','company_name text'),array('status !=99'));
            $data['warehouses'] = Query_helper::get_info($this->config->item('table_warehouse'),array('id value','warehouse_name text'),array('status !=99'));
            $data['categories'] = Query_helper::get_info($this->config->item('table_product_category'),array('id value','category_name text'),array('status !=99'));
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("reports/product_assign_report/list",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('reports/product_assign_report');
            $ajax['system_page_title']=$this->lang->line("TICKET_RELATED_REPORT");
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    public function get_product_list()
    {
        $inputs = $this->input->post();
        $data['products'] = $this->Product_assign_report_model->get_product_list($inputs);
        $ajax['system_content'][]=array("id"=>"#PrintArea","html"=>$this->load_view("reports/product_assign_report/report_format",$data,true));
        $this->jsonReturn($ajax);
    }

}
