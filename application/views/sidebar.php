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
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?= ($current_method === 'index' && $current_class === 'dashboard') ? 'active' : ''; ?>">
            <a href="<?= site_url(); ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <!------------------------- Registration ------------------------->
        <?php if ($this->session->userdata('active_event')): ?>
            <li class="<?= (($current_class === 'registration') && ($current_method === 'index')) ? ' active' : ''; ?>">
                <a href="<?= site_url('registration'); ?>">
                    <i class="fa fa-registered"></i> <span> Registration</span>
                </a>
            </li>
            <li class="treeview<?= (($current_class === 'registration') && ($current_method != 'index')) ? ' active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-print"></i> <span> Reports & Summaries etc</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= (($current_class === 'registration') && ($current_method === 'summary')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/summary'); ?>"><i class="fa fa-line-chart"></i> Summary</a>
                    </li>
<!--                    <li class="--><?//= (($current_class === 'registration') && ($current_method === 'sms')) ? ' active' : ''; ?><!--">-->
<!--                        <a href="--><?//= site_url('registration/sms'); ?><!--"><i class="fa fa-envelope"></i> SMS Summary</a>-->
<!--                    </li>-->
                    <li class="<?= (($current_class === 'registration') && ($current_method === 'group' or $current_method === 'group_calculatation')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/group'); ?>"><i class="fa fa-group"></i> Groups</a>
                    </li>
                    <li class="<?= (($current_class === 'registration') && ($current_method === 'badge')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/badge'); ?>"><i class="fa fa-credit-card"></i> Badges</a>
                    </li>
    <!--                    <li class="treeview<? //= (($current_class === 'registration') && ($current_method === 'print_section')) ? ' active' : '';        ?>">
                        <a href="#">
                            <i class="fa fa-check"></i> <span> Attendance</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu<? //= ($current_method === 'print_section') ? ' active' : '';        ?>">-->
                    <li class="<?= ($current_method === 'print_section' && $this->uri->segment(3) == 'desk') ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/print_section/desk'); ?>"><i class="fa fa-registered"></i> Registration List</a>
                    </li>
                    <li class="<?= ($current_method === 'print_section' && $this->uri->segment(3) == 'panel') ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/print_section/panel'); ?>"><i class="fa fa-university"></i> Hazri Sheet</a>
                    </li>
                    <li class="<?= ($current_method === 'print_section' && $this->uri->segment(3) == 'present') ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/print_section/present'); ?>"><i class="fa fa-check-circle"></i> List Presentee</a>
                    </li>
                    <li class="<?= ($current_method === 'print_section' && $this->uri->segment(3) == 'absent') ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/print_section/absent'); ?>"><i class="fa fa-times-circle"></i> List Absentee</a>
                    </li>
                    <li class="<?= ($current_method === 'print_section' && $this->uri->segment(3) == 'leave') ? ' active' : ''; ?>">
                        <a href="<?= site_url('registration/print_section/leave'); ?>"><i class="fa fa-battery-quarter"></i> On Leave</a>
                    </li>

                    <!--                        </ul>
                                        </li>-->
                </ul>
            </li>
        <?php endif; ?>
        <!----------------------- End Registration ----------------------->
        <!------------------------ Participants ------------------------>
        <li class="treeview<?= ($current_class === 'participant') ? ' active' : ''; ?>">
            <a href="#">
                <i class="fa fa-users"></i> <span> Participants </span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php if (user_role() == 'admin'): ?>
                <li class="<?= (($current_class === 'participant') && ($current_method === 'trash')) ? ' active' : ''; ?>">
                    <a href="<?= site_url('participant/trash'); ?>"><i class="fa fa-trash"></i> Trash Data</a>
                </li>
                <?php endif;?>
                <li class="<?= (($current_class === 'participant') && ($current_method === 'create')) ? ' active' : ''; ?>">
                    <a href="<?= site_url('participant/create'); ?>"><i class="fa fa-circle-o"></i> Create New</a>
                </li>
                <li class="<?= (($current_class === 'participant') && ($current_method === 'export')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('participant/export'); ?>">
                        <i class="fa fa-file-excel-o"></i> <span> Export Data</span>
                    </a>
                </li>
                <li class="<?= (($current_class === 'participant') && ($current_method === 'index' or $current_method === 'read' or $current_method === 'update')) ? 'active' : ''; ?>">
                    <a href=""><i class="fa fa-circle-o"></i> Existing Data<i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?= (($current_class === 'participant') && ($current_method === 'index') && !$this->input->get('ideology')) ? 'active' : ''; ?>">
                            <a href="<?= site_url('participant'); ?>"><i class="fa fa-circle-o"></i> Show All</a>
                        </li>
                        <?php foreach ($ideologies as $ideology): ?>
                            <li class="<?= (($current_class === 'participant') && ($current_method === 'index') && $this->input->get('ideology') === $ideology->ideology_id) ? 'active' : ''; ?>">
                                <a href="<?= site_url('participant/?ideology=' . $ideology->ideology_id); ?>">
                                    <i class="fa fa-circle-o"></i> <?= $ideology->ideology_status; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </li>
        <!---------------------- End Participants ---------------------->
        <!--------------------------- Events --------------------------->
        <?php if (user_role() == 'desk'): ?>
            <li class="<?= ($current_class === 'event') ? ' active' : ''; ?>">
                <a href="<?= site_url('event'); ?>">
                    <i class="fa fa-calendar"></i> <span> Events</span>
                </a>
            </li>
        <?php elseif (user_role() == 'admin'): ?>
            <li class="treeview<?= ($current_class === 'event') ? ' active' : ''; ?>">

                <a href="#">
                    <i class="fa fa-calendar"></i> <span> Events</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= (($current_class === 'event') && ($current_method === 'create')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('event/create'); ?>"><i class="fa fa-circle-o"></i> Add New Event</a>
                    </li>
                    <li class="<?= (($current_class === 'event') && ($current_method === 'index' or $current_method === 'read' or $current_method === 'update')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('event'); ?>"><i class="fa fa-circle-o"></i> List of Events</a>
                    </li>
                </ul>
            </li>
            <!------------------------ Organization ------------------------>
            <li class="treeview<?= ($current_class === 'organization') ? ' active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-building"></i> <span> Tanzimaat </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">                    
                    <li class="<?= (($current_class === 'organization') && ($current_method === 'regions' or $current_method === 'region')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('organization/regions'); ?>"><i class="fa fa-circle-o"></i> <?= lang('region')?></a>
                    </li>
                    <li class="<?= (($current_class === 'organization') && ($current_method === 'zones' or $current_method === 'zone')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('organization/zones'); ?>"><i class="fa fa-circle-o"></i> <?= lang('zone')?></a>
                    </li>
                    <li class="<?= (($current_class === 'organization') && ($current_method === 'cities' or $current_method === 'city')) ? ' active' : ''; ?>">
                        <a href="<?= site_url('organization/cities'); ?>"><i class="fa fa-circle-o"></i> <?= lang('city')?></a>
                    </li>
                </ul>
            </li>
            <!---------------------- End Organization ---------------------->
            <!------------------------ Propagation ------------------------->
            <li class="<?= ($current_class === 'propagation') ? 'active' : ''; ?>">
                <a href="<?= site_url('propagation'); ?>">
                    <i class="fa fa-share-alt"></i> <span>Dawati Haisiat</span>
                </a>
            </li>
            <!---------------------- End Propagation ----------------------->
            <!------------------------ Ideology ------------------------->
            <li class="<?= ($current_class === 'ideology') ? 'active' : ''; ?>">
                <a href="<?= site_url('ideology'); ?>">
                    <i class="fa fa-book"></i> <span>Tarbiti Haisiat</span>
                </a>
            </li>
            <!---------------------- End Ideology ----------------------->
            <!------------------------ Majlis Amomi ------------------------->
            <li class="<?= ($current_class === 'majlis_amomi') ? 'active' : ''; ?>">
                <a href="<?= site_url('majlis_amomi'); ?>">
                    <i class="fa fa-book"></i> <span>Majlis Amomi</span>
                </a>
            </li>
            <!---------------------- End Majlis Amomi ----------------------->
            <!------------------------ Event Titles ------------------------->
            <li class="<?= ($current_class === 'title') ? 'active' : ''; ?>">
                <a href="<?= site_url('title'); ?>">
                    <i class="fa fa-sticky-note-o"></i> <span>Event Title</span>
                </a>
            </li>
            <!---------------------- End Titles ----------------------->
            <!------------------------ Maintenance ------------------------>
            <li class="<?= ($current_class === 'maintenance') ? 'active' : ''; ?>">
                <a href="<?= site_url('maintenance'); ?>">
                    <i class="fa fa-database"></i> <span> Database</span>
                </a>
            </li>
            <!---------------------- End Organization ---------------------->
        <?php endif; ?>
        <li class="<?= ($current_class === 'file') ? 'active' : ''; ?>">
            <a href="<?= site_url('file'); ?>">
                <i class="fa fa-file"></i> <span> Files</span>
            </a>
        </li>
        <li class="<?= ($current_class === 'feedback') ? 'active' : ''; ?>">
            <a href="<?= site_url('feedback'); ?>">
                <i class="fa fa-exchange"></i> <span> Feedback</span>
            </a>
        </li>
        <!------------------------- End events ------------------------->
        <!--        <li class="treeview">
                    <a href="#">
                        <i class="fa fa-wrench"></i> <span> Settings</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href=""><i class="fa fa-circle-o"></i> Theme</a>
                        </li>
                    </ul>
                </li>-->
        <!-------------------------- Settings -------------------------->

    </ul>
</section>