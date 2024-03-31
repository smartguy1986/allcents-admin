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
			.card {
				margin: 10px 2px !important;
			}

			.col-xl-4 {
				width: 33% !important;
			}

			.col-xl-6 {
				width: 49% !important;
			}
		</style>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js"
			integrity="sha512-b3xr4frvDIeyC3gqR1/iOi6T+m3pLlQyXNuvn5FiRrrKiMUJK3du2QqZbCywH6JxS5EOfW0DY0M6WwdXFbCBLQ=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="content__wrap">
						<h1 class="page-title mb-2 text-white">Dashboard</h1>
						<h2 class="h5 text-white">Welcome back
							<?php echo $this->session->userdata('logged_in_info')->userfname; ?>
						</h2>
					</div>
					<div class="card radius-10 col-6 col-lg-6 col-xl-6 d-flex">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">All Users</h6> <a href="javascript:void(0);"
										id="downloadPdfall">Download</a>
								</div>
							</div>
							<hr>
							<form class="form">
								<div class="row">
									<div class="col-12 col-lg-6 col-xl-6">
										<label for="timeperiod" class="form-label">Period of Reporting</label>
										<select class="form-control" name="timeperiod" id="timeperiodall"
											onchange="getuserchartall(this.value);">
											<option value="0">Select</option>
											<option value="1">YoY</option>
											<option value="2">MoM</option>
											<option value="3">WoW</option>
											<option value="4">DoD</option>
										</select>
									</div>
								</div>
							</form>
							<canvas id="monthlyusersall" width="auto" height="150px"></canvas>
						</div>
					</div>
					<div class="card radius-10 col-6 col-lg-6 col-xl-6 d-flex nobg">
						<div class="row">
							<div class="col-6">
								<div class="card radius-10 card-color1">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<?php $totaluser = get_total_user(); ?>
												<h4 class="my-1 text-white">
													<?php echo $totaluser; ?>
												</h4>
												<p class="mb-0 font-13 text-white">Total User</p>
											</div>
											<div class="widgets-icons-2 rounded-circle text-white ms-auto">
												<i class='bx bx-user'></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-6">
								<div class="card radius-10 card-color2">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<h4 class="my-1 text-white">
													<?php echo '$ ' . number_format(get_total_donation_home()->totdon, 2); ?>
												</h4>
												<p class="mb-0 font-13 text-white">Total Donation</p>
											</div>
											<div class="widgets-icons-2 rounded-circle text-white ms-auto">
												<i class='bx bx-money'></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-6">
								<div class="card radius-10 card-color3">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<h4 class="my-1 text-white">
													<?php echo total_branch(); ?>
												</h4>
												<p class="mb-0 font-13 text-white">Total Branch</p>
											</div>
											<div class="widgets-icons-2 rounded-circle text-white ms-auto">
												<i class='bx bx-church'></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-6">
								<div class="card radius-10 card-color4">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div>
												<h4 class="my-1 text-white">
													<?php echo total_cell(); ?>
												</h4>
												<p class="mb-0 font-13 text-white">Total Cell</p>
											</div>
											<div class="widgets-icons-2 rounded-circle text-white ms-auto">
												<i class='bx bx-church'></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="card radius-10">
								<div class="card-body">
									<h5 class="h6">Available Policies</h5>
									<?php
									$policy_list = policy_list_homepage();
									// print_r($policy_list);
									echo '<ul class="list-group">';
									foreach ($policy_list as $policy) {
										echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
										echo $policy->policy_title;
										echo '<span class="badge"><a href="' . base_url() . 'policies/details/' . $policy->id . '"><i class="bx bxs-edit"></i></a></span>';
										echo '</li>';
									}
									echo '</ul>';
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="card radius-10 col-6 col-lg-6 col-xl-6 d-flex">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">All Donations</h6> <a href="javascript:void(0);"
										id="downloadPdfalldonate">Download</a>
								</div>
							</div>
							<hr>
							<form class="form">
								<div class="row">
									<div class="col-12 col-lg-6 col-xl-6">
										<label for="timeperiod" class="form-label">Period of Reporting</label>
										<select class="form-control" name="timeperiodalldonate" id="timeperiodalldonate"
											onchange="getuserchartalldonate(this.value);">
											<option value="0">Select</option>
											<option value="1">YoY</option>
											<option value="2">MoM</option>
											<option value="3">WoW</option>
											<option value="4">DoD</option>
										</select>
									</div>
								</div>
							</form>
							<canvas id="monthlydonateall" width="auto" height="150px"></canvas>
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
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script>
		$('document').ready(function () {
			$.ajax({
				url: "<?php echo base_url("DashboardController/showmonthlyuserchartall"); ?>",
				data: { timeperiod: 0 },
				type: "POST",
				cache: false,
				success: function (data) {
					//alert(data);
					$('#monthlyusersall').empty();
					$('#monthlyusersall').html(data);
				}
			});

			$.ajax({
				url: "<?php echo base_url("DashboardController/showmonthlydonatechartall"); ?>",
				data: { timeperiod: 0 },
				type: "POST",
				cache: false,
				success: function (data) {
					//alert(data);
					$('#monthlydonateall').empty();
					$('#monthlydonateall').html(data);
				}
			});

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showmonthlyuserchartsocial"); ?>",
			// 	data: { timeperiod: 0 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#monthlyuserssocial').empty();
			// 		$('#monthlyuserssocial').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showmonthlybookingchartall"); ?>",
			// 	data: { timeperiod: 2 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		console.log(data);
			// 		$('#bookingtotal').empty();
			// 		$('#bookingtotal').html(data);
			// 	}
			// });

			// var stim = $('#timeperiodbp').val();
			// // var prov = $('#provinceidbp').val();
			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showmonthlybookingchartprovince"); ?>",
			// 	data: { timeperiod: stim, provinceid: 0 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		console.log(data);
			// 		$('#bookingprovince').empty();
			// 		$('#bookingprovince').html(data);
			// 	}
			// });

			// var stimtp = $('#timeperiodtype').val();
			// var provtp = $('#provinceidtype').val();
			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showmonthlybookingcharttype"); ?>",
			// 	data: { timeperiod: stimtp, booktype: provtp },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		console.log(data);
			// 		$('#bookingtype').empty();
			// 		$('#bookingtype').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showmonthlycategorychart"); ?>",
			// 	data: { timeperiod: 2 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#monthlycategory').empty();
			// 		$('#monthlycategory').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/toparticlechart"); ?>",
			// 	data: { timeperiod: 2 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#toparticle').empty();
			// 		$('#toparticle').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/topprovincechart"); ?>",
			// 	data: { timeperiod: 2 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#topprovince').empty();
			// 		$('#topprovince').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/topcitychart"); ?>",
			// 	data: { timeperiod: 2 },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#topcities').empty();
			// 		$('#topcities').html(data);
			// 	}
			// });

			// $.ajax({
			// 	url: "<?php echo base_url("DashboardController/showbookingcomparechart"); ?>",
			// 	data: { timeperiod: '1' },
			// 	type: "POST",
			// 	cache: false,
			// 	success: function (data) {
			// 		//alert(data);
			// 		$('#bookingcompare').empty();
			// 		$('#bookingcompare').html(data);
			// 	}
			// });
		});

		function getuserchartall(y) {
			//var y = $("#timeperiod").val();
			//alert(x);
			$.ajax({
				url: "<?php echo base_url("DashboardController/showmonthlyuserchartall"); ?>",
				data: { timeperiod: y },
				type: "POST",
				cache: false,
				success: function (data) {
					//alert(data);
					$('#monthlyusersall').empty();
					$('#monthlyusersall').html(data);
				}
			});
		}

		function getuserchartalldonate(y) {
			//var y = $("#timeperiod").val();
			//alert(x);
			$.ajax({
				url: "<?php echo base_url("DashboardController/showmonthlydonatechartall"); ?>",
				data: { timeperiodn: y },
				type: "POST",
				cache: false,
				success: function (data) {
					//alert(data);
					$('#monthlydonateall').empty();
					$('#monthlydonateall').html(data);
				}
			});
		}

		// function getuserchartemail(y) {
		// 	//var y = $("#timeperiod").val();
		// 	//alert(x);
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlyuserchartemail"); ?>",
		// 		data: { timeperiod: y },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#monthlyusersemail').empty();
		// 			$('#monthlyusersemail').html(data);
		// 		}
		// 	});
		// }

		// function getuserchartsocial(y) {
		// 	//var y = $("#timeperiod").val();
		// 	//alert(x);
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlyuserchartsocial"); ?>",
		// 		data: { timeperiod: y },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#monthlyuserssocial').empty();
		// 			$('#monthlyuserssocial').html(data);
		// 		}
		// 	});
		// }

		// function getbookingtotal(y) {
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlybookingchartall"); ?>",
		// 		data: { timeperiod: y },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			console.log(data);
		// 			$('#bookingtotal').empty();
		// 			$('#bookingtotal').html(data);
		// 		}
		// 	});
		// }

		// function getbookingprovince(y) {
		// 	var stim = $('#timeperiodbp').val();
		// 	var prov = $('#provinceidbp').val();
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlybookingchartprovince"); ?>",
		// 		data: { timeperiod: stim, provinceid: prov },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			console.log(data);
		// 			$('#bookingprovince').empty();
		// 			$('#bookingprovince').html(data);
		// 		}
		// 	});
		// }

		// function getbookingtype() {
		// 	var stimtp = $('#timeperiodtype').val();
		// 	var provtp = $('#provinceidtype').val();
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlybookingcharttype"); ?>",
		// 		data: { timeperiod: stimtp, booktype: provtp },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			console.log(data);
		// 			$('#bookingtype').empty();
		// 			$('#bookingtype').html(data);
		// 		}
		// 	});
		// }

		// function gettopcategory() {
		// 	var stimec = $('#timeperiodtc').val();
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showmonthlycategorychart"); ?>",
		// 		data: { timeperiod: stimec },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#monthlycategory').empty();
		// 			$('#monthlycategory').html(data);
		// 		}
		// 	});
		// }

		// function gettoparticle(stm) {
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/toparticlechart"); ?>",
		// 		data: { timeperiod: stm },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#toparticle').empty();
		// 			$('#toparticle').html(data);
		// 		}
		// 	});
		// }

		// function gettopprovincefilter(prv) {
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/topprovincechart"); ?>",
		// 		data: { timeperiod: prv },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#topprovince').empty();
		// 			$('#topprovince').html(data);
		// 		}
		// 	});
		// }

		// function gettopcityfilter(ct) {
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/topcitychart"); ?>",
		// 		data: { timeperiod: ct },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#topcities').empty();
		// 			$('#topcities').html(data);
		// 		}
		// 	});
		// }

		// function getbookingcomparechart(cm) {
		// 	//var cm = $("#timeperiod").val();
		// 	//alert(x);
		// 	$.ajax({
		// 		url: "<?php echo base_url("DashboardController/showbookingcomparechart"); ?>",
		// 		data: { timeperiod: cm },
		// 		type: "POST",
		// 		cache: false,
		// 		success: function (data) {
		// 			//alert(data);
		// 			$('#bookingcompare').empty();
		// 			$('#bookingcompare').html(data);
		// 		}
		// 	});
		// }

		$('#downloadPdfall').click(function(event) {	
			var canvas = document.querySelector('#monthlyusersall');
			//creates image
			var canvasImg = canvas.toDataURL(canvas, '#ffffff', {type: 'image/jpeg', encoderOptions: 1.0});
			//var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
		
			//creates PDF from img
			var doc = new jsPDF('landscape');
			doc.setFontSize(20);
			
			doc.addImage(canvasImg, 'JPEG', 10, 10, 280, 150 );
			doc.save('user_data.pdf');
		});

		$('#downloadPdfalldonate').click(function(event) {	
			var canvas = document.querySelector('#monthlydonateall');
			//creates image
			var canvasImg = canvas.toDataURL(canvas, '#ffffff', {type: 'image/jpeg', encoderOptions: 1.0});
			//var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
		
			//creates PDF from img
			var doc = new jsPDF('landscape');
			doc.setFontSize(20);
			
			doc.addImage(canvasImg, 'JPEG', 10, 10, 280, 150 );
			doc.save('donation_data.pdf');
		});
	</script>
</body>

</html>