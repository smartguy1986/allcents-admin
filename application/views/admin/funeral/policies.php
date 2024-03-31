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
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">
                                Update Policy
                            </h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($policy_data);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('policies/update'); ?>"
                            onsubmit="return formValidateUser(4);" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $policy_data->id; ?>">
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Policy Title</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="policy_title" data-error="Please Enter Policy Title"
                                    value="<?php echo $policy_data->policy_title; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Policy Payout</label>
                                <input type="number" class="form-control text-val-user" id="inputFirstName"
                                    name="policy_payout" data-error="Please Enter Payout amount" step="0.1"
                                    value="<?php echo $policy_data->policy_payout; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Memeber</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="policy_member" data-error="Please Enter Memeber Description"
                                    value="<?php echo $policy_data->policy_member; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Benifits</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="policy_benifits" data-error="Please Enter Benifits"
                                    value="<?php echo $policy_data->policy_benifits; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Waiting Period (months)</label>
                                <input type="number" class="form-control text-val-user" id="inputEmail"
                                    name="policy_waiting" data-error2="Please Enter waiting time" step="0.1"
                                    value="<?php echo $policy_data->policy_waiting; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Claim</label>
                                <input type="text" class="form-control text-val-user" id="inputEmail"
                                    name="policy_claim" data-error="Please Enter Claim Description"
                                    value="<?php echo $policy_data->policy_claim; ?>">
                                <label></label>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Description</label>
                                <textarea class="form-control text-ar-user topictextarea" id="topictextarea"
                                    name="policy_description"
                                    data-error2="Please enter Policy Description"><?php echo $policy_data->policy_description; ?></textarea>
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Current Icon : </label>
                                <img src="<?php echo base_url(); ?>uploads/policies/<?php echo $policy_data->policy_logo; ?>"
                                    width="100" />
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Current Files : </label>
                                <div class="row">
                                    <?php
                                    $pfiles = get_policy_files($policy_data->id);
                                    foreach ($pfiles as $polfile) {
                                        ?>
                                        <div class="col-3">
                                            <div class="card" style="width: 10rem;">
                                                <a
                                                    href="<?php echo base_url(); ?>uploads/policies/<?php echo $polfile->file_name; ?>" target="_blank"><img
                                                        class="card-img-top"
                                                        src="<?php echo base_url(); ?>uploads/defaults/filelogo.png"
                                                        alt="<?php echo $polfile->file_name; ?>" width="35"></a>
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        <?php echo $polfile->file_name; ?>
                                                    </div>
                                                    <!-- <p class="card-text">Some quick example text to build on the card title and make
                                                up the bulk of the card's content.</p> -->
                                                    <a href="<?php echo base_url() . 'policies/filedelete/' . $polfile->id . '/' . $policy_data->id; ?>"
                                                        class="btn btn-warning">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        //echo "<a href='" . base_url() . "uploads/policies/" . $polfile->file_name . "' target='_blank'><img src='" . base_url() . "uploads/defaults/filelogo.png' width='50'></a>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Policy Icon</label>
                                <input type="file" class="form-control" id="inputEmail" name="policy_logo"
                                    data-error="Please Select Policy Icon">
                                <label></label>
                            </div>
                            <input type="hidden" name="policy_logo_old"
                                value="<?php echo $policy_data->policy_logo; ?>">
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Policy Files</label>
                                <input type="file" class="form-control" id="inputEmail" name="policy_files[]"
                                    data-error="Please Select Policy Files" multiple>
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Premium Amount</label>
                                <input type="number" class="form-control text-val-user" id="inputEmail"
                                    name="policy_premium" data-error="Please Enter Premium Amount" step="0.1"
                                    value="<?php echo $policy_data->policy_premium; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">
                                    Select Policy Status
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="policy_status"
                                    data-error2="Please Select Policy Status">
                                    <option value="">Choose...</option>
                                    <option value="1" <?php if ($policy_data->policy_status == '1')
                                        echo "selected"; ?>>
                                        Active</option>
                                    <option value="0" <?php if ($policy_data->policy_status == '0')
                                        echo "selected"; ?>>
                                        Inactive</option>
                                </select>
                                <label></label>
                            </div>

                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="Update Policy">
                            </div>
                        </form>
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

    </script>
</body>

</html>