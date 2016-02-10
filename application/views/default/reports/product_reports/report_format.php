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
    পণ্য সম্পর্কিত  প্রতিবেদন
</h3>
<h5 class="text-center">
    তারিখ: <?php echo date('d-m-Y') ?>
</h5>
<table class="table table-bordered" style="overflow: auto">
    <thead>
        <tr style="background: #eee">
            <th>প্রোডাক্ট  নাম</th>
            <th>প্রোডাক্ট কোড</th>
            <th>ক্রমিক সংখ্যা</th>
            <th>ইউনিট মূল্য</th>
            <th>ক্যটাগরি</th>
            <th>পণ্যাগার</th>
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
    foreach($products as $product)
    {
        ?>
        <tr>
            <td><?php echo $product['product_name'] ?></td>
            <td><?php echo $product['product_code'] ?></td>
            <td><?php echo $product['serial_number'] ?></td>
            <td><?php echo $product['unit_price'] ?></td>
            <td><?php echo $product['category_name'] ?></td>
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
            <td><?php echo ($product['status']) ? 'Active' : 'In-active' ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
