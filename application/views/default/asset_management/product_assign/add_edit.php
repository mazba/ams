<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/metronic/global/plugins/select2/select2.css"/>
<script type="text/javascript" src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/metronic/global/plugins/select2/select2.min.js"></script>
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
                        <form id="system_save_form" action="<?php echo $CI->get_encoded_url('asset_management/product_assign/index/save'); ?>" method="post">
                            <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-7 col-md-offset-2">


                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('PRODUCT'); ?></label></div>
                                            <div class="col-lg-7" id="product_wrp">
                                                <select name="product_assign[product_id][]" class="form-control select2me" style="margin-bottom: 10px">
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>true,'drop_down_options'=>$product));
                                                    ?>
                                                </select>
                                            </div>
                                            <div id="add_new" class="label label-danger col-lg-1" style="float:left;padding: 6px 0; margin: 2px 0; cursor: pointer"><i class="fa fa-plus"></i></div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4"><label class="control-label bold"><?php echo $CI->lang->line('USER'); ?></label></div>
                                            <div class="col-lg-8">
                                                <select name="product_assign[user_id]" class="form-control" >
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_default_option'=>true,'drop_down_options'=>$user));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group has-error row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="assign_date"><?php echo $CI->lang->line('ASSIGN_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product_assign[assign_date]" placeholder="<?php echo $CI->lang->line('ASSIGN_DATE'); ?>" class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="return_date"><?php echo $CI->lang->line('RETURN_DATE'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="product_assign[return_date]" placeholder="<?php echo $CI->lang->line('RETURN_DATE'); ?>" class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group has-success row">
                                            <div class="col-lg-4">
                                                <label class="control-label bold" for="product_assign[remarks]"><?php echo $CI->lang->line('REMARKS'); ?></label>
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea type="text" name="product_assign[remarks]" class="form-control" rows="2"></textarea>
                                            </div>
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
<div id="product_drpwn" style="display:none">
    <div class="newProduct">
       <div class="col-md-10">
        <select name="product_assign[product_id][]" class="form-control" style="margin-bottom: 10px">
            <?php
            $CI->load_view('dropdown',array('drop_down_default_option'=>true,'drop_down_options'=>$product));
            ?>
        </select>
        </div>
        <div class="col-md-2">
            <a href="#" class="external" onclick="removeIt(this)"><i class="fa fa-times"></i></a>
        </div>  
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        $('.date-picker').datepicker()
        $(".select2me").select2();
        $("#add_new").click(function () {
            $("#product_wrp")
                .children("select")
                // call destroy to revert the changes made by Select2
                .select2("destroy")
                .end();
                $("#product_wrp").append($("#product_drpwn").html());
                // $("#product_wrp select:last").wrap("<div class='newProduct'></div>")
                // $("#product_wrp .newProduct:last").append('<a href="#" class="external" onclick="removeIt(this)"><i class="fa fa-times"></i></a>')
            // enable Select2 on the select elements
            $("#product_wrp select").select2();
        });
    });
    function removeIt(ele){
        ele.closest('.newProduct').remove();
    }
</script>

