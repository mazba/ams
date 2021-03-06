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
        var url = "<?php echo $CI->get_encoded_url('ticket_management/ticket_resolve/get_list');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'edit_link', type: 'string' },
                { name: 'ticket_issue_id', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'name_bn', type: 'string' },
                { name: 'priority', type: 'string' },
                { name: 'product_name', type: 'string' },
                { name: 'product_code', type: 'string' },
                { name: 'create_date_time', type: 'string' },
                { name: 'support_name', type: 'string' }
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
                showfilterrow: true,
                columnsresize: true,
                pagesize:10,
                pagesizeoptions: ['10', '20', '30', '50','100','150'],
                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,

                columns: [
                    { text: '<?php echo $CI->lang->line('TOKEN'); ?>', dataField: 'ticket_issue_id', width:'5%'},
                    { text: '<?php echo $CI->lang->line('SUBJECT'); ?>', dataField: 'subject', width:'27%'},
                    { text: '<?php echo $CI->lang->line('ISSUE_FROM'); ?>', dataField: 'name_bn', width:'10%'},
                    { text: '<?php echo $CI->lang->line('PRIORITY'); ?>', dataField: 'priority', width:'10%'},
                    { text: '<?php echo $CI->lang->line('PRODUCT_NAME'); ?>', dataField: 'product_name', width:'10%'},
                    { text: '<?php echo $CI->lang->line('PRODUCT_CODE'); ?>', dataField: 'product_code', width:'10%'},
                    { text: '<?php echo $CI->lang->line('TIME'); ?>', dataField: 'create_date_time', width:'10%'},
                    { text: '<?php echo $CI->lang->line('SUPPORT_NAME'); ?>', dataField: 'support_name', width:'15%'}
                ]
            });
        //for Double Click to edit
        <?php
            if($CI->permissions['edit'])
            {
                ?>
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
            <?php
        }
    ?>
    });
</script>