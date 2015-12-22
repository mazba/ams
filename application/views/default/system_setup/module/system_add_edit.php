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
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="#portlet-config" data-toggle="modal" class="config">
                            </a>
                            <a href="" class="reload">
                            </a>
                            <a href="" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('system_setup/module/index/save') ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $module_info['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('NAME_EN'); ?><span style="color:#FF0000">*</span></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <input type="text" name="name_en" class="form-control" value="<?php echo $module_info['name_en'];?>">
                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('NAME_BN'); ?><span style="color:#FF0000">*</span></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <input type="text" name="name_bn" class="form-control" value="<?php echo $module_info['name_bn'];?>">
                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('COMPONENT_NAME'); ?><span style="color:#FF0000">*</span></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <select name="component_id" class="form-control" id="component_options">
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$components_list,'drop_down_selected'=>$module_info['component_id']));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('ICON'); ?></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <input type="text" name="icon" class="form-control" value="<?php echo $module_info['icon'];?>">
                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('DESCRIPTION'); ?></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <textarea name="description" class="form-control"><?php echo $module_info['description'];?></textarea>

                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('ORDERING'); ?></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <input type="text" name="ordering" class="form-control" value="<?php echo $module_info['ordering'];?>">
                                    </div>
                                </div>
                                <div style="" class="row show-grid">
                                    <div class="col-xs-4">
                                        <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-8">
                                        <select name="status" class="form-control" id="module_options">
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('INACTIVE'),'value'=>0),array('text'=>$CI->lang->line('ACTIVE'),'value'=>1)),'drop_down_selected'=>$module_info['status']));
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