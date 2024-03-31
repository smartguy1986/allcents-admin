<!--end wrapper-->
<!--start switcher-->

<!--end switcher-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>resources/admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script> -->
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- <script src="<?php echo base_url(); ?>resources/admin/assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/chartjs/js/Chart.extension.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.js" integrity="sha512-Cv3WnEz5uGwmTnA48999hgbYV1ImGjsDWyYQakowKw+skDXEYYSU+rlm9tTflyXc8DbbKamcLFF80Cf89f+vOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- <script src="<?php echo base_url(); ?>resources/admin/assets/js/index.js"></script> -->

<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="<?php echo base_url(); ?>resources/admin/assets/plugins/select2/js/select2.min.js"></script>

<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->

<script>
    $(document).ready(function() {
        $('.tabledata').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print'
            ],
            stateSave: true,
        });
    });
    $(document).ready(function() {
        $('#example').DataTable({
            "bSort": true,
            stateSave: true,
        });
    });
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            select: true,
            ordering: true,
            "bSort": true,
            stateSave: true
        });

        table.buttons().container().appendTo('#example2_wrapper');

        var table = $('#example3').DataTable({
            "aaSorting": [],
            stateSave: true,
            //buttons: [ 'excel']
        });

        table.buttons().container().appendTo('#example3_wrapper');
    });
