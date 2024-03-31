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
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bx-building-house me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Add Centres</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($province);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('centres/savecentre');?>" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Banner Image</label>
                                <input type="file" class="form-control text-r" id="banner_image" name="banner_image" required oninvalid="this.setCustomValidity('Please Upload Banner Image')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Logo</label>
                                <input type="file" class="form-control text-r" id="centre_logo" name="centre_logo" required oninvalid="this.setCustomValidity('Please Upload Logo')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Name</label>
                                <input type="text" class="form-control text-r" id="centre_name" name="centre_name" required oninvalid="this.setCustomValidity('Please Enter Centre name')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Email</label>
                                <input type="email" class="form-control text-em" id="centre_email" name="centre_email" required oninvalid="this.setCustomValidity('Please Enter Centre Email')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Centre Bio</label>
                                <textarea type="text" class="form-control text-r topictextarea" id="topictextarea" name="centre_bio"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
                                <label for="inputEmail" class="form-label">Phone No</label>
                                <input type="text" class="form-control text-r text-ph" id="centre_phone" name="centre_phone" required oninvalid="this.setCustomValidity('Please Enter Valid Phone Number')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
                                <label for="inputEmail" class="form-label">Fax No</label>
                                <input type="text" class="form-control" id="centre_fax" name="centre_fax">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Province</label>
                                <select id="centre_province" class="form-select" name="centre_province" required oninvalid="this.setCustomValidity('Please Select Province')" onchange="return populatecity(this.value)" oninput="setCustomValidity('')">
                                    <option value="">Choose...</option>
                                    <?php
                                    foreach($province as $state)
                                    {
                                        echo "<option value='".$state->ProvinceID."'>".$state->ProvinceName."</option>";
                                    }
                                    ?>
                                </select>
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">Sentebale Health App.</a></p>
                                <label for="inputEmail" class="form-label">City</label>
                                <div id="showcity">
                                    <select id="centre_city" class="form-select" name="centre_city" data-error2="Please Select City">
                                        <option value="">Choose...</option>                                        
                                    </select>
                                </div>
                                <label></label>
                            </div>
                            
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Address</label>
                                <textarea class="form-control text-r" id="centre_address" rows="3" name="centre_address" required oninvalid="this.setCustomValidity('Please enter address')" oninput="setCustomValidity('')"></textarea>
                                <label></label>
                                <hr>
                                <label for="inputEmail" class="form-label">Contact Person</label>
                                <input type="text" class="form-control text-r" id="centre_contact" name="centre_contact" required oninvalid="this.setCustomValidity('Please Enter Contact Person name')" oninput="setCustomValidity('')">
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Weekly Timing</label>
                                <div class="form-control">
                                    <?php
                                    $weekarray = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');                 
                                    for($i=0; $i<7; $i++)
                                    {
                                        ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <?php if($i==0){ echo "<label class='form-label'>Day</label>";}?>   
                                                <input type="text" class="form-control" name="day[]" value="<?php echo $weekarray[$i];?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <?php if($i==0){ echo "<label class='form-label'>Start Time</label>";}?>   
                                                <?php
                                                echo "<select name='start_time[]' class='form-control'>";
                                                for($st=0; $st<24; $st++)
                                                {
                                                    echo "<option value='".$st.":00'>".$st.":00</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                            <div class="col-3">
                                                <?php if($i==0){ echo "<label class='form-label'>Closing Time</label>";}?>   
                                                <?php
                                                echo "<select name='closing_time[]' class='form-control'>";
                                                for($ct=0; $ct<24; $ct++)
                                                {
                                                    echo "<option value='".$ct.":00'>".$ct.":00</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" name="savecentre" class="btn btn-primary px-5" value="Save">
                            </div>
                        </form>
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
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
    function populatecity(x)
    {
        // alert(x);
        $.ajax({
            type: "POST",
            url: base_url+'centres/getcity',
            data: {pid: x},
            success: function(data){
                $('#showcity').html(data);
            },
            error: function(err) {
                $('#showcity').html(err);
            }
        });
        //rerun();
        return false;
    }
	</script>
    </body>
</html>