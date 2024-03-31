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
                                Create User
                            </h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($city_info);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('users/add'); ?>"
                            onsubmit="return formValidateUser(4);" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">
                                    User Role
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="userrole"
                                    data-error2="Please Select User Role">
                                    <option value="">Choose...</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Treasurer</option>
                                    <option value="3">User</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Church Title</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="userchurchtitle" data-error="Please Enter Church Title">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Title</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="usertitle" data-error="Please Enter Title">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Name</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="userfname" data-error="Please Enter First name">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Surname</label>
                                <input type="text" class="form-control text-val-user" id="inputFirstName"
                                    name="userlname" data-error="Please Enter Surname">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">
                                    Password
                                </label>
                                <input type="password" class="form-control text-val-user" id="inputPassword"
                                    name="userpassword" data-error="Please Enter Password">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Email ID</label>
                                <input type="email" class="form-control text-em-user" id="inputEmail" name="usermail"
                                    data-error2="Please Enter valid Email">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Phone Number</label>
                                <input type="text" class="form-control text-val-user" id="inputEmail" name="userphone"
                                    data-error="Please Enter Phone Number">
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control text-val-user" id="inputEmail" name="userdob"
                                    data-error="Please Enter Date of Birth">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">Gender</label>
                                <select id="inputState" class="form-select text-dr-user" name="usergender"
                                    data-error2="Please Select Gender">
                                    <option value="">Choose...</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Address</label>
                                <textarea class="form-control text-ar-user" id="inputAddress" rows="3"
                                    name="useraddress" data-error2="Please enter address"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">
                                    Select Country
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="usercountry"
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
                                <select id="inputuserprovince" class="form-select text-dr-user" name="userprovince"
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
                                <select id="inputuserdistricts" class="form-select text-dr-user" name="userdistrict"
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
                                <select id="inputState" class="form-select text-dr-user" name="userbranch"
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
                                <select id="inputState" class="form-select text-dr-user" name="usercell"
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
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">
                                    Select User Status
                                </label>
                                <select id="inputState" class="form-select text-dr-user" name="userstatus"
                                    data-error2="Please Select User Status">
                                    <option value="">Choose...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="Create">
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