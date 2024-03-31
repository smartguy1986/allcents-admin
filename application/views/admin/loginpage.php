<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo base_url(); ?>resources/admin/assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
		rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/metismenu/css/metisMenu.min.css"
		rel="stylesheet" />
	<!-- loader-->
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/app.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/icons.css" rel="stylesheet">
	<title>African Apostolic Church App Backend</title>
	<base href="<?php echo base_url(); ?>">
	<style>
		.logo-icon {
			width: 160px;
		}
	</style>
</head>

<body class="bg-login" data-base="<?php echo base_url(); ?>">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<!-- <h2>The Funeral Policy App Admin</h2> -->

							<?php $company_info = company_info('company_logo'); ?>
							<?php if ($company_info) { ?>
								<img src="<?php echo base_url(); ?>uploads/company/<?php echo $company_info->company_logo; ?>"
									class="logo-icon" alt="logo icon">
								<?php
							}
							// echo "<pre>";
							// print_r($_SESSION);
							// echo "</pre>";
							?>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<!-- <div class="text-center">
										<h3 class="">Sign in</h3>
										</p>
									</div> -->
									<div class="login-separater text-center mb-4"> <span>SIGN IN WITH EMAIL</span>
										<hr />
									</div>
									<div class="form-body">
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
										<form class="row g-3" method="post" action=""
											onsubmit="return checkmycredentials();" id="adminLoginform">
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="text" name="adminmail" class="form-control"
													id="inputEmailAddress" placeholder="Email Address">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter
													Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="adminpass"
														class="form-control border-end-0" id="inputChoosePassword"
														value="12345678" placeholder="Enter Password"> <a
														href="javascript:;" class="input-group-text bg-transparent"><i
															class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<!-- <div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div> -->
											</div>
											<!-- <div class="col-md-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>
											</div> -->
											<div class="col-12">
												<div class="d-grid">
													<input type="submit" class="btn btn-primary" value="Sign in"
														name="submit">
												</div>
											</div>
										</form>
										<div id="result-data"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script
		src="<?php echo base_url(); ?>resources/admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/app.js"></script>
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/customfunc.js"></script>
</body>

</html>