<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CurrentStock_report_view extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        //$this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        //$this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("reports/Current_stock_model");
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
            $data['title']=$this->lang->line("TITLE");
            $inputs = $this->input->post();
            $data['data'] = $this->Current_stock_model->get_product_list($inputs);
            $this->load->view('default/reports/current_stock/report_format',$data);
        }
        else
        {
            $data['title']=$this->lang->line("TITLE");
            $inputs = $this->input->post();
            $data['data'] = $this->Current_stock_model->get_product_list($inputs);
            $html =  $this->load->view('default/reports/current_stock/report_format',$data);
            System_helper::get_pdf($html);

        }
    }

}