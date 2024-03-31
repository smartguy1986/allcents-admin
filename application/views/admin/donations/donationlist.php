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
                // print_r($donations);
                // echo "</pre>";
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example22" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Branch</th>
                                        <th>Cell</th>
                                        <th>Treasurer</th>
                                        <th>Church</th>
                                        <th>Currency</th>
                                        <th>Donated By</th>
                                        <th>Amount</th>
                                        <th>Mode</th>
                                        <th>Transaction ID</th>
                                        <th>Reference ID</th>
                                        <th>Event</th>
                                        <th>Description</th>
                                        <th>Status URL</th>
                                        <th>Status</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($donations as $cat) {
                                        if ($cat->final_status == 0) {
                                            $catclass = 'bg-nonpaid';
                                        } else {
                                            $catclass = 'bg-paid';
                                        }
                                        $donatedbyuser = getusername($cat->donation_by);
                                        $trdetails = getusername($cat->treasurer);
                                        // print_r($trdetails);
                                        echo "<tr class='" . $catclass . "'>";
                                        echo "<td>" . $cat->id . "</td>";
                                        echo "<td>" . branch_name($cat->branch)->branch_name . "</td>";
                                        echo "<td>" . cell_name($cat->cell)->cell_name . "</td>";
                                        echo "<td>";
                                        if ($cat->treasurer > 0) {
                                            echo $trdetails->usertitle . ' ' . $trdetails->userfname . ' ' . $trdetails->userlname;
                                        } else {
                                            echo "N/A";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $cat->church_title . "</td>";
                                        echo "<td>" . $cat->currency . "</td>";
                                        $donatedBy = '';
                                        if (isset($donatedbyuser->usertitle) && ($donatedbyuser->usertitle != '' || $donatedbyuser->usertitle != null)) {
                                            $donatedBy .= $donatedbyuser->usertitle . ' ';
                                        }
                                        if (isset($donatedbyuser->userfname) && ($donatedbyuser->userfname != '' || $donatedbyuser->userfname != null)) {
                                            $donatedBy .= $donatedbyuser->userfname . ' ';
                                        }
                                        if (isset($donatedbyuser->userlname) && ($donatedbyuser->userlname != '' || $donatedbyuser->userlname != null)) {
                                            $donatedBy .= $donatedbyuser->usertitle . ' ';
                                        }
                                        echo "<td>" . $donatedBy . "</td>";

                                        echo "<td>" . $cat->donation_amount . "</td>";
                                        echo "<td>" . $cat->donation_mode . "</td>";
                                        echo "<td>" . $cat->transaction_id . "</td>";
                                        echo "<td>" . $cat->paynowreference . "</td>";
                                        echo "<td>";
                                        if ($cat->event_id > 0) {
                                            echo geteventname($cat->event_id)->title;
                                        } else {
                                            echo "N/A";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $cat->description . "</td>";
                                        echo "<td>";
                                        if ($cat->pollurl) {
                                            echo "<a href='" . $cat->pollurl . "' target='_blank'>Browse URL</a>";
                                        } else {
                                            echo "--";
                                        }
                                        echo "</td>";
                                        echo "<td>";
                                        if ($cat->final_status == 1) {
                                            echo "Paid";
                                        } else {
                                            echo '<button class="btn btn-primary registerbutt" href="javascript:void(0);" data-target="#registerdonationModal"
                                                data-transid="' . $cat->transaction_id . '"
                                                data-userid="' . $cat->donation_by . '"
                                                data-amount="' . $cat->donation_amount . '"
                                                data-username="' . getusername($cat->donation_by)->usertitle . ' ' . getusername($cat->donation_by)->userfname . ' ' . getusername($cat->donation_by)->userlname . '"
                                                data-transtext="Are you sure to register this donation as final?">Register Transaction</button>';
                                        }
                                        echo "</td>";
                                        echo "<td>" . date("j F, Y H:i A", strtotime($cat->added_on)) . "</td>";
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
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright ©
                <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AllCents App.</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $('#example22').dataTable({
            "order": [],
            // Your other options here...
        });
        $(document).ready(function() {
            $(document).on('click', '.registerbutt', function() {
                var transid = $(this).data('transid');
                var userid = $(this).data('userid');
                var amount = $(this).data('amount');
                var username = $(this).data('username');
                var transtext = $(this).data('transtext');

                $('#transid').val(transid);
                $('#userid').val(userid);
                $('#amount').val(amount);
                $('#username').val(username);
                $('#transtext').text(transtext);

                $('#registerdonationModal').modal('show');
            });
        });
    </script>
    <div class="modal" id="registerdonationModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register Donation on behalf of a Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="post" action="<?php echo base_url('donations/register'); ?>" onsubmit="return confirm('Are you sure you want to register this donation as final?');">
                        <input type="hidden" name="transid" id="transid">
                        <input type="hidden" name="donate_by" id="userid">
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">
                                Select User
                            </label>
                            <input type="text" class="form-control" id="username" name="username" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">
                                Enter Amount
                            </label>
                            <input type="text" class="form-control" id="amount" name="donation_amount" readonly>
                        </div>
                        <div class="col-12">
                            <?php $trs = get_recent_trasurer(); ?>
                            <label for="inputCity" class="form-label">
                                Select Treasurer
                            </label>
                            <select id="inputState" class="form-select" name="treasurer">
                                <option value="">Choose...</option>
                                <?php
                                foreach ($trs as $treasurer) {
                                    echo "<option value='" . $treasurer->id . "'>" . $treasurer->usertitle . ' ' . $treasurer->userfname . ' ' . $treasurer->userlname . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <input class="form-check-input" type="checkbox" id="check1" name="agreecheck" value="Y" required> I am declaring that I have submitted the amount to chuch account and
                            registering this donation on behalf of the above user.
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary px-5" value="Register Donation" name="regdonation">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>