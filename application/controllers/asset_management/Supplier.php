<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('asset_management/supplier');
        if($this->permissions)
        {
            $this->permissions['delete']=0;
            $this->permissions['view']=0;
        }
        $this->controller_url='asset_management/supplier';
        $this->load->model("asset_management/supplier_model");
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
        elseif($action=='batch_edit')
        {
            $this->system_batch_edit();
        }
        elseif($action=='edit')
        {
            $this->system_edit($id);
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        elseif($action=='batch_details')
        {
            $this->system_batch_details();
        }
        elseif($action=='batch_delete')
        {
            $this->system_batch_delete();
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
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/supplier/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/supplier');
            $ajax['system_page_title']=$this->lang->line("SUPPLIER");
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

            $data['title']=$this->lang->line("CREATE_NEW_SUPPLIER");

            $data['supplier_info'] = array
            (
                'id'=>'',
                'company_name'=>'',
                'company_address'=>'',
                'company_office_phone'=>'',
                'company_office_fax'=>'',
                'contact_person'=>'',
                'contact_person_phone'=>'',
                'agreement_attachment'=>'',
                'supplier_description'=>'',
                'status'=>'',
            );

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/supplier/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('asset_management/supplier/index/add');
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_edit($id)
    {
        if($this->permissions['edit'])
        {
            $this->current_action='edit';
            $ajax['status']=true;
            $data=array();

            $data['title']=$this->lang->line("EDIT_SUPPLIER");
            $data['supplier_info']=Query_helper::get_info($this->config->item('table_supplier'),'*',array('id ='.$id),1);

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/supplier/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/supplier/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save()
    {
        $user=User_helper::get_user();
        $id = $this->input->post("id");
        if($id>0)
        {
            if(!$this->permissions['edit'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!$this->permissions['add'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }

        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $supplier_detail = $this->input->post('supplier');

            if($id>0)
            {
                unset($supplier_detail['id']);

                $supplier_detail['update_by']=$user->id;
                $supplier_detail['update_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::update($this->config->item('table_supplier'),$supplier_detail,array("id = ".$id));

                $this->db->trans_complete();   //DB Transaction Handle END

                if ($this->db->trans_status() === TRUE)
                {
                    $this->message=$this->lang->line("MSG_UPDATE_SUCCESS");
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
                    $ajax['system_message']=$this->lang->line("MSG_UPDATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
            else
            {
                $supplier_detail['status']=$this->config->item('STATUS_ACTIVE');
                $supplier_detail['create_by']=$user->id;
                $supplier_detail['create_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::add($this->config->item('table_supplier'),$supplier_detail);

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
    }

    private function system_batch_edit()
    {
        //        $selected_ids=$this->input->post('selected_ids');
        //        $this->system_edit($selected_ids[0]);
    }

    private function system_batch_delete()
    {
        //        if($this->permissions['delete'])
        //        {
        //            $user=User_helper::get_user();
        //            $selected_ids=$this->input->post('selected_ids');
        //            $this->db->trans_start();  //DB Transaction Handle START
        //            foreach($selected_ids as $id)
        //            {
        //                Query_helper::update($this->config->item('table_divisions'),array('status'=>99,'update_by'=>$user->id,'update_date'=>time()),array("id = ".$id));
        //            }
        //            $this->db->trans_complete();   //DB Transaction Handle END
        //
        //            if ($this->db->trans_status() === TRUE)
        //            {
        //                $this->message=$this->lang->line("MSG_DELETE_SUCCESS");
        //                $this->system_list();
        //            }
        //            else
        //            {
        //                $ajax['status']=false;
        //                $ajax['system_message']=$this->lang->line("MSG_DELETE_FAIL");
        //                $this->jsonReturn($ajax);
        //            }
        //        }
        //        else
        //        {
        //            $ajax['status']=false;
        //            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
        //            $this->jsonReturn($ajax);
        //        }
    }

    private function check_validation()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('supplier[company_name]',$this->lang->line('COMPANY_NAME'),'required');
        if($this->input->post('id')>0)
        {
            $this->form_validation->set_rules('supplier[status]',$this->lang->line('STATUS'),'required');
        }

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }



    public function get_list()
    {
        $Suppliers = array();
        if($this->permissions['list'])
        {
            $Suppliers = $this->supplier_model->get_record_list();
        }
        $this->jsonReturn($Suppliers);
    }



}
