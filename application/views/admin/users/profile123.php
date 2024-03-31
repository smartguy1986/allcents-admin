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

            <?php

            // echo "<pre>";

            // print_r($userdata);

            // echo "</pre>";

            ?>   

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">User Profile</div>

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="<?php echo base_url('users/filter/adminusers');?>"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page"><?php echo $userdata->userfname;?> Profile</li>

							</ol>

						</nav>

					</div>

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

                            if(!empty($this->session->flashdata('error')))

                            {

                                $alertdata['error'] = $this->session->flashdata('error');

                                $this->view('admin/inc/erroralert', $alertdata);

                            }

                            if(!empty($this->session->flashdata('success')))

                            {

                                $alertdata['success'] = $this->session->flashdata('success');

                                $this->view('admin/inc/successalert', $alertdata);

                            }

                            if(!empty($this->session->flashdata('update')))

                            {

                                $alertdata['success'] = $this->session->flashdata('update');

                                $this->view('admin/inc/successalert', $alertdata);

                            }

                            ?>

								<div class="card">

									<div class="card-body">

										<div class="d-flex flex-column align-items-center text-center">

                                            <?php

                                            if($userdata->userimage)

											{

                                            	echo "<a href='".base_url()."admin/user/profile/".$userdata->id."'><img class='rounded-circle p-1 bg-primary' src='".base_url()."uploads/user_profile/".$userdata->userimage."' width='110'></a>";

											}

											else

											{

												echo "<a href='".base_url()."admin/user/profile/".$userdata->id."'><img class='rounded-circle p-1 bg-primary' alt='user avatar' src='".base_url()."uploads/defaults/default_logo.jpg' width='110'></a>";

											}

                                            ?>

											<!-- <img src="<?php //echo base_url().'uploads/user_profile/'.$userdata->userimage;?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110"> -->

											<div class="mt-3">

												<h4><?php echo $userdata->userfname.' '.$userdata->userlname;?></h4>

												<!-- <p class="text-secondary mb-1">Full Stack Developer</p>

												<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> -->

												<!-- <button class="btn btn-primary">Disable</button> -->

												<!-- <button class="btn btn-outline-primary">Message</button> -->

											</div>

										</div>

										<hr class="my-4" />

										<ul class="list-group list-group-flush">

											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Role</h6>

												<span class="text-secondary"><?php if($userdata->userrole=='2'){ echo "Admin Staff";} if($userdata->userrole=='3'){ echo "Users";} ?></span>

											</li>

											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Email</h6>

												<span class="text-secondary"><?php echo $userdata->usermail; ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Phone</h6>

												<span class="text-secondary"><?php echo $userdata->userphone; ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Gender</h6>

												<span class="text-secondary"><?php if($userdata->usergender=='M'){ echo "Male";} if($userdata->usergender=='F'){ echo "Female";} ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Address</h6>

												<span class="text-secondary"><?php echo $userdata->useraddress; ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">City</h6>

												<span class="text-secondary"><?php echo city_name($userdata->usercity)->RegionName; ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Zip</h6>

												<span class="text-secondary"><?php echo $userdata->userzip; ?></span>

											</li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

												<h6 class="mb-0">Member Since</h6>

												<span class="text-secondary"><?php echo date('d-M-Y', strtotime($userdata->userregistered)); ?></span>

											</li>

										</ul>

									</div>

								</div>

							</div>

							<div class="col-lg-8">

								<div class="card">

									<div class="card-body">

                                        <form class="row g-3" method="post" action="<?php echo base_url('users/update');?>" enctype="multipart/form-data" onsubmit="return formValidate(0);">

                                            <div class="col-md-6">

                                                <label for="inputFirstName" class="form-label">User Role</label>

                                                <input type="hidden" name="mode" value='1'>

                                                <input type="hidden" name="userid" value="<?php echo $userdata->id;?>">

                                                <input type="text" class="form-control" id="inputFirstName" value="<?php if($userdata->userrole=='1'){ echo "Admin";}

                                                if($userdata->userrole=='2'){ echo 'Admin Staff';}

                                                if($userdata->userrole=='3'){ echo 'Users';}?>" readonly>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputFirstName" class="form-label">Profile Image</label>

                                                <input type="hidden" name="olduserimage" value="<?php echo $userdata->userimage;?>">

                                                <input type="file" class="form-control" id="inputFirstName" name="userimage" data-error="Please Upload Image">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputFirstName" class="form-label">First Name</label>

                                                <input type="text" class="form-control text-r" id="inputFirstName" name="userfname" data-error="Please Enter First name" value="<?php echo $userdata->userfname?>">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputFirstName" class="form-label">Last Name</label>

                                                <input type="text" class="form-control text-r" id="inputFirstName" name="userlname" data-error="Please Enter Last name" value="<?php echo $userdata->userlname;?>">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputPassword" class="form-label">Change Password</label>

                                                <input type="password" class="form-control" id="inputPassword" name="change_userpassword" data-error="Please Enter Password">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">                                

                                                <label for="inputEmail" class="form-label">Email</label>

                                                <input type="email" class="form-control text-em" id="inputEmail" name="usermail" data-error2="Please Enter valid Email" value="<?php echo $userdata->usermail; ?>">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">                                

                                                <label for="inputEmail" class="form-label">Phone No</label>

                                                <input type="text" class="form-control text-ph" id="inputEmail" name="userphone" data-error2="Please Enter Phone Number" value="<?php echo $userdata->userphone; ?>">

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputState" class="form-label">Gender</label>

                                                <select id="inputState" class="form-select text-dr" name="usergender" data-error2="Please Select Gender">

                                                    <option value="">Choose...</option>

                                                    <option value="M" value="M" <?php if($userdata->usergender=='M') { echo 'selected';} ?>>Male</option>

                                                    <option value="F" value="F" <?php if($userdata->usergender=='F') { echo 'selected';} ?>>Female</option>

                                                    <option value="O" value="O" <?php if($userdata->usergender=='O') { echo 'selected';} ?>>Other</option>

                                                </select>

                                                <label></label>

                                            </div>

                                            <div class="col-6">

                                                <label for="inputAddress" class="form-label">Date of Birth</label>

                                                <input type="date" class="form-control text-r" id="inputEmail" name="userdob" data-error="Please Enter Date of Birth" value="<?php echo date('Y-m-d', strtotime($userdata->userdob)); ?>">

                                                <label></label>

                                            </div>

                                            <div class="col-12">

                                                <label for="inputAddress" class="form-label">Address</label>

                                                <textarea class="form-control text-ar" id="inputAddress" rows="3" name="useraddress" data-error2="Please enter address"><?php echo $userdata->useraddress;?></textarea>

                                                <label></label>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputCity" class="form-label">Location</label>

                                                <?php $city_info = city_lists();?>

                                                <select id="inputState" class="form-select text-dr" name="usercity" data-error2="Please Select Location">

                                                    <?php

                                                    foreach($city_info as $city)

                                                    {

                                                        echo "<optgroup label='".$city['province']."'>";

                                                        foreach($city['city_list'] as $cities)

                                                        {

                                                            if($userdata->usercity==$cities->RegionID)

                                                            {

                                                                echo "<option value='".$cities->RegionID."' selected='selected'>".$cities->RegionName."</option>";

                                                            }

                                                            else

                                                            {

                                                                echo "<option value='".$cities->RegionID."'>".$cities->RegionName."</option>";

                                                            }

                                                        }

                                                        echo "</optgroup>";

                                                    }

                                                    ?>

                                                </select>

                                                <label></lable>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="inputZip" class="form-label">Zip</label>

                                                <input type="text" class="form-control text-r" id="inputZip" name="userzip" data-error="Please Enter Zip Code" value="<?php echo $userdata->userzip;?>">

                                                <label></lable>

                                            </div>

                                            <div class="col-12">

                                                <input type="submit" class="btn btn-primary px-5" name="update" value="Update">

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

		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

		<!--End Back To Top Button-->

		<footer class="page-footer">

			<p class="mb-0">Copyright © 2021. All right reserved.</p>

		</footer>

	</div>

    <?php $this->view('admin/inc/foot'); ?>

    </body>

</html>