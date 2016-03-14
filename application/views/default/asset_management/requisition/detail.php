<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$requisition_type = $CI->config->item('requisition_type');
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
                    <div class="portlet-body">
                        <?php
                        foreach($requisitions as $requisition)
                        {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="color: #00CC00; font-weight: bold"><?php echo $requisition['requisition_title'] ?></h3>
                                </div>
                                <div class="panel-body">
                                   <table class="table table-striped table-hover">
                                       <tr>
                                           <th><?php echo $CI->lang->line('REQUISITION_TYPE'); ?></th><td><?php echo $requisition_type[$requisition['requisition_type']] ?></td>
                                       </tr>
                                       <tr>
                                           <th><?php echo $CI->lang->line('REQUISITION_ID'); ?></th><td><?php echo $requisition['requisition_id'] ?></td>
                                       </tr>
                                       <tr>
                                           <th><?php echo $CI->lang->line('DESCRIPTION'); ?></th><td><?php echo $requisition['description'] ?></td>
                                       </tr>
                                   </table>
                                   <span class="label label-success pull-right"><?php echo $requisition['user_name'] ?></span>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>