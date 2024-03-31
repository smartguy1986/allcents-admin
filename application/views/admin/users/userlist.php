<!doctype html>
<html lang="en">
<?php $this->view('admin/inc/head'); ?>

<body>
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php $this->view('admin/inc/sidebar'); ?>
        <!--end sidebar wrapper -->
        <?php $this->view('admin/inc/header'); ?>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <?php
                // echo "<pre>";
                // print_r($user_info);
                // echo "</pre>";
                ?>
                <div class="card">
                    <?php
                    if (!empty($this->session->flashdata('error'))) {
                        $alertdata['error'] = $this->session->flashdata('error');
                        $this->view('admin/inc/erroralert', $alertdata);
                        unset($_SESSION['error']);
                    }
                    if (!empty($this->session->flashdata('success'))) {
                        $alertdata['success'] = $this->session->flashdata('success');
                        $this->view('admin/inc/successalert', $alertdata);
                        unset($_SESSION['success']);
                    }
                    if (!empty($this->session->flashdata('update'))) {
                        $alertdata['success'] = $this->session->flashdata('update');
                        $this->view('admin/inc/successalert', $alertdata);
                        unset($_SESSION['update']);
                    }
                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role</th>
                                        <th>Title</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Church Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>Province</th>
                                        <th>District</th>
                                        <th>Branch</th>
                                        <th>Cell</th>
                                        <th>Registered On</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($user_info as $users) {
                                        if ($users->userstatus == 0) {
                                            $userclass = 'bg-deactiveuser';
                                        } else {
                                            $userclass = 'bg-activeuser';
                                        }
                                        echo "<tr class='" . $userclass . "'>";
                                        echo "<td>" . $users->uniqueid . "</td>";
                                        echo "<td>";
                                        if ($users->userrole == 1) {
                                            echo "Admin";
                                        }
                                        if ($users->userrole == 2) {
                                            echo "Treasurer";
                                        }
                                        if ($users->userrole == 3) {
                                            echo "Users";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $users->usertitle . "</td>";
                                        echo "<td>" . $users->userfname . "</td>";
                                        echo "<td>" . $users->userlname . "</td>";
                                        echo "<td>" . $users->userchurchtitle . "</td>";
                                        echo "<td>" . strtolower($users->usermail) . "</td>";
                                        echo "<td>" . $users->userphone . "</td>";
                                        echo "<td>";
                                        if ($users->usergender == 'M') {
                                            echo "Male";
                                        }
                                        if ($users->usergender == 'F') {
                                            echo "Female";
                                        }
                                        if ($users->usergender == 'O') {
                                            echo "Other";
                                        }
                                        echo "</td>";
                                        echo "<td>";
                                        if (!empty($users->userdob) && strpos($users->userdob, "0000") === false) {
                                            echo date("d M Y", strtotime($users->userdob));
                                        }
                                        else{
                                            echo "N/A";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $users->useraddress . "</td>";
                                        if (isset($users->usercountry)) {
                                            echo "<td>" . country_name($users->usercountry)->country_name . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        if (isset($users->userprovince)) {
                                            echo "<td>" . province_name($users->userprovince)->provincename . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        if (isset($users->userdistrict)) {
                                            echo "<td>" . district_name($users->userdistrict)->district_name . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        if (isset($users->userbranch)) {
                                            echo "<td>" . branch_name($users->userbranch)->branch_name . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        if (isset($users->usercell)) {
                                            echo "<td>" . cell_name($users->usercell)->cell_name . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        echo "<td>" . date('d-M-Y', strtotime($users->userregistered)) . "</td>";
                                        echo "<td>" . date('d-M-Y', strtotime($users->last_updated)) . "</td>";
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole != 1 && $this->session->userdata('logged_in_info')->userrole != 2 && $this->session->userdata('logged_in_info')->id != $users->id) {
                                            echo '';
                                        } else {
                                            echo "<a href='" . base_url() . "user/profile/" . $users->id . "/" . $term . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                            // } else {
                                            //     echo "<a href='" . base_url() . "user/profile/" . $users->id . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                            // }
                                        }
                                        if ($this->session->userdata('logged_in_info')->userrole == 1 || $this->session->userdata('logged_in_info')->userrole == 2) {
                                            if ($users->userstatus == 1) {
                                                ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-deletelink="<?php echo base_url() . 'user/disable/' . $users->id . "/" . $term . "/" . $users->userrole; ?>"
                                                    data-deletetext="Are you sure to disable this user?"><i
                                                        class='fadeIn animated bx bxs-lock-open'></i></a>
                                                <?php
                                                // echo "|&nbsp;<a href='".base_url()."user/disable/".$users->id."/".$term."' class='confirm' onclick='return confirm('Are you sure to disable this user?');'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                            } else {
                                                ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-deletelink="<?php echo base_url() . 'user/enable/' . $users->id . "/" . $term . "/" . $users->userrole; ?>"
                                                    data-deletetext="Are you sure to enable this user?"><i
                                                        class='fadeIn animated bx bxs-lock'></i></a>
                                                <?php
                                                // echo "|&nbsp;<a href='".base_url()."user/enable/".$users->id."/".$term."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:void(0);" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright ©
                <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech"
                    target="_blank">AllCents App.</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('deletelink');
            var mytext = $(event.relatedTarget).data('deletetext');
            //alert(myVal);
            $("#confirmBtndel").attr("href", myValid);
            $("#deletetext").text(mytext);
        });
    </script>
</body>

</html>