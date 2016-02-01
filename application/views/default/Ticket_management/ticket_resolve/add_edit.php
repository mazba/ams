<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$user=User_helper::get_user();
$directory=$this->config->item('file_upload');

?>
<div class="page-content-wrapper" xmlns="http://www.w3.org/1999/html">
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
                            <a href="" class="reload external">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('ticket_management/ticket_resolve/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $ticket['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <input type="hidden" name="comment[ticket_issue_id]" value="<?php echo $ticket['ticket_issue_id'];?>"/>
                            <div class="form-body">
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVER_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <button class="btn btn-circle btn-danger btn-sm" type="button"><?php echo $users[0]['text']; ?></button>
                                    </div>
                                </div>
                                <div class="portlet light tasks-widget">
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
                                                            $ticket_issue_status=$ticket_issue['ticket_issue_status'];
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
                                                                                <span class="h4" title="<?php echo $this->lang->line('SUBJECT');?>"><?php echo $ticket_issue['subject'];?></span>
                                                                                <br />
                                                                                <br />

                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="cont-col2">

                                                                            <?php echo $ticket_issue['ticket_issue_description'];?>

                                                                        </div>
                                                                        <div class="cont-col2 text-right">
                                                                            <br />
                                                                            <span class="label label-sm label-primary" title="<?php echo $this->lang->line('NAME');?>"><?php echo $ticket_issue['name_bn'];?></span>
                                                                            <span class="label label-sm label-success" title="<?php echo $this->lang->line('PRODUCT_NAME');?>"><?php echo isset($ticket_issue['product_name']) ? $ticket_issue['product_name'] : '';?></span>
                                                                            <span class="label label-sm label-danger" title="<?php echo $this->lang->line('TIME');?>"><?php echo date('h:i A',$ticket_issue['create_date']);?></span>
                                                                            <span class="badge badge-warning" title="<?php echo $this->lang->line('TOKEN');?>"><?php echo $ticket_issue['ticket_issue_id'];?></span>
                                                                            <?php
                                                                            $all_priority = $CI->config->item('ticket_priority');
                                                                            ?>
                                                                            <span class="badge badge-info" title="<?php echo $this->lang->line('PRIORITY');?>"><?php echo isset($all_priority[$ticket_issue['priority']]) ? $all_priority[$ticket_issue['priority']]: '';?></span>
                                                                            <?php

                                                                            if(!empty($ticket_issue['issue_attachment']))
                                                                            {
                                                                                ?>
                                                                                <a target="_blank" href="<?php echo base_url().$directory['ticket_issue'].'/'.$ticket_issue['issue_attachment'];?>" class="badge badge-warning external" title="<?php echo $this->lang->line('ATTACHMENT');?>"><?php echo $this->lang->line('ATTACHMENT');?></a>
                                                                                <?php
                                                                            }
                                                                            ?>


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

                                    <?php

                                    if($ticket_issue_status==$this->config->item('STATUS_ASSIGN'))
                                    {
                                        if($user->user_group_level==$this->config->item('SUPPORT_GROUP_ID'))
                                        {
                                            ?>
                                            <div class="form-group has-success row" >
                                                <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                                <div class="col-lg-4">
                                                    <select name="comment[ticket_status_id]" class="form-control" style="margin-top: 10px;">
                                                        <?php
                                                        $CI->load_view('dropdown',array('drop_down_default_option'=>true,'drop_down_options'=>$ticket_status,'drop_down_selected'=>array()));
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group has-error row" >
                                                <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE_REMARKS'); ?></label></div>
                                                <div class="col-lg-8">
                                                    <textarea name="comment[comment]"  class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        elseif($user->user_group_level==$this->config->item('OFFICER_GROUP_ID'))
                                        {
                                            ?>
                                            <div class="form-group has-success row" >
                                                <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                                <div class="col-lg-4">
                                                    <select name="comment[ticket_status_id]" class="form-control" style="margin-top: 10px;">
                                                        <?php
                                                        $CI->load_view('dropdown',array('drop_down_default_option'=>true,'drop_down_options'=>array(array('text'=>$CI->lang->line('REJECT'),'value'=>$this->config->item('STATUS_REJECT')),array('text'=>$CI->lang->line('RESOLVE'),'value'=>$this->config->item('STATUS_RESOLVE'))),'drop_down_selected'=>array()));
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group has-error row" >
                                                <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE_REMARKS'); ?></label></div>
                                                <div class="col-lg-8">
                                                    <textarea name="comment[comment]"  class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        elseif($user->user_group_level==$this->config->item('END_GROUP_ID'))
                                        {
                                            ?>
                                            <div class="form-group has-error row" >
                                                <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE_REMARKS'); ?></label></div>
                                                <div class="col-lg-8">
                                                    <textarea name="comment[comment]"  class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            if($ticket_issue_status==$this->config->item('STATUS_RESOLVE'))
                                            {
                                               echo $this->lang->line('RESOLVE');
                                            }
                                            else
                                            {
                                                echo $ticket_issue_status;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if($ticket_issue_status==$this->config->item('STATUS_RESOLVE'))
                                        {
                                            ?>
                                            <div class="col-lg-12 text-center h3">
                                                <button class="btn btn-circle btn-primary btn-large" type="button"><?php echo $this->lang->line('RESOLVE'); ?></button>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="col-lg-12 text-center h3">
                                                <button class="btn btn-circle btn-danger btn-large" type="button"><?php echo $this->lang->line('REJECT'); ?></button>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                        <!-- BEGIN PORTLET-->

                                        <?php
                                        if(!empty($comments))
                                        {
                                           ?>
                                            <div class="portlet">
                                                <div class="portlet-title line">
                                                    <div class="caption">
                                                        <i class="fa fa-comments"></i><?php echo $this->lang->line('COMMENT');?>
                                                    </div>
                                                </div>
                                                    <div id="chats" class="portlet-body">
                                                        <div class="scroller " style="position: relative; overflow: scroll; width: auto; height: 300px;">
                                                            <div data-rail-visible1="1" data-always-visible="1" style="height: 300px; overflow: scroll; width: auto;" class="scroller" data-initialized="1">
                                                                <ul class="chats">
                                                                <?php
                                                                foreach($comments as $comment)
                                                                {
                                                                    if($comment['create_by']==$user->id)
                                                                    {
                                                                        $in_out_class='out';
                                                                    }
                                                                    else
                                                                    {
                                                                        $in_out_class='in';
                                                                    }
                                                                    //if($comment['type']==$this->config->item('ticket_comment_end_user') || $comment['type']==$this->config->item('ticket_comment_manager'))
                                                                    //{
                                                                    //    $in_out_class='in';
                                                                    //}
                                                                    //elseif($comment['type']==$this->config->item('ticket_comment_support_user'))
                                                                    //{
                                                                    //    $in_out_class='out';
                                                                    //}
                                                                    //else
                                                                    //{
                                                                    //    $in_out_class='';
                                                                    //}
                                                                    ?>
                                                                    <li class="<?php echo $in_out_class;?>">
                                                                        <img src="<?php echo base_url();?>images/<?php echo $comment['picture_name']?'users/'.$comment['picture_name']:'profile.png';?>" alt="" class="avatar">
                                                                        <div class="message">
                                                                            <span class="arrow">
                                                                            </span>
                                                                            <a class="name" href="#">
                                                                                <?php echo $comment['user_name'];?>
                                                                            </a>
                                                                            <span class="datetime">
                                                                                at <?php echo date('h:i A - d M,y', $comment['create_date']);?>
                                                                                <?php

                                                                                if(!empty($comment['resolve_status']))
                                                                                {
                                                                                    ?>
                                                                                    <span class="badge badge-warning" title="<?php echo $this->lang->line('TOKEN');?>">
                                                                                    <?php echo $comment['resolve_status'];?>
                                                                                </span>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                            <span class="body"><?php echo $comment['comment'];?></span>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- END PORTLET-->
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
        $('.date-picker').datepicker()
        turn_off_triggers();
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

<script>
    jQuery(document).ready(function() {
        $('.scroller').each(function() {
            if ($(this).attr("data-initialized")) {
                return; // exit
            }

            var height;

            if ($(this).attr("data-height")) {
                height = $(this).attr("data-height");
            } else {
                height = $(this).css('height');
            }

            $(this).slimScroll({
                allowPageScroll: true, // allow page scroll when the element scroll is ended
                size: '7px',
                color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : '#bbb'),
                wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : '#eaeaea'),
//                position: isRTL ? 'left' : 'right',
                height: height,
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                disableFadeOut: true
            });

            $(this).attr("data-initialized", "1");
        });
    });
</script>