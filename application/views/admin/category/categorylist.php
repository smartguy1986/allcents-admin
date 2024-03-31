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
                // print_r($categories);
                // echo "</pre>";
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($categories as $cat) {
                                        if ($cat->status == 0) {
                                            $catclass = 'bg-danger';
                                        } else {
                                            $catclass = '';
                                        }
                                        echo "<tr class='" . $catclass . "'>";
                                        echo "<td>" . $cat->id . "</td>";
                                        echo "<td>" . $cat->cat_name . "</td>";
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1) {
                                            echo "<a href='categories/edit/" . $cat->id . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                            if ($cat->status == 1) {
                                    ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'categories/disablecat/' . $cat->id; ?>" data-deletetext="Are you sure to disable this category?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."admin/categories/disablecat/".$cat->id."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                            } else {
                                            ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'categories/enablecat/' . $cat->id; ?>" data-deletetext="Are you sure to enable this category?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."admin/categories/enablecat/".$cat->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                            ?>
                                            |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'categories/deletecat/' . $cat->id; ?>" data-deletetext="Are you sure to delete this category and programms associated with it?" class="red_link"><i class='fadeIn animated bx bxs-trash'></i></a>
                                    <?php
                                        } else {
                                            if ($region->status == '1') {
                                                echo "Active";
                                            } else {
                                                echo "Disabled";
                                            }
                                        }
                                        echo "</td>";
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
            <p class="mb-0">Copyright ©
                <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AllCents App.</a>
            </p>
        </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('deletelink');
            var mytext = $(event.relatedTarget).data('deletetext');
            //alert(myVal);
            $("#confirmBtndel").attr("href", myValid);
            $("#deletetext").text(mytext);
        });
    </script>
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editcategory"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>