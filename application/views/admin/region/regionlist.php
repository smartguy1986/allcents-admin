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
					<div class="card-body" id="regionTable">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>ID</th>
										<th>Province Name</th>
                                        <th>Geo Restrict</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    foreach($province as $region)
                                    {
                                        if($region->status==0)
                                        {
                                            $regionclass = 'bg-danger';
                                        }
                                        else
                                        {
                                            $regionclass = '';
                                        }

                                        echo "<tr class='".$regionclass."'>";
                                            echo "<td>".$region->ProvinceID."</td>";
                                            echo "<td>".$region->ProvinceName."</td>";
                                            if($region->geo_restriction==0)
                                            {
                                                echo "<td><input type='checkbox' name='geo_rest' id='".$region->ProvinceID."' onchange='return restrict_region(".$region->ProvinceID.");'><div id='resp-".$region->ProvinceID."'></div></td>";
                                            }
                                            else
                                            {
                                                echo "<td><input type='checkbox' name='geo_rest' id='".$region->ProvinceID."' checked onchange='return restrict_region(".$region->ProvinceID.");'><div id='resp-".$region->ProvinceID."'></div></td>";
                                            }                                            
                                            echo "<td>";
                                            if($this->session->userdata('logged_in_info')->userrole==1)
                                            {
                                                echo "<a href='javascript:void(0);' onclick='return editmyprovince(".$region->ProvinceID.");'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";    
                                                
                                                if($region->status==1)
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'region/disableprovince/' . $region->ProvinceID; ?>" data-deletetext="Are you sure to disable this Region?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."region/disableprovince/".$region->ProvinceID."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                                }
                                                else
                                                {
                                                    ?>
                                                    |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'region/enableprovince/' . $region->ProvinceID; ?>" data-deletetext="Are you sure to enable this Region?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                                    <?php
                                                    //echo "|&nbsp;<a href='".base_url()."region/enableprovince/".$region->ProvinceID."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                                }

                                            }
                                            else
                                            {
                                                if($region->status=='1')
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
										<th>Province Name</th>
                                        <th>Geo Restrict</th>
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

        function restrict_region(x)
        {
            //console.log('restrict');
            //alert(x);
            $.ajax({
                url:'<?php echo base_url();?>region/restrict_region',
                method: 'post',
                data: {provinceid: x},
                dataType: 'json',
                success: function(response){
                    console.log(response); 
                    $('#resp-'+x).text(response);       
                }
            });
        }

    </script>
    <div class="modal fade" id="editRegionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editregion"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>