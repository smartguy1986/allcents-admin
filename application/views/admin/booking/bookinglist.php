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
				// print_r($booking_info);
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
                            <div class="card">
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
                            </div>
							<table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>#</th>
										<th>ID</th>
                                        <th>User</th>
                                        <!-- <th>Category</th> -->
                                        <th>Centre</th>
                                        <th>Booking Type</th>
                                        <th>Booking Date</th>
                                        <th>Booking Time</th>
                                        <th>Status</th>
                                        <th>Admin Remark</th>
                                        <th>User Feedback</th>
                                        <!-- <th>Rescheduled Date</th> -->
                                        <!-- <th>Added On</th>
                                        <th>Last Updated</th> -->
                                        <th>Action</th> 
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    // echo "<pre>";
                                    // print_r($booking_info);
                                    // echo "</pre>";
                                    foreach($booking_info as $booking)
                                    {
                                        $user = getusername($booking['user_id']);
                                        if($booking['schedule_date'])
                                        {
                                             
                                            if(strtotime('today')>strtotime('+7 day '.$booking['schedule_date']))
                                            {
                                                $bookingclass = 'bg-primary';
                                                $style="background-color:#64523A; color:#fff;";
                                            }
                                            else
                                            {
                                                if($booking['status']==0)
                                                {
                                                    $bookingclass = 'bg-primary';
                                                    $style="color:#151511;";
                                                }
                                                if($booking['status']==1)
                                                {
                                                    $bookingclass = 'bg-primary';
                                                    $style="background-color:#7CCFD3; color:#151511;";
                                                }
                                                if($booking['status']==2)
                                                {
                                                    $bookingclass = 'bg-warning';
                                                    $style="background-color:#D2DCB3; color:#151511;";
                                                }
                                                if($booking['status']==3)
                                                {
                                                    $bookingclass = 'bg-default';
                                                    $style="background-color:#9D90F2; color:#fff;";
                                                }
                                                if($booking['status']==4)
                                                {
                                                    $bookingclass = 'bg-danger';
                                                    $style="background-color:#E6775C; color:#fff;";
                                                }
                                                else
                                                {
                                                    $bookingclass = '';
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if(strtotime('today')>strtotime('+7 day '.$booking['booking_date']))
                                            {
                                                $bookingclass = 'bg-primary';
                                                $style="background-color:#64523A; color:#fff;";
                                            }
                                            else
                                            {
                                                if($booking['status']==0)
                                                {
                                                    $bookingclass = 'bg-primary';
                                                    $style="color:#151511;";
                                                }
                                                if($booking['status']==1)
                                                {
                                                    $bookingclass = 'bg-primary';
                                                    $style="background-color:#7CCFD3; color:#151511;";
                                                }
                                                if($booking['status']==2)
                                                {
                                                    $bookingclass = 'bg-warning';
                                                    $style="background-color:#D2DCB3; color:#151511;";
                                                }
                                                if($booking['status']==3)
                                                {
                                                    $bookingclass = 'bg-default';
                                                    $style="background-color:#9D90F2; color:#fff;";
                                                }
                                                if($booking['status']==4)
                                                {
                                                    $bookingclass = 'bg-danger';
                                                    $style="background-color:#E6775C; color:#fff;";
                                                }
                                                else
                                                {
                                                    $bookingclass = '';
                                                }
                                            }
                                        }  
                                        
                                        echo "<tr style='".$style."'>";
                                        echo "<td>".$booking['id']."</td>";
                                        echo "<td>";
                                        ?>
                                        <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#bookingModal" data-booking-id="<?php echo $booking['id'];?>"><?php echo $booking['unique_id'];?></a> -->
                                        <a href="javascript:void(0);" onclick="openeditModal(<?php echo $booking['id'];?>)"><?php echo $booking['unique_id'];?></a>
                                        <?php
                                        echo "</td>";
                                        echo "<td>".$user->userfname."</td>";
                                        // echo "<td>".getcategoryinitials($booking->category_id)->cat_name_en."</td>";
                                        if($booking['centre_id']==1)
                                        {
                                            echo "<td>Sentebale Health Advisor</td>";
                                        }
                                        else
                                        {
                                            echo "<td>".getcentreinitials($booking['centre_id'])->centre_name."</td>";
                                        }
                                        echo "<td>";
                                            if($booking['booking_type']==0)
                                            {
                                                echo "Not Assigned";
                                            }
                                            if($booking['booking_type']==1)
                                            {
                                                echo "Appointment Booking";
                                            }
                                            if($booking['booking_type']==2)
                                            {
                                                echo "Requesting a Call";
                                            }
                                            if($booking['booking_type']==3)
                                            {
                                                echo "Requesting Consultation";
                                            }
                                        echo "</td>";
                                        echo "<td>".date("d M, Y", strtotime($booking['schedule_date']))."</td>";
                                        echo "<td>".$booking['booking_time']."</td>";
                                        echo "<td>";
                                        if($booking['schedule_date'])
                                        {
                                            if(strtotime('today')>strtotime($booking['schedule_date']))
                                            {
                                                echo "Expired";
                                            }
                                            else
                                            {
                                                if($booking['status']==0)
                                                {
                                                    echo "Received";
                                                }
                                                if($booking['status']==1)
                                                {
                                                    echo "Booking in progress";
                                                }
                                                if($booking['status']==2)
                                                {
                                                    echo "Booked Slot";
                                                }
                                                if($booking['status']==3)
                                                {
                                                    echo "Rescheduled";
                                                }
                                                if($booking['status']==4)
                                                {
                                                    echo "Cancelled";
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if(strtotime('today')>strtotime($booking['schedule_date']))
                                            {
                                                echo "Expired";
                                            }
                                            else
                                            {
                                                if($booking['status']==0)
                                                {
                                                    echo "Received";
                                                }
                                                if($booking['status']==1)
                                                {
                                                    echo "Booking in progress";
                                                }
                                                if($booking['status']==2)
                                                {
                                                    echo "Booked Slot";
                                                }
                                                if($booking['status']==3)
                                                {
                                                    echo "Rescheduled";
                                                }
                                                if($booking['status']==4)
                                                {
                                                    echo "Cancelled";
                                                }
                                            }
                                        }                                            
                                        echo "</td>";
                                        echo "<td>".$booking['admin_remark']."</td>";
                                        echo "<td>".$booking['user_feedback']."</td>";
                                        // if($booking['schedule_date'])
                                        // {
                                        //     echo "<td>".date("d M, Y", strtotime($booking['schedule_date']))."</td>";
                                        // }                                        
                                        // else
                                        // {
                                        //     echo "<td></td>";
                                        // }
                                        // echo "<td>".date("d M, Y", strtotime($booking['added_on']))."</td>";
                                        // echo "<td>".date("d M, Y", strtotime($booking['updated_on']))."</td>";
                                        
                                        echo "<td>";
                                        if($this->session->userdata('logged_in_info')->userrole!='1')
                                            {
                                                echo '';
                                            }
                                            else
                                            {
                                                ?>
                                                <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#bookingModal" data-booking-id="<?php echo $booking['id'];?>"><i class='fadeIn animated bx bx-show'></i>&nbsp;</a> -->
                                                <a href="javascript:void(0);" onclick="openeditModal(<?php echo $booking['id'];?>)"><i class='bx bxs-edit'></i>&nbsp;</a>
                                                <?php
                                                //echo "<a href='javascript:void(0);' id='bookingModal' data-booking-id='".$booking->id."'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";          
                                            }
                                        if($this->session->userdata('logged_in_info')->userrole==1)
                                        {
                                            if($booking['status']!=4)
                                            {
                                                ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'booking/cancel/' . $booking['id']."/".$term; ?>" data-deletetext="Are you sure to cancel this booking?"><i class='fadeIn animated bx bxs-lock'></i></a>
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