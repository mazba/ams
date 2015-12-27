<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user = User_helper::get_user();
$recent_ticket_issue = Dashboard_helper::get_recent_ticket_issue();
$warehouse_product_info = Dashboard_helper::get_warehouse_product_info();
//$ticket_status_info = Dashboard_helper::get_ticket_status_info();
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
                        <div data-always-visible="1" data-rail-visible="0">
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
                                <a href="<?php echo base_url().'ticket_management/ticket_issue' ?>"><?php echo $CI->lang->line('SEE_ALL_RECORDS') ?></a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('TICKET_AND_REQUEST'); ?>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse external">
                            </a>
                            <a href="javascript:;" class="remove external">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                <tr>

                                </tr>
                                </tbody>
                            </table>
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
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('WAREHOUSE_INFO'); ?> &nbsp;<span class="label label-warning"><?php echo count($warehouse_product_info) ?></span>
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
                            <table class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-bank"></i> <?php echo $CI->lang->line('WAREHOUSE'); ?>
                                    </th>
                                    <th>
                                        <i class="fa fa-cubes"></i> <?php echo $CI->lang->line('NO_OF_PRODUCT'); ?>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($warehouse_product_info as $warehouse) {
                                    ?>
                                    <tr>
                                        <td class="highlight">
                                            <div class="warning">
                                            </div>
                                            <a href="#" class="external">
                                                <?php echo $warehouse['warehouse_name'] ?> </a>
                                        </td>
                                        <td>
                                            <div class="label label-info center-block"><i class="fa fa-cubes "></i> <?php echo $warehouse['number_of_product'] ?></div>
                                        </td>
                                    </tr>
                                    <?php
                                }

                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('MY_PRODUCTS'); ?> <span class="label label-warning"><?php echo count($get_product_list) ?></span>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse external">
                            </a>
                            <a href="javascript:;" class="remove external">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><?php echo $CI->lang->line('PRODUCT'); ?></th>
                                    <th><?php echo $CI->lang->line('ASSIGN_DATE'); ?></th>
                                    <th><?php echo $CI->lang->line('RETURN_DATE'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($get_product_list as $product){
                                    ?>
                                    <tr>
                                        <td><?php echo $product['product_name'] ?></td>
                                        <td><?php echo System_helper::display_date($product['assign_date']) ?></td>
                                        <td><?php echo System_helper::display_date($product['return_date']) ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
