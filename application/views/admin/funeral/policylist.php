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
                            <table id="example23" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Payout</th>
                                        <th>Members</th>
                                        <th>Benifits</th>
                                        <th>Waiting Period</th>
                                        <th>Claim Desc</th>
                                        <!-- <th>Description</th> -->
                                        <th>Icon</th>
                                        <th>Premium</th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($policies as $pol) {
                                        if ($pol->policy_status == 1) {
                                            $userclass = 'bg-paid';
                                        } else {
                                            $userclass = 'bg-nonpaid';
                                        }
                                        echo "<tr class='" . $userclass . "'>";
                                        echo "<td>" . $pol->id . "</td>";
                                        echo "<td>" . $pol->policy_title . "</td>";
                                        echo "<td>" . $pol->policy_payout . "</td>";
                                        echo "<td>" . $pol->policy_member . "</td>";
                                        echo "<td>" . $pol->policy_benifits . "</td>";
                                        echo "<td>" . $pol->policy_waiting . "</td>";
                                        echo "<td>" . $pol->policy_claim . "</td>";
                                        // echo "<td width='10%'>" . $pol->policy_description . "</td>";
                                        echo "<td><img src='" . base_url() . "uploads/policies/" . $pol->policy_logo . "' width='75'></td>";
                                        echo "<td>" . $pol->policy_premium . "</td>";
                                        if ($pol->policy_status == 1) {
                                            echo "<td>Active</td>";
                                        } else {
                                            echo "<td>Inactive</td>";
                                        }
                                        echo "<td>" . date('d-M-Y', strtotime($pol->added_on)) . "</td>";
                                        echo "<td>" . date('d-M-Y', strtotime($pol->updated_on)) . "</td>";
                                        echo "<td>";
                                        echo "<a href='" . base_url() . "policies/details/" . $pol->id . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1 || $this->session->userdata('logged_in_info')->userrole == 2) {
                                            if ($pol->policy_status == 1) {
                                    ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'policies/disable/' . $pol->id; ?>" data-deletetext="Are you sure to disable this policy?"><i class='fadeIn animated bx bxs-lock-open'></i></a>
                                            <?php
                                                // echo "|&nbsp;<a href='".base_url()."user/disable/".$pol->id."/".$term."' class='confirm' onclick='return confirm('Are you sure to disable this user?');'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                            } else {
                                            ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'policies/enable/' . $pol->id; ?>" data-deletetext="Are you sure to enable this policy?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                    <?php
                                                // echo "|&nbsp;<a href='".base_url()."user/enable/".$pol->id."/".$term."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
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
        <!--Start Back To Top Button--> <a href="javaScript:void(0);" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright ©
                <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AllCents App.</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('deletelink');
            var mytext = $(event.relatedTarget).data('deletetext');
            //alert(myVal);
            $("#confirmBtndel").attr("href", myValid);
            $("#deletetext").text(mytext);
        });

        $('#example23').dataTable({
            "autoWidth": true
        });
    </script>
</body>

</html>