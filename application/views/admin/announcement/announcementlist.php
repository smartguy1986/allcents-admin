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
                // print_r($notice_data);
                // echo "</pre>";
                ?>
                <style>
                    .bg-danger td {
                        color: #fff !important;
                    }

                    .bg-danger td a {
                        color: #fff !important;
                    }
                </style>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Branch</th>
                                        <th>Cell</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($notice_data as $article) {
                                        if ($article->status == 0) {
                                            $articleclass = 'bg-danger';
                                        } else {
                                            $articleclass = '';
                                        }

                                        echo "<tr class='" . $articleclass . "'>";
                                        echo "<td>" . $article->id . "</td>";
                                        echo "<td>" . $article->title . "</td>";
                                        echo "<td>" . substr($article->message,0,50) . "...</td>";
                                        echo "<td>";
                                        if(!empty($article->branch)) { echo branch_name($article->branch)->branch_name; } else { echo "All"; }
                                        echo "</td>";
                                        echo "<td>";
                                        if(!empty($article->cell)) { echo cell_name($article->cell)->cell_name; } else { echo 'All'; }
                                        echo "</td>";
                                        echo "<td>" . date("j F, Y", strtotime($article->created_at)) . "</td>";                                      
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1) {
                                            if ($article->status == 1) {
                                                ?>
                                                <a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-deletelink="<?php echo base_url() . 'announcements/disable/' . $article->id; ?>"
                                                    data-deletetext="Are you sure to disable this notification?"><i
                                                        class='fadeIn animated bx bxs-lock'></i></a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-deletelink="<?php echo base_url() . 'announcements/enable/' . $article->id; ?>"
                                                    data-deletetext="Are you sure to enable this notification?"><i
                                                        class='fadeIn animated bx bxs-lock'></i></a>
                                                <?php
                                                //echo "|&nbsp;<a href='".base_url()."events/enable/".$article->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Topic Title</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot> -->
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
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright ©
                <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech"
                    target="_blank">AllCents App.</a>
            </p>
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
        $(document).ready(function () {
            $('#example5').DataTable({
                "order": [[5, "desc"]]
            });
        });
    </script>
    <!-- <div class="modal fade" id="editRegionModal" tabindex="-1" aria-hidden="true">
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
    </div> -->

    <div class="modal fade" id="articleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articletitle" style="color:#f38446;"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="articlecontent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>