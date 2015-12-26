<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user=User_helper::get_user();
$recent_ticket_issue = Dashboard_helper::get_recent_ticket_issue();

?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-blue-steel hide"></i>
                            <span class="caption-subject font-blue-steel bold uppercase"><?php echo $CI->lang->line('RECENT_TICKET_ISSUE'); ?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php
                                foreach($recent_ticket_issue as $ticket)
                                {
                                    ?>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                        <?php
                                                            switch($ticket['status']){
                                                                case $CI->config->item('STATUS_PENDING'):
                                                                    echo '<div class="label label-sm label-danger">';
                                                                    echo '<i class="fa fa-spinner"></i>';
                                                                    $status_text = $CI->lang->line('PENDING');
                                                                    break;
                                                                case $CI->config->item('STATUS_ASSIGN'):
                                                                    echo '<div class="label label-sm label-info">';
                                                                    echo '<i class="fa fa-mail-reply-all"></i>';
                                                                    $status_text = $CI->lang->line('ASSIGN');
                                                                    break;
                                                                case $CI->config->item('STATUS_RESOLVE'):
                                                                    echo '<div class="label label-sm label-success">';
                                                                    echo '<i class="fa fa-check-square"></i>';
                                                                    $status_text = $CI->lang->line('RESOLVE');
                                                                    break;
                                                                default:
                                                                    echo '<div class="label label-sm label-warning">';
                                                                    echo '<i class="fa fa-exclamation"></i>';
                                                                    $status_text = '';
                                                                    break;

                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        <?php echo $ticket['subject'] ?>
                                                        <span class="label label-sm label-info">
														<?php echo $status_text; ?> <i class="icon-bell"></i>
														</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                <?php echo date('d-m-Y h:i A',$ticket['create_date']) ?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="scroller-footer">
                            <div class="btn-arrow-link pull-right">
                                <a href="#">See All Records</a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
