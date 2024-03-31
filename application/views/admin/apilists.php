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
		<link rel="stylesheet" type="text/css"
			href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.19.5/swagger-ui.css">
		<style>
			#accordion .glyphicon {
				margin-right: 10px;
			}

			.panel-collapse>.list-group .list-group-item:first-child {
				border-top-right-radius: 0;
				border-top-left-radius: 0;
			}

			.panel-collapse>.list-group .list-group-item {
				border-width: 1px 0;
			}

			.panel-collapse>.list-group {
				margin-bottom: 0;
			}

			.panel-collapse .list-group-item {
				border-radius: 0;
			}
		</style>
		<div class="page-wrapper">
			<div class="page-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-3 col-md-3">
							<div class="accordion" id="accordionExample">
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
										<button class="accordion-button" type="button" data-bs-toggle="collapse"
											data-bs-target="#collapseOne" aria-expanded="true"
											aria-controls="collapseOne">
											General
										</button>
									</h2>
									<div id="collapseOne" class="accordion-collapse collapse show"
										aria-labelledby="headingOne" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(1);">Home Page</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(2);">Login Page</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(3);">Country & Province List</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(5);">Dashboard</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseTwo"
											aria-expanded="false" aria-controls="collapseTwo">
											Users
										</button>
									</h2>
									<div id="collapseTwo" class="accordion-collapse collapse"
										aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<!-- <li class="list-group-item">Get All Users</li> -->
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(4);">Login User</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(6);">Reset Password</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(11);">Edit Profile</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(12);">Edit Password</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(7);">Get Specific User</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(40);">User Transaction History</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThree">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseThree"
											aria-expanded="false" aria-controls="collapseThree">
											Treasurer
										</button>
									</h2>
									<div id="collapseThree" class="accordion-collapse collapse"
										aria-labelledby="headingThree" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(13);">Get All Users</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(41);">Create Users Page
														Dropdown</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(14);">Create Users</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(18);">Transaction History
														(Self)</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(19);">Transaction History
														(Members)</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(20);">Donation History</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(21);">Get User Lists (for cash
														dropdown)</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(22);">Cash Donation (Behalf)</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFour">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseFour"
											aria-expanded="false" aria-controls="collapseFour">
											Donations
										</button>
									</h2>
									<div id="collapseFour" class="accordion-collapse collapse"
										aria-labelledby="headingFour" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(23);">Donations Page</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(17);">Donations History By User</a>
												</li>
												<!-- <li class="list-group-item">Cash Donations</li> -->
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(15);">Make Payment Request</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(16);">Last Donation Details</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFive">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseFive"
											aria-expanded="false" aria-controls="collapseFive">
											Programme
										</button>
									</h2>
									<div id="collapseFive" class="accordion-collapse collapse"
										aria-labelledby="headingFive" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(8);">Get Programme Categories</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(9);">Get Programme Lists by
														Category</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(10);">Get Programme Details</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSix">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseSix"
											aria-expanded="false" aria-controls="collapseSix">
											Notices
										</button>
									</h2>
									<div id="collapseSix" class="accordion-collapse collapse"
										aria-labelledby="headingSix" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(24);">Get Notice Categories</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(25);">Get Notice Lists by
														Category</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(26);">Get Notice Details</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(27);">Notification Lists</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSeven">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseSeven"
											aria-expanded="false" aria-controls="collapseSeven">
											Funeral Cover
										</button>
									</h2>
									<div id="collapseSeven" class="accordion-collapse collapse"
										aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(28);">Funeral Page</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(29);">Policy Lists</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(34);">Policy Lists Treasurer</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(30);">Policy Shortlist /
														Unshortlist</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(36);">Active Policy Lists</a>
												</li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(31);">Policy Details</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(32);">Policy Purchase Page</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(33);">Policy Payment Page</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(35);">Policy Payment Treasurer
														Page</a></li>
												<!-- <li class="list-group-item">Policy Transaction (Cash/Card)</li> -->
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingEight">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseEight"
											aria-expanded="false" aria-controls="collapseEight">
											Cover Details
										</button>
									</h2>
									<div id="collapseEight" class="accordion-collapse collapse"
										aria-labelledby="headingEight" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(36);">Active Policy List</a></li>
												<!-- <li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(37);">Active Policy Details</a></li> -->
											</ul>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingNine">
										<button class="accordion-button collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#collapseNine"
											aria-expanded="false" aria-controls="collapseNine">
											Claims
										</button>
									</h2>
									<div id="collapseNine" class="accordion-collapse collapse"
										aria-labelledby="headingNine" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<ul class="list-group">
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(38);">Policy Dropdown List</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(39);">Raise a Claim</a></li>
												<li class="list-group-item"><a href="javascript:void(0)"
														onclick="return getMyAPIData(37);">Claims List</a></li>
											</ul>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="col-sm-9 col-md-9">
							<div class="row">
								<span id="apiresp">

								</span>
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
		<p class="mb-0">Copyright ©
			<?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AAC - African Apostolic Church</a>
		</p>
	</footer>
	</div>
	<?php $this->view('admin/inc/foot'); ?>
</body>

</html>