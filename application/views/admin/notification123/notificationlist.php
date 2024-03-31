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
                $userlists = get_not_users();
				?>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bx-building-house me-1 font-22 text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Send to Selected User</h5>
                                </div>
                                <hr>
                                <div class="row">
                                    <form method="post" action="<?php echo base_url('notifications/send_gcm');?>" enctype="multipart/form-data">                                            
                                        <div class="mb-3">
                                            <label for="msg_title" class="form-label">Message Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                            <!-- <input type="hidden" id="redId" name="regId" value="ebZ3xlP8QY6xxTXpVGT5vb:APA91bFJdlnyyt6lWdRYcJIHFLHifLS93SHs5mwXmddNE7iq-PiOHySwE-z2mXX4uwz8io-VLNAQiwao6R_ECgJIZtQW6g-qtddD_miXFTardoVm-43unqsdIv3KZ1cgE7g04YhP2HEw"> -->
                                        </div>                                            
                        
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Notification Message</label>
                                            <input type="text" class="form-control" id="message" name="message" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="include_image" class="form-label">Include Image</label>
                                            <input name="include_image" id="include_image" type="checkbox"> Yes
                                        </div>

                                        <div class="mb-3">
                                            <select class="form-control" name="regId">
                                            <?php
                                                echo "<option value=''>Select User</option>";
                                                foreach($userlists as $ul)
                                                {
                                                    echo "<option value='".$ul->deviceid."'>".$ul->userfname."(".$ul->usermail." / ".$ul->devicetype.")</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>  
                                        <div class="mb-3">
                                            <input type="hidden" name="push_type" value="individual"/>
                                            <input name="send_msg" class="btn btn-primary" id="send_msg" type="submit" value="Send Message">
                                        </div>                                   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bx-building-house me-1 font-22 text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Send Health Centre Selected User</h5>
                                </div>
                                <hr>
                                <div class="row">
                                    <form method="post" action="<?php echo base_url('notifications/send_gcm');?>" enctype="multipart/form-data">                                            
                                        <div class="mb-3">
                                            <label for="msg_title" class="form-label">Message Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                            <!-- <input type="hidden" id="redId" name="regId" value="ebZ3xlP8QY6xxTXpVGT5vb:APA91bFJdlnyyt6lWdRYcJIHFLHifLS93SHs5mwXmddNE7iq-PiOHySwE-z2mXX4uwz8io-VLNAQiwao6R_ECgJIZtQW6g-qtddD_miXFTardoVm-43unqsdIv3KZ1cgE7g04YhP2HEw"> -->
                                        </div>                                            
                        
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Notification Message</label>
                                            <input type="text" class="form-control" id="message" name="message" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="include_image" class="form-label">Include Image</label>
                                            <input name="include_image" id="include_image" type="checkbox"> Yes
                                        </div>

                                        <div class="mb-3">
                                            <?php $centrelist = health_centres(); /*echo "<pre>"; print_r($centrelist); echo "</pre>";*/?>
                                            <select class="form-control" name="centrelist">
                                            <?php
                                                echo "<option value=''>Select Health Centre</option>";
                                                foreach($centrelist as $ul)
                                                {
                                                    echo "<option value='".$ul->id."'>".$ul->centre_name."</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>  

                                        <div class="mb-3">
                                            <select class="form-control" name="regId">
                                            <?php
                                                echo "<option value=''>Select User</option>";
                                                foreach($userlists as $ul)
                                                {
                                                    echo "<option value='".$ul->deviceid."'>".$ul->userfname."(".$ul->usermail." / ".$ul->devicetype.")</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>  
                                        <div class="mb-3">
                                            <input type="hidden" name="push_type" value="individual"/>
                                            <input name="send_centre_msg" class="btn btn-primary" id="send_msg" type="submit" value="Send Message">
                                        </div>                                   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bx-building-house me-1 font-22 text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Open Profile of Selected User</h5>
                                </div>
                                <hr>
                                <div class="row">
                                    <form method="post" action="<?php echo base_url('notifications/send_gcm');?>" enctype="multipart/form-data">                                            
                                        <div class="mb-3">
                                            <label for="msg_title" class="form-label">Message Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                            <!-- <input type="hidden" id="redId" name="regId" value="ebZ3xlP8QY6xxTXpVGT5vb:APA91bFJdlnyyt6lWdRYcJIHFLHifLS93SHs5mwXmddNE7iq-PiOHySwE-z2mXX4uwz8io-VLNAQiwao6R_ECgJIZtQW6g-qtddD_miXFTardoVm-43unqsdIv3KZ1cgE7g04YhP2HEw"> -->
                                        </div>                                            
                        
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Notification Message</label>
                                            <input type="text" class="form-control" id="message" name="message" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="include_image" class="form-label">Include Image</label>
                                            <input name="include_image" id="include_image" type="checkbox"> Yes
                                        </div>

                                        <div class="mb-3">
                                            <select class="form-control" name="regId">
                                            <?php
                                                echo "<option value=''>Select User</option>";
                                                foreach($userlists as $ul)
                                                {
                                                    echo "<option value='".$ul->deviceid."'>".$ul->userfname."(".$ul->usermail." / ".$ul->devicetype.")</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>  
                                        <div class="mb-3">
                                            <input type="hidden" name="push_type" value="individual"/>
                                            <input name="send_profile_msg" class="btn btn-primary" id="send_msg" type="submit" value="Send Message">
                                        </div>                                   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bx-building-house me-1 font-22 text-primary"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary">Send Booking History Selected User</h5>
                                </div>
                                <hr>
                                <div class="row">
                                    <form method="post" action="<?php echo base_url('notifications/send_gcm');?>" enctype="multipart/form-data">                                            
                                        <div class="mb-3">
                                            <label for="msg_title" class="form-label">Message Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                            <!-- <input type="hidden" id="redId" name="regId" value="ebZ3xlP8QY6xxTXpVGT5vb:APA91bFJdlnyyt6lWdRYcJIHFLHifLS93SHs5mwXmddNE7iq-PiOHySwE-z2mXX4uwz8io-VLNAQiwao6R_ECgJIZtQW6g-qtddD_miXFTardoVm-43unqsdIv3KZ1cgE7g04YhP2HEw"> -->
                                        </div>                                            
                        
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Notification Message</label>
                                            <input type="text" class="form-control" id="message" name="message" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="include_image" class="form-label">Include Image</label>
                                            <input name="include_image" id="include_image" type="checkbox"> Yes
                                        </div>

                                        <div class="mb-3">
                                            <select class="form-control" name="regId">
                                            <?php
                                                echo "<option value=''>Select User</option>";
                                                foreach($userlists as $ul)
                                                {
                                                    echo "<option value='".$ul->deviceid."'>".$ul->userfname."(".$ul->usermail." / ".$ul->devicetype.")</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>  
                                        <div class="mb-3">
                                            <input type="hidden" name="push_type" value="individual"/>
                                            <input name="send_booking_msg" class="btn btn-primary" id="send_msg" type="submit" value="Send Message">
                                        </div>                                   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Device</th>
                                        <th>Status</th>
                                        <th>Sent At</th>
                                        <!-- <th>Response Code</th> -->
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    // echo "<pre>";
                                    // print_r($notice_data);
                                    // echo "</pre>";
                                    foreach($notice_data as $notf)
                                    {
                                        
                                        $notice = json_decode($notf->not_response);
                                        // echo "<pre>";
                                        // print_r($notice);
                                        // echo "</pre>";
                                        echo "<td>";
                                            echo $notf->id;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $notf->not_type;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $notf->not_title;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $notf->not_msg;
                                        echo "</td>";

                                        echo "<td>";
                                            echo $notf->devicetype;
                                        echo "</td>";

                                        echo "<td>";
                                            if($notice->success==1){ echo "Success";}
                                            if($notice->failure==1){ echo "Failure";}
                                        echo "</td>";

                                        echo "<td>";
                                            echo date("jS M, Y", strtotime($notf->not_generate_time));
                                        echo "</td>";

                                        // echo "<td>";
                                        //     echo "msg-id: ";
                                        //     ($notice->results[0]->message_id) ? $notice->results[0]->message_id : '';
                                        // echo "</td>";
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