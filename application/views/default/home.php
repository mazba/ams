<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user=User_helper::get_user();
if($user->user_group_id==$CI->config->item('SUPER_ADMIN_GROUP_ID'))
{
    $CI->load_view('dashboards/super_admin');
}
else if($user->user_group_id==$CI->config->item('ADMIN_GROUP_ID'))
{
    $CI->load_view('dashboards/super_admin');
}
else if($user->user_group_id==$CI->config->item('TOP_MANAGEMENT_GROUP_ID'))
{
    $CI->load_view('dashboards/super_admin');
}
else if($user->user_group_id==$CI->config->item('END_GROUP_ID'))
{
    $CI->load_view('dashboards/end_user');
}
else if($user->user_group_id==$CI->config->item('OFFICER_GROUP_ID'))
{
    $CI->load_view('dashboards/officer_group');
}
else if($user->user_group_id==$CI->config->item('SUPPORT_GROUP_ID'))
{
    $CI->load_view('dashboards/support_user');
}
else if($user->user_group_id==$CI->config->item('OPERATOR_GROUP_ID'))
{
    $CI->load_view('dashboards/operator_group');
}
else
{
    echo '<br><br><br><br><br>';
}
?>
