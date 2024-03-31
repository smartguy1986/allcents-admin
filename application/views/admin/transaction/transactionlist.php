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
                // print_r($transactions);
                // echo "</pre>";
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example22" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Policy</th>
                                        <th>Purchased By</th>
                                        <th>Treasurer</th>
                                        <th>Amount Paid</th>
                                        <th>Payment Frequency</th>
                                        <th>Next Payment</th>
                                        <th>Mode</th>
                                        <th>Reference No.</th>
                                        <th>Purchase For</th>
                                        <th>Transaction ID</th>
                                        <th>Status</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($transactions as $cat) {
                                        if ($cat->final_status == 0) {
                                            $catclass = 'bg-nonpaid';
                                        } else {
                                            $catclass = 'bg-paid';
                                        }
                                        $donatedbyuser = getusername($cat->user_id);
                                        $trdetails = getusername($cat->treasurer);
                                        $policy_info = policy_info($cat->policy_id);
                                        // print_r($trdetails);
                                        echo "<tr class='" . $catclass . "'>";
                                        echo "<td>" . $cat->id . "</td>";
                                        echo "<td>" . $policy_info->policy_title . " (" . $policy_info->policy_id . ")" . "</td>";
                                        echo "<td>" . $donatedbyuser->usertitle . ' ' . $donatedbyuser->userfname . ' ' . $donatedbyuser->userlname . "</td>";
                                        echo "<td>";
                                        if ($cat->treasurer > 0) {
                                            echo $trdetails->usertitle . ' ' . $trdetails->userfname . ' ' . $trdetails->userlname;
                                        } else {
                                            echo "N/A";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $cat->gross_amount . "</td>";
                                        echo "<td>" . $cat->payment_frequency . " Months</td>";
                                        echo "<td>" . date("j F, Y", strtotime($cat->next_date)) . "</td>";
                                        echo "<td>" . $cat->payment_mode . "</td>";
                                        echo "<td>" . $cat->reference_num . "</td>";
                                        echo "<td>" . $cat->purchase_for . "</td>";
                                        echo "<td>" . $cat->transaction_id . "</td>";
                                        echo "<td>";
                                        if ($cat->final_status == 1) {
                                            echo "Paid";
                                        } else {
                                            echo '<button class="btn btn-primary registerbuttn" href="javascript:void(0);"
                                                data-transid="' . $cat->transaction_id . '"
                                                data-userid="' . $cat->user_id . '"
                                                data-purchaseid="' . $cat->purchase_id . '"
                                                data-amount="' . $cat->gross_amount . '"
                                                data-username="' . getusername($cat->user_id)->usertitle . ' ' . getusername($cat->user_id)->userfname . ' ' . getusername($cat->user_id)->userlname . '"
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
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
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
        $('#example22').dataTable({
            "order": [],
            // Your other options here...
        });
        $(document).ready(function () {
            $('.registerbuttn').on('click', function () {
                $('#transid').val($(this).data('transid'));
                $('#userid').val($(this).data('userid'));
                $('#purchaseid').val($(this).data('purchaseid'));
                $('#transaction_amount').val($(this).data('amount'));
                $('#username').val($(this).data('username'));
                $('#registertransactionModal').modal('show');
            });
        });
    </script>
    <div class="modal" id="registertransactionModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register Policy Transaction on behalf of a Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="post" action="<?php echo base_url('transaction/register'); ?>"
                        onsubmit="return confirm('Are you sure to register this Transaction as final?');">
                        <input type="hidden" name="transid" id="transid">
                        <input type="hidden" name="donate_by" id="userid">
                        <input type="hidden" name="purchase_id" id="purchaseid">
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
                            <input type="text" class="form-control" id="transaction_amount" name="transaction_amount"
                                readonly>
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
                            <input class="form-check-input" type="checkbox" id="check1" name="agreecheck" value="Y"
                                required> I am declaring that I have submitted the amount to chuch account and
                            registering this donation on behalf of the above user.
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary px-5" value="Register Transaction"
                                name="regtransaction">
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