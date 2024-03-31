<!--start header -->
<header>
	<div class="topbar d-flex align-items-center">
		<nav class="navbar navbar-expand">
			<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
			</div>
			<div class="top-menu ms-auto">
				<?php
				$not = get_notifications();
				// echo "<pre>";
				// print_r($not);
				// echo "</pre>";
				?>
				<?php
				/*
				<ul class="navbar-nav align-items-center">
				<li class="nav-item dropdown dropdown-large">
				<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<!-- <span class="alert-count">7</span> -->
				<i class='bx bx-bell'></i>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
				<a href="javascript:;">
				<div class="msg-header">
				<p class="msg-header-title">Recent Notifications</p>
				</div>
				</a>
				
				<div class="header-notifications-list">
				<?php
				foreach($not as $ntf)
				{
				?>
				<a class="dropdown-item" href="javascript:;">
				<div class="d-flex align-items-center">
				<div class="notify bg-light-primary text-primary"><i class="bx bx-notification"></i>
				</div>
				<div class="flex-grow-1">
				<h6 class="msg-name"><?php echo $ntf->not_section;?><span class="msg-time float-end"><?php echo timeAgo($ntf->not_generate_time);?></span></h6>
				<p class="msg-info"><?php echo $ntf->not_msg;?></p>
				</div>
				</div>
				</a>
				<?php
				}
				?>
				
				</div>
				<!-- <a href="javascript:;">
				<div class="text-center msg-footer">View All Notifications</div>
				</a> -->
				</div>
				</li>
				</ul>
				*/?>
			</div>
			<div class="user-box dropdown">
				<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
					role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<?php
					if ($this->session->userdata('logged_in_info')->userrole == 1) {
						echo '<img src="' . base_url() . 'uploads/company/' . company_info('company_logo')->company_logo . '" class="user-img" alt="user avatar">';
					} else {
						if (!empty($this->session->userdata('logged_in_info')->userimage)) {
							echo '<img src="' . base_url() . 'uploads/user_profile/' . $this->session->userdata('logged_in_info')->userimage . '" class="user-img" alt="user avatar">';
						} else {
							echo '<img src="' . base_url() . 'uploads/company/' . company_info('company_logo')->company_logo . '" class="user-img" alt="user avatar">';
						}
					}
					?>

					<div class="user-info ps-3">
						<p class="user-name mb-0">
							<?php echo $this->session->userdata('logged_in_info')->userfname; ?>
						</p>
						<p class="designattion mb-0">
							<?php echo ($this->session->userdata('logged_in_info')->userrole == 1) ? 'Administrator' : 'Admin Staff'; ?>
						</p>
					</div>

					<div class="user-info ps-3">
						<p class="user-name mb-0">
							<i class='bx bxs-grid'></i>
						</p>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<?php
					if ($this->session->userdata('logged_in_info')->userrole == 1) { ?>
						<li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
								data-bs-target="#settingsModal"><i class="bx bx-cog"></i><span>Settings</span></a>
						</li>
					<?php } else { ?>
						<li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
								data-bs-target="#profileModal"><i class="bx bx-user"></i><span>Profile</span></a>
						</li>
					<?php } ?>
					<li>
						<div class="dropdown-divider mb-0"></div>
					</li>
					<li><a class="dropdown-item" href="<?php echo base_url(); ?>/logout"><i
								class='bx bx-log-out-circle'></i><span>Logout</span></a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<?php
	if (!empty($this->session->flashdata('error'))) {
		$alertdata['error'] = $this->session->flashdata('error');
		$this->view('admin/inc/erroralert', $alertdata);
		unset($_SESSION['error']);
	}
	if (!empty($this->session->flashdata('success'))) {
		$alertdata['success'] = $this->session->flashdata('success');
		$this->view('admin/inc/successalert', $alertdata);
		unset($_SESSION['success']);
	}
	if (!empty($this->session->flashdata('update'))) {
		$alertdata['success'] = $this->session->flashdata('update');
		$this->view('admin/inc/successalert', $alertdata);
		unset($_SESSION['update']);
	}
	?>
