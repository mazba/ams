<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_issue extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('ticket_management/ticket_issue');
        if($this->permissions)
        {
            $this->permissions['edit']=0;
            $this->permissions['delete']=0;
            //$this->permissions['view']=0;
        }
        $this->controller_url='ticket_management/ticket_issue';
        $this->load->model("ticket_management/ticket_issue_model");
        $this->lang->load("ticket_management", $this->get_language());
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
//        elseif($action=='edit')
//        {
//            $this->system_edit($id);
//        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        elseif($action=='batch_details')
        {
            $this->system_batch_details($id);
        }
//        elseif($action=='batch_delete')
//        {
//            $this->system_batch_delete();
//        }
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
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_issue/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_issue');
            $ajax['system_page_title']=$this->lang->line("LIST_TICKET_ISSUE");
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

            $data['title']=$this->lang->line("NEW_TICKET_ISSUE");

            $data['ticket'] = array
            (
                'id'=>'',
                'user_id'=>'',
                'product_id'=>'',
                'subject'=>'',
                'ticket_issue_description'=>'',
                'status'=>'',
            );
            $user=User_helper::get_user();

            if($user->user_group_level==$this->config->item('END_GROUP_ID') || $user->user_group_level==$this->config->item('TOP_MANAGEMENT_GROUP_ID') || $user->user_group_level==$this->config->item('SUPPORT_GROUP_ID') || $user->user_group_level==$this->config->item('OPERATOR_GROUP_ID'))
            {
                $user_condition=array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$user->id);
                $data['products'] = $this->ticket_issue_model->get_product($user->id);
            }
            else
            {
                $user_condition=array('status = '.$this->config->item('STATUS_ACTIVE'));
                $data['products'] = array();
            }

            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'), $user_condition);
            // $data['products']=Query_helper::get_info($this->config->item('table_product'),array('id value', 'product_name text'), $product_condition);
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_issue/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_issue/index/add');
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

            $data['title']=$this->lang->line("EDIT_TICKET_ISSUE");
            $data['ticket']=Query_helper::get_info($this->config->item('table_ticket_issue'),'*',array('id ='.$id),1);

            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'), array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$data['ticket']['user_id']));
            $data['products'] = $this->ticket_issue_model->get_product($data['users'][0]['value'], $data['ticket']['product_id']);
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_issue/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_issue/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function details($id)
    {

        if($this->permissions['view'])
        {
            $this->permissions['edit']=1;
            if(is_array($id))
                $id = System_helper::Get_Bng_to_Eng($id[0]);
            $this->current_action='edit';
            $ajax['status']=true;
            $data=array();

            $data['title']=$this->lang->line("VIEW_DETAILS_TICKET_ISSUE");
            $data['ticket']=Query_helper::get_info($this->config->item('table_ticket_issue'),'*',array('id = '. $id ),1);
            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'), array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$data['ticket']['user_id']));
            $data['products'] = $this->ticket_issue_model->get_product($data['users'][0]['value'], $data['ticket']['product_id']);
            $data['ticket_assign']=Query_helper::get_info($this->config->item('table_ticket_assign'),'*',array('ticket_issue_id ='.$id),1);
            $data['comments'] = $this->ticket_issue_model->get_ticket_comments($id);
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_issue/details",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_issue/index/batch_details/'.$id);
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
            $ticket_detail = $this->input->post('ticket');

            $dir = $this->config->item("file_upload");

            $uploaded = System_helper::upload_file($dir['ticket_issue'],1024,'gif|jpg|png|xls|xlsx|pdf|doc|docx');

            if(array_key_exists('issue_attachment',$uploaded))
            {
                if($uploaded['issue_attachment']['status'])
                {
                    $ticket_detail['issue_attachment'] = $uploaded['issue_attachment']['info']['file_name'];
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message.=$uploaded['issue_attachment']['message'].'<br>';
                    $this->jsonReturn($ajax);
                }
            }
            $comment_detail=$this->input->post('comment');
            if($id>0)
            {
                unset($ticket_detail['id']);

                $ticket_detail['update_by']=$user->id;
                $ticket_detail['update_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                //Query_helper::update($this->config->item('table_ticket_issue'),$ticket_detail,array("id = ".$id));
                $comment_detail['type']=$this->config->item('ticket_comment_end_user');
                $comment_detail['ticket_issue_id']=$id;
                $comment_detail['create_by']=$user->id;
                $comment_detail['create_date']=time();
                Query_helper::add($this->config->item('table_ticket_resolve_comment'),$comment_detail);

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
                $ticket_detail['status']=$this->config->item('STATUS_INACTIVE');
                $ticket_detail['create_by']=$user->id;
                $ticket_detail['create_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::add($this->config->item('table_ticket_issue'),$ticket_detail);

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

    private function system_batch_details($ids)
    {
        if(!$ids)
        $ids=$this->input->post('selected_ids');
        $this->details($ids);
    }



    private function check_validation()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('ticket[user_id]',$this->lang->line('USER_NAME'),'required');
        $this->form_validation->set_rules('ticket[subject]',$this->lang->line('SUBJECT'),'required');
        if($this->input->post('id')>0)
        {

        }
        else
        {
            $this->form_validation->set_rules('ticket[user_id]',$this->lang->line('USER_NAME'),'required');
            //$this->form_validation->set_rules('ticket[product_id]',$this->lang->line('PRODUCT_NAME'),'required');
            $this->form_validation->set_rules('ticket[subject]',$this->lang->line('SUBJECT'),'required');

            if($this->input->post('id')>0)
            {
                $this->form_validation->set_rules('ticket[status]',$this->lang->line('STATUS'),'required');
            }

            if($this->form_validation->run() == FALSE)
            {
                $this->message=validation_errors();
                return false;
            }

        }

        return true;
    }



    public function get_list()
    {
        $ticket_issues = array();
        if($this->permissions['list'])
        {
            $ticket_issues = $this->ticket_issue_model->get_record_list();
        }
        $this->jsonReturn($ticket_issues);
    }

    public function ajax_product_load()
    {
        $user_id=$this->input->post('user_id');
        $products = $this->ticket_issue_model->get_product($user_id);
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#product_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$products),true));
        $this->jsonReturn($ajax);
    }

}
