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


            <table style="margin-top: 50px; width: 100%">
                <tr>
                    <td style="text-align:center;">
                        <img src="<?php echo base_url() ?>images/government-logo.png">
                    </td>
                    </tr>
                <tr>
                    <td style="text-align:center;">
                        <h1 class="text-center">বাংলাদেশ জাতীয় সংসদ</h1>

                        <h3 class="text-center">প্রোডাক্ট সম্পর্কিত প্রতিবেদন</h3>
                    </td>
                    </tr>



            </table>
            <h5 class="pull-right"> মুদ্রণ তারিখ: <?php  echo System_helper::Get_Eng_to_Bng(date('d-m-Y'))  ?> </h5>
            <table class="table table-bordered" style="overflow: auto">
                <thead>
                <tr style="background: #eee">
                    <th>প্রোডাক্ট নাম</th>
                    <th>ক্যটাগরি</th>
                    <th>ইউনিট মূল্য</th>

                    <th>ওয়ারহাউস</th>
                    <th>প্রস্তুতকারক</th>
                    <th>সরবরাহকারী</th>
                    <th>আইটেম ইউনিট</th>
                    <th>সংক্ষিপ্ত বর্ণনা</th>
                    <th>স্পেসিফিকেশন</th>
                    <th>মডেল নাম্বার</th>
                    <th>ওয়্যারেন্টি শুরুর তারিখ</th>
                    <th>ওয়্যারেন্টি শেষ তারিখ</th>
                    <th>ক্রয়ের তারিখ</th>
                    <th>অবস্থা</th>

                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($products as $product) {
                    ?>
                    <tr>
                        <td><?php echo $product['product_name'] ?></td>
                        <td><?php echo $product['category_name'] ?></td>
                        <td><?php echo $product['unit_price'] ?></td>
                        <td><?php echo $product['warehouse_name'] ?></td>
                        <td><?php echo $product['manufacture_name'] ?></td>
                        <td><?php echo $product['company_name'] ?></td>
                        <td><?php echo $product['item_unit'] ?></td>
                        <td><?php echo $product['sort_description'] ?></td>
                        <td><?php echo $product['specification'] ?></td>
                        <td><?php echo $product['model_no'] ?></td>
                        <td><?php echo System_helper::display_date($product['warranty_start_date']) ?></td>
                        <td><?php echo System_helper::display_date($product['warranty_end_date']) ?></td>
                        <td><?php echo System_helper::display_date($product['purchase_date']) ?></td>
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
</div>
</body>
</html>
