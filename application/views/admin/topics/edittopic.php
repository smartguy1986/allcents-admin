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
                            <h5 class="mb-0 text-primary">Edit Event</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($topics);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('events/update'); ?>"
                            enctype="multipart/form-data" onsubmit="return formValidateUpdateTopic();">
                            <input type="hidden" name="articleid" value="<?php echo $topics->id; ?>">
                            <input type="hidden" name="oldslug" value="<?php echo $topics->slug; ?>">
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">Select Category</label>
                                <select id="inputState" class="form-select text-dr-topic" name="category"
                                    data-error2="Please Select Category">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($categories as $cats) {
                                        if ($topics->category == $cats->id) {
                                            echo "<option value='" . $cats->id . "' selected>" . $cats->cat_name . "</option>";
                                        } else {
                                            echo "<option value='" . $cats->id . "'>" . $cats->cat_name . "</option>";
                                        }

                                    }
                                    ?>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-md-3">
                                <label for="inputFirstName" class="form-label">Start Date</label>
                                <input type="date" class="form-control text-val-topic" id="" name="start_date"
                                    data-error="Please Enter Start Date" value="<?php echo $topics->start_date; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-3">
                                <label for="inputFirstName" class="form-label">End Date</label>
                                <input type="date" class="form-control text-val-topic" id="" name="end_date"
                                    data-error="Please Enter End Date" value="<?php echo $topics->end_date; ?>">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Title</label>
                                <input type="text" class="form-control text-r" id="topictitle" name="title"
                                    data-error="Please Enter Title" value="<?php echo $topics->title; ?>" required>
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">English Content</label>
                                <textarea type="text" class="form-control text-ar-topic topictextarea"
                                    id="topictextarea_en" name="topic_content"
                                    data-error="Please Enter Content"><?php echo $topics->topic_content; ?></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Excerpt</label>
                                <textarea type="text" class="form-control text-ar-topic"
                                    id="topic_excerpt" name="topic_excerpt"
                                    data-error="Please Enter excerpt"><?php echo $topics->topic_excerpt; ?></textarea>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Event Address</label>
                                <textarea class="form-control text-ar-topic" id="inputAddress" rows="3"
                                    name="event_address" data-error2="Please enter address"><?php echo $topics->event_address;?></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Country
                                </label>
                                <?php $countries = country_list(); ?>
                                <select id="inputState" class="form-select text-dru" name="event_country"
                                    data-error2="Please Select Country" onchange="return fetchMyProvince(this.value)">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($countries as $country) {
                                        if ($country->id == $topics->event_country) {
                                            echo "<option value='" . $country->id . "' selected>" . $country->country_name . "</option>";
                                        } else {
                                            echo "<option value='" . $country->id . "'>" . $country->country_name . "</option>";
                                        }

                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Province
                                </label>
                                <?php $provinces = province_list(); ?>
                                <select id="inputuserprovince" class="form-select text-dru" name="event_province"
                                    data-error2="Please Select province" onchange="return fetchMyDistrict(this.value)">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($provinces as $province) {
                                        if ($province->provinceid == $topics->event_province) {
                                            echo "<option value='" . $province->provinceid . "' selected>" . $province->provincename . "</option>";
                                        } else {
                                            echo "<option value='" . $province->provinceid . "'>" . $province->provincename . "</option>";
                                        }

                                    }
                                    ?>
                                    <span id="show_province"></span>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select District
                                </label>
                                <?php $districts = district_list(); ?>
                                <select id="inputuserdistricts" class="form-select text-dru" name="event_district"
                                    data-error2="Please Select district">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($districts as $district) {
                                        if ($district->id == $topics->event_district) {
                                            echo "<option value='" . $district->id . "' selected>" . $district->district_name . "</option>";
                                        } else {
                                            echo "<option value='" . $district->id . "'>" . $district->district_name . "</option>";
                                        }

                                    }
                                    ?>
                                    <span id="show_district"></span>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Branch
                                </label>
                                <?php $branches = branch_list(); ?>
                                <select id="inputState" class="form-select text-dru" name="event_branch"
                                    data-error2="Please Select Branch">
                                    <?php
                                    foreach ($branches as $branch) {
                                        if ($branch->id == $topics->event_branch) {
                                            echo "<option value='" . $branch->id . "' selected>" . $branch->branch_name . "</option>";
                                        } else {
                                            echo "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
                                        }

                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Cell
                                </label>
                                <?php $cells = cell_list(); ?>
                                <select id="inputState" class="form-select text-dru" name="event_cell"
                                    data-error2="Please Select Cell">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach ($cells as $cell) {
                                        if ($cell->id == $topics->event_cell) {
                                            echo "<option value='" . $cell->id . "' selected>" . $cell->cell_name . "</option>";
                                        } else {
                                            echo "<option value='" . $cell->id . "'>" . $cell->cell_name . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="Update Event">
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
                    target="_blank">AllCents
                    App.</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $(document).ready(function () {
            populatesubcat2(<?php echo $topics->category; ?>, <?php echo $topics->subcategory; ?>);
        });

        function populatesubcat(x) {
            // alert(x);
            $.ajax({
                type: "POST",
                url: base_url + 'topics/getsubcat',
                data: { cid: x },
                success: function (data) {
                    $('#showsubcat').html(data);
                },
                error: function (err) {
                    $('#showsubcat').html(err);
                }
            });
            return false;
        }

        function populatesubcat2(x, y) {
            // alert(x);
            $.ajax({
                type: "POST",
                url: base_url + 'topics/getsubcat2',
                data: { cid: x, scid: y },
                success: function (data) {
                    $('#showsubcat').html(data);
                },
                error: function (err) {
                    $('#showsubcat').html(err);
                }
            });
            return false;
        }
    </script>
</body>

</html>