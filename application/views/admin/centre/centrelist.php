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
        .myclass {
            background: #fff;
            border-radius: 5px;
            margin-top: -10%;
            padding: 2%;
        }
            </style>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<?php
				// echo "<pre>";
				// print_r($centres);
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
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>ID</th>
										<th>Logo</th>
                                        <th>Name</th>
										<th>Address</th>
										<th>Province</th>
										<th>City</th>
                                        <!-- <th>Latitude</th>
                                        <th>Longitude</th> -->
										<th>Email</th>
										<th>Phone</th>
										<th>Contact Person</th>
                                        <th>Status</th>
										<th>Created On</th>
										<th>Last Updated</th>
                                        <th>Column A</th>
                                        <th>Column B</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    foreach($centres as $centre)
                                    {
                                        if($centre->status==0)
                                        {
                                            $centreclass = 'bg-danger';
                                        }
                                        else
                                        {
                                            $centreclass = 'bg-primary';
                                        }

                                        echo "<tr>";
                                            echo "<td>".$centre->id."</td>";
                                            echo "<td>";
                                                if($centre->centre_logo)
                                                {
                                                    echo "<a href='javascript:void(0);' onclick='openCentreModal(".$centre->id.");'><img class='rounded-circle p-1 ".$centreclass."' src='".base_url()."uploads/centre/logo/".$centre->centre_logo."' width='75px'></a>";
                                                }
                                                else
                                                {
                                                    echo "<a href='javascript:void(0);' onclick='openCentreModal(".$centre->id.");'><img class='rounded-circle p-1 ".$centreclass."' alt='user avatar' src='".base_url()."uploads/defaults/default_logo.jpg' width='75px'></a>";
                                                }
                                            echo "</td>";
                                            echo "<td><a href='javascript:void(0);' onclick='openCentreModal(".$centre->id.");'>".$centre->centre_name."</a></td>";
                                            echo "<td>".$centre->centre_address."</td>";
                                            echo "<td>".get_province_name($centre->centre_province)->ProvinceName."</td>";
                                            echo "<td>".city_name($centre->centre_city)->RegionName."</td>";
                                            // echo "<td>".$centre->centre_lat."</td>";
                                            // echo "<td>".$centre->centre_long."</td>";
                                            echo "<td>".$centre->centre_email."</td>";
                                            echo "<td>".$centre->centre_phone."</td>";
                                            echo "<td>".$centre->centre_contact."</td>";
                                            
                                            echo "<td>";
                                                if($centre->status=='1')
                                                {
                                                    echo $this->lang->line('status1');
                                                }
                                                if($centre->status=='0')
                                                {
                                                    echo $this->lang->line('status2');
                                                }
                                            echo "</td>";
                                            echo "<td>".date('d-M-Y', strtotime($centre->added_on))."</td>";
                                            echo "<td>".date('d-M-Y', strtotime($centre->updated_on))."</td>"; 
                                            echo "<td>";
                                            if($centre->column_a==0)
                                            {
                                                echo "<input type='checkbox' name='columnA' id='".$centre->id."' onchange='return restrict_columnA(".$centre->id.");'><div id='resp-".$centre->id."'></div>";
                                            }
                                            else
                                            {
                                                echo "<input type='checkbox' name='columnA' id='".$centre->id."' checked onchange='return restrict_columnA(".$centre->id.");'><div id='resp-".$centre->id."'></div>";
                                            }
                                            echo "</td>";
                                            echo "<td>";
                                            if($centre->column_b==0)
                                            {
                                                echo "<input type='checkbox' name='columnB' id='".$centre->id."' onchange='return restrict_columnB(".$centre->id.");'><div id='resp-".$centre->id."'></div>";
                                            }
                                            else
                                            {
                                                echo "<input type='checkbox' name='columnB' id='".$centre->id."' checked onchange='return restrict_columnB(".$centre->id.");'><div id='resp-".$centre->id."'></div>";
                                            }
                                            echo "</td>";  
                                            echo "<td>";
                                            if($this->session->userdata('logged_in_info')->userrole!='1')
                                            {
                                                echo '';
                                            }
                                            else
                                            {
                                                echo "<a href='".base_url()."centres/edit/".$centre->id."'><i class='bx bxs-edit'></i></a>&nbsp;";          
                                            }
                                            if($this->session->userdata('logged_in_info')->userrole==1)
                                            {
                                                if($centre->status==1)
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'centres/disable/' . $centre->id; ?>" data-deletetext="Are you sure to disable this centre?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."admin/centres/disable/".$centre->id."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                                }
                                                else
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'centres/enable/' . $centre->id; ?>" data-deletetext="Are you sure to enable this centre?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."admin/centres/enable/".$centre->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                                }                                                    
                                            }
                                            echo "</td>";                                                                    
                                        echo "</tr>";
                                    }
                                    ?>
								</tbody>
								<!-- <tfoot>
                                    <tr>
                                        <th>ID</th>
										<th>Logo</th>
                                        <th>Name</th>
										<th>Address</th>
										<th>Region</th>
										<th>City</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Contact Person</th>
                                        <th>Status</th>
										<th>Created On</th>
										<th>Last Updated</th>
                                        <th>Action</th>
									</tr>
								</tfoot> -->
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
        function openCentreModal(x){
            //alert(x);
            $.ajax({
                type: "POST",
                url: base_url+'centres/details',
                data: {cid: x},
                success: function(data){
                    var response = $.parseJSON(data);
                    $('#centreModal').modal('show');
                    //alert(response.centre_banner);
                    if(response.centre_banner)
                    {
                        $('.centrebanner').attr('src', base_url+'uploads/centre/banner/'+response.centre_banner);
                    }
                    else
                    {
                        $('.centrebanner').attr('src', base_url+'uploads/defaults/default_banner.jpg');
                    }
                    if(response.centre_logo)
                    {
                        $('.centre_logo').attr('src', base_url+'uploads/centre/logo/'+response.centre_logo);
                    }
                    else
                    {
                        $('.centre_logo').attr('src', base_url+'uploads/defaults/default_logo.jpg');
                    }
                    $('.centretitle').html(response.centre_name);
                    $('.centrebio').html(response.centre_bio);
                    $('.centrecontact').html('Contact Person: '+response.centre_contact);
                    $('.centrephone').html('Phone: '+response.centre_phone);
                    $('.centrefax').html('Fax: '+response.centre_fax);
                    $('.centreemail').html('Email: '+response.centre_email);
                    $('.centreaddress').html('Address: '+response.centre_address);
                    $.ajax({
                        type: "POST",
                        url: base_url+'centres/getprovincename',
                        data: {pid: response.centre_province},
                        success: function(data2){
                            $('.centreprovince').html('Province: '+data2);
                        }
                    });   
                    $.ajax({
                        type: "POST",
                        url: base_url+'centres/getcityname',
                        data: {cid: response.centre_city},
                        success: function(data3){
                            $('.centrecity').html('City: '+data3);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: base_url+'centres/showtiming',
                        data: {show: response.id},
                        success: function(data4){
                            $('.centretiming').html(data4);
                        }
                    });
                },
                error: function(err) {
                    $('#centreModal').modal('show');
                    $('#modalcontent').html(err);
                }
            });
        }

        $('#deleteModal').on('show.bs.modal', function (event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('deletelink');
            var mytext = $(event.relatedTarget).data('deletetext');
            //alert(myVal);
            $("#confirmBtndel").attr("href", myValid);
            $("#deletetext").text(mytext);
        });

        function restrict_columnA(x)
        {
            //console.log('restrict');
            //alert(x);
            $.ajax({
                url:'<?php echo base_url();?>centre/restrict_columna',
                method: 'post',
                data: {centreid: x},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    if(response)
                    {
                        alert(response);
                    } 
                }
            });
        }

        function restrict_columnB(x)
        {
            //console.log('restrict');
            //alert(x);
            $.ajax({
                url:'<?php echo base_url();?>centre/restrict_columnb',
                method: 'post',
                data: {centreid: x},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    if(response)
                    {
                        alert(response);
                    } 
                }
            });
        }
    </script>
    <div class="modal fade" id="centreModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Centre Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalcontent">                        
                    </div>
                    <div class="col">
						<div class="card mb-3">
							<img src="" class="card-img-top centrebanner" alt="...">
							<div class="card-body">
                                <div class="row g-0 myclass">
                                    <div class="col-md-4">
                                        <img src="" alt="..." class="card-img centre_logo">
                                        <div class="card-body">
                                            <p class="card-text centrecontact"></p>
                                            <p class="card-text centrephone"></p>
                                            <p class="card-text centrefax"></p>
                                            <p class="card-text centreemail"></p>
                                            <p class="card-text centreaddress"></p>
                                            <p class="card-text centreprovince"></p>
                                            <p class="card-text centrecity"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title centretitle"></h5>
                                            <p class="card-text centrebio"></p>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <table class="table mb-0 table-striped">
									<thead>
										<tr>
											<th scope="col">Day</th>
											<th scope="col">Opening Time</th>
											<th scope="col">Closing Time</th>
										</tr>
									</thead>
									<tbody class="centretiming">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>