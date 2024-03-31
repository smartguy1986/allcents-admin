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
				// print_r($province);
				// echo "</pre>";
				?>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>ID</th>
										<th>City Name</th>
                                        <th>Province Name</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    foreach($cities as $city)
                                    {
                                        if($city->status==0)
                                        {
                                            $cityclass = 'bg-danger';
                                        }
                                        else
                                        {
                                            $cityclass = '';
                                        }

                                        echo "<tr class='".$cityclass."'>";
                                            echo "<td>".$city->RegionID."</td>";
                                            echo "<td>".$city->RegionName."</td>";
                                            echo "<td>";
                                            echo !empty($city->ProvinceID)? get_province_name($city->ProvinceID)->ProvinceName : '';
                                            echo "</td>";
                                            echo "<td>";
                                            if($this->session->userdata('logged_in_info')->userrole==1)
                                            {
                                                echo "<a href='javascript:void(0);' onclick='return editmycity(".$city->RegionID.",".$city->ProvinceID.");'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";   
                                                
                                                if($city->status==1)
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'region/disablecity/' . $city->RegionID; ?>" data-deletetext="Are you sure to disable this City?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."admin/region/disablecity/".$city->RegionID."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                                }
                                                else
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'region/enablecity/' . $city->RegionID; ?>" data-deletetext="Are you sure to enable this City?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."admin/region/enablecity/".$city->RegionID."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                                }
                                            }
                                            else
                                            {
                                                if($city->status=='1')
                                                {
                                                    echo "Active";
                                                }
                                                else
                                                {
                                                    echo "Disabled";
                                                }
                                            }
                                            echo "</td>";                                                                    
                                        echo "</tr>";
                                    }
                                    ?>
								</tbody>
								<tfoot>
									<tr>
                                        <th>ID</th>
										<th>City Name</th>
                                        <th>Province Name</th>
                                        <th>Action</th>
									</tr>
								</tfoot>
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
    </script>
    <div class="modal fade" id="editCityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editcity"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>