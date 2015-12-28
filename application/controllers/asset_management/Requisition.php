<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisition extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('asset_management/requisition');
        if($this->permissions)
        {
            $this->permissions['delete']=0;
            $this->permissions['edit']=0;
        }
        $this->controller_url='asset_management/requisition';
        $this->load->model("asset_management/Requisition_model");
        $this->lang->load("asset_management", $this->get_language());
    }

    public function index($action='list',$id=0)
    {
        $this->current_action=$action;

        if($action=='list')
        {
            $this->system_list();
        }
        elseif($action=='add')
        {
            $this->system_add();
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        elseif($action=='batch_details')
        {
            $this->system_batch_details();
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
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/requisition/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/requisition');
            $ajax['system_page_title']=$this->lang->line("REQUISITION");
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_add()
    {


        if($this->permissions['add'])
        {

            $this->current_action='add';
            $ajax['status']=true;
            $data=array();

            $data['title']=$this->lang->line("CREATE_NEW_REQUISITION");
            $data['requisition_type']= $this->config->item('requisition_type');

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/requisition/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_title']=$this->lang->line("ADD_NEW_REQUISITION");
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/requisition/index/add');
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }
    private function system_save()
    {
        $user=User_helper::get_user();
        if(!$this->permissions['add'])
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
            die();
        }
        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $data = $this->input->post('requisition');
            $data['create_by']=$user->id;
            $data['create_date']=time();
            $data['user_id']=$user->id;
            $this->load->helper('string');

            $data['requisition_id'] = time().random_string('alpha',3);;

            $this->db->trans_start();  //DB Transaction Handle START

            Query_helper::add($this->config->item('table_requisition'),$data);

            $this->db->trans_complete();   //DB Transaction Handle END

            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_CREATE_SUCCESS");
                $save_and_new=$this->input->post('system_save_new_status');
                if($save_and_new==1)
                {
                    $this->system_add();
                }
                else
                {
                    $this->system_list();
                }
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_CREATE_FAIL");
                $this->jsonReturn($ajax);
            }
        }
    }

    private function system_batch_details()
    {
        if($this->permissions['view'])
        {
            $this->current_action='batch_details';
            $selected_ids=$this->input->post('selected_ids');
            $data['requisitions']=$this->Requisition_model->get_requisitons_details($selected_ids);
            $data['title']= $this->lang->line("REQUISITIONS_DETAILS");
            $ajax['status']=true;

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/requisition/detail",$data,true));
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function check_validation()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('requisition[requisition_title]',$this->lang->line('REQUISITION_TITLE'),'required');
        $this->form_validation->set_rules('requisition[description]',$this->lang->line('DESCRIPTION'),'required');
        $this->form_validation->set_rules('requisition[requisition_type]',$this->lang->line('REQUISITION_TYPE'),'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }



    public function get_list()
    {
        $data = array();
        if($this->permissions['list'])
        {
            $data = $this->Requisition_model->get_record_list();

        }
        $this->jsonReturn($data);
    }



}
