<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_reports extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('reports/ticket_reports');
        $this->controller_url='reports/ticket_reports';
        $this->load->model("reports/ticket_reports_model");
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
            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'),array('status !=99'));
            $data['products']=Query_helper::get_info($this->config->item('table_product'),array('id value', 'product_name text'), array('status !=99'));


            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("reports/ticket_reports/list",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('reports/ticket_reports');
            $ajax['system_page_title']=$this->lang->line("TICKET_RELATED_REPORT");
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    public function get_ticket_list()
    {
        $inputs = $this->input->post();
        $data['tickets'] = $this->ticket_reports_model->get_ticket_list($inputs);
        $ajax['system_content'][]=array("id"=>"#PrintArea","html"=>$this->load_view("reports/ticket_reports/report_format",$data,true));
        $this->jsonReturn($ajax);
    }
    public function get_product_list_by_category()
    {
        $category_id =$this->input->post('category_id');


        $products = Query_helper::get_info($this->config->item('table_product'),array('product_name value', 'product_name text'), array('category_id='.$category_id),0,0,'product_name');
        $ajax['status'] = true;
        $ajax['system_content'][] = array("id"=>"#product_name","html"=>$this->load_view("dropdown",array('drop_down_options'=>$products),true));
        $this->jsonReturn($ajax);
    }

}
