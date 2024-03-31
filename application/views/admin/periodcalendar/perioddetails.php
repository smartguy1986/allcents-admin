<!doctype html>
<html lang="en">
    <?php $this->view('admin/inc/head'); ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
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
                $period = getallperioddata();
				// echo "<pre>";
				// print_r($period);
				// echo "</pre>";
                $userlists = get_not_users();
				?>
                <style>
                    .bg-greenback{
                        font-size: 22px;
                        color : #fff;
                        text-align: center;
                        background-color: #1d9397;
                        padding: 2% 5%;
                    }
                    .bg-orangeback{
                        font-size: 22px;
                        color : #fff;
                        text-align: center;
                        background-color: #f38446;
                        padding: 2% 5%;
                    }
                </style>
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
                    
                    <nav aria-label="breadcrumb d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo base_url('periodcalendar');?>"><i class="bx bx-right-arrow-alt"></i>Calendars</a></li>
                        </ol>
                    </nav>

					<div class="card-body">
						<div class="container-fluid col-12">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="card radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Period Calendar</h6>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="card radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0">User Overview</h6>
                                                </div>
                                            </div>	
                                        </div>			
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            // echo "<pre>";
                                            // print_r($periods);
                                            // echo "</pre>";
                                            ?>
                                            <div class="bg-greenback" role=""><?php echo "<strong>".$next_date." Days</strong> left for Next Period";?></div>
                                            <div class="bg-orangeback" role="">
                                                <?php 
                                                if($ovulation<1){
                                                    echo 'Your Ovulation date passed already';
                                                }
                                                else
                                                {
                                                    echo $ovulation.' Days left for next Ovulation';
                                                }
                                                ?>
                                            </div>
                                            <br>
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <?php 
                                                if($user_data->usergender=='F')
                                                {
                                                    ?><img class="rounded-circle p-1 bg-primary" alt="user avatar" src="<?php echo base_url();?>/uploads/avatar/female-avatar-new2.jpg" width="110"><?php
                                                }
                                                else if($user_data->usergender=='M')
                                                {
                                                    ?><img class="rounded-circle p-1 bg-primary" alt="user avatar" src="<?php echo base_url();?>/uploads/avatar/male-avatar-new2.jpg" width="110"><?php
                                                }
                                                else
                                                {
                                                    ?><img class="rounded-circle p-1 bg-primary" alt="user avatar" src="<?php echo base_url();?>/uploads/avatar/avatar.jpg" width="110"><?php
                                                }
                                                ?>
                                                <div class="mt-3">
                                                    <h4><?php echo $user_data->userfname;?> </h4>
                                                    <!-- <p class="text-secondary mb-1">Full Stack Developer</p>
                                                    <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> -->
                                                    <!-- <button class="btn btn-primary">Disable</button> -->
                                                    <!-- <button class="btn btn-outline-primary">Message</button> -->
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0">Email</h6>
                                                    <span class="text-secondary"><?php echo $user_data->usermail;?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0">Phone</h6>
                                                    <span class="text-secondary"><?php echo $user_data->userphone;?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0">Gender</h6>
                                                    <span class="text-secondary"><?php echo ($user_data->usergender=='M')? "Male" : "Female";?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0">DOB</h6>
                                                    <span class="text-secondary"><?php echo date("d M, Y", strtotime($user_data->userdob));?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <h6 class="mb-0">Member Since</h6>
                                                    <span class="text-secondary"><?php echo date("d M, Y", strtotime($user_data->userregistered));?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
                <div class="card">
                    <div class="card-body">
						<div class="container-fluid col-12">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="card radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Period Notes</h6>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                        if(empty($period_note))
                                        {
                                            echo "No Period note submitted by the User";
                                        }
                                        else
                                        {
                                            // echo "<pre>";
                                            // print_r($period_note);
                                            // echo "</pre>";
                                            ?>
                                            <table id="example3" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Note Date</th>
                                                        <th>Note</th>
                                                        <th>Heavy Flow?</th>
                                                        <th>Added On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $i=1;
                                                        foreach($period_note as $pd)
                                                        {
                                                            echo "<tr>";
                                                                echo "<td>".$i."</td>";
                                                                echo "<td>".date("Y-m-d", strtotime($pd->note_date))."</td>";
                                                                echo "<td>".$pd->note."</td>";
                                                                echo "<td>";
                                                                    if($pd->flow=='Y'){ echo "Yes";} else { echo "No";}
                                                                echo "</td>";
                                                                echo "<td>".date("Y-m-d", strtotime($pd->added_on))."</td>";
                                                            echo "</tr>";
                                                            $i++;
                                                        }
                                                    ?>
                                                </body>
                                            </table>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="card radius-10">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Booking History</h6>
                                                </div>
                                            </div>	
                                        </div>			
                                    </div>
                                    <div>
                                        <?php
                                        if(empty($booking_history))
                                        {
                                            echo "No Booking has been made by this User";
                                        }
                                        else
                                        {
                                            // echo "<pre>";
                                            // print_r($booking_history);
                                            // echo "</pre>";
                                            ?>
                                            <table id="example3" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Booking ID</th>
                                                        <th>Centre</th>
                                                        <th>Booking Type</th>
                                                        <th>Booking Date</th>
                                                        <th>Booking Time</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $ii=1;
                                                        foreach($booking_history as $booking)
                                                        {
                                                            $user = getusername($booking->user_id);
                                                            if($booking->schedule_date)
                                                            {
                                                                if(strtotime('today')>strtotime($booking->schedule_date))
                                                                {
                                                                    $bookingclass = 'bg-primary';
                                                                    $style="background-color:#64523A; color:#fff;";
                                                                }
                                                                else
                                                                {
                                                                    if($booking->status==0)
                                                                    {
                                                                        $bookingclass = 'bg-primary';
                                                                        $style="color:#151511;";
                                                                    }
                                                                    if($booking->status==1)
                                                                    {
                                                                        $bookingclass = 'bg-primary';
                                                                        $style="background-color:#7CCFD3; color:#151511;";
                                                                    }
                                                                    if($booking->status==2)
                                                                    {
                                                                        $bookingclass = 'bg-warning';
                                                                        $style="background-color:#D2DCB3; color:#151511;";
                                                                    }
                                                                    if($booking->status==3)
                                                                    {
                                                                        $bookingclass = 'bg-default';
                                                                        $style="background-color:#9D90F2; color:#fff;";
                                                                    }
                                                                    if($booking->status==4)
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
                                                                if(strtotime('today')>strtotime($booking->booking_date))
                                                                {
                                                                    $bookingclass = 'bg-primary';
                                                                    $style="background-color:#64523A; color:#fff;";
                                                                }
                                                                else
                                                                {
                                                                    if($booking->status==0)
                                                                    {
                                                                        $bookingclass = 'bg-primary';
                                                                        $style="color:#151511;";
                                                                    }
                                                                    if($booking->status==1)
                                                                    {
                                                                        $bookingclass = 'bg-primary';
                                                                        $style="background-color:#7CCFD3; color:#151511;";
                                                                    }
                                                                    if($booking->status==2)
                                                                    {
                                                                        $bookingclass = 'bg-warning';
                                                                        $style="background-color:#D2DCB3; color:#151511;";
                                                                    }
                                                                    if($booking->status==3)
                                                                    {
                                                                        $bookingclass = 'bg-default';
                                                                        $style="background-color:#9D90F2; color:#fff;";
                                                                    }
                                                                    if($booking->status==4)
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
                                                            echo "<td>".$ii."</td>";
                                                            echo "<td>".$booking->id."</td>";
                                                             if($booking->centre_id==1)
                                                            {
                                                                echo "<td>Sentebale Health Advisor</td>";
                                                            }
                                                            else
                                                            {
                                                                echo "<td>".getcentreinitials($booking->centre_id)->centre_name."</td>";
                                                            }
                                                            echo "<td>";
                                                                if($booking->booking_type==0)
                                                                {
                                                                    echo "Not Assigned";
                                                                }
                                                                if($booking->booking_type==1)
                                                                {
                                                                    echo "Appointment Booking";
                                                                }
                                                                if($booking->booking_type==2)
                                                                {
                                                                    echo "Requesting a Call";
                                                                }
                                                                if($booking->booking_type==3)
                                                                {
                                                                    echo "Requesting Consultation";
                                                                }
                                                            echo "</td>";
                                                            echo "<td>".date("d M, Y", strtotime($booking->schedule_date))."</td>";
                                                            echo "<td>".$booking->booking_time."</td>";
                                                            echo "<td>";
                                                            if($booking->schedule_date)
                                                            {
                                                                if(strtotime('today')>strtotime($booking->schedule_date))
                                                                {
                                                                    echo "Expired";
                                                                }
                                                                else
                                                                {
                                                                    if($booking->status==0)
                                                                    {
                                                                        echo "Received";
                                                                    }
                                                                    if($booking->status==1)
                                                                    {
                                                                        echo "Booking in progress";
                                                                    }
                                                                    if($booking->status==2)
                                                                    {
                                                                        echo "Booked Slot";
                                                                    }
                                                                    if($booking->status==3)
                                                                    {
                                                                        echo "Rescheduled";
                                                                    }
                                                                    if($booking->status==4)
                                                                    {
                                                                        echo "Cancelled";
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                if(strtotime('today')>strtotime($booking->schedule_date))
                                                                {
                                                                    echo "Expired";
                                                                }
                                                                else
                                                                {
                                                                    if($booking->status==0)
                                                                    {
                                                                        echo "Received";
                                                                    }
                                                                    if($booking->status==1)
                                                                    {
                                                                        echo "Booking in progress";
                                                                    }
                                                                    if($booking->status==2)
                                                                    {
                                                                        echo "Booked Slot";
                                                                    }
                                                                    if($booking->status==3)
                                                                    {
                                                                        echo "Rescheduled";
                                                                    }
                                                                    if($booking->status==4)
                                                                    {
                                                                        echo "Cancelled";
                                                                    }
                                                                }
                                                            }                                            
                                                            echo "</td>";                                                                   
                                                            echo "</tr>";
                                                            $ii++;
                                                        }
                                                    ?>
                                                </body>
                                            </table>
                                            <?php
                                        }
                                        ?>
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
        
        function openperiodmodal(x)
        {
            //alert(x);
            $('#usercalender').modal('show');
            $.ajax({
                type: "POST",
                url: base_url+'CalendarController/getuserperioddetails',
                data: {uid: x},
                success: function(data){                    
                    $('#periodDetails').html(data);
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '<?php echo date("Y-m-t");?>',
            headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: '',
            timeZone: 'local',
            },
            events: <?php echo json_encode($periods);?>
        });

        calendar.render();
        });
    </script>
    <div class="modal fade" id="usercalender" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Period Calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="periodDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>