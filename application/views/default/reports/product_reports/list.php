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
                            <i class="fa fa-cogs"></i>পণ্যের প্রতিবেদন
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
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">ক্যটাগরি</label>
                                            <div class="col-md-9">
                                                <select name="category" class="form-control" id="category">
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_options'=>$categories));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">প্রস্তুতকারক</label>
                                            <div class="col-md-9">
                                                <select name="manufacture" class="form-control" id="manufacture">
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_options'=>$manufactures));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">প্রস্তুতকারক</label>
                                            <div class="col-md-9">
                                                <select name="supplier" class="form-control" id="supplier">
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_options'=>$suppliers));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">পণ্যাগার</label>
                                            <div class="col-md-9">
                                                <select name="warehouse" class="form-control" id="warehouse">
                                                    <?php
                                                    $CI->load_view('dropdown',array('drop_down_options'=>$warehouses));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px">
                                            <label class="col-md-4 control-label">Unassigned</label>
                                            <div class="col-md-2">
                                                <input type="radio" checked value="unassigned"  name="product_type" />
                                            </div>
                                            <label class="col-md-4 control-label">Assigned</label>
                                            <div class="col-md-2">
                                                <input type="radio" value="all"  name="product_type" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin: 10px 0">
                                        <button id="submit" class="btn btn-success pull-right">রিপোর্ট দেখুন</button>
                                    </div>
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
    $(document).ready(function ()
    {
        turn_off_triggers();
//        $('.date-picker').datepicker()
        $(document).on('click','#submit',function(){
//            console.log();
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/product_reports/get_product_list'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{
                    category:$('#category').val(),
                    manufacture:$('#manufacture').val(),
                    supplier:$('#supplier').val(),
                    warehouse:$('#warehouse').val(),
                    product_type:$('[name=product_type]:checked').val()
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