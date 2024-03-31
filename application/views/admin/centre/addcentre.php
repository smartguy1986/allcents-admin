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
                            <h5 class="mb-0 text-primary"><?php echo $this->lang->line('centreadd1');?></h5>
                        </div>
                        <hr>
                        <?php
                        //echo "<pre>";
                        $cat = get_category_list();
                        // print_r($cat);
                        // echo "</pre>";
                        ?>
                        <form class="row g-3" method="post" action="<?php echo base_url('centres/savecentre');?>" onsubmit="return formValidate2();"  enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Banner Image&nbsp;
                                <i class='bx bxs-info-circle' style="color:#F38446;" data-toggle="tooltip" data-placement="top" title="Make sure to upload banner image of size 1400px X 600px"></i></label>
                                <input type="file" class="form-control text-val" id="banner_image" name="banner_image" data-error="Please Upload Banner Image">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Logo&nbsp;
                                <i class='bx bxs-info-circle' style="color:#F38446;" data-toggle="tooltip" data-placement="top" title="Make sure to upload logo image of size 300px X 300px"></i></label>
                                <input type="file" class="form-control text-val" id="centre_logo" name="centre_logo" data-error="Please Upload Logo">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Name</label>
                                <input type="text" class="form-control text-val" id="centre_name" name="centre_name" data-error="Please Enter Centre name">
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Centre Email</label>
                                <input type="text" class="form-control text-em-val" id="centre_email" name="centre_email" data-error2="Please Enter Centre Email">
                                <label></label>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFirstName" class="form-label">Centre Bio</label>
                                <textarea type="text" class="form-control topictextarea" id="topictextarea" name="centre_bio"></textarea>
                                <label></label>
                            </div>
                            <div class="col-md-1">       
                                <label for="inputEmail" class="form-label">&nbsp;</label>                         
                                <input type="text" class="form-control" id="country_code" name="country_code" value="+27" readonly>
                            </div>
                            <div class="col-md-5">                                
                                <label for="inputEmail" class="form-label">Landline number</label>
                                <input type="text" class="form-control text-val text-ph-val" id="centre_phone" name="centre_phone" data-error="Please Enter Landline Number" data-error2="Please Enter Valid Phone Number">
                                <!-- <input type="text" class="form-control text-val text-ph-val" id="centre_phone" name="centre_phone" data-error="Please Enter Phone Number" data-error2="Please Enter Valid Phone Number"> -->
                                <label></label>
                            </div>
                            <div class="col-md-6">                                
                                <label for="inputEmail" class="form-label">Cell Phone number</label>
                                <input type="text" class="form-control text-val text-ph-val" id="centre_fax" name="centre_fax" data-error="Please Enter Cell Phone Number" data-error2="Please Enter Valid Phone Number">
                                <!-- <input type="text" class="form-control" id="centre_fax" name="centre_fax"> -->
                                <label></label>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Province</label>
                                <select id="centre_province" class="form-select text-dr-val" name="centre_province" required onchange="return populatecity(this.value);" >
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
                                <label for="inputEmail" class="form-label">City</label>
                                <div id="showcity">
                                    <select id="centre_city" class="form-select" name="centre_city">
                                        <option value="">Choose...</option>                                        
                                    </select>
                                </div>
                                <label></label>
                            </div>
                            
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Address</label>
                                <textarea class="form-control text-ar-val" id="centre_address" rows="3" name="centre_address" data-error2="Please enter address"></textarea>
                                <label></label>
                                <hr>
                                <label for="inputEmail" class="form-label">Contact Person</label>
                                <input type="text" class="form-control text-val" id="centre_contact" name="centre_contact" data-error="Please Enter Contact Person name">
                                <label></label>
                                <hr>
                                <label for="inputEmail" class="form-label">Services Offered</label>
                                <select class="form-control multiple-select" name="centre_category[]" data-placeholder="Choose anything" multiple="multiple">
                                    <?php
                                    foreach($cat as $category)
                                    {
                                        echo "<option value='".$category->id."'>";
                                        echo ($category->cat_name_en!='')? $category->cat_name_en : "";
                                        echo ($category->cat_name_zu!='')? " / ".$category->cat_name_zu : "";
                                        echo ($category->cat_name_st!='')? " / ".$category->cat_name_st : "";
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                                <!-- <input type="text" class="form-control text-val" id="centre_contact" name="centre_contact" data-error="Please Enter Contact Person name"> -->
                                <label></label>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Operating Hours</label>
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
                                <label></label>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary px-5" value="<?php echo $this->lang->line('button2');?>">
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
			<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">Sentebale Health App.</a></p>
		</footer>
	</div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
    $(document).ready(function() {
        var prv = $('#centre_province').val();
        populatecity(prv);
    });
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

    function formValidate2()
    {
        //alert('submitted');

        $('.field-error').remove();
        var value = '';
        var error_html = '';
        var error_text;
        var flag = '1';

        $(".text-val").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error');
            console.log(value);
            if (value.trim() == '') {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        $(".text-ph-val").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error2');
            console.log(value);
            var phone_pattern = /^[0-9]*$/;
            if (phone_pattern.test(value) == false) {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
            // else if(value.length<10) 
            // {
            //     flag = '0';
            //     error_html = '<span class="field-error">Please enter minimum 10 Digits</span>';
            //     $(this).next('label').after(error_html);
            // }
            // else
            // {

            // }
        });

        $(".text-em-val").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error2');
            console.log(value);
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            if (reg.test(value) == false) {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        $(".text-ar-val").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error2');
            console.log(value);
            if (value.length < 1) {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        $(".text-dr-val").each(function () {
            value = $(this).val();
            error_text = $(this).attr('data-error2');
            console.log(value);
            if (value.length < 1) {
                flag = '0';
                error_html = '<span class="field-error">' + error_text + '</span>';
                $(this).next('label').after(error_html);
            }
        });

        if(flag=='0')
        {
            return false;
        }
        else
        {
            var r = confirm('Are you happy with all the information you have submitted? If not press cancel and double check before submitting!');
            if (r == true) {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
	</script>
    </body>
</html>