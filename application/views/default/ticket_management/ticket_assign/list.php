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
                <div class="portlet box grey-cararra">
                    <div class="col-lg-12 text-danger h4">
                        <?php echo $this->lang->line('TOTAL_NOT_ASSIGN_ISSUE');?> ( <?php echo System_helper::Get_Eng_to_Bng($ticket['number_of_not_assign_issue']?$ticket['number_of_not_assign_issue']:0);?> )
                    </div>
                    <div class="portlet-body">
                        <div id="system_dataTable">

                        </div>
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
        var url = "<?php echo $CI->get_encoded_url('ticket_management/ticket_assign/get_list');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'edit_link', type: 'string' },
                { name: 'name_bn', type: 'string' },
                { name: 'email', type: 'string' },
                { name: 'mobile', type: 'string' },
                { name: 'pbx', type: 'string' },
                { name: 'ticket_issue_id', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#system_dataTable").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: false,
                columnsresize: true,
                pagesize:10,
                pagesizeoptions: ['10', '20', '30', '50','100','150'],
                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,

                columns: [
                    { text: '<?php echo $CI->lang->line('USER_NAME'); ?>', dataField: 'name_bn',filtertype: 'checkedlist', width:'25%'},
                    { text: '<?php echo $CI->lang->line('EMAIL'); ?>', dataField: 'email',filtertype: 'checkedlist', width:'22%'},
                    { text: '<?php echo $CI->lang->line('MOBILE_NUMBER'); ?>', dataField: 'mobile',filtertype: 'checkedlist', width:'20%'},
                    { text: '<?php echo $CI->lang->line('PBX'); ?>', dataField: 'pbx',filtertype: 'checkedlist', width:'20%'},
                    { text: '<?php echo $CI->lang->line('NUMBER_OF_ISSUE'); ?>', dataField: 'ticket_issue_id', width:'10%'}
                ]
            });
        //for Double Click to edit
        $('#system_dataTable').on('rowDoubleClick', function (event)
        {
            var edit_link=$('#system_dataTable').jqxGrid('getrows')[event.args.rowindex].edit_link;

            $.ajax({
                url: edit_link,
                type: 'POST',
                dataType: "JSON",
                success: function (data, status)
                {

                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        });
    });
</script>