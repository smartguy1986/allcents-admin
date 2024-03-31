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
				// print_r($user_info);
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
                                        <th>Name</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Request</th>
                                        <!-- <th>Response</th> -->
                                        <th>IP</th>
                                        <th>Time</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $i=1;
                                    foreach($api_calls as $apis)
                                    {
                                        echo "<tr>";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$apis->api_name."</td>";
                                        echo "<td>".$apis->api_method."</td>";
                                        echo "<td>";
                                            if($apis->api_status==1)
                                            {
                                                echo "Success";
                                            }
                                            else
                                            {
                                                echo "Failure / Empty";
                                            }
                                        echo "</td>";
                                        echo "<td><code>".$apis->api_data."</code></td>";
                                        // echo "<td><code>".$apis->api_response."</code></td>";
                                        echo "<td>".$apis->ip_addr."</td>";
                                        echo "<td>".date("dS M, Y - H:i:s", strtotime($apis->call_time))."</td>";
                                        echo "</tr>";
                                        $i++;
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
			<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AAC - African Apostolic Church</a></p>
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
    </body>
</html>