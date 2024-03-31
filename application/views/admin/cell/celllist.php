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
                // print_r($cell);
                // echo "</pre>";
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cell Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($cells as $cat) {
                                        if ($cat->status == 0) {
                                            $catclass = 'bg-danger';
                                        } else {
                                            $catclass = '';
                                        }
                                        echo "<tr class='" . $catclass . "'>";
                                        echo "<td>" . $cat->id . "</td>";
                                        echo "<td>" . $cat->cell_name . "</td>";
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1) {
                                            echo "<a href='cells/edit/" . $cat->id . "'><i class='fadeIn animated bx bx-show'></i></a>&nbsp;";
                                            if ($cat->status == 1) {
                                    ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'cells/disablecell/' . $cat->id; ?>" data-deletetext="Are you sure to disable this cell?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."admin/cell/disablecat/".$cat->id."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                            } else {
                                            ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'cells/enablecell/' . $cat->id; ?>" data-deletetext="Are you sure to enable this cell?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."admin/cell/enablecat/".$cat->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                            ?>
                                            |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'cells/deletecell/' . $cat->id; ?>" data-deletetext="Are you sure to delete this cell?" class="red_link"><i class='fadeIn animated bx bxs-trash'></i></a>
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

        // $('#deleteModal').on('show.bs.modal', function(event) {
        //     console.log('modal open');
        //     var myValid = $(event.relatedTarget).data('deletelink');
        //     var mytext = $(event.relatedTarget).data('deletetext');
        //     //alert(myVal);
        //     $("#confirmBtndel").attr("href", myValid);
        //     $("#deletetext").text(mytext);
        // });
    </script>
    <div class="modal fade" id="editcellModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cell</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editcell"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>