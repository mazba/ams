<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_return extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('asset_management/Product_return');
        if($this->permissions)
        {    $this->permissions['add']=0;
            $this->permissions['delete']=0;
            $this->permissions['view']=0;
           // $this->permissions['edit']=0;
        }
        $this->controller_url='asset_management/Product_return';
        $this->load->model("asset_management/Product_return_model");
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
//        elseif($action=='batch_edit')
//        {
//            $this->system_batch_edit();
//        }
        elseif($action=='edit'|| $action=='batch_edit')
        {
            $this->system_edit($id);
        }
        elseif($action=='save')
        {
            $this->system_save();
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
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/product_return/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/Product_return');
            $ajax['system_page_title']=$this->lang->line("PRODUCT_RETURN_LIST");
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

            $data['title']=$this->lang->line("NEW_Product_return");

            $data['product'] = array
            (
                'id'=>'',
                'product_name'=>'',
                'product_code'=>'',
            );
            $data['product'] = $this->Product_return_model->get_unassigned_products();
            $data['user'] = Query_helper::get_list($this->config->item('table_users'),'name_en',array('status = 1'));

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/Product_return/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_title']=$this->lang->line("NEW_Product_return");
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/Product_return/index/add');
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
            $this->current_action='batch_details';
            $ajax['status']=true;
            $data=array();

            $data['title']=$this->lang->line("EDIT_RETURN_PRODUCT_INFORMATION");
            $data['user_products']=$this->Product_return_model->get_assigend_product($id);
            $data['user_info']=Query_helper::get_info($this->config->item('table_users'),'*',array('id ='.$id),1);
           // $data['product']=Query_helper::get_info($this->config->item('table_product'),'*',array('id ='.$id),1);

           // $data['category'] = Query_helper::get_list($this->config->item('table_product_category'),'category_name',array('status = 1'));
//            $data['manufacture'] = Query_helper::get_list($this->config->item('table_manufacture'),'manufacture_name',array('status = 1'));
//            $data['supplier'] = Query_helper::get_list($this->config->item('table_supplier'),'company_name',array('status = 1'));
//            $data['warehouse'] = Query_helper::get_list($this->config->item('table_warehouse'),'warehouse_name',array('status = 1'));

            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("asset_management/product_return/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('asset_management/product_return/index/edit/'.$id);
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
            $data = $this->input->post('Product_return');
            $data['create_by']=$user->id;
            $data['create_date']=time();
            $data['status'] = 1;

            $data['assign_date']= strtotime($data['assign_date']);
            $data['return_date']= strtotime($data['return_date']);

            $this->db->trans_start();  //DB Transaction Handle START
            $inserted_product = array();
            foreach($data['product_id'] as $product)
            {
                $data['product_id'] = $product;
                if(!in_array($product,$inserted_product))
                Query_helper::add($this->config->item('table_Product_return'),$data);

                $inserted_product[] = $product;
            }

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

    private function check_validation()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('Product_return[product_id]',$this->lang->line('PRODUCT'),'required');
        $this->form_validation->set_rules('Product_return[user_id]',$this->lang->line('USER'),'required');
        $this->form_validation->set_rules('Product_return[assign_date]',$this->lang->line('ASSIGN_DATE'),'required');

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
            $data = $this->Product_return_model->get_record_list();
        }
        $this->jsonReturn($data);
    }

    public function get_product_user_list(){
        $data = array();
        if($this->permissions['list'])
        {
            $data = $this->Product_return_model->get_user_list();
        }
        $this->jsonReturn($data);
    }
    public function unassigned_product(){
        $user=User_helper::get_user();
        $id= $this->input->post('assign_id');
        if($id>0){
            $data= array();
            $data['update_by']=$user->id;
            $data['update_date']=time();
            $data['status']=0;
            $this->Product_return_model->update_assign_produce($id,$data);
        }
        return  $this->jsonReturn('tes') ;
    }

    public function reject_product(){
        $user=User_helper::get_user();
        $id= $this->input->post('assign_id');
        if($id>0){
            $data= array();
            $data['update_by']=$user->id;
            $data['update_date']=time();
            $data['status']=0;
            Query_helper::update($this->config->item('table_product_assign'),$data,array('product_id ='.$id));
    //        $this->Product_return_model->update_assign_produce($id,$data);

            $s_data= array();
            $s_data['update_by']=$user->id;
            $s_data['update_date']=time();
            $s_data['status']=99;

            Query_helper::update($this->config->item('table_product'),$s_data,array('id ='.$id));

        }
        return  $this->jsonReturn('tes') ;
    }



}
