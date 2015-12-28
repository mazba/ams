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
        var url = "<?php echo $CI->get_encoded_url('asset_management/requisition/get_list');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'link', type: 'string' },
                { name: 'requisition_id', type: 'string' },
                { name: 'requisition_title', type: 'string' },
                { name: 'requisition_type', type: 'string' },
                { name: 'user_name', type: 'string' }
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
                    { text: '<?php echo $CI->lang->line('REQUISITION_ID'); ?>', dataField: 'requisition_id', width:'20%'},
                    { text: '<?php echo $CI->lang->line('REQUISITION_TITLE'); ?>', dataField: 'requisition_title', width:'43%'},
                    { text: '<?php echo $CI->lang->line('REQUISITION_TYPE'); ?>', dataField: 'requisition_type', width:'16%'},
                    { text: '<?php echo $CI->lang->line('USER_NAME'); ?>', dataField: 'user_name', width:'18%'}
                ]
            });
        //for Double Click to edit
        <?php
            if($CI->permissions['view'])
            {
                ?>
            $('#system_dataTable').on('rowDoubleClick', function (event)
            {

                var link = $('#system_dataTable').jqxGrid('getrows')[event.args.rowindex].link;
                $.ajax({
                    url: link,
                    type: 'POST',
                    dataType: "JSON",
                    data:{selected_ids:[$('#system_dataTable').jqxGrid('getrows')[event.args.rowindex].id]},
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