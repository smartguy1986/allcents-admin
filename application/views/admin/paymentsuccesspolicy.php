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
</head>

<body class="bg-login" data-base="<?php echo base_url(); ?>">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<!-- <div class="mb-4 text-center">
							<h2>The Funeral Policy App Admin</h2>
						</div> -->
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="login-separater text-center mb-4"> <span>Payment Details</span>
										<hr />
									</div>
									<div class="form-body">
										<?php
										$udata = getusername($transaction->user_id);
										// echo "<pre>";
										// print_r($udata);
										// echo "</pre>";
										$policyData = policy_info($transaction->policy_id);
										echo "<strong>Thank you for Purchasing Funeral Covers. Your transaction details are as below</strong>";
										echo '<table class="table">
										<tbody>
										  <tr>
											<th>Transaction ID</th>
											<td>' . $transaction->transaction_id . '</td>
										  </tr>
										  <tr>
											<th>Purchased By</th>
											<td>' . $udata->usertitle . ' ' . $udata->userfname . ' ' . $udata->userlname . '</td>
										  </tr>
										  <tr>
											<th>Amount Paid</th>
											<td>' . $transaction->gross_amount . '</td>
										  </tr>
										  <tr>
											<th>Payment Method</th>
											<td>' . $transaction->payment_mode . '</td>
										  </tr>
										  <tr>
											<th>Payment ID</th>
											<td>' . $transaction->reference_num . '</td>
										  </tr>
										  <tr>
											<th>Policy Purchased</th>
											<td>' . $policyData->policy_title . '</td>
										  </tr>
										  <tr>
											<th>Payment Frequency</th>
											<td>' . $transaction->payment_frequency . ' month(s)</td>
										  </tr>
										  <tr>
											<th>Next Payment Date</th>
											<td>' . date("j F, Y h:i:s A", strtotime($transaction->next_date)) . '</td>
										  </tr>
										  
										  <tr>
											<th>Status</th>
											<td>';
										if ($transaction->final_status == "1") {
											echo 'Success';
										} else {
											echo 'Failed';
										}
										echo '</td>
										  </tr>
										</tbody>
									  </table>';
										?>
									</div>
									<div class="col-12">
										<div class="d-grid">
											<input type="submit" id="payment_button_ok" class="btn btn-primary"
												value="Ok" name="submit" onclick="getMysuccess();">
										</div>
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
	<!--app JS-->
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/app.js"></script>
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/customfunc.js"></script>
	<script>
		function getMysuccess() {
			console.log("button clicked");
		}
	</script>
</body>

</html>