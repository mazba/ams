<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$conditions = array();
foreach ($this->config->item('product_condition') as $key => $dd) {
    $conditions[] = array('text' => $dd, 'value' => $key);
}
?>
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>
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
                        <form id="system_save_form"
                              action="<?php echo $CI->get_encoded_url('asset_management/product/index/save'); ?>"
                              method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>"/>
                            <input type="hidden" name="system_save_new_status" id="system_save_new_status" value="0"/>

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="name_en"><?php echo $CI->lang->line('NAME'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" id="product_name" name="product[product_name]"
                                                       value="<?php echo $product['product_name']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('NAME'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('UNIT_PRICE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[unit_price]"
                                                       value="<?php echo $product['unit_price']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('UNIT_PRICE'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('CATEGORY'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select name="product[category_id]" class="form-control">
                                                    <?php
                                                    $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => $category, 'drop_down_selected' => $product['category_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('WAREHOUSE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select name="product[warehouse_id]" class="form-control">
                                                    <?php
                                                    $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => $warehouse, 'drop_down_selected' => $product['warehouse_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('ITEM_UNIT'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[item_unit]"
                                                       value="<?php echo $product['item_unit']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('ITEM_UNIT'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('SORT_DESCRIPTION'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[sort_description]"
                                                       value="<?php echo $product['sort_description']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('SORT_DESCRIPTION'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('SPECIFICATION'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[specification]"
                                                       value="<?php echo $product['specification']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('SPECIFICATION'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('MODEL_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[model_no]"
                                                       value="<?php echo $product['model_no']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('MODEL_NO'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="stock_book_no"><?php echo $CI->lang->line('STOCK_BOOK_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[stock_book_no]"
                                                       value="<?php echo $product['stock_book_no']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('STOCK_BOOK_NO'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label
                                                    class="control-label bold"><?php echo $CI->lang->line('REMARKS'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="product[remarks]" cols="30"  rows="3"><?php echo $product['remarks']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="unit_price"><?php echo $CI->lang->line('WARRANTY_START_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[warranty_start_date]"
                                                       value="<?php echo System_helper::display_date($product['warranty_start_date']); ?>"
                                                       placeholder="<?php echo $CI->lang->line('WARRANTY_START_DATE'); ?>"
                                                       class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="warranty_end_date"><?php echo $CI->lang->line('WARRANTY_END_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[warranty_end_date]"
                                                       value="<?php echo System_helper::display_date($product['warranty_end_date']); ?>"
                                                       placeholder="<?php echo $CI->lang->line('WARRANTY_END_DATE'); ?>"
                                                       class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="purchase_order_no"><?php echo $CI->lang->line('PURCHASE_ORDER_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[purchase_order_no]"
                                                       value="<?php echo $product['purchase_order_no']; ?>"
                                                       placeholder="<?php echo $CI->lang->line('PURCHASE_ORDER_NO'); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold"
                                                       for="purchase_order_no"><?php echo $CI->lang->line('PURCHASE_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[purchase_date]"
                                                       value="<?php echo System_helper::display_date($product['purchase_date']); ?>"
                                                       placeholder="<?php echo $CI->lang->line('PURCHASE_DATE'); ?>"
                                                       class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label
                                                    class="control-label bold"><?php echo $CI->lang->line('OTHERS'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
            <textarea class="form-control" name="product[others]" cols="30"
                      rows="2"><?php echo $product['others']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('MANUFACTURE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select name="product[manufacture_id]" class="form-control">
                                                    <?php
                                                    $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => $manufacture, 'drop_down_selected' => $product['manufacture_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('SUPPLIER'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select name="product[supplier_id]" class="form-control">
                                                    <?php
                                                    $CI->load_view('dropdown', array('drop_down_default_option' => true, 'drop_down_options' => $supplier, 'drop_down_selected' => $product['supplier_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group has-success row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('CONDITION'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <select name="product[condition]" class="form-control">
                                                    <?php
                                                    $CI->load_view('dropdown', array('drop_down_default_option' => true, 'drop_down_options' => $conditions, 'drop_down_selected' => $product['condition']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4"><label
                                                    class="control-label bold"><?php echo $CI->lang->line('ATTACHMENT'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                        <span class="btn btn-primary btn-file">
                                             <i class="fa fa-cloud-upload"></i>
                                            <?php echo $CI->lang->line('Upload'); ?>
                                            <input type="file" name="attachment" id="issue_attachment"
                                                   data-preview-container="#imtext" data-preview-height="30"
                                                   class="validate[custom[validateMIME[image/jpeg|image/png|image/jpg|image/gif]]]"/>

                                        </span>
                                                <span>Max Size 1024KB</span>
                                            </div>
                                        </div>

                                        <!--    <div class="form-group has-error row">-->
                                        <!--        <div class="col-lg-4"><label class="control-label bold">-->
                                        <?php //echo $CI->lang->line('STATUS'); ?><!--</label></div>-->
                                        <!--        <div class="col-lg-8">-->
                                        <!--            <select name="product[status]" class="form-control">-->
                                        <!--                --><?php
                                        //                $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => array(array('text' => $CI->lang->line('ACTIVE'), 'value' => $this->config->item('STATUS_ACTIVE')), array('text' => $CI->lang->line('INACTIVE'), 'value' => $this->config->item('STATUS_INACTIVE'))), 'drop_down_selected' => isset($product['status']) ? $product['status'] : $this->config->item('STATUS_ACTIVE')));
                                        //                ?>
                                        <!--            </select>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                    </div>
                                    <div class="col-md-12">
                                        <hr style="border-color: #fce99d"/>
                                        <?php
                                        if (!$product['id']) {
                                            ?>
                                            <div class="col-md-4">
                                                <div class="form-group has-error row">
                                                    <div class="col-lg-4">
                                                        <label class="control-label bold"
                                                               for="product_code"><?php echo $CI->lang->line('NUMBER_OF_PRODUCT'); ?></label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="number" id="number_of_product" value=""
                                                               placeholder="Number Of Product"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">

                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="product_wrp">
                                        <div class="col-md-12" id="base_product_row">
                                            <div class="col">
                                                <div class="col-md-6">
                                                    <div class="form-group has-error row">
                                                        <div class="col-lg-1">
                                                            <span style="margin-top: 5px"
                                                                  class="badge badge-success">1</span>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label class="control-label bold"
                                                                   for="product_code"><?php echo $CI->lang->line('PRODUCT_CODE'); ?></label>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="product[product_code][]"
                                                                   value="<?php echo $product['product_code']; ?>"
                                                                   placeholder="<?php echo $CI->lang->line('CODE'); ?>"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group has-error row">
                                                        <div class="col-lg-4">
                                                            <label class="control-label bold"
                                                                   for="serial_number"><?php echo $CI->lang->line('SERIAL_NUMBER'); ?></label>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="product[serial_number][]"
                                                                   value="<?php echo $product['serial_number']; ?>"
                                                                   placeholder="<?php echo $CI->lang->line('SERIAL_NUMBER'); ?>"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="new_product_row" class="col-md-12">

                                        </div>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
    $(document).ready(function () {
        turn_off_triggers();
        $('.date-picker').datepicker();
        $(document).on('keyup', '#number_of_product', function () {
            var no_of_product = parseInt($(this).val());
            if (!isNaN(no_of_product) && no_of_product > 1 && no_of_product < 300) {
                $('#new_product_row').html('');
                for (var i = 1; i < no_of_product; i++) {
                    var newItem = $('#new_product_row').append($('#base_product_row').html());
                    newItem.find('.col:last span').html(i + 1)
                    console.log(newItem)
                }
            }
            else {
                $('#new_product_row').html('');
            }
        });

        $("#product_name").autocomplete({
            source: "<?php echo $CI->get_encoded_url('asset_management/product/get_product_name_by_str'); ?>",
            minLength: 2,
            select: function (event, ui) {
//                log( ui.item ?
//                    "Selected: " + ui.item.value + " aka " + ui.item.id :
//                    "Nothing selected, input was " + this.value );
                console.log(ui);
            }
        });
    });
</script>

