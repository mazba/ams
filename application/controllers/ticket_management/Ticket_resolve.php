<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_resolve extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('ticket_management/ticket_resolve');
        if($this->permissions)
        {
            $this->permissions['add']=0;
            $this->permissions['delete']=0;
            //$this->permissions['view']=0;
        }
        $this->controller_url='ticket_management/ticket_resolve';
        $this->load->model("ticket_management/ticket_resolve_model");
        $this->load->model("Common_model");

        $this->lang->load("ticket_management", $this->get_language());
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
            $this->system_batch_details($id);
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
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_resolve/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_resolve');
            $ajax['system_page_title']=$this->lang->line("LIST_TICKET_RESOLVE");
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

        //        if($this->permissions['add'])
        //        {
        //
        //            $this->current_action='add';
        //            $ajax['status']=true;
        //            $data=array();
        //
        //            $data['title']=$this->lang->line("NEW_TICKET_RESOLVE");
        //
        //            $data['ticket'] = array
        //            (
        //                'id'=>'',
        //                'ticket_issue_id'=>'',
        //                'user_id'=>'',
        //                'resolved_date'=>'',
        //                'remarks'=>'',
        //                'status'=>'',
        //            );
        //
        //            $data['users'] = $this->ticket_resolve_model->get_user();
        //            $data['ticket_issues'] = $this->ticket_resolve_model->get_ticket_issue();
        //            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_resolve/add_edit",$data,true));
        //
        //            if($this->message)
        //            {
        //                $ajax['system_message']=$this->message;
        //            }
        //
        //            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_resolve/index/add');
        //            $this->jsonReturn($ajax);
        //        }
        //        else
        //        {
        //            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
        //            $this->jsonReturn($ajax);
        //        }
    }

    private function system_edit($id)
    {
        if($this->permissions['edit'])
        {
            $this->current_action='edit';
            $ajax['status']=true;
            $data=array();

            $data['title']=$this->lang->line("EDIT_TICKET_RESOLVE");
            $data['ticket']=Query_helper::get_info($this->config->item('table_ticket_assign'),'*',array('id ='.$id),1);
            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'), array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$data['ticket']['user_id']));
            $data['ticket_status']=Query_helper::get_info($this->config->item('table_ticket_resolve_status'),array('id value', 'name text'), array('status = '.$this->config->item('STATUS_ACTIVE')));
            $data['ticket_issue'] = $this->ticket_resolve_model->get_ticket_assign($data['ticket']['id']);
            $data['user_info']=Query_helper::get_info($this->config->item('table_users'),'*', array('id = '. $data['ticket_issue']['user_id']),'1');
          //  $data['product_info']=Query_helper::get_info($this->config->item('table_product'),'*', array('id = '. $data['ticket_issue']['product_id']),'1');
            $data['product_info']=$this->Common_model->get_product_info_by_id($data['ticket_issue']['product_id']);
          //  print_r($data['user_info']);die();
            $data['comments'] = $this->ticket_resolve_model->get_ticket_comments($data['ticket']['ticket_issue_id']);
            //$data['comments']=Query_helper::get_info($this->config->item('table_ticket_resolve_comment'),'*',array('ticket_issue_id ='.$data['ticket']['ticket_issue_id']),1);
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_resolve/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_resolve/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_batch_details($id)
    {
        //        if($this->permissions['view'])
        //        {
        //            $this->current_action='batch_details';
        //            $ajax['status']=true;
        //            $data=array();
        //
        //            $data['title']=$this->lang->line("VIEW_DETAILS_TICKET_RESOLVE");
        //            $data['ticket']=Query_helper::get_info($this->config->item('table_ticket_resolve'),'*',array('user_id ='.$id),1);
        //            $data['users']=Query_helper::get_info($this->config->item('table_users'),array('id value', 'name_bn text'), array('status = '.$this->config->item('STATUS_ACTIVE'), "id = ".$id));
        //            //$data['ticket_issues'] = $this->ticket_resolve_model->get_ticket_assign($id);
        //            //$data['products'] = $this->ticket_resolve_model->get_product($data['users'][0]['value'], $data['ticket']['product_id']);
        //            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("ticket_management/ticket_resolve/details",$data,true));
        //            if($this->message)
        //            {
        //                $ajax['system_message']=$this->message;
        //            }
        //
        //            $ajax['system_page_url']=$this->get_encoded_url('ticket_management/ticket_resolve/index/batch_details/'.$id);
        //            $this->jsonReturn($ajax);
        //        }
        //        else
        //        {
        //            $ajax['status']=true;
        //            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
        //            $this->jsonReturn($ajax);
        //        }
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
            $comment_detail=$this->input->post('comment');

            if($id>0)
            {

                $this->db->trans_start();  //DB Transaction Handle START

                if($user->user_group_level==$this->config->item('SUPPORT_GROUP_ID'))
                {
                    $comment_detail['type']=$this->config->item('ticket_comment_support_user');
                    $comment_detail['ticket_assign_id']=$id;
                    $comment_detail['create_by']=$user->id;
                    $comment_detail['create_date']=time();
                    Query_helper::add($this->config->item('table_ticket_resolve_comment'),$comment_detail);
                }
                elseif($user->user_group_level==$this->config->item('OFFICER_GROUP_ID'))
                {
                    $comment_detail['type']=$this->config->item('ticket_comment_manager');
                    $comment_detail['ticket_assign_id']=$id;
                    $comment_detail['create_by']=$user->id;
                    $comment_detail['create_date']=time();
                    Query_helper::add($this->config->item('table_ticket_resolve_comment'),$comment_detail);

                    $ticket_issue_detail['update_by']=$user->id;
                    $ticket_issue_detail['create_date']=time();
                    if(!empty($comment_detail['ticket_status_id']))
                    {
                        $ticket_issue_detail['status']=$comment_detail['ticket_status_id'];
                    }
                    else
                    {
                        unset($ticket_issue_detail['status']);
                    }

                    Query_helper::update($this->config->item('table_ticket_issue'),$ticket_issue_detail,array("id = ".$comment_detail['ticket_issue_id']));

                    $ticket_assign_detail['update_by']=$user->id;
                    $ticket_assign_detail['create_date']=time();
                    if(!empty($comment_detail['ticket_status_id']))
                    {
                        $ticket_assign_detail['status']=$comment_detail['ticket_status_id'];
                    }
                    else
                    {
                        unset($ticket_assign_detail['status']);
                    }
                    Query_helper::update($this->config->item('table_ticket_assign'),$ticket_assign_detail,array("id = ".$id));
                }
                elseif($user->user_group_level==$this->config->item('END_GROUP_ID'))
                {
                    $comment_detail['type']=$this->config->item('ticket_comment_end_user');
                    $comment_detail['ticket_assign_id']=$id;
                    $comment_detail['create_by']=$user->id;
                    $comment_detail['create_date']=time();
                    Query_helper::add($this->config->item('table_ticket_resolve_comment'),$comment_detail);
                }
                else
                {

                }

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
                //                $comment_detail['status']=$this->config->item('STATUS_PENDING');
                //                $comment_detail['create_by']=$user->id;
                //                $comment_detail['create_date']=time();
                //
                //                $ticket_issue_detail['status']=$this->config->item('STATUS_ASSIGN');
                //                $ticket_issue_detail['create_by']=$user->id;
                //                $ticket_issue_detail['create_date']=time();
                //
                //                $this->db->trans_start();  //DB Transaction Handle START
                //                for($i=0;$i<$count;$i++)
                //                {
                //                    if(isset($ticket_issue_id[$i]))
                //                    {
                //                        //echo $ticket_issue_id[$i]."<br />";
                //                        $comment_detail['user_id']=$user_id;
                //                        $comment_detail['ticket_issue_id']=$ticket_issue_id[$i];
                //                        Query_helper::add($this->config->item('table_ticket_resolve'),$comment_detail);
                //                        Query_helper::update($this->config->item('table_ticket_issue'),$ticket_issue_detail,array("id = ".$ticket_issue_id[$i]));
                //                    }
                //                }
                //
                //                $this->db->trans_complete();   //DB Transaction Handle END
                //
                //                if ($this->db->trans_status() === TRUE)
                //                {
                //                    $this->message=$this->lang->line("MSG_CREATE_SUCCESS");
                //                    $save_and_new=$this->input->post('system_save_new_status');
                //                    if($save_and_new==1)
                //                    {
                //                        $this->system_add();
                //                    }
                //                    else
                //                    {
                //                        $this->system_list();
                //                    }
                //                }
                //                else
                //                {
                //                    $ajax['status']=false;
                //                    $ajax['system_message']=$this->lang->line("MSG_CREATE_FAIL");
                //                    $this->jsonReturn($ajax);
                //                }
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

        //$this->form_validation->set_rules('comment[resolved_date]',$this->lang->line('RESOLVE_DATE'),'required');
        $this->form_validation->set_rules('comment[comment]',$this->lang->line('RESOLVE_REMARKS'),'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            return false;
        }
        return true;
    }



    public function get_list()
    {
        $ticket_resolves = array();
        if($this->permissions['list'])
        {
            $ticket_resolves = $this->ticket_resolve_model->get_record_list();
        }
        $this->jsonReturn($ticket_resolves);
    }


}
