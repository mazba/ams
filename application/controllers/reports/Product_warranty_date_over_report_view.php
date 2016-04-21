<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_warranty_date_over_report_view extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        //$this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        //$this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));

        $this->load->model("reports/Product_warranty_date_over_model");
    }

    public function index($task="search",$id=0)
    {
        if($task=="list")
        {
            $this->report_list();
        }
        else if($task=="pdf")
        {
            $this->report_list("pdf");
        }
        else
        {
            $this->search();
        }
    }
    private function report_list($format="")
    {
        if($format!="pdf")
        {
            $data['title']=$this->lang->line("PRODUCT_RELATED_REPORTS");
            $inputs = $this->input->get();
            $data['products'] = $this->Product_warranty_date_over_model->get_product_list($inputs);
            $this->load->view('default/reports/product_warranty_date_over_reports/report_format',$data);
        }
        else
        {
            $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
            $inputs = $this->input->get();
            $data['products'] = $this->Product_warranty_date_over_model->get_product_list($inputs);
            $html = $this->load->view('default/reports/product_warranty_date_over_reports/report_format',$data, true);
            System_helper::get_pdf($html);
        }
    }

}