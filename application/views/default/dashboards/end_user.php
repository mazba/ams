<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user = User_helper::get_user();
$recent_ticket_issue = Dashboard_helper::get_recent_ticket_issue_by_user();
$get_product_list = Dashboard_helper::get_my_product_list();

?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('RECENT_TICKET_ISSUE'); ?>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse external">
                            </a>
                            <a href="javascript:;" class="remove external">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height: 270px;" data-always-visible="1" data-rail-visible="0">
                            <?php
                            if(!count($recent_ticket_issue)){
                                echo '<h3 class="text-center"><span class="label label-danger">'.$CI->lang->line('NO_DATA_FOUND').'</span></h3>';
                            }
                            else{
                            ?>
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
                        <?php
                        }
                        ?>
                        </div>
                        <div class="scroller-footer">
                            <div class="btn-arrow-link pull-right">
                                <a href="<?php echo base_url().'ticket_management/ticket_issue' ?>"><?php echo $CI->lang->line('SEE_ALL_RECORDS') ?></a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
            <div class="col-md-6">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('MY_PRODUCTS_LIST'); ?> <span class="label label-warning"><?php echo count($get_product_list) ?></span>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse external">
                            </a>
                            <a href="javascript:;" class="remove external">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <?php
                            if(!count($get_product_list)){
                                echo '<h3 class="text-center"><span class="label label-danger">'.$CI->lang->line('NO_DATA_FOUND').'</span></h3>';
                            }
                            else {
                                ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo $CI->lang->line('PRODUCT'); ?></th>
                                        <th><?php echo $CI->lang->line('ASSIGN_DATE'); ?></th>
                                        <th><?php echo $CI->lang->line('RETURN_DATE'); ?></th>
                                        <th><?php echo $CI->lang->line('REMAIN/PENDING'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($get_product_list as $product) {
                                        ?>
                                        <tr>
                                            <td><?php echo $product['product_name'] ?></td>
                                            <td><?php echo System_helper::display_date($product['assign_date']) ?></td>
                                            <td><?php echo System_helper::display_date($product['return_date']) ?></td>
                                            <td>
                                                <?php
                                                $total_date = $product['return_date'] - $product['assign_date'];
                                                $remain_date = $product['return_date'] - time();
                                                if ($remain_date > 0) {
                                                    echo '<span class="label label-info">';
                                                    echo floor(($remain_date / 60 / 60 / 24)) . ' ' . $CI->lang->line('DAYS_REMAIN');
                                                    echo '</span>';
                                                } else {
                                                    echo '<span class="label label-danger">';
                                                    echo floor((time() - $product['return_date']) / 60 / 60 / 24) . ' ' . $CI->lang->line('DAYS_PENDING');
                                                    echo '</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
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