</header>
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="chip chip-md bg-light text-dark">
					<?php
					if (!empty($this->session->userdata('logged_in_info')->userimage)) {
						echo '<img src="' . base_url() . 'uploads/user_profile/' . $this->session->userdata('logged_in_info')->userimage . '" class="user-img" alt="user avatar"> My Profile';
					} else {
						echo '<img src="' . base_url() . 'uploads/company/' . company_info('company_logo')->company_logo . '" class="user-img" alt="user avatar"> My Profile';
					}
					?>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<form class="row g-3" method="post" action="<?php echo base_url('users/update'); ?>"
							onsubmit="return formValidate(4);" enctype="multipart/form-data">
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">User Role</label>
								<input type="hidden" name="mode" value='0'>
								<input type="hidden" name="userid" value="<?php if ($this->session->userdata('logged_in_info')->id) {
									echo $this->session->userdata('logged_in_info')->id;
								} ?>">
								<input type="text" class="form-control" id="inputFirstName" value="<?php if ($this->session->userdata('logged_in_info')->userrole == '1') {
									echo "Admin";
								}
								if ($this->session->userdata('logged_in_info')->userrole == '2') {
									echo 'Admin Staff';
								}
								if ($this->session->userdata('logged_in_info')->userrole == '3') {
									echo 'Users';
								} ?>" readonly>
							</div>
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">Profile Image</label>
								<input type="hidden" name="olduserimage"
									value="<?php echo $this->session->userdata('logged_in_info')->userimage; ?>">
								<input type="file" class="form-control" id="inputFirstName" name="userimage"
									data-error="Please Upload Image">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">First Name</label>
								<input type="text" class="form-control text-r" id="inputFirstName" name="userfname"
									data-error="Please Enter First name" value="<?php if (isset($this->session->userdata('logged_in_info')->userfname)) {
										echo $this->session->userdata('logged_in_info')->userfname;
									} else {
										echo '';
									} ?>">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">Last Name</label>
								<input type="text" class="form-control text-r" id="inputFirstName" name="userlname"
									data-error="Please Enter Last name" value="<?php if (isset($this->session->userdata('logged_in_info')->userlname)) {
										echo $this->session->userdata('logged_in_info')->userlname;
									} else {
										echo '';
									} ?>">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputPassword" class="form-label">Change Password</label>
								<input type="password" class="form-control" id="inputPassword"
									name="change_userpassword" data-error="Please Enter Password">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputEmail" class="form-label">Email</label>
								<input type="email" class="form-control text-em" id="inputEmail" name="usermail"
									data-error2="Please Enter valid Email" value="<?php if (isset($this->session->userdata('logged_in_info')->usermail)) {
										echo $this->session->userdata('logged_in_info')->usermail;
									} else {
										echo '';
									} ?>">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputEmail" class="form-label">Phone No</label>
								<input type="text" class="form-control text-r" id="inputEmail" name="userphone"
									data-error="Please Enter Phone Number" value="<?php if (isset($this->session->userdata('logged_in_info')->userphone)) {
										echo $this->session->userdata('logged_in_info')->userphone;
									} else {
										echo '';
									} ?>">
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputState" class="form-label">Gender</label>
								<select id="inputState" class="form-select text-dr2" name="usergender"
									data-error2="Please Select Gender">
									<option value="">Choose...</option>
									<option value="M" value="M" <?php if ($this->session->userdata('logged_in_info')->usergender == 'M') {
										echo 'selected';
									} ?> >Male</option>
									<option value="F" value="F" <?php if ($this->session->userdata('logged_in_info')->usergender == 'F') {
										echo 'selected';
									} ?> >Female</option>
									<option value="O" value="O" <?php if ($this->session->userdata('logged_in_info')->usergender == 'O') {
										echo 'selected';
									} ?> >Other</option>
								</select>
								<label></label>
							</div>
							<div class="col-6">
								<label for="inputAddress" class="form-label">Date of Birth</label>
								<input type="date" class="form-control text-r" id="inputEmail" name="userdob"
									data-error="Please Enter Date of Birth" value="<?php if (isset($this->session->userdata('logged_in_info')->userdob)) {
										echo date('Y-m-d', strtotime($this->session->userdata('logged_in_info')->userdob));
									} else {
										echo '';
									} ?>">
								<label></label>
							</div>
							<div class="col-12">
								<label for="inputAddress" class="form-label">Address</label>
								<textarea class="form-control text-ar" id="inputAddress" rows="3" name="useraddress"
									data-error2="Please enter address"><?php if (isset($this->session->userdata('logged_in_info')->useraddress)) {
										echo $this->session->userdata('logged_in_info')->useraddress;
									} else {
										echo '';
									} ?></textarea>
								<label></label>
							</div>
							<div class="col-md-6">
								<label for="inputCity" class="form-label">Location</label>
								<?php $city_info = city_lists(); ?>
								<select id="inputState" class="form-select text-dr3" name="usercity"
									data-error2="Please Select Location">
									<option value="">Choose...</option>
									<?php
									foreach ($city_info as $city) {
										echo "<optgroup label='" . $city['province'] . "'>";
										foreach ($city['city_list'] as $cities) {
											if (isset($this->session->userdata('logged_in_info')->usercity)) {
												if ($this->session->userdata('logged_in_info')->usercity == $cities->RegionID) {
													echo "<option value='" . $cities->RegionID . "' selected>" . $cities->RegionName . "</option>";
												} else {
													echo "<option value='" . $cities->RegionID . "'>" . $cities->RegionName . "</option>";
												}
											} else {
												echo "<option value='" . $cities->RegionID . "'>" . $cities->RegionName . "</option>";
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
								<input type="text" class="form-control text-r" id="inputZip" name="userzip"
									data-error="Please Enter Zip Code" value="<?php if (isset($this->session->userdata('logged_in_info')->userzip)) {
										echo $this->session->userdata('logged_in_info')->userzip;
									} else {
										echo '';
									} ?>">
								<label></lable>
							</div>
							<div class="col-12">
								<input type="submit" class="btn btn-primary px-5" value="Update">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Change Company Settings</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php $company_info = company_details(); ?>
				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<form class="row g-3" action="<?php echo base_url(); ?>update_company" method="post"
							enctype="multipart/form-data">
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">Company Logo</label>
								<input type="file" class="form-control" id="inputFirstName" name="company_logo">
								<input type="hidden" class="form-control" id="inputFirstName" name="company_logo_old"
									value="<?php echo !empty($company_info->company_logo) ? $company_info->company_logo : ''; ?>">
							</div>
							<div class="col-md-6">
								<img src="<?php echo !empty($company_info->company_logo) ? base_url() . 'uploads/company/' . $company_info->company_logo : base_url() . 'uploads/company/default_logo.PNG'; ?>"
									width="50%">
							</div>
							<div class="col-md-6">
								<label for="inputFirstName" class="form-label">Company Name</label>
								<input type="text" class="form-control" id="inputFirstName" name="company_name"
									value="<?php echo !empty($company_info->company_name) ? $company_info->company_name : ''; ?>">
							</div>
							<div class="col-md-6">
								<label for="inputLastName" class="form-label">Company Email</label>
								<input type="email" class="form-control" id="inputLastName" name="company_email"
									value="<?php echo !empty($company_info->company_email) ? $company_info->company_email : ''; ?>">
							</div>
							<div class="col-12">
								<label for="inputAddress" class="form-label">Company Address</label>
								<textarea class="form-control" id="inputAddress" placeholder="Address..." rows="3"
									name="company_address"><?php echo !empty($company_info->company_address) ? $company_info->company_address : ''; ?></textarea>
							</div>
							<div class="col-md-6">
								<label for="inputEmail" class="form-label">Phone</label>
								<input type="text" class="form-control" id="inputEmail" name="company_phone"
									value="<?php echo !empty($company_info->company_phone) ? $company_info->company_phone : ''; ?>">
							</div>
							<div class="col-md-6">
								<label for="inputPassword" class="form-label">Fax</label>
								<input type="text" class="form-control" id="inputPassword" name="company_fax"
									value="<?php echo !empty($company_info->company_fax) ? $company_info->company_fax : ''; ?>">
							</div>
							<div class="col-md-6">
								<label for="inputCity" class="form-label">City</label>
								<input type="text" class="form-control" id="inputCity" name="company_city"
									value="<?php echo !empty($company_info->company_city) ? $company_info->company_city : ''; ?>">
							</div>
							<div class="col-md-4">
								<label for="inputState" class="form-label">State</label>
								<input type="text" class="form-control" id="inputState" name="company_state"
									value="<?php echo !empty($company_info->company_state) ? $company_info->company_state : ''; ?>">
							</div>
							<div class="col-md-2">
								<label for="inputZip" class="form-label">Zip</label>
								<input type="text" class="form-control" id="inputZip" name="company_zip"
									value="<?php echo !empty($company_info->company_zip) ? $company_info->company_zip : ''; ?>">
							</div>
							<div class="col-12">
								<input type="submit" class="btn btn-primary px-5" value="Update">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--end header -->