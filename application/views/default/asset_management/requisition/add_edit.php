<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
foreach($requisition_type as $key=>$dd)
$re_type[] = array('text'=>$dd,'value'=>$key);
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
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('asset_management/requisition/index/save'); ?>" method="post">
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('REQUISITION_TITLE'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="requisition[requisition_title]" value="" placeholder="<?php echo $CI->lang->line('NAME'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('DESCRIPTION'); ?></label></div>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="requisition[description]"  rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold"><?php echo $CI->lang->line('REQUISITION_TYPE'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="requisition[requisition_type]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>$re_type));
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

