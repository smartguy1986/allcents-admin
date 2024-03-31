<!doctype html>
<html lang="en">
<?php $this->view('admin/inc/head'); ?>

<body>
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php $this->view('admin/inc/sidebar'); ?>
        <!--end sidebar wrapper -->
        <?php $this->view('admin/inc/header'); ?>
        <style>
            .tox-notifications-container {
                display: none !important;
            }
        </style>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bx-book me-1 font-22 text-primary"></i></div>
                            <h5 class="mb-0 text-primary">Add New Notice</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($categories);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('notices/save'); ?>"
                            enctype="multipart/form-data" onsubmit="return formValidateTopic();">
                            <div class="col-md-12">
                                <label for="inputState" class="form-label">Select Category</label>
                                <select id="inputState" class="form-select text-dr-topic" name="category"
                                    data-error2="Please Select Category">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($categories as $cats) {
                                        echo "<option value='" . $cats->id . "'>" . $cats->cat_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Title</label>
                                <input type="text" class="form-control text-val-topic" id="topictitle" name="title"
                                    data-error="Please Enter English Title">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Content</label>
                                <textarea class="form-control text-ar-topic topictextarea" id="topictextarea"
                                    name="topiccontent" data-error2="Please Enter Content"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Excerpt</label>
                                <textarea class="form-control text-ar-topic" id=""
                                    name="notice_excerpt" data-error2="Please Enter excerpt"></textarea>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="Save Topic">
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
</body>

</html>