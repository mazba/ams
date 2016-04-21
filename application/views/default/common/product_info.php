


<?php
$CI=& get_instance();
?>
<p><b><?php echo $CI->lang->line('NAME'); ?></b>:<?php echo" ".$product_info['product_name']?></p>
<p><b><?php echo $CI->lang->line('CATEGORY'); ?></b>:<?php echo" ".$product_info['category_name']?></p>
<p><b><?php echo $CI->lang->line('PRODUCT_CODE'); ?></b>:<?php echo" ".$product_info['product_code']?></p>
<p><b><?php echo $CI->lang->line('SERIAL_NUMBER'); ?></b>:<?php echo" ".$product_info['serial_number']?></p>
<p><b><?php echo $CI->lang->line('UNIT_PRICE'); ?></b>:<?php echo" ".$product_info['unit_price']?></p>
<p><b><?php echo $CI->lang->line('MODEL_NO'); ?></b>:<?php echo" ".$product_info['model_no']?></p>
<p><b><?php echo $CI->lang->line('WAREHOUSE'); ?></b>:<?php echo" ".$product_info['warehouse_name']?></p>
<p><b><?php echo $CI->lang->line('WARRANTY_START_DATE'); ?></b>:<?php echo" ".System_helper::display_date($product_info['warranty_start_date']) ?></p>
<p><b><?php echo $CI->lang->line('WARRANTY_END_DATE'); ?></b>:<?php echo" ".System_helper::display_date($product_info['warranty_end_date'])?></p>
<p><b><?php echo $CI->lang->line('STATUS'); ?></b>:<?php echo" ";if($product_info['condition']==0){echo "ভাল";}else{echo'ত্রুটিপূর্ণ';}?></p>
<hr/>
<h4><?php echo $CI->lang->line('SUPPLIER_DETAILS')?></h4>
<hr/>
<p><b><?php echo $CI->lang->line('COMPANY_NAME'); ?></b>:<?php echo " ".$product_info['company_name'];?></p>
<p><b><?php echo $CI->lang->line('COMPANY_ADDRESS'); ?></b>:<?php echo " ".$product_info['company_address'];?></p>
<p><b><?php echo $CI->lang->line('COMPANY_OFFICE_PHONE'); ?></b>:<?php echo " ".$product_info['company_office_phone'];?></p>
<p><b><?php echo $CI->lang->line('CONTACT_PERSON'); ?></b>:<?php echo " ".$product_info['contact_person'];?></p>
<p><b><?php echo $CI->lang->line('CONTACT_PERSON_PHONE'); ?></b>:<?php echo " ".$product_info['contact_person_phone'];?></p>