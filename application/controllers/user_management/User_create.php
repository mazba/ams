<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_create extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('user_management/user_create');
        if($this->permissions)
        {
            $this->permissions['delete']=0;
            $this->permissions['view']=0;
        }
        $this->controller_url='user_management/user_create';
        $this->load->model("user_management/user_create_model");
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
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("user_management/user_create/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('user_management/user_create');
            $ajax['system_page_title']=$this->lang->line("product_category");
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

            $data['title']=$this->lang->line("CREATE_NEW_USER");

            $data['userInfo'] = array
            (
                'id'=>'',
                'username'=>'',
                'password'=>'',
                'name_bn'=>'',
                'name_en'=>'',
                'user_group_id'=>'',
                'user_group_level'=>'',
                'designation'=>'',
                'gender'=>'',
                'phone'=>'',
                'office_phone'=>'',
                'mobile'=>'',
                'email'=>'',
                'national_id_no'=>'',
                'present_address'=>'',
                'permanent_address'=>'',
                'picture_name'=>'',
                'dob'=>'',
                'type'=>'',
                'gender'=>1,
                'status'=>''
            );

            $this->db->from($this->config->item('table_user_group'));
            $this->db->where('status != 99');
            $this->db->select("concat_ws('-', id, level) value",false);
            $this->db->select("name_".$this->get_language_code()." text");
            $data['groups']=$this->db->get()->result_array();

            $data['designations']=Query_helper::get_info($this->config->item('table_designation'),array('id value', 'name_bn text'), array());
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("user_management/user_create/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('user_management/user_create/index/add');
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

            $data['title']=$this->lang->line("EDIT_USER");
            $data['userInfo']=Query_helper::get_info($this->config->item('table_users'),'*',array('id ='.$id),1);
            $user_group_id_level=Query_helper::get_info($this->config->item('table_user_group'),'*',array('id ='.$data['userInfo']['user_group_id']),1);
            $data['userInfo']['user_group_level']=$user_group_id_level['level'];

            $this->db->from($this->config->item('table_user_group'));
            $this->db->where('status != 99');
            $this->db->select("concat_ws('-', id, level) value",false);
            $this->db->select("name_".$this->get_language_code()." text");
            $data['groups']=$this->db->get()->result_array();

            $data['designations']=Query_helper::get_info($this->config->item('table_designation'),array('id value', 'name_bn text'), array());
            
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("user_management/user_create/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('user_management/user_create/index/edit/'.$id);
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
            $userDetail = $this->input->post('user_detail');
            if($id>0)
            {
                if($userDetail['password']!="")
                {
                    $encryptPass = md5(md5($userDetail['password']));
                    unset($userDetail['password']);
                    unset($userDetail['confirm_password']);
                    $userDetail['password'] = $encryptPass;
                }
                else
                {
                    unset($userDetail['password']);
                    unset($userDetail['confirm_password']);
                }
            }
            else
            {
                $encryptPass = md5(md5($userDetail['password']));
                unset($userDetail['password']);
                unset($userDetail['confirm_password']);
                $userDetail['password'] = $encryptPass;
            }

            $user_group_id_level=explode('-',$this->input->post("user_detail[user_group_id]"));
            $user_group_id=$user_group_id_level[0];
            //$user_group_level=$user_group_id_level[1];
            $userDetail['user_group_id']=$user_group_id;

            $date_of_birth=strtotime($userDetail['dob']);
            $userDetail['dob']=$date_of_birth;

            $dir = $this->config->item("file_upload");

            $uploaded = System_helper::upload_file($dir['users'],1024,'gif|jpg|png');

            if(array_key_exists('picture_name',$uploaded))
            {
                if($uploaded['picture_name']['status'])
                {
                    $userDetail['picture_name'] = $uploaded['picture_name']['info']['file_name'];
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message.=$uploaded['picture_name']['message'].'<br>';
                    $this->jsonReturn($ajax);
                }
            }

            if($id>0)
            {
                unset($userDetail['id']);

                $userDetail['update_by']=$user->id;
                $userDetail['update_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::update($this->config->item('table_users'),$userDetail,array("id = ".$id));

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
                $userDetail['status']=$this->config->item('STATUS_ACTIVE');
                $userDetail['create_by']=$user->id;
                $userDetail['create_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::add($this->config->item('table_users'),$userDetail);

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

        $this->form_validation->set_rules('user_detail[user_group_id]',$this->lang->line('GROUP_NAME'),'required');
        $this->form_validation->set_rules('user_detail[name_bn]',$this->lang->line('NAME_BN'),'required');
        $this->form_validation->set_rules('user_detail[name_en]',$this->lang->line('NAME_EN'),'required');
        $this->form_validation->set_rules('user_detail[username]',$this->lang->line('USER_NAME'),'required');
        $this->form_validation->set_rules('user_detail[email]',$this->lang->line('EMAIL'),'required|valid_email');
        $this->form_validation->set_rules('user_detail[designation]',$this->lang->line('DESIGNATION'),'required');
        $this->form_validation->set_rules('user_detail[type]',$this->lang->line('USER_TYPE'),'required');
        $this->form_validation->set_rules('user_detail[gender]',$this->lang->line('GENDER'),'required');
        //$this->form_validation->set_rules('user_detail[password]',$this->lang->line('PASSWORD'),'required');
        //$this->form_validation->set_rules('user_detail[confirm_password]',$this->lang->line('PASSWORD'),'required');
        //$this->form_validation->set_rules('user_detail[mobile]',$this->lang->line('MOBILE_NUMBER'),'required');

        $userDetail = $this->input->post('user_detail');
        if($this->input->post('id')>0)
        {
            if($userDetail['password']!="")
            {
                $this->form_validation->set_rules('user_detail[password]',$this->lang->line('PASSWORD'),'required');
                $this->form_validation->set_rules('user_detail[confirm_password]',$this->lang->line('PASSWORD'),'required');
                if($userDetail['password']!=$userDetail['confirm_password'])
                {
                    $this->message.=$this->lang->line('NOT_MATCH_CONFIRM_PASSWORD');
                    return false;
                }
            }
        }
        else
        {
            $this->form_validation->set_rules('user_detail[password]',$this->lang->line('PASSWORD'),'required');
            $this->form_validation->set_rules('user_detail[confirm_password]',$this->lang->line('PASSWORD'),'required');
            if($userDetail['password']!=$userDetail['confirm_password'])
            {
                $this->message.=$this->lang->line('NOT_MATCH_CONFIRM_PASSWORD');
                return false;
            }
        }

        if($this->input->post('id')>0)
        {
            $this->form_validation->set_rules('user_detail[status]',$this->lang->line('STATUS'),'required');
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
        $categories = array();
        if($this->permissions['list'])
        {
            $categories = $this->user_create_model->get_record_list();
        }
        $this->jsonReturn($categories);
    }



}
