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
                // print_r($topics);
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
                                        <th>Notice Date</th>
                                        <th>Category</th>
                                        <th>Updated On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($topics as $article) {
                                        if ($article->status == 0) {
                                            $articleclass = 'bg-danger';
                                        } else {
                                            $articleclass = '';
                                        }

                                        echo "<tr class='" . $articleclass . "'>";
                                        echo "<td>" . $article->id . "</td>";
                                        echo "<td><a href='" . base_url() . "notices/edit/" . $article->id . "'>" . substr($article->title, 0, 25) . "...</a></td>";
                                        echo "<td>" . date("j F, Y", strtotime($article->added_on)) . "</td>";
                                        echo "<td>" . get_cat_name($article->category)->cat_name . "";
                                        echo "<td>" . date("j F, Y", strtotime($article->updated_on)) . "</td>";
                                        echo "<td>";
                                        if ($this->session->userdata('logged_in_info')->userrole == 1) {
                                            echo "<a href='" . base_url() . "notices/edit/" . $article->id . "'><i class='fadeIn animated bx bx-edit'></i></a>&nbsp;";
                                            if ($article->status == 1) {
                                    ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'notices/disable/' . $article->id; ?>" data-deletetext="Are you sure to disable this notice?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."events/disable/".$article->id."' class='confirm'><i class='fadeIn animated bx bxs-lock-open'></i></a>";
                                            } else {
                                            ?>
                                                |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'notices/enable/' . $article->id; ?>" data-deletetext="Are you sure to enable this notice?"><i class='fadeIn animated bx bxs-lock'></i></a>
                                            <?php
                                                //echo "|&nbsp;<a href='".base_url()."events/enable/".$article->id."' class='confirm'><i class='fadeIn animated bx bxs-lock'></i></a>";
                                            }
                                            ?>
                                            |&nbsp;<a href='#' data-bs-toggle="modal" data-bs-target="#deleteModal" data-deletelink="<?php echo base_url() . 'notices/delete/' . $article->id; ?>" data-deletetext="Are you sure to delete this notice?" class="red_link"><i class='fadeIn animated bx bxs-trash'></i></a>
                                    <?php
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
        $(document).ready(function() {
            $('#example5').DataTable({
                "order": [
                    [5, "desc"]
                ]
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