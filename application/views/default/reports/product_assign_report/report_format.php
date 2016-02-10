<?php
/**
 * Created by PhpStorm.
 * User: Mazba
 * Date: 2/8/2016
 * Time: 6:22 PM
 */
?>
<button class="btn btn-sm btn-danger" id="print_button" onclick="print_rpt()"><i class="fa fa-print"></i> প্রিন্ট</button>
<h1 class="text-center">
    বাংলাদেশ জাতীয় সংসদ
</h1>
<h3 class="text-center">
    বরাদ্দকৃত  পণ্য সম্পর্কিত প্রতিবেদন
</h3>
<h5 class="text-center">
    তারিখ: <?php echo date('d-m-Y') ?>
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
