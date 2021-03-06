<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;

    function __construct()
    {
        parent::__construct();
        $this->message = '';
        $this->permissions = Menu_helper::get_permission('asset_management/product');
        if ($this->permissions) {
            $this->permissions['delete'] = 0;
            $this->permissions['view'] = 0;
        }
        $this->controller_url = 'asset_management/Product';
        $this->load->model("asset_management/Product_model");
        $this->lang->load("asset_management", $this->get_language());
    }

    public function index($action = 'list', $id = 0)
    {
        $this->current_action = $action;

        if ($action == 'list') {
            $this->system_list();
        } elseif ($action == 'add') {
            $this->system_add();
        } elseif ($action == 'batch_edit') {
            $this->system_batch_edit();
        } elseif ($action == 'edit') {
            $this->system_edit($id);
        } elseif ($action == 'save') {
            $this->system_save();
        }
//        elseif($action=='batch_details')
//        {
//            $this->system_batch_details();
//        }
        elseif ($action == 'batch_delete') {
            $this->system_batch_delete();
        } else {
            $this->system_list();
        }
    }

    private function system_list()
    {
        if ($this->permissions['list']) {
            $this->current_action = 'list';
            $ajax['status'] = true;
            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("asset_management/product/list", "", true));

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }
            $ajax['system_page_url'] = $this->get_encoded_url('asset_management/product');
            $ajax['system_page_title'] = $this->lang->line("PRODUCT");
            $this->jsonReturn($ajax);
        } else {
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_add()
    {
        if ($this->permissions['add']) {
            $this->current_action = 'add';
            $ajax['status'] = true;
            $data = array();

            $data['title'] = $this->lang->line("CREATE_NEW_PRODUCT");

            $data['product'] = array
            (
                'id' => '',
                'product_name' => '',
                'product_code' => '',
                'serial_number' => '',
                'category_id' => '',
                'manufacture_id' => '',
                'supplier_id' => '',
                'warehouse_id' => '',
                'unit_price' => '',
                'quantity' => '',
                'item_unit' => '',
                'sort_description' => '',
                'specification' => '',
                'model_no' => '',
                'condition' => '',
                'warranty_start_date' => '',
                'warranty_end_date' => '',
                'stock_book_no' => '',
                'purchase_order_no' => '',
                'purchase_date' => '',
                'status' => 1,
                'remarks' => '',
                'others' => '',
            );
            $data['category'] = Query_helper::get_list($this->config->item('table_product_category'), 'category_name', array('status = 1'));
            $data['manufacture'] = Query_helper::get_list($this->config->item('table_manufacture'), 'manufacture_name', array('status = 1'));
            $data['supplier'] = Query_helper::get_list($this->config->item('table_supplier'), 'company_name', array('status = 1'));
            $data['warehouse'] = Query_helper::get_list($this->config->item('table_warehouse'), 'warehouse_name', array('status = 1'));

            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("asset_management/product/add_edit", $data, true));

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }
            $ajax['system_page_title'] = $this->lang->line("ADD_PRODUCT");
            $ajax['system_page_url'] = $this->get_encoded_url('asset_management/product/index/add');
            $this->jsonReturn($ajax);
        } else {
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_edit($id)
    {
        if ($this->permissions['edit']) {
            $this->current_action = 'edit';
            $ajax['status'] = true;
            $data = array();

            $data['title'] = $this->lang->line("EDIT_PRODUCT");
            $data['product'] = Query_helper::get_info($this->config->item('table_product'), '*', array('id =' . $id), 1);

            $data['category'] = Query_helper::get_list($this->config->item('table_product_category'), 'category_name', array('status = 1'));
            $data['manufacture'] = Query_helper::get_list($this->config->item('table_manufacture'), 'manufacture_name', array('status = 1'));
            $data['supplier'] = Query_helper::get_list($this->config->item('table_supplier'), 'company_name', array('status = 1'));
            $data['warehouse'] = Query_helper::get_list($this->config->item('table_warehouse'), 'warehouse_name', array('status = 1'));

            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("asset_management/product/add_edit", $data, true));
            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }
            $ajax['system_page_url'] = $this->get_encoded_url('asset_management/product/index/edit/' . $id);
            $this->jsonReturn($ajax);
        } else {
            $ajax['status'] = true;
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save()
    {
        $user = User_helper::get_user();
        $id = $this->input->post("id");
        if ($id > 0) {
            if (!$this->permissions['edit']) {
                $ajax['status'] = false;
                $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        } else {
            if (!$this->permissions['add']) {
                $ajax['status'] = false;
                $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }

        if (!$this->check_validation()) {
            $ajax['status'] = false;
            $ajax['system_message'] = $this->message;
            $this->jsonReturn($ajax);
        } else {
            $data = $this->input->post('product');


            $dir = $this->config->item("file_upload");
            $uploaded = System_helper::upload_file($dir['users'],1024,'gif|jpg|png|doc|pdf|xls|xlsx');
            $attachment='';
            if(array_key_exists('attachment',$uploaded))
            {
                if($uploaded['attachment']['status'])
                {
                    $attachment = $uploaded['attachment']['info']['file_name'];
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message.=$uploaded['attachment']['message'].'<br>';
                    $this->jsonReturn($ajax);
                }
            }
            if ($id > 0) {
                unset($data['id']);
                $data['update_by'] = $user->id;
                $data['attachment']=$attachment;
                $data['status'] = 1;
                $data['warranty_start_date'] = strtotime($data['warranty_start_date']);
                $data['warranty_end_date'] = strtotime($data['warranty_end_date']);
                $data['purchase_date'] = strtotime($data['purchase_date']);
                $data['update_date'] = time();
                $data['product_code'] = $data['product_code'][0];
                $data['serial_number'] = $data['serial_number'][0];
                $this->db->trans_start();  //DB Transaction Handle START
                Query_helper::update($this->config->item('table_product'), $data, array("id = " . $id));
                $this->db->trans_complete();   //DB Transaction Handle END

                if ($this->db->trans_status() === TRUE) {
                    $this->message = $this->lang->line("MSG_UPDATE_SUCCESS");
                    $save_and_new = $this->input->post('system_save_new_status');
                    if ($save_and_new == 1) {
                        $this->system_add();
                    } else {
                        $this->system_list();
                    }
                } else {
                    $ajax['status'] = false;
                    $ajax['system_message'] = $this->lang->line("MSG_UPDATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            } else {
                $data['create_by'] = $user->id;
                $data['create_date'] = time();
                $data['status'] = 1;
                $data['attachment']=$attachment;
                $data['warranty_start_date'] = strtotime($data['warranty_start_date']);
                $data['warranty_end_date'] = strtotime($data['warranty_end_date']);
                $data['purchase_date'] = strtotime($data['purchase_date']);
                $data['quantity'] = 1;

                $product_code = $data['product_code'];
                $serial_number = $data['serial_number'];
                unset($data['product_code']);
                unset($data['serial_number']);

                $this->db->trans_start();  //DB Transaction Handle START
                foreach ($product_code as $key => $code) {
                    $data['product_code'] = $code;
                    $data['serial_number'] = $serial_number[$key];
                    Query_helper::add($this->config->item('table_product'), $data);
                }

                $this->db->trans_complete();   //DB Transaction Handle END

                if ($this->db->trans_status() === TRUE) {
                    $this->message = $this->lang->line("MSG_CREATE_SUCCESS");
                    $save_and_new = $this->input->post('system_save_new_status');
                    if ($save_and_new == 1) {
                        $this->system_add();
                    } else {
                        $this->system_list();
                    }
                } else {
                    $ajax['status'] = false;
                    $ajax['system_message'] = $this->lang->line("MSG_CREATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
        }
    }

    private function system_batch_edit()
    {
        $selected_ids = $this->input->post('selected_ids');
        $this->system_edit($selected_ids[0]);
    }

    private function check_validation()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('product[product_name]', $this->lang->line('PRODUCT_NAME'), 'required');
        $this->form_validation->set_rules('product[product_code]', $this->lang->line('PRODUCT_CODE'), 'required');
        $this->form_validation->set_rules('product[serial_number]', $this->lang->line('SERIAL_NUMBER'), 'required');
        $this->form_validation->set_rules('product[category_id]', $this->lang->line('CATEGORY_ID'), 'required');
        $this->form_validation->set_rules('product[manufacture_id]', $this->lang->line('MANUFACTURE_ID'), 'required');
      //  $this->form_validation->set_rules('product[warehouse_id]', $this->lang->line('WAREHOUSE_ID'), 'required ');
        $this->form_validation->set_rules('product[unit_price]', $this->lang->line('UNIT_PRICE'), 'required');
//        $this->form_validation->set_rules('product[quantity]',$this->lang->line('QUANTITY'),'required');

        //  $this->form_validation->set_rules('product[status]',$this->lang->line('STATUS'),'required');





        if ($this->form_validation->run() == FALSE) {
            $this->message = validation_errors();
            return false;
        }
        else{
            $input = $this->input->post('product');
            if (count($input['product_code']) !== count(array_unique($input['product_code']))) {
                $this->message = $this->lang->line('PRODUCT_CODE_NUMBER_SHOULD_BE_UNIQUE');
                return false;
            }elseif(count($input['serial_number']) !== count(array_unique($input['serial_number']))){
                $this->message = $this->lang->line('SERAIL_NUMBER_SHOULD_BE_UNIQUE');
                return false;
            }
        }
        return true;
    }




    public function get_list()
    {
        $data = array();
        if ($this->permissions['list']) {
            $data = $this->Product_model->get_record_list();
        }
        $this->jsonReturn($data);
    }

    public function get_product_name_by_str()
    {
        $str = $this->input->get('term');
        $data = $this->Product_model->get_product_name_by_str($str);
        return $this->jsonReturn($data);
    }


}
