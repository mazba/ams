<?php
$CI = & get_instance();
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo $CI->lang->line('NO'); ?></th>
            <th><?php echo $CI->lang->line('NAME'); ?></th>
            <th><?php echo $CI->lang->line('PRODUCT_CODE'); ?></th>
            <th><?php echo $CI->lang->line('SERIAL_NUMBER'); ?></th>
            <th><?php echo $CI->lang->line('MODEL_NO'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach($data as $dd)
        {
            ?>
            <tr>
                <td><span class="badge badge-info"><?php echo $i; ?></span></td>
                <td><?php echo $dd['product_name'] ?></td>
                <td><?php echo $dd['product_code'] ?></td>
                <td><?php echo $dd['serial_number'] ?></td>
                <td><?php echo $dd['model_no'] ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
</table>