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
        <div class="page-wrapper" style="position: inherit !important;">
            <div class="page-content">
                <?php
                // echo "<pre>";
                // print_r($calendar_details);
                // echo "</pre>";
                ?>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body">
                        <form method="post" action="<?php echo base_url(); ?>/updatecalendarimage"
                            enctype="multipart/form-data"
                            onsubmit="return confirm('Are sure to submit and update details?');">
                            <?php
                            if (isset($calendar_details)) {
                                ?><input type="hidden" name="calendar_id" value="<?php echo $calendar_details->id; ?>"><?php
                            }
                            ?>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                    if (isset($calendar_details)) {
                                        ?><input type="hidden" name="calendar_oldimage"
                                            value="<?php echo $calendar_details->calendar_image; ?>">
                                        <img src="<?php echo base_url() . 'uploads/admin/' . $calendar_details->calendar_image; ?>"
                                            class="img-fluid" alt="" width="100px">
                                        <?php
                                    }
                                    ?>
                                    <!-- <label for="inputState" class="form-label">Change Image (* Resolution must be
                                        maximum 500 px x 500 px and a square shape) </label> -->

                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="calendar_image" class="form-control">
                                    <p></p>
                                    <input type="submit" class="btn btn-primary px-5 align-right"
                                        value="Update Calendar Event Image">
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