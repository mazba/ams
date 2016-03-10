<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("/list", "/pdf", $_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";
//die();
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
<!--            <span class="pull-right">--><?php //echo $this->lang->line('REPORT_CURRENT_DATE_VIEW'); ?><!--</span>-->
        </div>
        <div class="col-lg-12">
            <table style="margin-top: 50px;">
                <tr>
                    <td style="width: 20%">
                        <img src="<?php echo base_url() ?>images/government-logo.gif">
                    </td>
                    <td style="width: 60%">
                        <h1 class="text-center">বাংলাদেশ জাতীয় সংসদ</h1>

                        <h3 class="text-center">
                            স্টক এর বর্তমান অবস্থা সম্পর্কিত প্রতিবেদ
                    </td>
                    <td style="width: 20%">
                        <img src="<?php echo base_url() ?>images/government-logo.gif">

                    </td>
                </tr>

            </table>

            <h5 class="pull-right">
                মুদ্রণ তারিখ: <?php echo date('d-m-Y') ?>
            </h5>
            <table class="table table-bordered" style="overflow: auto">
                <thead>
                <tr style="background: #eee">
                    <th>প্রোডাক্ট নাম</th>
                    <th>পণ্যাগার</th>
                    <th>প্রস্তুতকারক</th>
                    <th>সরবরাহকারী</th>
                    <th>আইটেম ইউনিট</th>
                    <th>সংক্ষিপ্ত বর্ণনা</th>
                    <th>স্পেসিফিকেশন</th>
                    <th>মডেল নাম্বার</th>
                    <th>পণ্যের সংখ্যা</th>

                    <th>হস্তান্তর</th>
                    <th>অবশিষ্ট</th>

                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data['products'] as $product) {
                    ?>
                    <tr>
                        <td><?php echo $product['product_name'] ?></td>
                        <td><?php echo $product['warehouse_name'] ?></td>
                        <td><?php echo $product['manufacture_name'] ?></td>
                        <td><?php echo $product['company_name'] ?></td>
                        <td><?php echo $product['item_unit'] ?></td>
                        <td><?php echo $product['sort_description'] ?></td>
                        <td><?php echo $product['specification'] ?></td>
                        <td><?php echo $product['model_no'] ?></td>
                        <td style="text-align: center"><span
                                class="label label-primary"><?php echo $product['nub_of_product'] ?></span></td>

                        <td style="text-align: center"><span
                                class="label label-warning"> <?php echo $product['nub_of_product'] - $nub_of_product_warehouse =
                                        (isset($data['current_product'][$product['product_name']]) ? $data['current_product'][$product['product_name']]['nub_of_product'] : 0)  ?>
                </span>
                        </td>
                        <td style="text-align: center"><span class="label label-success">
                     <?php echo(isset($data['current_product'][$product['product_name']]) ? $data['current_product'][$product['product_name']]['nub_of_product'] : 0) ?>
                 </span>
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