</script>
<script>
    $('.multiple-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
</script>
<!--app JS-->
<script src="<?php echo base_url(); ?>resources/admin/assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/js/customfunc.js"></script>
<script src="<?php echo base_url(); ?>resources/admin/assets/js/form.validation.js"></script>

<!-- ============================= Modals =============================== -->
<div class="modal fade" id="addRegionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Province</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('region/add'); ?>">
                    <div class="col-md-6">
                        <label for="provincename" class="form-label">Province Name</label>
                        <input type="text" class="form-control text-r" id="provincename" name="provincename" required>
                    </div>

                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add Province" name="addregion">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('region/addcity'); ?>">
                    <div class="col-md-6">
                        <label for="cityname" class="form-label">City Name</label>
                        <input type="text" class="form-control text-r" id="cityname" name="cityname" required>
                    </div>
                    <div class="col-md-6">
                        <?php $province_list = get_province_list(); ?>
                        <label for="cityname" class="form-label">Province</label>
                        <select class="form-control text-dr" name="cityregion" required>
                            <?php
                            foreach ($province_list as $province) {
                                echo "<option value='" . $province->ProvinceID . "'>" . $province->ProvinceName . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addcity">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('categories/add'); ?>" onsubmit="return formValidatecat();" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="cat_name_en" class="form-label">Category Name </label>
                        <input type="text" class="form-control text-val-cat" id="cat_name_en" name="cat_name" data-error="Please Enter name">
                        <label></label>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addcat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addNoticeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('noticecategories/add'); ?>" onsubmit="return formValidatenotcat();" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="cat_name" class="form-label">Category Name </label>
                        <input type="text" class="form-control text-val-notice-cat" id="cat_name" name="cat_name" data-error="Please Enter name">
                        <label></label>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addcat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('notifications/add'); ?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="cat_name" class="form-label">Title </label>
                        <input type="text" class="form-control text-val-notcat" id="not_title" name="not_title" data-error="Please Enter Notification Title" required>
                        <label></label>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_name" class="form-label">Message </label>
                        <textarea type="text" class="form-control text-ar-notcat" id="not_msg" name="not_msg" data-error="Please Enter Notification Message" required></textarea>
                        <label></label>
                    </div>
                    <?php
                    $branch_info = $this->AdminModel->get_branch_info();
                    $cell_info = $this->AdminModel->get_cell_info();
                    ?>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">
                            Select Branch
                        </label>
                        <select id="inputState" class="form-select text-dr-notcat" name="userbranch" data-error="Please Select Branch" required>
                            <option value="">Choose...</option>
                            <?php
                            foreach ($branch_info as $branch) {
                                echo "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
                            }
                            ?>
                        </select>
                        <label></lable>
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">
                            Select Cell
                        </label>
                        <select id="inputState" class="form-select text-dr-notcat" name="usercell" data-error="Please Select Cell" required>
                            <option value="">Choose...</option>
                            <?php
                            foreach ($cell_info as $cell) {
                                echo "<option value='" . $cell->id . "'>" . $cell->cell_name . "</option>";
                            }
                            ?>
                        </select>
                        <label></lable>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addnotification">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('addannouncement'); ?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="cat_name" class="form-label">Title </label>
                        <input type="text" class="form-control text-val-notcat" id="not_title" name="title" data-error="Please Enter Notification Title" required>
                        <label></label>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_name" class="form-label">Message </label>
                        <textarea class="form-control" id="not_msg" name="message"></textarea>
                        <label></label>
                    </div>
                    <?php
                    $branch_info = $this->AdminModel->get_branch_info();
                    $cell_info = $this->AdminModel->get_cell_info();
                    ?>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">
                            Select Branch
                        </label>
                        <select id="inputBranch" class="form-select text-dr-notcat" name="userbranch" data-error="Please Select Branch">
                            <option value="">Choose...</option>
                            <?php
                            foreach ($branch_info as $branch) {
                                echo "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
                            }
                            ?>
                        </select>
                        <label></lable>
                    </div>
                    <div class="col-md-12">
                        <label for="inputCell" class="form-label">
                            Select Cell
                        </label>
                        <select id="inputState" class="form-select text-dr-notcat" name="usercell" data-error="Please Select Cell">
                            <option value="">Choose...</option>
                            <?php
                            foreach ($cell_info as $cell) {
                                echo "<option value='" . $cell->id . "'>" . $cell->cell_name . "</option>";
                            }
                            ?>
                        </select>
                        <label></lable>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addannouncement">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBranchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Branch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('branches/add'); ?>" onsubmit="return formValidatebranch();" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="branch_name" class="form-label">Branch Name excel file </label>
                        <input type="file" class="form-control text-val-branch" id="bulk_file_branch" name="bulk_file_branch" data-error="Please upload file">
                        <label></label>
                    </div>
                    <!-- <div class="col-md-6">
                        <label for="branch_name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name"
                            data-error="Please Enter Branch Name">
                        <label></label>
                    </div> -->
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addbranch">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('users/import'); ?>" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="branch_name" class="form-label">User data excel file </label>
                        <input type="file" class="form-control text-val-branch" id="bulk_file_user" name="bulk_file_user" data-error="Please upload file" required>
                        <label></label>
                    </div>
                    <!-- <div class="col-md-6">
                        <label for="branch_name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name"
                            data-error="Please Enter Branch Name">
                        <label></label>
                    </div> -->
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Import" name="importuser">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCellModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Cell</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="<?php echo base_url('cells/add'); ?>" onsubmit="return formValidatecell();" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="branch_name" class="form-label">Cell Name excel file </label>
                        <input type="file" class="form-control text-val-cell" id="bulk_file_cell" name="bulk_file_cell" data-error="Please upload file">
                        <label></label>
                    </div>
                    <div class="col-md-6">
                        <label for="cell_name" class="form-label">Cell Name </label>
                        <input type="text" class="form-control text-val-cell" id="cell_name" name="cell_name" data-error="Please Enter Cell Name">
                        <label></label>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Add" name="addcell">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importCentreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Centres</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="<?php echo base_url(''); ?>uploads/excelsample/sample.xlsx">Download Sample Excel File</a>
                <form class="row g-3" method="post" action="<?php echo base_url('centres/importFile'); ?>" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="cat_name" class="form-label">Select File</label>
                        <input type="file" class="form-control text-r" id="import_file" name="import_file" required>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Import" name="addcat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deletetext">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" id="confirmBtndel" class="filterLink btn btn-primary" href="">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="removeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="removetext">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" id="confirmBtndel2" class="filterLink btn btn-primary" href="">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deletetext">Are you sure to update user data?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" id="confirmBtndel" class="filterLink btn btn-primary" href="">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal23" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deletetext">Are you sure to update user data?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="submit" id="confirmBtndel2" class="filterLink btn btn-primary" href="javascript:void(0);">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="comingsoonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Please Confirm</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Section is under development</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="bookingDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>