<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$user=User_helper::get_user();

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
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('ticket_management/ticket_assign/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $ticket['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('USER_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="user_id" class="form-control" id="user_id">
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_options'=>$users,'drop_down_selected'=>$ticket['user_id']));
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="portlet light tasks-widget">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase"><?php echo $this->lang->line('TICKET');?></span>
                                            <span class="caption-helper"><?php echo System_helper::Get_Eng_to_Bng(sizeof($ticket_issues));?> <?php echo $this->lang->line('PENDING');?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="task-content">
                                            <div data-handle-color="#D7DCE2" data-rail-visible1="0" data-always-visible="1"  class="" data-initialized="1">
                                                <ul class="feeds">
                                                    <?php
                                                    //$ticket_issues='';
                                                    if(empty($ticket_issues))
                                                    {
                                                        ?>
                                                        <li>
                                                            <div class="task-title text-center">
                                                                <span class="label label-sm label-danger"><?php echo $CI->lang->line('DATA_NOT_FOUND'); ?></span>
                                                                    <span class="task-bell">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </span>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        foreach($ticket_issues as $ticket_issue)
                                                        {
                                                        ?>
                                                            <li>
                                                                <div class="col1">
                                                                    <div class="cont">
                                                                        <div class="cont-col1">
                                                                            <div class="label label-sm label-danger">
                                                                                <i class="fa fa-bullhorn"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cont-col2">
                                                                            <div class="desc">
                                                                                <input type="hidden" name="row_id[]" value="<?php echo $ticket_issue['id'];?>" />
                                                                                <input type="checkbox" name="ticket_issue_id[]" value="<?php echo $ticket_issue['id'];?>" class="checkbox-inline">

                                                                                <span class="" title="<?php echo $this->lang->line('SUBJECT');?>"><?php echo $ticket_issue['subject'];?></span>

                                                                                <span class="btn label label-sm label-primary user_info" data-user_id="<?php echo $ticket_issue['user_id'];?>"data-toggle="modal" data-target="#myModal" title="<?php echo $this->lang->line('NAME');?>">
                                                                                    <?php echo $ticket_issue['name_bn'];?></span>

                                                                                <span class="label label-sm label-success btn product_info"  data-product_id="<?php echo $ticket_issue['product_id'];?>"data-toggle="modal" data-target="#productModal"title="<?php echo $this->lang->line('PRODUCT_NAME');?>">
                                                                                    <?php echo $ticket_issue['product_name'].' ('.$ticket_issue['product_code'].')';?></span>


                                                                                <span class="label label-sm label-danger" title="<?php echo $this->lang->line('TIME');?>"><?php echo date('h:i A',$ticket_issue['create_date']);?></span>
                                                                                <span class="badge badge-warning" title="<?php echo $this->lang->line('TOKEN');?>"><?php echo $ticket_issue['id'];?></span>

                                                                                <select title="<?php echo $this->lang->line('PRIORITY');?>" name="ticket_priority[]" id="ticket_priority">
                                                                                    <?php
                                                                                    foreach($CI->config->item('ticket_priority') as $key=>$priority)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?php echo $key ?>"><?php echo $priority ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col2">
                                                                    <div class="date">
                                                                        <?php echo date('d M,y',$ticket_issue['create_date']);?>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group has-error row" style="<?php if(!($ticket['id']>0)){echo 'display:none';} ?>" id="module_container">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <select name="ticket[status]" class="form-control" >
                                            <?php
                                            $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('PENDING'),'value'=>$this->config->item('STATUS_PENDING')),array('text'=>$CI->lang->line('RESOLVE'),'value'=>$this->config->item('STATUS_RESOLVE'))),'drop_down_selected'=>isset($ticket['status'])?$ticket['status']:$this->config->item('STATUS_PENDING')));
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('USER_DETAILS'); ?>
                </h4>
            </div>
            <div class="modal-body" id="user_model_body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('PRODUCT_DETAILS'); ?>
                </h4>
            </div>
            <div class="modal-body" id="product_model_body">




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();

        $(document).on ('click',".user_info",function(){


                var id = $(this).data('user_id');
                $.ajax({
                    data:{id: id},
                    url:'<?php echo $CI->get_encoded_url('common/user_info');?>',
                    type: 'POST',
                    success: function(response)
                    {


                    }
                });
        });

        $(document).on ('click',".product_info",function(){


            var id = $(this).data('product_id');
            $.ajax({
                data:{id: id},
                url:'<?php echo $CI->get_encoded_url('common/product_info');?>',
                type: 'POST',
                success: function(response){


                }
            });

        });


        //        $(document).on("change","#user_id",function()
        //        {
        //            $.ajax({
        //                url: '<?php //echo $CI->get_encoded_url('ticket_management/ticket_issue/ajax_product_load'); ?>//',
        //                type: 'POST',
        //                dataType: "JSON",
        //                data:{user_id: $(this).val()},
        //                success: function (data, status)
        //                {
        //
        //                },
        //                error: function (xhr, desc, err)
        //                {
        //                    console.log("error");
        //                }
        //            });
        //
        //        });
    });
</script>

