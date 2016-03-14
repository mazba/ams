<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_reports_view extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();

        /*$this->template='default';
        $this->default_template='default';

        $this->language='bangla';
        $this->language_code='bn';*/

        //check security and loged user

        //$this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));

        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("reports/ticket_reports_model");
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
            $data['title']=$this->lang->line("TICKET_RELATED_REPORT");
            $inputs = $this->input->get();
            $data['tickets'] = $this->ticket_reports_model->get_ticket_list($inputs);
            $this->load->view('default/reports/ticket_reports/report_format',$data);
        }
        else
        {
            $data['title']=$this->lang->line("Title");
            $inputs = $this->input->get();
            $data['tickets'] = $this->ticket_reports_model->get_ticket_list($inputs);
            $html = $this->load->view('default/reports/ticket_reports/report_format',$data);
            System_helper::get_pdf($html);


        }
    }

}