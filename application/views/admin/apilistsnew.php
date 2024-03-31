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
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.19.5/swagger-ui.css">
        <style>
            #accordion .glyphicon {
                margin-right: 10px;
            }

            .panel-collapse>.list-group .list-group-item:first-child {
                border-top-right-radius: 0;
                border-top-left-radius: 0;
            }

            .panel-collapse>.list-group .list-group-item {
                border-width: 1px 0;
            }

            .panel-collapse>.list-group {
                margin-bottom: 0;
            }

            .panel-collapse .list-group-item {
                border-radius: 0;
            }
        </style>
        <div class="page-wrapper">
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            General
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="list-group">
                                                <li class="list-group-item"><a href="javascript:void(0)"
                                                        onclick="return getMyAPIData(1);">Home Page</a></li>
                                                <li class="list-group-item"><a href="javascript:void(0)"
                                                        onclick="return getMyAPIData(2);">Login Page</a></li>
                                                <li class="list-group-item"><a href="javascript:void(0)"
                                                        onclick="return getMyAPIData(3);">Country & Province List</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Users
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">Get All Users</li>
                                                <li class="list-group-item"><a href="javascript:void(0)"
                                                        onclick="return getMyAPIData(4);">Login User</a></li>
                                                <li class="list-group-item">Reset Password</li>
                                                <li class="list-group-item">Edit Profile</li>
                                                <li class="list-group-item">Get Specific User</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-9">
                            <div class="row">
                                <span id="apiresp">

                                </span>
                            </div>
                        </div>
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
            <?php echo date("Y"); ?>. All right reserved by <a href="https://www.allcents.tech" target="_blank">AAC - African Apostolic Church</a>
        </p>
    </footer>
    </div>
    <?php $this->view('admin/inc/foot'); ?>
</body>

</html>