<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$user = User_helper::get_user();
$warehouse_product_info = Dashboard_helper::get_warehouse_product_info();
$get_product_list = Dashboard_helper::get_my_product_list();

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="" rel="stylesheet" type="text/css"/>
<style>
    .display_none{
        display: none;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row">
            <div class="col-sm-12 col-sm-offset-0">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('PRODUCT_DETAILS'); ?>
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
                            <div class="col-sm-6 col-sm-offset-3">
                                <br/>
                                <input type="text" class="form-control large" id="product_name" value="" placeholder="SEARCH PRODUCT">
                                <br/>
                            </div>
                            <table class="table table-bordered product_list display_none" data-item-id="0" data-payment-id="0" id="" >
                                <tr>
                                    <td><?php echo $CI->lang->line('NAME'); ?></td>
                                    <td><?php echo $CI->lang->line('PRODUCT_CODE'); ?></td>
                                    <td><?php echo $CI->lang->line('SERIAL_NUMBER'); ?></td>
                                    <td><?php echo $CI->lang->line('UNIT_PRICE'); ?></td>
                                    <td><?php echo $CI->lang->line('MODEL_NO'); ?></td>
                                    <td><?php echo $CI->lang->line('WARRANTY_START_DATE'); ?></td>
                                    <td><?php echo $CI->lang->line('WARRANTY_END_DATE'); ?></td>
                                    <td><?php echo $CI->lang->line('STATUS'); ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('WAREHOUSE_WISE_PRODUCT_INFO'); ?> &nbsp;<span class="label label-warning"><?php echo System_helper::Get_Eng_to_Bng( count($warehouse_product_info)) ?></span>
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
                                            <a href="#" class="external">
                                                <?php echo $warehouse['warehouse_name'] ?> </a>
                                        </td>
                                        <td>
                                            <div class="label label-info center-block"><i class="fa fa-cubes "></i> <?php echo System_helper::Get_Eng_to_Bng($warehouse['number_of_product']) ?></div>
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
            </div>
            <div class="col-md-6">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo $CI->lang->line('MY_PRODUCTS_LIST'); ?> <span class="label label-warning"><?php echo System_helper::Get_Eng_to_Bng( count($get_product_list)) ?></span>
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
                            if(!count($get_product_list)){
                                echo '<h3 class="text-center"><span class="label label-danger">'.$CI->lang->line('NO_DATA_FOUND').'</span></h3>';
                            }
                            else {
                                ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo $CI->lang->line('PRODUCT'); ?></th>
                                        <th><?php echo $CI->lang->line('PRODUCT_CODE'); ?></th>
                                        <th><?php echo $CI->lang->line('ASSIGN_DATE'); ?></th>
                                        <th><?php echo $CI->lang->line('WARRANTY_END_DATE'); ?></th>
                                        <th><?php echo $CI->lang->line('REMAIN/PENDING'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($get_product_list as $product) {
                                        ?>
                                        <tr>
                                            <td><?php echo $product['product_name'] ?></td>
                                            <td><?php echo $product['product_code'] ?></td>
                                            <td><?php echo System_helper::display_date($product['assign_date']) ?></td>
                                            <td><?php echo System_helper::display_date($product['warranty_end_date']) ?></td>
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


        $("#product_name").autocomplete({
            source: "<?php echo  base_url().'Home/'.'search_product/'; ?>",
            minLength: 2,
            focus: function( event, ui ) {
                event.preventDefault();
                $('#item_name').val(ui.item.label);
            },
            select: function (event, ui) {

                $('#product_name').val(ui.item.label);

                //alert(discount_type);
//                $('#item_id').val(ui.item.value);
//                return false
                $(".table").removeClass('display_none');
                var index = $('.product_list').data('item-id');
                var html = "<tr class=' single_product'>" +


                    "<td>"+
                    "<input type='text' class='form-control' value='" + ui.item.product_name + "' disabled>" +
                    "</td>"+

                    "<td>" +
                    "<input type='text' class='form-control' value='" + ui.item.product_code + "' disabled>" +
                    "</td>"+

                    "<td>"+
                    "<input type='text' class='form-control' value='" + ui.item.serial_numb + "' disabled>" +
                    "</td>"+

                    "<td>"+
                    "<input type='text' class='form-control' value='" + ui.item.unit_price + "' disabled>" +
                    "</td>"+

                    "<td>"+
                    "<input type='text' class='form-control' value='" + ui.item.model_no + "' disabled>" +
                    "</td>"+

                    "<td>"+
                    "<input type='text' class='form-control' value='" + ui.item.warranty_start_date + "' disabled>" +                    "</td>"+

                    "<td>"+

                    "<input type='text' class='form-control' value='" + ui.item.warranty_end_date + "' disabled>" +
                    "</td>"+
                    "<td>"+

                    "<input type='text' class='form-control' value='" + ui.item.status + "' disabled>" +
                    "</td>"+
                    "</tr>";


                var status = true;
                $.each($('.product_list').find('.product_id'), function (index, element) {
                    if (parseInt(element.value) == ui.item.value) {
                        status = false;
                        alert('This product already assigned.')
                        return false;
                    }
                });
                if (status) {
                    $('.product_list').data('item-id',index+1)
                    $('.product_list tr:first').after(html);
                }
                $(this).val('')
                return false
            }
            ,
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }

        });
    });
</script>