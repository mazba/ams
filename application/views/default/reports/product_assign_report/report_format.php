<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("/list", "/pdf", $_SERVER['REQUEST_URI']);

?>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/templates/default/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="main_container">
        <div class="row show-grid hidden-print">
            <!--            <a class="btn btn-primary btn-rect pull-right"-->
            <!--               href="--><?php //echo $pdf_link; ?><!--">--><?php //echo $this->lang->line("BUTTON_PDF"); ?><!--</a>-->
            <a class="btn btn-primary btn-rect pull-right" style="margin-right: 10px;"
               href="javascript:window.print();"><?php echo $this->lang->line("BUTTON_PRINT"); ?></a>

            <div class="clearfix"></div>
            <!--            <span class="pull-right">-->
            <?php //echo $this->lang->line('REPORT_CURRENT_DATE_VIEW');?><!--</span>-->
        </div>
        <div class="col-lg-12">
<table style="margin-top: 50px;">
    <tr>
        <td style="width: 20%">
            <img src="<?php echo base_url()?>images/government-logo.gif">
        </td>
        <td style="width: 60%">
            <h1 class="text-center">বাংলাদেশ জাতীয় সংসদ</h1>
            <h3 class="text-center"> বরাদ্দকৃত  পণ্য সম্পর্কিত প্রতিবেদন</h3>
        </td>
        <td style="width: 20%">
            <img  src="<?php echo base_url()?>images/government-logo.gif">

        </td>
    </tr>

</table>
<h5 class="pull-right">
    মুদ্রণ তারিখ: <?php echo date('d-m-Y') ?>
</h5>
<table class="table table-bordered">
    <thead>
        <tr style="background: #eee">
            <th>প্রোডাক্ট  নাম</th>
            <th>ব্যবহারকারীর নাম</th>
            <th>প্রোডাক্ট কোড</th>
            <th>ক্রমিক সংখ্যা</th>
            <th>ক্যটাগরি</th>
            <th>প্রস্তুতকারক</th>
            <th>মডেল নাম্বার</th>
            <th>ওয়্যারেন্টি শুরুর তারিখ</th>
            <th>ওয়্যারেন্টি শেষ তারিখ</th>
            <th>রিটার্ন তারিখ</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($products as $product)
    {
        ?>
        <tr>
            <td><?php echo $product['product_name'] ?></td>
            <td><?php echo $product['user_name'] ?></td>
            <td><?php echo $product['product_code'] ?></td>
            <td><?php echo $product['serial_number'] ?></td>
            <td><?php echo $product['category_name'] ?></td>
            <td><?php echo $product['manufacture_name'] ?></td>
            <td><?php echo $product['model_no'] ?></td>
            <td><?php echo System_helper::display_date($product['warranty_start_date']) ?></td>
            <td><?php echo System_helper::display_date($product['warranty_end_date']) ?></td>
            <td><?php echo System_helper::display_date($product['return_date']) ?></td>
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
