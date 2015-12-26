<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/metronic/admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/metronic/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN LOGIN -->
<div class="login" style="background: none!important;">
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="<?php echo $CI->get_encoded_url("home/login");?>" method="post">
            <h3 class="form-title" style="color: #4b8df9; font-weight: bold"><?php echo $CI->lang->line('LOGIN_TO_YOUR_ACCOUNT'); ?></h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
			<span>
                <?php echo $CI->lang->line('ENTER_USERNAME_AND_PASSWORD'); ?>
            </span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9"><?php echo $CI->lang->line('USERNAME'); ?></label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9"><?php echo $CI->lang->line('PASSWORD'); ?></label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn blue pull-right">
                    <?php echo $CI->lang->line('LOGIN'); ?> <i class="m-icon-swapright m-icon-white"></i>
                </button>
            </div>
        </form>
        <!-- END LOGIN FORM -->
    </div>
</div>
<!-- END LOGIN -->