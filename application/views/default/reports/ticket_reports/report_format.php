<?php
/**
 * Created by PhpStorm.
 * User: Mazba
 * Date: 2/8/2016
 * Time: 6:22 PM
 */
$CI = &get_instance();
?>
<button class="btn btn-sm btn-danger" id="print_button" onclick="print_rpt()"><i class="fa fa-print"></i> প্রিন্ট</button>
<h1 class="text-center">
    বাংলাদেশ জাতীয় সংসদ
</h1>
<h3 class="text-center">
    টিকেট সম্পর্কিত  প্রতিবেদন
</h3>
<h5 class="text-center">
    তারিখ: <?php echo date('d-m-Y') ?>
</h5>
<table class="table table-bordered" style="overflow: auto">
    <thead>
        <tr style="background: #eee">
            <th>#</th>
            <th>বিষয়</th>
            <th>প্রোডাক্ট </th>
            <th>ইউজারের নাম</th>
            <th>বিবরণ</th>
            <th>ইস্যু তারিখ </th>
            <th>অবস্থা </th>


        </tr>
    </thead>
    <tbody>
    <?php
    $i=0;
    foreach($tickets as $ticket)
    {
        $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $ticket['subject'] ?></td>
            <td><?php echo $ticket['product_name'] ?></td>
            <td><?php echo $ticket['user_name'] ?></td>
            <td title="<?php echo $ticket['ticket_issue_description']; ?>"><?php echo $ticket['ticket_issue_description'] ?></td>
            <td><?php echo System_helper::display_date($ticket['create_date']) ?></td>
            <td>
                <?php
                if($ticket['status']==$this->config->item('STATUS_INACTIVE'))
                {
                    echo $CI->lang->line('PENDING');
                }
                else if($ticket['status']==$this->config->item('STATUS_ACTIVE'))
                {
                    echo $CI->lang->line('RESOLVE');
                }
                else if($ticket['status']==$this->config->item('STATUS_ASSIGN'))
                {
                    echo $CI->lang->line('ASSIGN');
                }
                else if($ticket['status']==$this->config->item('STATUS_RESOLVE'))
                {
                    echo $CI->lang->line('RESOLVE');
                }
                else if($ticket['status']==$this->config->item('STATUS_REJECT'))
                {
                    echo $CI->lang->line('REJECT');
                }
                else
                {
                    echo $ticket['status'];
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
