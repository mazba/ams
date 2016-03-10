<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user = User_helper::get_user();
$recent_ticket_issue = Dashboard_helper::get_recent_ticket_issue();
$warehouse_product_info = Dashboard_helper::get_warehouse_product_info();
$ticket_status_info = Dashboard_helper::get_ticket_status_info();
$get_product_list = Dashboard_helper::get_my_product_list();
$get_requisition_info = Dashboard_helper::get_requisition_info();

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
                <div class="scroller" style="height: 160px;" data-always-visible="1" data-rail-visible="0">
                    <ul class="feeds">
                        <?php
                        foreach ($recent_ticket_issue as $ticket)
                        {
                        ?>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <?php
                                        switch ($ticket['status']) {
                                            case $CI->config->item('STATUS_INACTIVE'):
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
                        <?php echo date('d-m-Y h:i A', $ticket['create_date']) ?>
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
                    <a href="<?php echo base_url() . 'ticket_management/ticket_issue' ?>"><?php echo $CI->lang->line('SEE_ALL_RECORDS') ?></a>
                    <i class="icon-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('TICKET_AND_REQUISITION_INFO'); ?>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse external">
                </a>
                <a href="javascript:;" class="remove external">
                </a>
            </div>
        </div>
        <div class="portlet-body ticket-and-requisition">
            <div class="scroller" style="height: 186px;" data-always-visible="1" data-rail-visible="0">
                <div class="col-md-6">
                    <span class="label label-success" style="margin: 0px 0px 5px 64px; float:left;"> <i
                            class="fa  fa-ticket "></i> <?php echo $CI->lang->line('TICKET'); ?></span>

                    <div class="table-scrollable table-scrollable-borderless">
                        <table style="border: 1px solid #ccc;" class="table  table-bordered  table-hover">
                            <tbody>
                            <tr>
                                <?php
                                $a = 0;
                                $b = 0;
                                $c = 0;
                                ?>
                                <th><?php echo $CI->lang->line('PENDING_TICKET'); ?></th>
                                <th><span
                                        class="badge badge-danger"><?php echo System_helper::Get_Eng_to_Bng(isset($ticket_status_info[$CI->config->item('STATUS_INACTIVE')]) ? $a = $ticket_status_info[$CI->config->item('STATUS_INACTIVE')] : '0') ?></span>
                                </th>
                            </tr>
                            <tr>
                                <th><?php echo $CI->lang->line('RESOLVED_TICKET'); ?></th>
                                <td><span
                                        class="badge badge-success"><?php echo System_helper::Get_Eng_to_Bng(isset($ticket_status_info[$CI->config->item('STATUS_RESOLVE')]) ? $b = $ticket_status_info[$CI->config->item('STATUS_RESOLVE')] : '0') ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo $CI->lang->line('ASSIGNED_TICKET'); ?></th>
                                <td><span
                                        class="badge badge-warning"><?php echo System_helper::Get_Eng_to_Bng( isset($ticket_status_info[$CI->config->item('STATUS_ASSIGN')]) ? $c = $ticket_status_info[$CI->config->item('STATUS_ASSIGN')] : '0' )?></span>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo $CI->lang->line('TOTAL_TICKET'); ?></th>
                                <td><span class="badge badge-info"><?php echo System_helper::Get_Eng_to_Bng($a + $b + $c); ?></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="label label-success" style="margin: 0px 0px 5px 64px; float:left;"><i
                            class="fa fa-hand-o-up"></i> <?php echo $CI->lang->line('REQUISITION'); ?></span>

                    <div class="table-scrollable table-scrollable-borderless">
                        <table style="border: 1px solid #ccc;" class="table  table-bordered  table-hover">
                            <tbody>
                            <tr>
                                <th><?php echo $CI->lang->line('TODAY_REQUISITION'); ?></th>
                                <td><span
                                        class="badge badge-danger"><?php echo System_helper::Get_Eng_to_Bng( $get_requisition_info['today_requisition']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo $CI->lang->line('TOTAL_REQUISITION'); ?></th>
                                <td><span
                                        class="badge badge-info"><?php echo System_helper::Get_Eng_to_Bng($get_requisition_info['total_requisition']); ?></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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
                <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('WAREHOUSE_WISE_PRODUCT_INFO'); ?>
                &nbsp;<span class="label label-warning"><?php echo System_helper::Get_Eng_to_Bng(count($warehouse_product_info)) ?></span>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse external">
                </a>
                <a href="javascript:;" class="remove external">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="scroller" style="height: 189px;" data-always-visible="1" data-rail-visible="0">
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
                                <a href="#basic" data-toggle="modal" class="external load_product"
                                   data-warehouse-id="<?php echo $warehouse['id'] ?>">
                                    <?php echo $warehouse['warehouse_name'] ?>
                                </a>
                            </td>
                            <td>
                                <a class="external" href="#basic" data-toggle="modal"
                                   data-warehouse-id="<?php echo $warehouse['id'] ?>">
                                    <div data-warehouse-id="<?php echo $warehouse['id'] ?>"
                                         class="load_product label label-info center-block"><i
                                            class="fa fa-cubes "></i> <?php echo System_helper::Get_Eng_to_Bng( $warehouse['number_of_product']) ?>
                                    </div>
                                </a>
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
                <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('MY_PRODUCTS_LIST'); ?> <span
                    class="label label-warning"><?php echo System_helper::Get_Eng_to_Bng(count($get_product_list)) ?></span>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse external">
                </a>
                <a href="javascript:;" class="remove external">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="scroller" style="height: 186px;" data-always-visible="1" data-rail-visible="0">
                <?php
                if (!count($get_product_list)) {
                    echo '<h3 class="text-center"><span class="label label-danger">' . $CI->lang->line('NO_DATA_FOUND') . '</span></h3>';
                } else {
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
                                        echo System_helper::Get_Eng_to_Bng(floor(($remain_date / 60 / 60 / 24))) . ' ' . $CI->lang->line('DAYS_REMAIN');
                                        echo '</span>';
                                    } else {
                                        echo '<span class="label label-danger">';
                                        echo System_helper::Get_Eng_to_Bng( floor((time() - $product['return_date']) / 60 / 60 / 24)) . ' ' . $CI->lang->line('DAYS_PENDING');
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

<div aria-hidden="true" role="basic" tabindex="-1" id="basic" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title">Product List</h4>
            </div>
            <div class="modal-body" id="product_list">

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn default" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    jQuery(document).ready(function () {
        $('.scroller').each(function () {
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
        $(document).on('click', '.load_product', function () {
            $('#product_list').html('');
            var warehouseId = $(this).data('warehouse-id');
            if (warehouseId) {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_product_list'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data: {warehouseId: warehouseId},
                    success: function (data, status) {

                    },
                    error: function (xhr, desc, err) {
                        console.log("error");

                    }
                });
            }

        });
    });
</script>