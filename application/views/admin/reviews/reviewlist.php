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
				<?php
				// echo "<pre>";
				// print_r($review_data);
				// echo "</pre>";
				?>
				<div class="card">
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
					<div class="card-body">
						<div class="table-responsive">
                            <!-- <div class="card">
								<div class="card-body">
                                    <div class="row">
                                        <div class="input-group col"> 
                                            <span class="input-group-text" style="background-color:#7CCFD3;" id="basic-addon1">&nbsp;</span>
                                            <input type="text" class="form-control" value="On Hold" readonly>
                                        </div>
                                        <div class="input-group col"> 
                                            <span class="input-group-text" style="background-color:#D2DCB3;" id="basic-addon1">&nbsp;</span>
                                            <input type="text" class="form-control" value="Slot Booked" readonly>
                                        </div>
                                        <div class="input-group col"> 
                                            <span class="input-group-text" style="background-color:#9D90F2;" id="basic-addon1">&nbsp;</span>
                                            <input type="text" class="form-control" value="Rescheduled" readonly>
                                        </div>
                                        <div class="input-group col"> 
                                            <span class="input-group-text" style="background-color:#E6775C;" id="basic-addon1">&nbsp;</span>
                                            <input type="text" class="form-control" value="Cancelled" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
							<table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Centre</th>
                                        <th>Location</th>
                                        <th>Booking Type</th>
                                        <th>Booking Date</th>
                                        <th>Booking Time</th>
                                        <th>Feedback</th>
                                        <th>Rating></th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th>Action</th> 
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    // echo "<pre>";
                                    // print_r($booking_info);
                                    // echo "</pre>";
                                    foreach($review_data as $review)
                                    {
                                        echo "<td>";
                                            echo $review->id;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $review->userfname;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $review->centre_name;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $review->RegionName;
                                        echo "</td>";

                                        echo "<td>";
                                            if($review->booking_type==0 || $review->booking_type==1)
                                            {
                                                echo "Booking Request";
                                            }
                                            if($review->booking_type==2)
                                            {
                                                echo "Call Back Request";
                                            }
                                            if($review->booking_type==3)
                                            {
                                                echo "Tele Consultation Request";
                                            }
                                        echo "</td>";

                                        echo "<td>";
                                            echo date("jS M, Y", strtotime($review->schedule_date));
                                        echo "</td>";

                                        echo "<td>";
                                            echo $review->booking_time;
                                        echo "</td>";

                                        echo "<td>";
                                            echo "<p>".$review->review_text."</p>";
                                        echo "</td>";

                                        echo "<td>";
                                            echo $review->centre_rating;
                                        echo "</td>";

                                        echo "<td>";
                                            if($review->status==0)
                                            {
                                                echo "Not Approved";
                                            }
                                            if($review->status==1)
                                            {
                                                echo "Approved";
                                            }
                                        echo "</td>";

                                        echo "<td>";
                                            echo date("jS M, Y", strtotime($review->added_on));
                                        echo "</td>";                            
                                        
                                        echo "<td>";
                                        if($this->session->userdata('logged_in_info')->userrole='1')
                                        {
                                            if($review->status==0)
                                            {
                                                ?>
                                                &nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'reviews/approve/' . $review->id; ?>" data-deletetext="Are you sure to approve this Review?"><i class='fadeIn animated bx bxs-lock-open' style="color:#f00002;"></i></a>
                                                <?php  
                                            }
                                            else
                                            {
                                                ?>
                                                &nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'reviews/disapprove/' . $review->id; ?>" data-deletetext="Are you sure to disapprove this Review?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                <?php
                                            }
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
								</tbody>
							</table>
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
			<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">Sentebale Health App.</a></p>
		</footer>
	</div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('deletelink');
            var mytext = $(event.relatedTarget).data('deletetext');
            //alert(myVal);
            $("#confirmBtndel").attr("href", myValid);
            $("#deletetext").text(mytext);
        });
        function openeditModal(x)
        {
            //alert(x);
            $('#bookingModal').modal('show');
            $.ajax({
                type: "POST",
                url: base_url+'BookingController/getbookinginfo',
                data: {bid: x},
                success: function(data){                    
                    $('#bookingDetails').html(data);
                }
            });
        }
    </script>
    </body>
</html>