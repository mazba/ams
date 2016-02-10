<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
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
                            <i class="fa fa-cogs"></i>বরাদ্দকৃত পণ্যের প্রতিবেদন
                        </div>
                        <div class="tools">
                            <a class="reload" href="javascript:;" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row form-inline">
                                <div class="form-body">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-top: 10px">
                                            <label class="col-md-6 control-label">All</label>
                                            <div class="col-md-2">
                                                <input type="radio" checked value="all"  name="search_type" />
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px">
                                            <label class="col-md-10 control-label">Return date over</label>
                                            <div class="col-md-2">
                                                <input type="radio" value="pending"  name="search_type" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin: 10px 0">
                                        <button id="submit" class="btn btn-success pull-right">রিপোর্ট দেখুন</button>
                                    </div>
                                    <div class="col-md-12">
                                        <hr/>
                                    </div>
                                    <div class="col-md-12 " id="PrintArea" style="padding-top: 22px;">

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
    $(document).ready(function ()
    {
        turn_off_triggers();
//        $('.date-picker').datepicker()
        $(document).on('click','#submit',function(){
//            console.log();
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/product_assign_report/get_product_list'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{
                    search_type:$('[name=search_type]:checked').val()
                },
                success: function (data, status)
                {
//                    console.log(data.system_content.html)
//                    window.open(data.html, "width=600,height=600,scrollbars=yes");
                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        });

    });
    function print_rpt(){
        URL="<?php echo base_url().'assets/'; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,left = 20,top = 50');");
    }
</script>