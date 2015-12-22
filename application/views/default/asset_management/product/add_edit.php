<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
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
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="#portlet-config" data-toggle="modal" class="config">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('asset_management/manufacture/index/save'); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id'];?>"/>
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="name_en"><?php echo $CI->lang->line('NAME'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[product_name]" value="<?php echo $product['product_name'];?>" placeholder="<?php echo $CI->lang->line('NAME'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="product_code"><?php echo $CI->lang->line('PRODUCT_CODE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[product_code]" value="<?php echo $product['product_code'];?>" placeholder="<?php echo $CI->lang->line('CODE'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="serial_number"><?php echo $CI->lang->line('SERIAL_NUMBER'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[serial_number]" value="<?php echo $product['serial_number'];?>" placeholder="<?php echo $CI->lang->line('SERIAL_NUMBER'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('UNIT_PRICE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[unit_price]" value="<?php echo $product['unit_price'];?>" placeholder="<?php echo $CI->lang->line('UNIT_PRICE'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('ITEM_UNIT'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[item_unit]" value="<?php echo $product['item_unit'];?>" placeholder="<?php echo $CI->lang->line('ITEM_UNIT'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('SORT_DESCRIPTION'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[sort_description]" value="<?php echo $product['sort_description'];?>" placeholder="<?php echo $CI->lang->line('SORT_DESCRIPTION'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('SPECIFICATION'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[specification]" value="<?php echo $product['specification'];?>" placeholder="<?php echo $CI->lang->line('SPECIFICATION'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('MODEL_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[model_no]" value="<?php echo $product['model_no'];?>" placeholder="<?php echo $CI->lang->line('MODEL_NO'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="unit_price"><?php echo $CI->lang->line('WARRANTY_START_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[warranty_start_date]" value="<?php echo $product['warranty_start_date'];?>" placeholder="<?php echo $CI->lang->line('WARRANTY_START_DATE'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="warranty_end_date"><?php echo $CI->lang->line('WARRANTY_END_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[warranty_end_date]" value="<?php echo $product['warranty_end_date'];?>" placeholder="<?php echo $CI->lang->line('WARRANTY_END_DATE'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="stock_book_no"><?php echo $CI->lang->line('STOCK_BOOK_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[stock_book_no]" value="<?php echo $product['stock_book_no'];?>" placeholder="<?php echo $CI->lang->line('STOCK_BOOK_NO'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="purchase_order_no"><?php echo $CI->lang->line('PURCHASE_ORDER_NO'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[purchase_order_no]" value="<?php echo $product['purchase_order_no'];?>" placeholder="<?php echo $CI->lang->line('PURCHASE_ORDER_NO'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="purchase_order_no"><?php echo $CI->lang->line('PURCHASE_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product[purchase_date]" value="<?php echo $product['purchase_date'];?>" placeholder="<?php echo $CI->lang->line('PURCHASE_DATE'); ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('CATEGORY'); ?></label></div>
                                            <div class="col-lg-8">
                                                <select name="manufacture[category_id]" class="form-control" >
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>$category,'drop_down_selected'=>$product['category_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('MANUFACTURE'); ?></label></div>
                                            <div class="col-lg-8">
                                                <select name="manufacture[manufacture_id]" class="form-control" >
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>$manufacture,'drop_down_selected'=>$product['manufacture_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('SUPPLIER'); ?></label></div>
                                            <div class="col-lg-8">
                                                <select name="manufacture[manufacture_id]" class="form-control" >
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>$manufacture,'drop_down_selected'=>$product['manufacture_id']));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('STATUS'); ?></label></div>
                                            <div class="col-lg-8">
                                                <select name="manufacture[status]" class="form-control" >
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('ACTIVE'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('INACTIVE'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($product['status'])?$product['status']:$this->config->item('STATUS_ACTIVE')));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

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
        turn_off_triggers();
        
    });
</script>

