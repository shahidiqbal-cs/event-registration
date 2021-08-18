<?php
$current_method = $this->router->fetch_method();
$current_class = $this->router->fetch_class();
$is_event = false;
if ($current_method === 'event' || $current_method === 'event_new' || $current_method === 'event_action' || $current_method === 'event_attendance' || $current_method === 'event_summary'):
    $is_event = true;
endif;
?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="<?= ($current_class === 'new_db') ? 'active' : ''; ?>">
            <a href="<?= site_url('admin/new_db'); ?>">
                <i class="fa fa-database"></i> <span> New Database</span>
            </a>
        </li>
        <li class="<?= ($current_class === 'drop_db') ? 'active' : ''; ?>">
            <a href="<?= site_url('admin/drop_db'); ?>">
                <i class="fa fa-eraser"></i> <span> Erase Database</span>
            </a>
        </li>

    </ul>
</section>