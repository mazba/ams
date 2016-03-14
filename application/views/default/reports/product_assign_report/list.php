<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>বরাদ্দকৃত প্রোডাক্টের প্রতিবেদন
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <form class="report_form" id="system_save_form"
                                  action="<?php echo $CI->get_encoded_url('reports/Product_assign_report_view/index/list'); ?>"
                                  method="get">


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold">ক্যটাগরি</label>
                                        <select name="category" class="form-control " id="category">
                                            <?php
                                            $CI->load_view('dropdown', array('drop_down_options' => $categories));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label class="bold">প্রোডাক্ট নাম</label>
                                        <select name="product_name" class="form-control " id="product_name">
                                            <?php
                                            $CI->load_view('dropdown', array('drop_down_options' => $products));
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold">শুরুর তারিখ</label>

                                        <input type="text" id="start_date" class="date-picker form-control"
                                               name="start_date"/>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold">শেষের তারিখ </label>

                                        <input type="text" id="end_date" class="date-picker form-control"
                                               name="end_date"/>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="bold">
                                            <input type="radio" checked value="all" name="search_type"/>
                                            সকল বরাদ্দকৃত প্রোডাক্ট
                                        </label>
                                        &nbsp; &nbsp;
                                        <label class="bold">
                                            <input type="radio" value="pending" name="search_type"/>
                                            ফেরত দেওয়ার তারিখ শেষ হয়েগেছে
                                        </label>
                                </div>
                        </div>

                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary pull-right"
                                   value="রিপোর্ট দেখুন">
                        </div>
                        </form>

                    </div>
                    <form class="report_form" id="system_save_form"
                          action="<?php echo $CI->get_encoded_url('reports/Product_assign_report_view/index/list'); ?>"
                          method="get">
                        <div class="row form-inline">
                            <div class="form-body">
                                <div class="col-md-12">
                                    <div class="row">


                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 10px 0">


                                </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT INNER -->
</div>
</div>
<script>
    $(document).ready(function () {
        turn_off_triggers();
        $('.date-picker').datepicker()
//        $(document).on('click', '#submit', function () {
////            console.log();
//            $.ajax({
//                url: '<?php //echo $CI->get_encoded_url('reports/product_assign_report/get_product_list'); ?>//',
//                type: 'POST',
//                dataType: "JSON",
//                data: {
//                    search_type: $('[name=search_type]:checked').val(),
//                    start_date: $('#start_date').val(),
//                    end_date: $('#end_date').val(),
//                    category: $('#category').val(),
//                    product_name: $('#product_name').val()
//
//                },
//                success: function (data, status) {
////                    console.log(data.system_content.html)
////                    window.open(data.html, "width=600,height=600,scrollbars=yes");
//                },
//                error: function (xhr, desc, err) {
//                    console.log("error");
//
//                }
//            });
//        });

    });
//    function print_rpt() {
//        URL = "<?php //echo base_url().'assets/'; ?>//page/Print_a4_Eng.php?selLayer=PrintArea";
//        day = new Date();
//        id = day.getTime();
//        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,left = 20,top = 50');");
//    }
</script>

<script>
    turn_off_triggers();

    $(document).on("change","#category",function()
    {
        var category_id = $("#category").val();

        if(category_id.length>0)
        {
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/Product_reports/get_product_list_by_category'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{category_id:category_id},
                success: function (data, status)
                {

                },
                error: function (xhr, desc, err)
                {
                    console.log("error");
                }
            });
        }
    });

</script>