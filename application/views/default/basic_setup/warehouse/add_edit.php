<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    $CI=& get_instance();

?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>

    <?php
    //print_r($warehouse_info);
    ?>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('basic_setup/Division_create/index/save'); ?>" method="post">
        <input type="hidden" name="id" value="<?php if(isset($warehouse_info['divid'])){echo $warehouse_info['divid'];}else{echo 0;}?>"/>
        <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
        <div class="row widget">
            <div class="widget-header">
                <div class="title">
                    <?php echo $title; ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="warehouse[warehouse_name]" class="form-control" value="<?php echo $warehouse_info['warehouse_name'];?>" />
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CODE'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="warehouse[warehouse_code]" class="form-control" value="<?php echo $warehouse_info['warehouse_code'];?>">
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('ADDRESS'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea name="warehouse[warehouse_address]" class="form-control" ><?php echo $warehouse_info['warehouse_address'];?></textarea>
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CAPACITY'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="warehouse[warehouse_capacity]" class="form-control" value="<?php echo $warehouse_info['warehouse_capacity'];?>" />
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DESCRIPTION'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea name="warehouse[warehouse_description]" class="form-control" ><?php echo $warehouse_info['warehouse_description'];?></textarea>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="notice_detail[status]" class="form-control" id="module_options">
                        <?php
                        $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('ACTIVE'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('INACTIVE'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($warehouse_info['status'])?$warehouse_info['status']:$this->config->item('STATUS_ACTIVE')));
                        ?>
                    </select>
                </div>
            </div>

        </div>
    </form>
</div>

