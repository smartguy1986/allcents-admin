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
                // print_r($admin_details);
                // echo "</pre>";
                ?>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body">
                        <form method="post" action="<?php echo base_url(); ?>DashboardController/updateadmin"
                            enctype="multipart/form-data"
                            onsubmit="return confirm('Are sure to submit and update details?');">
                            <input type="hidden" name="admin_id" value="<?php echo $admin_details->id; ?>">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">About</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="admin_oldimage"
                                        value="<?php echo $admin_details->admin_image; ?>">
                                    <img src="<?php echo base_url() . 'uploads/admin/' . $admin_details->admin_image; ?>"
                                        class="img-fluid" alt="">
                                    <hr>
                                    <label for="inputState" class="form-label">Change Image (* Resolution must be
                                        maximum 500 px x 500 px and a square shape) </label>
                                    <input type="file" name="admin_image" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label for="inputState" class="form-label">Page Title</label>
                                    <h4 class="card-title">
                                        <input type="text" name="admin_name"
                                            value="<?php echo $admin_details->admin_name; ?>" class="form-control">
                                    </h4>
                                    <label for="inputState" class="form-label">Change Content EN</label>
                                    <textarea class="form-control topictextarea" id="topictextarea"
                                        name="admin_bio_en"><?php echo $admin_details->admin_bio_en; ?></textarea>
                                </div>
                                <div class="row">
                                    <p></p>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary px-5 align-right ml-auto text-center"
                                            value="Update Admin Details">
                                    </div>
                                </div>
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
                    target="_blank">AAC - African Apostolic Church</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
</body>

</html>