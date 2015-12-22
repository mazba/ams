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
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('system_setup/task/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $task_info['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error">
                                    <label class="control-label" for="name_en"><?php echo $CI->lang->line('NAME_EN'); ?></label>
                                    <input type="text" name="name_en" value="<?php echo $task_info['name_en'];?>" placeholder="<?php echo $CI->lang->line('NAME_EN'); ?>" id="name_en" class="form-control">
                                </div>
                                <div class="form-group has-error">
                                    <label class="control-label" for="name_bn"><?php echo $CI->lang->line('NAME_BN'); ?></label>
                                    <input type="text" name="name_bn" value="<?php echo $task_info['name_bn'];?>" placeholder="<?php echo $CI->lang->line('NAME_BN'); ?>" id="name_bn" class="form-control">
                                </div>
                                <div class="form-group has-error">
                                    <label class="control-label" for="name_bn"><?php echo $CI->lang->line('COMPONENT_NAME'); ?></label>
                                    <select name="component_id" class="form-control" id="component_options">
                                        <?php
                                        $CI->load_view('dropdown',array('drop_down_options'=>$components_list,'drop_down_selected'=>$task_info['component_id']));
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group has-error" style="<?php if(!($task_info['id']>0)){echo 'display:none';} ?>" id="module_container">
                                    <label class="control-label" for="name_bn"><?php echo $CI->lang->line('MODULE_NAME'); ?></label>
                                    <select name="module_id" class="form-control" id="module_options">
                                        <?php
                                        $CI->load_view('dropdown',array('drop_down_options'=>$module_list,'drop_down_selected'=>$task_info['module_id']));
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group has-error">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('CONTROLLER'); ?></label>
                                    <input type="text" name="controller" value="<?php echo $task_info['name_bn'];?>" placeholder="<?php echo $CI->lang->line('CONTROLLER'); ?>" id="controller" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('ICON'); ?></label>
                                    <input type="text" name="icon" value="<?php echo $task_info['icon'];?>" placeholder="<?php echo $CI->lang->line('icon'); ?>" id="icon" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('AT_LEFT_MENU'); ?></label>
                                    <input type="checkbox" name="<?php echo $CI->config->item('system_sidebar01') ?>" value="1" <?php if($task_info[$CI->config->item('system_sidebar01')]==1) echo "checked";?>>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('AT_TOP_MENU'); ?></label>
                                    <input type="checkbox" name="<?php echo $CI->config->item('system_sidebar02') ?>" value="1" <?php if($task_info[$CI->config->item('system_sidebar02')]==1) echo "checked";?>>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('DESCRIPTION'); ?></label>
                                    <textarea class="form-control" name="description" id="description" rows="3"><?php echo $task_info['description'];?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('ORDERING'); ?></label>
                                    <input type="text" name="ordering" value="<?php echo $task_info['ordering'];?>" placeholder="<?php echo $CI->lang->line('ordering'); ?>" id="ordering" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="controller"><?php echo $CI->lang->line('STATUS'); ?></label>
                                    <select name="status" class="form-control" id="module_options">
                                        <?php
                                        $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('INACTIVE'),'value'=>0),array('text'=>$CI->lang->line('ACTIVE'),'value'=>1)),'drop_down_selected'=>$task_info['status']));
                                        ?>
                                    </select>
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
        $(document).on("change","#component_options",function()
        {
            $("#module_container").show();
            $("#module_options").val("");
            var component_id=$(this).val();
            if(component_id>0)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('system_setup/task/get_modules_by_component_id'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{component_id:component_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });

            }
            else
            {
                $("#module_container").hide();
            }



        });
    });
</script>