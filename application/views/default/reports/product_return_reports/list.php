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
                            <i class="fa fa-cogs"></i>ফেরত দেত্তয়া প্রোডাক্ট সম্পর্কিত প্রতিবেদন

                        </div>
                        <div class="tools">
                            <a class="reload" href="javascript:;" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="report_form" id="system_save_form"
                              action="<?php echo $CI->get_encoded_url('reports/Product_return_report_view/index/list'); ?>"
                              method="get">
                        <div class="row form-inline">
                            <div class="form-body">
                                <br/>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="">শুরুর তারিখ</label>

                                            <input type="text" id="start_date" class="datepicker form-control"
                                                   name="start_date"/>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="">শেষের তারিখ </label>

                                            <input type="text" id="end_date" class="datepicker form-control"
                                                   name="end_date"/>

                                        </div>


                                        <div class="form-group col-md-4" style="margin-top: 15px;">

                                            <label class="">ক্যটাগরি</label>
                                            <select name="category" class="form-control " id="category">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $categories));
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4" style="margin-top: 15px;">

                                            <label class="">ব্যবহারকারীর নাম</label>
                                            <select name="user_name" class="form-control " id="user_name">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $users));
                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4" style="margin-top: 15px;">

                                            <label class="">প্রোডাক্ট  নাম</label>
                                            <select name="product_name" class="form-control " id="product_name">
                                                <?php
                                                $CI->load_view('dropdown', array('drop_down_options' => $products));
                                                ?>
                                            </select>
                                        </div>

                                    </div>


                                </div>

                                <div class="col-md-12" style="margin: 10px 0">
                                    <div class="col-md-12" style="margin: 10px 0">
                                        <input type="submit" class="btn btn-primary pull-right"
                                               value="রিপোর্ট দেখুন">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr/>
                                </div>
                                <div class="col-md-12 " id="PrintArea" style="overflow: scroll;padding-top: 22px;">

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
<script>
    $(document).ready(function () {
        turn_off_triggers();
        $('.datepicker').datepicker()
        $(document).on('click', '#submit', function () {
//            console.log();
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/product_return_report/get_product_list'); ?>',
                type: 'POST',
                dataType: "JSON",
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                 //   ticket_type: $('#ticket_type').val(),
                    category: $('#category').val(),
                    user_name:$('#user_name').val(),
                    product_name:$('#product_name').val()
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
