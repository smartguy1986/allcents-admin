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
                                        <th>Branch Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($branches as $cat) {
                                        if ($cat->status == 0) {
                                            $catclass = 'bg-danger';
                                        } else {
                                            $catclass = '';
                                        }
                                        echo "<tr class='" . $catclass . "'>";
                                        echo "<td>" . $cat->id . "</td>";
                                        echo "<td>" . $cat->branch_name . "</td>";
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1) {
                                            echo "<a href='branches/edit/" . $cat->id . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                            if ($cat->status == 1) {
                                    ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'branches/disablebranch/' . $cat->id; ?>" data-deletetext="Are you sure to disable this branch?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                            } else {
                                            ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'branches/enablebranch/' . $cat->id; ?>" data-deletetext="Are you sure to enable this branch?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."admin/categories/enablecat/".$cat->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                            ?>
                                            |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#removeModal" data-removelink="<?php echo base_url() . 'branches/deletebranch/' . $cat->id; ?>" data-removetext="Are you sure to delete this branch?" class="red_link"><i class='fadeIn animated bx bxs-trash'></i></a>
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
            <?php echo setfootercopyrightdata(); ?>
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

        $('#removeModal').on('show.bs.modal', function(event) {
            console.log('modal open');
            var myValid = $(event.relatedTarget).data('removelink');
            var mytext = $(event.relatedTarget).data('removetext');
            //alert(myVal);
            $("#confirmBtndel2").attr("href", myValid);
            $("#removetext").text(mytext);
        });
    </script>
    <div class="modal fade" id="editBranchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editbranch"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>