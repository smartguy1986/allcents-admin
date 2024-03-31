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
                            <h5 class="mb-0 text-primary">Edit Category</h5>
                        </div>
                        <hr>
                        <?php
                        // echo "<pre>";
                        // print_r($categorydetails);
                        // echo "</pre>";
                        ?>
                        <form class='row g-3' method='post' action='<?php echo base_url('categories/update');?>' enctype='multipart/form-data'>
                            <input type='hidden' name='cid' value='<?php echo $categorydetails->id;?>'>
                            <div class='col-md-12'>
                                <label for='cat_name' class='form-label'>Category Name English</label>
                                <input type='text' class='form-control' id='cat_name' name='cat_name' value='<?php echo $categorydetails->cat_name;?>' required>
                            </div>
                             
                            <div class='col-md-12'>
                                <label for='cat_desc_en' class='form-label'>Category Description</label>
                                <textarea class="form-control text-ar-topic topictextarea" id="topictextarea" name="cat_desc" data-error2="Please Enter English Description"></textarea>
                            </div>
                            <div class='col-12'>
                                <input type='submit' class='btn btn-primary px-5' value='Update' name='addcat'>
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
			<p class="mb-0">Copyright © <?php echo date("Y");?>. All right reserved by <a href="https:www.allcents.tech" target="_blank">AllCents App.</a></p>
		</footer>
	</div>
    <?php $this->view('admin/inc/foot'); ?>
    </body>
</html>