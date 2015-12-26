<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$components=User_helper::get_task_module_component($CI->config->item('system_sidebar01'));
?>

<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu1" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <?php
    foreach($components as $component)
    {
        ?>
        <?php
        foreach($component['modules'] as $module)
        {
            ?>
            <li>
                <a class="external" href="javascript:;">
                    <i class="<?php echo $module['module_icon']; ?>"></i> <?php echo $module['module_name']; ?> <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <?php
                    foreach($module['tasks'] as $task)
                    {
                        ?>
                        <li>
                            <a class="" href="<?php echo $CI->get_encoded_url($task['controller']); ?>"><i class="<?php echo $task['task_icon']; ?>"></i><?php echo $task['task_name']; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <?php
        }
        ?>
    <?php
    }
    ?>
</ul>
<!-- END SIDEBAR -->
