<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<link rel="stylesheet" type="text/css"
      href="<?php echo base_url() . 'assets/templates/' . $CI->get_template(); ?>/metronic/global/plugins/select2/select2.css"/>
<script type="text/javascript"
        src="<?php echo base_url() . 'assets/templates/' . $CI->get_template(); ?>/metronic/global/plugins/select2/select2.min.js"></script>
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
                            <input type="hidden" name="system_save_new_status" id="system_save_new_status" value="0"/>

                            <div class="portlet box grey-cararra">
                                <div class="portlet-body">
                                    <div id="system_dataTable">

                                        <div class="col-sm-6 ">
                                            <h3><?php echo $CI->lang->line('USER_DETAILS');?></h3>
                                          <p><b><?php echo $CI->lang->line('name_bn');?>:</b> <?php echo  $user_info['name_bn']?></p>

                                            <p><b><?php echo $CI->lang->line('office_phone');?>:</b> <?php echo  $user_info['office_phone']?></p>
                                            <p><b><?php echo $CI->lang->line('mobile');?>:</b> <?php echo  $user_info['mobile']?></p>
                                            <p><b><?php echo $CI->lang->line('email');?>:</b> <?php echo  $user_info['email']?></p>
                                            <p><b><?php echo $CI->lang->line('national_id_no');?>:</b> <?php echo  $user_info['national_id_no']?></p>
                                            <p><b><?php echo $CI->lang->line('present_address');?>:</b> <?php echo  $user_info['present_address']?></p>
                                            <p><b><?php echo $CI->lang->line('permanent_address');?>:</b> <?php echo  $user_info['permanent_address']?></p>


                                        </div>



                                        <table class="table table-bordered">
                                                <tr>
                                                    <td><?php echo $CI->lang->line('PRODUCT_NAME');?> </td>
                                                    <td><?php echo $CI->lang->line('PRODUCT_CODE');?> </td>
                                                    <td><?php echo $CI->lang->line('WARRANTY_END_DATE');?> </td>
                                                    <td><?php echo $CI->lang->line('ASSIGN_DATE');?></td>
                                                    <td><?php echo $CI->lang->line('RETURN_DATE');?></td>
                                                    <td><?php // echo $CI->lang->line('');?></td>
                                                </tr>
                                                <?php foreach($user_products as $product):?>
                                                <tr>
                                                    <td><?= $product->product_name?></td>
                                                    <td><?= $product->product_code?></td>
                                                    <td><?= System_helper::display_date($product->warranty_end_date)?></td>
                                                    <td><?= System_helper::display_date($product->assign_date)?></td>
                                                    <td><?= System_helper::display_date($product->return_date)?></td>
                                                    <td><button type="button" class="btn btn-success" onclick="deleteIt(<?php echo $product->product_id; ?>,this)">প্রোডাক্টটি ফেরত নিন</button>
                                                    <button type="button" class="btn btn-danger" onclick="rejectProduct(<?php echo $product->product_id; ?>,this)">বাতিল করুন</button></td>


                                                </tr>
                                                <?php endforeach?>
                                            </table>

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
        $(document).on("click",".delete",function()
        {
            var thisButton = $(this);

        });
    });
    function deleteIt(assignId, ele)
    {
        var answer = confirm ("Are you sure ?")

        if (answer)
        {
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('asset_management/product_return/unassigned_product'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{assign_id:assignId},
                success: function (data, status)
                {
                    $(ele).closest('tr').remove();
                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        }
    }
    function rejectProduct(assignId, ele)
    {
        var answer = confirm ("Are you sure ?")

        if (answer)
        {
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('asset_management/product_return/reject_product'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{assign_id:assignId},
                success: function (data, status)
                {
                    $(ele).closest('tr').remove();
                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        }
    }
</script>