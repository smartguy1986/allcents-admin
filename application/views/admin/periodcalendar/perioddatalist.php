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
                $period = getallperioddata();
				// echo "<pre>";
				// print_r($period);
				// echo "</pre>";
                $userlists = get_not_users();
				?>
                <style>
                    /* .bx{
                        font-size: 22px;
                        color : #f38446;
                        text-align: center;
                    } */
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
					<div class="card-body">
						<div class="table-responsive">
							<table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Last Date</th>
                                        <th>Cycle Days</th>
                                        <th>Menstrual Type</th>
                                        <th>QnA</th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <!-- <th>Details</th> -->
									</tr>
								</thead>
								<tbody>
                                    <?php
                                        foreach($period as $pd)
                                        {
                                            if(isset(getusername($pd->user_id)->userfname))
                                            {
                                                echo "<tr>";
                                                    echo "<td>".$pd->id."</td>";
                                                    echo "<td><a href='".base_url('/periodcalendar/details/'.$pd->user_id)."'>".getusername($pd->user_id)->userfname."</a></td>";
                                                    echo "<td>".$pd->last_day."</td>";
                                                    echo "<td>".$pd->cycle_days."</td>";
                                                    echo "<td>";
                                                        if($pd->menstrual_type==0) { echo "Regular"; }
                                                        if($pd->menstrual_type==1) { echo "Irregular"; }
                                                        if($pd->menstrual_type==2) { echo "Heavy"; }
                                                        if($pd->menstrual_type==3) { echo "Clot Present"; }
                                                    echo "</td>";
                                                    echo "<td><strong>".$pd->question1."</strong><br>".$pd->answer1."</td>";
                                                    echo "<td>";
                                                        if($pd->status==1) { echo "Active";}
                                                        else { echo "Inactive";}
                                                    echo "</td>";
                                                    echo "<td>".date("Y-m-d", strtotime($pd->added_on))."</td>";
                                                    // echo "<td><i class='bx bx-calendar' onclick='openperiodmodal(".$pd->user_id.")'></i></td>";
                                                echo "</td>";
                                            }
                                        }
                                    ?>
                                </body>
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
		<!--Start Back To Top Button--> <a href="javaScript:void(0);" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
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