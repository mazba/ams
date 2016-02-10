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
                            <i class="fa fa-cogs"></i>টিকেট রিপোর্ট
                        </div>
                        <div class="tools">
                            <a class="reload" href="javascript:;" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row form-inline">
                                <div class="form-body">
                                    <br/>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">শুরুর তারিখ</label>
                                            <div class="col-md-8">
                                                <input type="text" id="start_date" class="datepicker form-control" name="start_date"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">শেষের তারিখ </label>
                                            <div class="col-md-8">
                                                <input type="text" id="end_date" class="datepicker form-control" name="end_date"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">টিকেটর ধরন</label>
                                            <div class="col-md-7">
                                                <select name="ticket_type" id="ticket_type" class="form-control">
                                                    <option value="all">All</option>
                                                    <option value="assigned">Assigned</option>
                                                    <option value="unassigned">Unassigned</option>
                                                    <option value="resolved">Resolved</option>
                                                    <option value="reject">Reject</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12" style="margin: 10px 0">
                                        <button id="submit" class="btn btn-success pull-right"> <i class="fa fa-file"></i> রিপোর্ট দেখুন</button>
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
        $('.datepicker').datepicker()
        $(document).on('click','#submit',function(){
//            console.log();
            $.ajax({
                url: '<?php echo $CI->get_encoded_url('reports/ticket_reports/get_ticket_list'); ?>',
                type: 'POST',
                dataType: "JSON",
                data:{
                    start_date:$('#start_date').val(),
                    end_date:$('#end_date').val(),
                    ticket_type:$('#ticket_type').val()
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