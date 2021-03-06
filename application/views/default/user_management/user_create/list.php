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
        var url = "<?php echo $CI->get_encoded_url('user_management/user_create/get_list');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'edit_link', type: 'string' },
                { name: 'user_name', type: 'string' },
                { name: 'username', type: 'string' },
                { name: 'group_name', type: 'dropdown' },
                { name: 'email', type: 'string' },
                { name: 'mobile', type: 'string' },
                { name: 'status_text', type: 'string' }
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
                pagesize:50,
                pagesizeoptions: ['10', '20', '30', '50','100','150'],
                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,

                columns: [
                    { text: '<?php echo $CI->lang->line('NAME'); ?>', dataField: 'user_name', width:'20%'},
                    { text: '<?php echo $CI->lang->line('USER_NAME'); ?>', dataField: 'username', width:'20%'},
                    { text: '<?php echo $CI->lang->line('EMAIL'); ?>', dataField: 'email', width:'20%'},
                    { text: '<?php echo $CI->lang->line('MOBILE_NUMBER'); ?>', dataField: 'mobile', width:'15%'},
                    { text: '<?php echo $CI->lang->line('GROUP_NAME'); ?>', dataField: 'group_name',filtertype: 'checkedlist', width:'12%'},
                    { text: '<?php echo $CI->lang->line('STATUS'); ?>', dataField: 'status_text',filtertype: 'checkedlist', width:'10%'}
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