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
                            <i class="fa fa-cogs"></i>স্টক এর  বর্তমান অবস্থার প্রতিবেদন
                        </div>

                    </div>
                    <div class="portlet-body">
                        <form class="report_form" id="system_save_form"
                              action="<?php echo $CI->get_encoded_url('reports/CurrentStock_report_view/index/list'); ?>"
                              method="get">
                        <div class="row form-inline ">
                            <div class="form-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="">ক্যটাগরি</label>
                                            <select name="category" class="form-control " id="category">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $categories));
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="">প্রস্তুতকারক</label>
                                            <select name="manufacture" class="form-control " id="manufacture">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $manufactures));
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="">সরবরাহকারী</label>


                                            <select name="supplier" class="form-control " id="supplier">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $suppliers));
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="">পণ্যাগার</label>

                                            <select name="warehouse" class="form-control " id="warehouse">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $warehouses));
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12" style="margin: 10px 0">
                                    <input type="submit" class="btn btn-primary pull-right"
                                           value="রিপোর্ট দেখুন">
                                </div>

                        </form>
                                <div class="col-md-12">
                                    <hr/>
                                </div>
                                <div class="col-md-12 " id="PrintArea" style="overflow: scroll;padding-top: 22px;">

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
<script>
    $(document).ready(function () {
        turn_off_triggers();
//        $('.date-picker').datepicker()
        $(document).on('click', '#submit', function () {
//            console.log();
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/CurrentStock/get_product_list'); ?>',
                type: 'POST',
                dataType: "JSON",
                data: {
                    category: $('#category').val(),
                    manufacture: $('#manufacture').val(),
                    supplier: $('#supplier').val(),
                    warehouse: $('#warehouse').val(),
                    product_type: $('[name=product_type]:checked').val()
                },
                success: function (data, status) {
//                    console.log(data.system_content.html)
//                    window.open(data.html, "width=600,height=600,scrollbars=yes");
                },
                error: function (xhr, desc, err) {
                    console.log("error");

                }
            });
        });

    });
    function print_rpt() {
        URL = "<?php echo base_url().'assets/'; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,left = 20,top = 50');");
    }
</script>