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
                            <h5 class="mb-0 text-primary">User Registration</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($city_info);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('users/add');?>" onsubmit="return formValidate(4);"  enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">User Role</label>
                                <select id="inputState" class="form-select text-dr" name="userrole" data-error2="Please Select User Role">
                                    <option value="">Choose...</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Admin Staff</option>
                                    <option value="3">User</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Profile Image</label>
                                <input type="file" class="form-control text-r" id="inputFirstName" name="userimage" data-error="Please Upload Image">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control text-r" id="inputFirstName" name="userfname" data-error="Please Enter First name">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Last Name</label>
                                <input type="text" class="form-control text-r" id="inputFirstName" name="userlname" data-error="Please Enter Last name">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" class="form-control text-r" id="inputPassword" name="userpassword" data-error="Please Enter Password">
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control text-em" id="inputEmail" name="usermail" data-error2="Please Enter valid Email">
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
                                <label for="inputEmail" class="form-label">Phone No</label>
                                <input type="text" class="form-control text-r" id="inputEmail" name="userphone" data-error="Please Enter Phone Number">
                                <label></label>
                            </div>
                            <div class="col-md-6">
<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">Sentebale Health App.</a></p>
                                <label for="inputState" class="form-label">Gender</label>
                                <select id="inputState" class="form-select text-dr" name="usergender" data-error2="Please Select Gender">
                                    <option value="">Choose...</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control text-r" id="inputEmail" name="userdob" data-error="Please Enter Date of Birth">
                                <label></label>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Address</label>
                                <textarea class="form-control text-ar" id="inputAddress" rows="3" name="useraddress" data-error2="Please enter address"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">Location</label>
                                <select id="inputState" class="form-select text-dr" name="usercity" data-error2="Please Select Location">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach($city_info as $city)
                                    {
                                        echo "<optgroup label='".$city['province']."'>";
                                        foreach($city['city_list'] as $cities)
                                        {
                                            echo "<option value='".$cities->RegionID."'>".$cities->RegionName."</option>";
                                        }
                                        echo "</optgroup>";
                                    }
                                    ?>
                                </select>
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputZip" class="form-label">Zip</label>
                                <input type="text" class="form-control text-r" id="inputZip" name="userzip" data-error="Please Enter Zip Code">
                                <label></lable>
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">User Status</label>
                                <select id="inputState" class="form-select text-dr" name="userstatus" data-error2="Please Select User Status">
                                    <option value="">Choose...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="Register">
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
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>
    <?php $this->view('admin/inc/foot'); ?>
    </body>
</html>