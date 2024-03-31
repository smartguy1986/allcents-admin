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
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">User Profile</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="<?php if ($userdata->userrole == 1) {
                                    echo base_url('users/filter/admin');
                                } else if ($userdata->userrole == 2) {
                                    echo base_url('users/filter/treasurer');
                                } else {
                                    echo base_url('users/filter/user');
                                } ?>"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo $userdata->userfname; ?>'s Profile
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <?php
                    // echo "<pre>";
                    // print_r($userdata);
                    // echo "</pre>";
                    ?>
                    <!-- <div class="ms-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Settings</button>
                            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                                <a class="dropdown-item" href="javascript:;">Another action</a>
                                <a class="dropdown-item" href="javascript:;">Something else here</a>
                                <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!--end breadcrumb-->
                <div class="container">
                    <div class="main-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <?php
                                if (!empty($this->session->flashdata('error'))) {
                                    $alertdata['error'] = $this->session->flashdata('error');
                                    $this->view('admin/inc/erroralert', $alertdata);
                                }
                                if (!empty($this->session->flashdata('success'))) {
                                    $alertdata['success'] = $this->session->flashdata('success');
                                    $this->view('admin/inc/successalert', $alertdata);
                                }
                                if (!empty($this->session->flashdata('update'))) {
                                    $alertdata['success'] = $this->session->flashdata('update');
                                    $this->view('admin/inc/successalert', $alertdata);
                                }
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <?php
                                            if ($userdata->usergender == 'M') {
                                                echo "<img class='rounded-circle p-1 bg-primary' alt='user avatar' src='" . base_url() . "uploads/avatar/male-avatar-new2.jpg' width='110'>";
                                            } else if ($userdata->usergender == 'F') {
                                                echo "<img class='rounded-circle p-1 bg-primary' alt='user avatar' src='" . base_url() . "uploads/avatar/female-avatar-new2.jpg' width='110'>";
                                            } else {
                                                echo "<img class='rounded-circle p-1 bg-primary' alt='user avatar' src='" . base_url() . "uploads/avatar/avatar.jpg' width='110'>";
                                            }
                                            ?>
                                            <div class="mt-3">
                                                <h4>
                                                    <?php echo $userdata->usertitle . ' ' . $userdata->userfname . ' ' . $userdata->userlname; ?>
                                                </h4>
                                            </div>
                                        </div>
                                        <hr class="my-4" />
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Role</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->userrole == 1) {
                                                        echo "Admin";
                                                    } else if ($userdata->userrole == 2) {
                                                        echo "Treasurer";
                                                    } else {
                                                        echo "User";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Church Title</h6>
                                                <span class="text-secondary">
                                                    <?php echo $userdata->userchurchtitle; ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Title</h6>
                                                <span class="text-secondary">
                                                    <?php echo $userdata->usertitle; ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Email</h6>
                                                <span class="text-secondary">
                                                    <?php echo $userdata->usermail; ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Phone</h6>
                                                <span class="text-secondary">
                                                    <?php echo $userdata->userphone; ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Gender</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->usergender == 'M') {
                                                        echo "Male";
                                                    }
                                                    if ($userdata->usergender == 'F') {
                                                        echo "Female";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Address</h6>
                                                <span class="text-secondary">
                                                    <?php echo $userdata->useraddress; ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Country</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->usercountry) {
                                                        echo country_name($userdata->usercountry)->country_name;
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Province</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->userprovince) {
                                                        echo province_name($userdata->userprovince)->provincename;
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">District</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->userdistrict) {
                                                        echo district_name($userdata->userdistrict)->district_name;
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Branch</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->userbranch) {
                                                        echo branch_name($userdata->userbranch)->branch_name;
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Cell</h6>
                                                <span class="text-secondary">
                                                    <?php if ($userdata->usercell) {
                                                        echo cell_name($userdata->usercell)->cell_name;
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <h6 class="mb-0">Member Since</h6>
                                                <span class="text-secondary">
                                                    <?php echo date('d-M-Y', strtotime($userdata->userregistered)); ?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="userUpdateForm" class="row g-3" method="post"
                                            action="<?php echo base_url('users/update'); ?>"
                                            enctype="multipart/form-data" onsubmit="return formValidateusers(0);">
                                            <input type="hidden" name="term" value="<?php if ($userdata->userrole == 1) {
                                                echo "Admin";
                                            } else if ($userdata->userrole == 2) {
                                                echo "Treasurer";
                                            } else {
                                                echo "User";
                                            } ?>">
                                            <input type="hidden" name="mode" value="
                                            <?php if ($userdata->userrole == 1) {
                                                echo "1";
                                            } else {
                                                echo "0";
                                            } ?>">
                                            <input type="hidden" name="userid" value="<?php echo $userdata->id; ?>">
                                            <div class="col-md-6">
                                                <label for="inputState" class="form-label">
                                                    User Role
                                                </label>
                                                <select id="inputState" class="form-select text-dru" name="userrole"
                                                    data-error2="Please Select User Role" disabled>
                                                    <option value="">Choose...</option>
                                                    <option value="1" <?php if ($userdata->userrole == 1) {
                                                        echo "selected";
                                                    } ?>>Admin</option>
                                                    <option value="2" <?php if ($userdata->userrole == 2) {
                                                        echo "selected";
                                                    } ?>>Treasurer</option>
                                                    <option value="3" <?php if ($userdata->userrole == 3) {
                                                        echo "selected";
                                                    } ?>>User</option>
                                                </select>
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputFirstName" class="form-label">Church Title</label>
                                                <input type="text" class="form-control text-ru" id="inputFirstName"
                                                    name="userchurchtitle" data-error="Please Enter Church Title"
                                                    value="<?php echo $userdata->userchurchtitle; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputFirstName" class="form-label">Title</label>
                                                <input type="text" class="form-control text-ru" id="inputFirstName"
                                                    name="usertitle" data-error="Please Enter Title"
                                                    value="<?php echo $userdata->usertitle; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputFirstName" class="form-label">Name</label>
                                                <input type="text" class="form-control text-ru" id="inputFirstName"
                                                    name="userfname" data-error="Please Enter First name"
                                                    value="<?php echo $userdata->userfname; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputFirstName" class="form-label">Surname</label>
                                                <input type="text" class="form-control text-ru" id="inputFirstName"
                                                    name="userlname" data-error="Please Enter Surname"
                                                    value="<?php echo $userdata->userlname; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputPassword" class="form-label">
                                                    Password
                                                </label>
                                                <input type="password" class="form-control" id="inputPassword"
                                                    name="userpassword" data-error="Please Enter Password">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEmail" class="form-label">Email ID</label>
                                                <input type="email" class="form-control text-emu" id="inputEmail"
                                                    name="usermail" data-error2="Please Enter valid Email"
                                                    value="<?php echo $userdata->usermail; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEmail" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control text-ru" id="inputEmail"
                                                    name="userphone" data-error="Please Enter Phone Number"
                                                    value="<?php echo $userdata->userphone; ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-6">
                                                <label for="inputAddress" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="inputEmail"
                                                    name="userdob" data-error="Please Enter Date of Birth"
                                                    value="<?php echo substr($userdata->userdob, 0, 10); ?>">
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputState" class="form-label">Gender</label>
                                                <select id="inputState" class="form-select text-dru" name="usergender"
                                                    data-error2="Please Select Gender">
                                                    <option value="">Choose...</option>
                                                    <option value="M" <?php if ($userdata->usergender == 'M') {
                                                        echo "selected";
                                                    } ?>>Male</option>
                                                    <option value="F" <?php if ($userdata->usergender == 'F') {
                                                        echo "selected";
                                                    } ?>>Female</option>
                                                    <option value="O" <?php if ($userdata->usergender == 'O') {
                                                        echo "selected";
                                                    } ?>>Other</option>
                                                </select>
                                                <label></label>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputAddress" class="form-label">Address</label>
                                                <textarea class="form-control text-ar-user" id="inputAddress" rows="3"
                                                    name="useraddress"
                                                    data-error2="Please enter address"><?php echo $userdata->useraddress; ?></textarea>
                                                <label></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputCity" class="form-label">
                                                    Select Country
                                                </label>
                                                <?php $countries = country_list(); ?>
                                                <select id="inputState" class="form-select text-dru" name="usercountry"
                                                    data-error2="Please Select Country"
                                                    onchange="return fetchMyProvince(this.value)">
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        if ($country->id == $userdata->usercountry) {
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
                                                <select id="inputuserprovince" class="form-select text-dru"
                                                    name="userprovince" data-error2="Please Select province"
                                                    onchange="return fetchMyDistrict(this.value)">
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    foreach ($provinces as $province) {
                                                        if ($province->provinceid == $userdata->userprovince) {
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
                                                <select id="inputuserdistricts" class="form-select text-dru"
                                                    name="userdistrict" data-error2="Please Select district">
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    foreach ($districts as $district) {
                                                        if ($district->id == $userdata->userdistrict) {
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
                                                <select id="inputState" class="form-select text-dru" name="userbranch"
                                                    data-error2="Please Select Branch">
                                                    <?php
                                                    foreach ($branches as $branch) {
                                                        if ($branch->id == $userdata->userbranch) {
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
                                                <select id="inputState" class="form-select text-dru" name="usercell"
                                                    data-error2="Please Select Cell">
                                                    <option value="">Choose...</option>
                                                    <?php
                                                    foreach ($cells as $cell) {
                                                        if ($cell->id == $userdata->usercell) {
                                                            echo "<option value='" . $cell->id . "' selected>" . $cell->cell_name . "</option>";
                                                        } else {
                                                            echo "<option value='" . $cell->id . "'>" . $cell->cell_name . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label></lable>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputState" class="form-label">
                                                    Select User Status
                                                </label>
                                                <select id="inputState" class="form-select text-dru" name="userstatus"
                                                    data-error2="Please Select User Status">
                                                    <option value="">Choose...</option>
                                                    <option value="1" <?php if ($userdata->userstatus == 1) {
                                                        echo "selected";
                                                    } ?>>Active</option>
                                                    <option value="0" <?php if ($userdata->userstatus == 0) {
                                                        echo "selected";
                                                    } ?>>Inactive</option>
                                                </select>
                                                <label></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="submit" id="formUpdate" class="btn btn-primary px-5"
                                                    name="update" value="Update">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</body>

</html>
<script>
    function formValidateusers(x) {
        //alert('submitted');

        $('.field-error').remove();
        var value = '';
        var error_html = '';
        var error_text;
        var flag = '1';

        $(".text-ru").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error');
            console.log(value);
            if (value.trim() == '') {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        $(".text-dru").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error2');
            console.log(value);
            if (value.length < 1) {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        $(".text-emu").each(function () {
            value = $(this).val();
            //name = $(this).attr('name');
            //label_text = $(this).next('label').children('span').html();
            error_text = $(this).attr('data-error2');
            //console.log(value);
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            if (reg.test(value) == false) {
                flag = '0';
                //$(this).next('label').attr('style', 'border-color: #ff0000');
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
                //textarea.text-active + label{border-color: #f18a21;}
            }
        });

        $(".text-aru").each(function () {
            value = $(this).val();
            //name = $(this).attr('name');
            //label_text = $(this).next('label').children('span').html();
            error_text = $(this).attr('data-error2');
            //console.log(value);
            //var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            if (value.length < 1) {
                flag = '0';
                //$(this).next('label').attr('style', 'border-color: #ff0000');
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
                //textarea.text-active + label{border-color: #f18a21;}
            }
        });

        if (flag == '0') {
            return false;
        }
        else {
            var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
            if (r == true) {
                return true;
                // $('#deleteModal23').modal('show');
            }
            else {
                return false;
            }
        }
    }

    $('#confirmBtndel2').click(function () {
        console.log('submitting');
        $('#userUpdateForm').submit();
    });
</script>