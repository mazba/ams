<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$user = User_helper::get_user();
//$modules=User_helper::get_task_module($CI->config->item('system_sidebar02'));
$dir=$CI->config->item('file_upload');
?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo base_url() ?>">
                <img src="<?php echo base_url() ?>images/logo/softbdltd.png" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"></li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
<!--                        <a href="#" class="dropdown-toggle external" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">-->
<!--                            <i class="icon-bell"></i>-->
<!--							<span class="badge badge-success">-->
<!--							7 </span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu">-->
<!--                            <li class="external">-->
<!--                                <h3><span class="bold">12 pending</span> notifications</h3>-->
<!--                                <a href="extra_profile.html">view all</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">-->
<!--                                    <li>-->
<!--                                        <a href="javascript:;">-->
<!--                                            <span class="time">just now</span>-->
<!--											<span class="details">-->
<!--											<span class="label label-sm label-icon label-success">-->
<!--											<i class="fa fa-plus"></i>-->
<!--											</span>-->
<!--											New user registered. </span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                        </ul>-->
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide"></li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<span class="username username-hide-on-mobile">
								<?php
                                echo $user->name_bn;
                                ?>
								</span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            <img alt="" class="img-circle" src="<?php echo base_url().$dir['users'].'/'.$user->picture_name ?>"/>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo base_url() ?>Home/logout">
                                    <i class="icon-key"></i><?php echo $CI->lang->line('LOG_OUT'); ?> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>