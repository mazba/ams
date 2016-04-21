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
<!--            <span class="pull-right">--><?php //echo $this->lang->line('REPORT_CURRENT_DATE_VIEW');?><!--</span>-->
        </div>
        <div class="col-lg-12">
<table style="width: 100%;">
    <tr>
        <td style="text-align:center;">
            <img src="<?php echo base_url()?>images/government-logo.png">
        </td>
        </tr>
    <tr>
        <td style="width: 60%">
            <h1 class="text-center">বাংলাদেশ জাতীয় সংসদ</h1>
            <h3 class="text-center">ওয়ারেন্টি শেষ হয়ে যাওয়া প্রোডাক্ট সম্পর্কিত প্রতিবেদন</h3>

            <?php
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];

            if ($start_date != null && $end_date != null) {
                echo '<p class="text-center"> অনুসন্ধানএর তারিখ : ' . System_helper::Get_Eng_to_Bng($start_date) . " " . 'হইতে ' . System_helper::Get_Eng_to_Bng($end_date) .  'পর্যন্ত</p>';
            } elseif ($start_date != null && $end_date == null) {
                echo '<p class="text-center"> অনুসন্ধানএর তারিখ :  ' . System_helper::Get_Eng_to_Bng($start_date) . ' ' . 'হইতে বর্তমান পর্যন্ত</p>';
            } elseif ($start_date == null && $end_date != null) {
                echo '<p class="text-center">  অনুসন্ধানএর তারিখ :  আরম্ভ হইতে' . '' . System_helper::Get_Eng_to_Bng($end_date) . ' পর্যন্ত</p>';
            } else {

            } ?>
        </td>
        </tr>


</table>

<h5 class="pull-right">
    মুদ্রণ তারিখ: <?php echo System_helper::Get_Eng_to_Bng(date('d-m-Y')) ?>
</h5>
<table class="table table-bordered" style="overflow: auto">
    <thead>
        <tr style="background: #eee">
            <th>প্রোডাক্ট  নাম</th>
            <th>প্রোডাক্ট কোড</th>
            <th>ক্যটাগরি</th>
            <th>সরবরাহকারী প্রতিষ্ঠানের নাম</th>
            <th> সরবরাহকারী  ব্যক্তির নাম</th>
            <th>সরবরাহকারী  ব্যক্তির মোবাইল নাম্বার</th>
            <th>ক্রয়ের তারিখ</th>
            <th>ওয়ারেন্টি শেষ এর  তারিখ</th>
            <th>প্রোডাক্টএর বর্তমান অবস্থা</th>

        </tr>
    </thead>
    <tbody>
    <?php
    foreach($products as $product)
    {
        ?>
        <tr>
            <td><?php echo $product['product_name'] ?></td>
            <td><?php echo $product['product_code'] ?></td>
            <td><?php echo $product['category_name'] ?></td>

            <td><?php echo $product['company_name'] ?></td>
            <td><?php echo $product['contact_person'] ?></td>
            <td><?php echo $product['contact_person_phone'] ?></td>


            <td><?php echo System_helper::display_date($product['purchase_date']) ?></td>
            <td><?php echo System_helper::display_date($product['warranty_end_date']) ?></td>
            <td><?php echo ($product['condition']) ? 'ত্রুটিপূর্ণ' : 'ভাল' ?></td>
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
