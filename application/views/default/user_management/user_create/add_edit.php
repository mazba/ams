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
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('user_management/user_create/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $userInfo['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('GROUP_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="user_detail[user_group_id]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$groups,'drop_down_selected'=>$userInfo['user_group_id'].'-'.$userInfo['user_group_level']));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('NAME_BN'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[name_bn]" value="<?php echo $userInfo['name_bn'];?>" placeholder="<?php echo $CI->lang->line('NAME_BN'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('NAME_EN'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[name_en]" value="<?php echo $userInfo['name_en'];?>" placeholder="<?php echo $CI->lang->line('NAME_EN'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('USER_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[username]" value="<?php echo $userInfo['username'];?>" placeholder="<?php echo $CI->lang->line('USER_NAME'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('PASSWORD'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="password" name="user_detail[password]" value="" placeholder="<?php echo $CI->lang->line('PASSWORD'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('CONFIRM_PASSWORD'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="password" name="user_detail[confirm_password]" value="" placeholder="<?php echo $CI->lang->line('CONFIRM_PASSWORD'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('EMAIL'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[email]" value="<?php echo $userInfo['email'];?>" placeholder="<?php echo $CI->lang->line('EMAIL'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('MOBILE_NUMBER'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[mobile]" value="<?php echo $userInfo['mobile'];?>" placeholder="<?php echo $CI->lang->line('MOBILE_NUMBER'); ?>" class="form-control OnlyNumber" maxlength="11" />
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('DATE_OF_BIRTH'); ?></label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="user_detail[dob]" value="<?php echo $userInfo['dob']?date('m/d/Y',$userInfo['dob']):'';?>" placeholder="<?php echo $CI->lang->line('DATE_OF_BIRTH'); ?>" class="form-control date-picker">
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('USER_TYPE'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="user_detail[type]" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('SELECT');?></option>
                                            <?php
                                            $types=$this->config->item('USER_HIGHER_KEY');
                                            foreach($types as $type_key=>$type_text)
                                            {
                                                if($type_key==$userInfo['type'])
                                                {
                                                    ?>
                                                        <option value="<?php echo $type_key;?>" selected="selected"><?php echo $type_text;?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <option value="<?php echo $type_key;?>"><?php echo $type_text;?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('DESIGNATION'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="user_detail[designation]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$designations,'drop_down_selected'=>$userInfo['designation']));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('PRESENT_ADDRESS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="user_detail[present_address]"  rows="3"><?php echo $userInfo['present_address'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('PERMANENT_ADDRESS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="user_detail[permanent_address]"  rows="3"><?php echo $userInfo['permanent_address'];?></textarea>
                                    </div>
                                </div>
                                <div class="form-group has-error row" style="<?php if(!($userInfo['id']>0)){echo 'display:none';} ?>" id="module_container">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="user_detail[status]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('ACTIVE'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('INACTIVE'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($userInfo['status'])?$userInfo['status']:$this->config->item('STATUS_ACTIVE')));
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
        $('.date-picker').datepicker()
    });
</script>

