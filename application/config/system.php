<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//public pages
$config['PUBLIC_CONTROLLERS']=array('home');
/////// Pagination Config
$config['page_size']=100;
///// report language folder
$config['GET_LANGUAGE']="bangla";
//// upload directories
$config['file_upload']['users']='images/users';
$config['file_upload']['supplier']='images/supplier';
$config['file_upload']['ticket_issue']='images/ticket_issue';

//////// USER LEVEL
$config['SUPER_ADMIN_GROUP_ID'] = 1;
$config['ADMIN_GROUP_ID'] = 2;
$config['TOP_MANAGEMENT_GROUP_ID'] = 3;
$config['END_GROUP_ID'] = 4;
$config['OFFICER_GROUP_ID'] = 5;
$config['SUPPORT_GROUP_ID'] = 6;
$config['OPERATOR_GROUP_ID'] = 7;

///////// SYSTEM STATUS VALUE
$config['STATUS_INACTIVE']=0; // TICKET PENDING
$config['STATUS_ACTIVE']=1; //
$config['STATUS_ASSIGN']=2; //
$config['STATUS_REJECT']=3;   //
$config['STATUS_RESOLVE']=4;   //
$config['STATUS_DELETE']=99;

//////// USER HIGHER KEY
$config['USER_HIGHER_KEY'][1] = 'Wing';
$config['USER_HIGHER_KEY'][2] = 'Sub Wing';
$config['USER_HIGHER_KEY'][3] = 'Branch';

//////// GENDER CONFIG
$config['GENDER'][1] = 'পুরুষ';
$config['GENDER'][0] = 'মহিলা';

////// DATE FORMATION
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

//// report menu id
$config['report_component_id']=3;

//////////// User Level ///////////
$config['user_level_min']=2;
$config['user_level_max']=13;

/////// TICKET ISSUE COMMENT TYPE
$config['ticket_comment_end_user']=1;
$config['ticket_comment_manager']=2;
$config['ticket_comment_support_user']=3;
// requisition type
$config['requisition_type'][1]='Hardware';
$config['requisition_type'][2]='Software';
