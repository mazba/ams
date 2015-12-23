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
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('ticket_management/ticket_issue/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $ticket['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('USER_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="ticket[user_id]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$users,'drop_down_selected'=>$ticket['user_id']));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('PRODUCT_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="ticket[product_id]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$products,'drop_down_selected'=>$ticket['product_id']));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('SUBJECT'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="ticket[subject]" value="<?php echo $ticket['subject'];?>" placeholder="<?php echo $CI->lang->line('USER_NAME'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('DESCRIPTION'); ?></label></div>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="ticket[ticket_issue_description]"  rows="3"><?php echo $ticket['ticket_issue_description'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group has-error row" style="<?php if(!($ticket['id']>0)){echo 'display:none';} ?>" id="module_container">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="ticket[status]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('ACTIVE'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('INACTIVE'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($ticket['status'])?$ticket['status']:$this->config->item('STATUS_ACTIVE')));
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

