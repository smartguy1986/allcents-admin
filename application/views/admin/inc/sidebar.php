<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <?php $company_info = company_info('company_logo'); ?>
            <img src="<?php echo base_url(); ?>uploads/company/<?php echo $company_info->company_logo; ?>"
                class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text"><a href="<?php echo base_url('dashboard'); ?>">Allcents</a></h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <div class="sidemenuwrapper">
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>" class="">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('details'); ?>" class="">
                    <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                    <div class="menu-title">Home Page Details</div>
                </a>
            </li>

            <!-- <li>
                <a href="<?php echo base_url('apicalllogs'); ?>" class="">
                    <div class="parent-icon"><i class="bx bx-category"></i></div>
                    <div class="menu-title">API Call Logs</div>
                </a>
            </li> -->

            <li>
                <a href="<?php echo base_url('calendar'); ?>" class="">
                    <div class="parent-icon"><i class="bx bx-calendar"></i></div>
                    <div class="menu-title">Calendar Event Image</div>
                </a>
            </li>
            <!-- <li class="menu-label">Booking Deatils</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-calendar'></i>
                </div>
                <div class="menu-title">Manage Booking</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('booking/requests'); ?>"><i class="bx bx-right-arrow-alt"></i>All Booking Requests</a>
                </li>
            </ul>
        </li> -->
            <li class="menu-label">User Section</li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('users/filter/admin'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Admin</a>
                    </li>
                    <li> <a href="<?php echo base_url('users/filter/treasurer'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Treasurers</a>
                    </li>
                    <li> <a href="<?php echo base_url('users/filter/user'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Users</a>
                    </li>
                    <li> <a href="<?php echo base_url('users/create'); ?>"><i class="bx bx-right-arrow-alt"></i>Register
                            User</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importUserModal"><i
                                class="bx bx-right-arrow-alt"></i>Import
                            User</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Donations</li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-credit-card'></i>
                    </div>
                    <div class="menu-title">Manage Donations</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('donations'); ?>"><i class="bx bx-right-arrow-alt"></i>Donation
                            Lists</a>
                    </li>
                    <!-- <li> <a href="<?php echo base_url('donations/add'); ?>"><i class="bx bx-right-arrow-alt"></i>Make Donation</a>
                </li> -->
                </ul>
            </li>

            <li class="menu-label">Policy Transactions</li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-credit-card'></i>
                    </div>
                    <div class="menu-title">Manage Transactions</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('transactions'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Transaction Lists</a>
                    </li>
                    <!-- <li> <a href="<?php echo base_url('transaction/add'); ?>"><i class="bx bx-right-arrow-alt"></i>Make Transaction</a>
                </li> -->
                </ul>
            </li>

            <li class="menu-label">Policies</li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-plus-medical'></i>
                    </div>
                    <div class="menu-title">Manage Funeral Covers</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('policies'); ?>"><i class="bx bx-right-arrow-alt"></i>Policy
                            Lists</a>
                    </li>
                    <li> <a href="<?php echo base_url('policies/create'); ?>"><i class="bx bx-right-arrow-alt"></i>Add
                            Policy</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Branches & Cells</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-git-branch'></i>
                    </div>
                    <div class="menu-title">Manage Branches</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('branches'); ?>"><i class="bx bx-right-arrow-alt"></i>Branch
                            List</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addBranchModal"><i
                                class="bx bx-right-arrow-alt"></i>Add Branch</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-church'></i>
                    </div>
                    <div class="menu-title">Manage Cells</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('cells'); ?>"><i class="bx bx-right-arrow-alt"></i>Cell List</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCellModal"><i
                                class="bx bx-right-arrow-alt"></i>Add Cell</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Programme Categories</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-category-alt'></i>
                    </div>
                    <div class="menu-title">Manage Programme Categories</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('categories'); ?>"><i class="bx bx-right-arrow-alt"></i>Category
                            List</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i
                                class="bx bx-right-arrow-alt"></i>Add Programme Category</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Programme Events</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-calendar-event'></i>
                    </div>
                    <div class="menu-title">Manage Events</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('events'); ?>"><i class="bx bx-right-arrow-alt"></i>Events
                            Lists</a>
                    </li>
                    <li> <a href="<?php echo base_url('events/add'); ?>"><i class="bx bx-right-arrow-alt"></i>Add
                            Events</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Notices Categories</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-category'></i>
                    </div>
                    <div class="menu-title">Manage Notice Categories</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('noticecategories'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Notice
                            Category List</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNoticeModal"><i
                                class="bx bx-right-arrow-alt"></i>Add Notice Category</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Notices</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-news'></i>
                    </div>
                    <div class="menu-title">Manage Notices</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('notices'); ?>"><i class="bx bx-right-arrow-alt"></i>Notice
                            Lists</a>
                    </li>
                    <li> <a href="<?php echo base_url('notices/add'); ?>"><i class="bx bx-right-arrow-alt"></i>Add
                            Notice</a>
                    </li>
                </ul>
            </li>

            <!-- <li class="menu-label">Health Centre and Doctors</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-health'></i>
                </div>
                <div class="menu-title">Health Centre</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('centres'); ?>"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu12'); ?></a>
                </li>
                <li> <a href="<?php echo base_url('centres/add'); ?>"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu13'); ?></a>
                </li>
                <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importCentreModal"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu14'); ?></a>
                </li>
            </ul>
        </li>
        <li class="menu-label">Period Tracker</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-female-sign'></i>
                </div>
                <div class="menu-title">Period Data</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('periodcalendar'); ?>"><i class="bx bx-right-arrow-alt"></i>Calendars</a>
                </li>
                <?php /*<li> <a href="<?php echo base_url('centres/add');?>"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu13'); ?></a>
                 </li>
                 <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importCentreModal"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu14'); ?></a>
                 </li> */?>
            </ul>
        </li> -->
            <!-- <li class="menu-label">Notifications</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-bell-minus' ></i>
                </div>
                <div class="menu-title">Manage Notifications</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('notifications'); ?>"><i
                            class="bx bx-right-arrow-alt"></i>Notification Lists</a>
                </li>
                <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNotificationModal"><i
                            class="bx bx-right-arrow-alt"></i>Add Notification</a>
                </li>
            </ul>
        </li> -->

            <li class="menu-label">Announcement</li>
            <li>
                <a class="has-arrow" href="javascript:void(0);">
                    <div class="parent-icon"><i class='bx bx-volume-full'></i>
                    </div>
                    <div class="menu-title">Manage Announcements</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('announcements'); ?>"><i
                                class="bx bx-right-arrow-alt"></i>Announcement Lists</a>
                    </li>
                    <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal"><i
                                class="bx bx-right-arrow-alt"></i>Add Announcement</a>
                    </li>
                </ul>
            </li>
            <!--<li class="menu-label">Reviews & Feedback</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-comment-detail'></i>
                </div>
                <div class="menu-title">Reviews</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('reviews'); ?>"><i class="bx bx-right-arrow-alt"></i>Reviews</a>
                </li>
                <?php /*<li> <a href="<?php echo base_url('centres/add');?>"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu13'); ?></a>
                 </li>
                 <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#importCentreModal"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu14'); ?></a>
                 </li> */?>
            </ul>
        </li>
        <li class="menu-label">Locations</li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-current-location'></i>
                </div>
                <div class="menu-title">Manage Locations</div>
            </a>
            <ul>
                <li> <a href="<?php echo base_url('region'); ?>"><i class="bx bx-right-arrow-alt"></i>Region List</a>
                </li>
                <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addRegionModal"><i class="bx bx-right-arrow-alt"></i>Add Region</a>
                </li>
                <li> <a href="<?php echo base_url('region/cities'); ?>"><i class="bx bx-right-arrow-alt"></i>City List</a>
                </li>
                <li> <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCityModal"><i class="bx bx-right-arrow-alt"></i>Add city</a>
                </li>
            </ul>
        </li> -->

            <li class="menu-label">API Section</li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-code-alt'></i>
                    </div>
                    <div class="menu-title">API Management</div>
                </a>
                <ul>
                    <li> <a href="<?php echo base_url('apilists'); ?>"><i class='bx bx-list-ul'></i>API Lists</a>
                    </li>
                    <!-- <li> <a href="<?php echo base_url('apicalllogs'); ?>"><i class="bx bx-right-arrow-alt"></i>API Calls Log</a>
                </li> -->
                </ul>
            </li>
            <!-- <li class="menu-label"><?php echo $this->lang->line('sidebarmenu36'); ?></li>
        <li>
            <a class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon"><i class='bx bx-mail-send'></i>
                </div>
                <div class="menu-title"><?php echo $this->lang->line('sidebarmenu37'); ?></div>
            </a>
            <ul>
                <li> <a class="has-arrow" href="#" id="comingsoon"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu38'); ?></a>
                </li>
                <li> <a class="has-arrow" href="#" id="comingsoon"><i class="bx bx-right-arrow-alt"></i><?php echo $this->lang->line('sidebarmenu39'); ?></a>
                </li>
            </ul>
        </li> -->
        </ul>
    </div>
    <!--end navigation-->
</div>