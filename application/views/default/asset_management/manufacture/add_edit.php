<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="system_action_button_container" class="system_action_button_container">
            <?php
            $CI->load_view('system_action_buttons');
            ?>
        </div>
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-qrcode"></i> <?php echo $title; ?>
                        </div>

                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('asset_management/manufacture/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $manufacture['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('NAME'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="manufacture[manufacture_name]" value="<?php echo $manufacture['manufacture_name'];?>" placeholder="<?php echo $CI->lang->line('NAME'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="manufacture_code"><?php echo $CI->lang->line('MANUFACTURE_CODE'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="manufacture[manufacture_code]" value="<?php echo $manufacture['manufacture_code'];?>" placeholder="<?php echo $CI->lang->line('CODE'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('DESCRIPTION'); ?></label></div>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="manufacture[manufacture_description]"  rows="3"><?php echo $manufacture['manufacture_description'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="manufacture[status]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('ACTIVE'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('INACTIVE'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($manufacture_info['status'])?$manufacture_info['status']:$this->config->item('STATUS_ACTIVE')));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        
    });
</script>

