
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link="http://".$_SERVER['HTTP_HOST'].str_replace("/list","/pdf",$_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";
//die();
?>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/templates/default/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="main_container">
        <div class="row show-grid hidden-print">
<!--            <a class="btn btn-primary btn-rect pull-right" href="--><?php //echo $pdf_link;?><!--">--><?php //echo $this->lang->line("BUTTON_PDF"); ?><!--</a>-->
            <a class="btn btn-primary btn-rect pull-right" style="margin-right: 10px;" href="javascript:window.print();"><?php echo $this->lang->line("BUTTON_PRINT"); ?></a>
            <div class="clearfix"></div>
        </div>
        <div class="col-lg-12">

<?php

$CI = &get_instance();
?>
<table style="margin-top: 50px;">
    <tr>
        <td style="width: 20%">
            <img src="<?php echo base_url()?>images/government-logo.gif">
        </td>
        <td style="width: 60%">
            <h1 class="text-center">বাংলাদেশ জাতীয় সংসদ</h1>
            <h3 class="text-center">    টিকেট সম্পর্কিত  প্রতিবেদন      </h3>
        </td>
        <td style="width: 20%">
            <img  src="<?php echo base_url()?>images/government-logo.gif">

        </td>
    </tr>

</table>

<h5 class="pull-right">
    মুদ্রণ তারিখ: <?php echo date('d-m-Y') ?>
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

</div>
</div>
</div>
</body>
</html>
