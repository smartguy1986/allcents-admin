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
                            <h5 class="mb-0 text-primary">Add New Event</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($categories);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('events/save'); ?>"
                            enctype="multipart/form-data" onsubmit="return formValidateTopic();">
                            <div class="col-md-6">
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
                            <div class="col-md-3">
                                <label for="inputFirstName" class="form-label">Start Date</label>
                                <input type="date" class="form-control text-val-topic" id=""
                                    name="start_date" data-error="Please Enter Start Date">
                                <label></label>
                            </div>
                            <div class="col-md-3">
                                <label for="inputFirstName" class="form-label">End Date</label>
                                <input type="date" class="form-control text-val-topic" id=""
                                    name="end_date" data-error="Please Enter End Date">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Title</label>
                                <input type="text" class="form-control text-val-topic" id="topictitle" name="title"
                                    data-error="Please Enter Title">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Content</label>
                                <textarea class="form-control text-ar-topic topictextarea" id="topictextarea"
                                    name="topiccontent" data-error2="Please Enter Content"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Excerpt (Brief Intro)</label>
                                <textarea class="form-control text-ar-topic" id=""
                                    name="topic_excerpt" data-error2="Please Enter excerpt"></textarea>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Event Address</label>
                                <textarea class="form-control text-ar-topic" id="inputAddress" rows="3"
                                    name="event_address" data-error2="Please enter address"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Country
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="event_country"
                                    data-error2="Please Select Country" onchange="return fetchMyProvince(this.value)">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($country_info as $country) {
                                        echo "<option value='" . $country->id . "'>" . $country->country_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Province
                                </label>
                                <select id="inputuserprovince" class="form-select text-dr-user" name="event_province"
                                    data-error2="Please Select province" onchange="return fetchMyDistrict(this.value)">
                                    <option value="">Choose...</option>
                                    <span id="show_province"></span>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select District
                                </label>
                                <select id="inputuserdistricts" class="form-select text-dr-user" name="event_district"
                                    data-error2="Please Select district">
                                    <option value="">Choose...</option>
                                    <span id="show_district"></span>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Branch
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="event_branch"
                                    data-error2="Please Select Branch">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($branch_info as $branch) {
                                        echo "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Cell
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="event_cell"
                                    data-error2="Please Select Cell">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($cell_info as $cell) {
                                        echo "<option value='" . $cell->id . "'>" . $cell->cell_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <label></lable>
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