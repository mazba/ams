<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//public pages
$config['PUBLIC_CONTROLLERS']=array('home');
/////// Pagination Config
$config['page_size']=100;
///// report language folder
$config['GET_LANGUAGE']="bangla";

//upload directories
$config['dcms_upload']['entrepreneur']='images/supplier';

$config['SUPER_ADMIN_GROUP_ID'] = 1;
$config['A_TO_I_GROUP_ID'] = 2;
$config['DONOR_GROUP_ID'] = 3;
$config['MINISTRY_GROUP_ID'] = 4;


$config['STATUS_INACTIVE']=0; // SERVICE PROPOSED
$config['STATUS_ACTIVE']=1; // SERVICE, USER APPROVED
$config['STATUS_REJECT']=2;   // USER DENY
$config['STATUS_SUSPEND']=3;
$config['STATUS_TEMPORARY_SUSPEND']=4;
$config['STATUS_DELETE']=99;

$config['GENDER_MALE']=1;
$config['GENDER_FEMALE']=2;

$config['GENDER']['1'] = 'পুরুষ';
$config['GENDER']['0'] = 'মহিলা';

$config['DATE_DISPLAY_FORMAT'] = 'Y-m-d';

// Equipment Status
$config['product_condition'][0] = 'ভাল';
$config['product_condition'][1] = 'ত্রুটিপূর্ণ';

// Month
$config['month']['01'] = 'জানুয়ারি';
$config['month']['02'] = 'ফেব্রুয়ারি';
$config['month']['03'] = 'মার্চ';
$config['month']['04'] = 'এপ্রিল';
$config['month']['05'] = 'মে';
$config['month']['06'] = 'জুন';
$config['month']['07'] = 'জুলাই';
$config['month']['08'] = 'আগস্ট';
$config['month']['09'] = 'সেপ্টেম্বর';
$config['month']['10'] = 'অক্টোবর';
$config['month']['11'] = 'নভেম্বর';
$config['month']['12'] = 'ডিসেম্বর';

//report menu id
$config['report_component_id']=3;

//////////// User Level ///////////
$config['user_level_min']=2;
$config['user_level_max']=13;
