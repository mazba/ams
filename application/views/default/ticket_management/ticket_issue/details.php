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
<!--                        <div class="tools">-->
<!--                            <a href="" class="collapse">-->
<!--                            </a>-->
<!--                            <a href="#portlet-config" data-toggle="modal" class="config">-->
<!--                            </a>-->
<!--                            <a href="" class="reload">-->
<!--                            </a>-->
<!--                            <a href="" class="remove">-->
<!--                            </a>-->
<!--                        </div>-->
                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('ticket_management/ticket_issue/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $ticket['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <?php
                                        if(sizeof($users)<2)
                                        {
                                            ?>
                                            <label class="control-label bold" for="name_bn"><?php echo $users[0]['text'];?></label>
                                            <input type="hidden" name="ticket[user_id]" value="<?php echo $users[0]['value'];?>" class="form-control" />
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <select name="ticket[user_id]" class="form-control" id="user_id">
                                                <?php
                                                $CI->load_view('dropdown',array('drop_down_options'=>$users,'drop_down_selected'=>$ticket['user_id']));
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group has-error row" >
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('PRODUCT_NAME'); ?></label></div>
                                    <div class="col-lg-8">
                                        <?php
                                        if($ticket['id']>0)
                                        {
                                            ?>
                                            <label class="control-label bold" for="name_bn"><?php echo $products[0]['text'];?></label>
                                            <input type="hidden" name="ticket[product_id]" value="<?php echo $products[0]['value'];?>" class="form-control" />
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <select name="ticket[product_id]" class="form-control" id="product_id" >
                                                <?php
                                                $CI->load_view('dropdown',array('drop_down_options'=>$products,'drop_down_selected'=>$ticket['product_id']));
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group has-error row">
                                    <div class="col-lg-2">
                                        <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('SUBJECT'); ?></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <?php
                                        if($ticket['id']>0)
                                        {
                                            ?>
                                            <label class="control-label bold" for="name_en"><?php echo $ticket['subject'];?></label>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <input type="text" name="ticket[subject]" value="<?php echo $ticket['subject'];?>" placeholder="<?php echo $CI->lang->line('SUBJECT'); ?>" class="form-control">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group has-success row">
                                    <div class="col-lg-2"><label class="control-label bold" for="controller"><?php echo $CI->lang->line('DESCRIPTION'); ?></label></div>
                                    <div class="col-lg-8">
                                        <?php
                                        if($ticket['id']>0)
                                        {
                                            ?>
                                            <label class="control-label bold" for="name_en"><?php echo $ticket['ticket_issue_description'];?></label>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <textarea class="form-control" name="ticket[ticket_issue_description]"  rows="3"><?php echo $ticket['ticket_issue_description'];?></textarea>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group has-error row" style="<?php if(!($ticket['id']>0)){echo 'display:none';} ?>" id="module_container">
                                    <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                    <div class="col-lg-8">
                                        <label class="control-label bold" for="name_en">
                                            <?php
                                            if($ticket['status']==$this->config->item('STATUS_INACTIVE'))
                                            {
                                                ?>
                                                <label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('PENDING'); ?></label>
                                                <?php
                                            }
                                            elseif($ticket['status']==$this->config->item('STATUS_RESOLVE'))
                                            {
                                                ?>
                                                <label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE'); ?></label>
                                                <?php
                                            }
                                            elseif($ticket['status']==$this->config->item('STATUS_ASSIGN'))
                                            {
                                                ?>
                                                <label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('ASSIGN'); ?></label>
                                                <?php
                                            }
                                            elseif($ticket['status']==$this->config->item('STATUS_REJECT'))
                                            {
                                                ?>
                                                <label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('REJECT'); ?></label>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>

                                                <?php
                                            }

                                            ?>
                                        </label>

                                    </div>
                                </div>
                                <?php
                                if(!empty($ticket_assign['remarks']))
                                {
                                    ?>
                                    <div class="form-group has-error row" id="module_container">
                                        <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE_REMARKS'); ?></label></div>
                                        <div class="col-lg-8">
                                            <label class="control-label bold" for="name_en">
                                                <?php
                                                echo $ticket_assign['remarks'];
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group has-error row" id="module_container">
                                        <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('RESOLVE_DATE'); ?></label></div>
                                        <div class="col-lg-8">
                                            <label class="control-label bold" for="name_en">
                                                <?php
                                                echo date('d M,Y',$ticket_assign['resolved_date']);
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php
                                }
                                if(!empty($ticket['issue_attachment']))
                                {
                                ?>
                                    <div class="form-group has-error row" >
                                        <div class="col-lg-2"><label class="control-label bold" for="name_bn"><?php echo $CI->lang->line('ATTACHMENT'); ?></label></div>
                                        <div class="col-lg-8">
                                            <div id="imtext" style="width: 150px; height: 150px;float: left"><img src="<?php echo base_url()?>images/<?php echo $ticket['issue_attachment']?'ticket_issue/'.$ticket['issue_attachment']:"upload-icon.png";?>" style="width: 130px; height: 130px; " id="imtext" /></div>
                                        </div>
                                    </div>
                                <?php
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
                                                            /*if($comment['create_by']==$user->id)
                                                            {
                                                                $in_out_class='out';
                                                            }
                                                            else
                                                            {
                                                                $in_out_class='in';
                                                            }*/
                                                            if($comment['type']==$this->config->item('ticket_comment_end_user') || $comment['type']==$this->config->item('ticket_comment_manager'))
                                                            {
                                                                $in_out_class='in';
                                                            }
                                                            elseif($comment['type']==$this->config->item('ticket_comment_support_user'))
                                                            {
                                                                $in_out_class='out';
                                                            }
                                                            else
                                                            {
                                                                $in_out_class='';
                                                            }
                                                            if(!empty($comment['picture_name']) && file_exists('images/'.$comment['picture_name']))
                                                            {
                                                                $profile_img=base_url().'images/'.$comment['picture_name'];
                                                            }
                                                            else
                                                            {
                                                                $profile_img=base_url().'images/profile.png';
                                                            }
                                                            ?>
                                                            <li class="<?php echo $in_out_class;?>">
                                                                <img src="<?php echo $profile_img;?>" alt="" class="avatar">
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
        $(document).on("change","#user_id",function()
        {
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('ticket_management/ticket_issue/ajax_product_load'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{user_id: $(this).val()},
                success: function (data, status)
                {

                },
                error: function (xhr, desc, err)
                {
                    console.log("error");
                }
            });

        });
    });
</script>

