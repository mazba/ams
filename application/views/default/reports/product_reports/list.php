<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<div class="page-content-wrapper" xmlns="http://www.w3.org/1999/html">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>প্রোডাক্টের প্রতিবেদন
                        </div>

                    </div>
                    <div class="portlet-body">


                        <div class="row">
                            <!--                            <div class="col-md-12 col-md-offset-0">-->
                            <form class="report_form" id="system_save_form"
                                  action="<?php echo $CI->get_encoded_url('reports/Product_reports_view/index/list'); ?>"
                                  method="get">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold" for="">ক্যটাগরি </label>
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
                                        <label class="bold" for="">প্রস্তুতকারক</label>

                                        <select name="manufacture" class="form-control " id="manufacture">
                                            <?php
                                            $CI->load_view('dropdown', array('drop_down_options' => $manufactures));
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold" for="">সরবরাহকারী</label>

                                        <select name="supplier" class="form-control " id="supplier">
                                            <?php
                                            $CI->load_view('dropdown', array('drop_down_options' => $suppliers));
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bold" for="">ওয়ারহাউস</label>
                                        <select name="warehouse" class="form-control " id="warehouse">
                                            <?php
                                            $CI->load_view('dropdown', array('drop_down_options' => $warehouses));
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkbox " style="margin-top: 30px;">
                                        <label class="bold ">
                                            <input type="radio" value="assigned" name="product_type"/>
                                            এস্যাইনড প্রোডাক্ট
                                        </label>
                                        &nbsp; &nbsp;
                                        <label class="bold">
                                            <input type="radio" checked value="unassigned" name="product_type"/>
                                            আ্যনএস্যাইনড প্রোডাক্ট
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <input type="submit" class="btn btn-primary pull-right"
                                       value="রিপোর্ট দেখুন">
                                    </div>
                            </form>
                            <!--                            </div>-->
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SAMPLE FORM PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT INNER -->
</div>
</div>
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--       -->
<!--//        $('.date-picker').datepicker()-->
<!--        $(document).on('click', '#submit', function () {-->
<!--//            console.log();-->
<!--            $.ajax({-->
<!--                url: '--><?php //echo $CI->get_encoded_url('reports/product_reports/get_product_list'); ?><!--',-->
<!--                type: 'POST',-->
<!--                dataType: "JSON",-->
<!--                data: {-->
<!--                    category: $('#category').val(),-->
<!--                    manufacture: $('#manufacture').val(),-->
<!--                    supplier: $('#supplier').val(),-->
<!--                    warehouse: $('#warehouse').val(),-->
<!--                    product_type: $('[name=product_type]:checked').val()-->
<!--                },-->
<!--                success: function (data, status) {-->
<!--//                    console.log(data.system_content.html)-->
<!--//                    window.open(data.html, "width=600,height=600,scrollbars=yes");-->
<!--                },-->
<!--                error: function (xhr, desc, err) {-->
<!--                    console.log("error");-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--    function print_rpt() {-->
<!--        URL = "--><?php //echo base_url().'assets/'; ?><!--page/Print_a4_Eng.php?selLayer=PrintArea";-->
<!--        day = new Date();-->
<!--        id = day.getTime();-->
<!--        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,left = 20,top = 50');");-->
<!--    }-->
<!--</script>-->
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