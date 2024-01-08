<?php
$page_title = "Dashboard";

require_once(__DIR__ . "/partials/Main.header.php");
?>
<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="">Dashboard</h4>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper" id="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-xl-3 col-md-6 col-6 mb-3">
                <div class="card shadow border-danger border-2 ">
                    <div class="card-body">
                        <div class="row">
                            <p><i class="fa fa-users fa-2x text-secondary me-2 "></i>Students</p>
                            <div class="col-12 text-center">
                                <h2><?= (!empty($studentCount)) ? $studentCount : 0  ?></h2>
                            </div>
                            <a href="<?= baseurl() ?>/admin/studentList/" class="card-view text-center stretched-link">View</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-xl-3 col-md-6 col-6 mb-3">
                <div class="card shadow border-danger border-2">
                    <div class="card-body">
                        <div class="row">
                            <p ><i class="fa-solid fa-school fa-2x text-secondary me-2"></i> Facultys</p>
                            <div class="col-12 text-center">
                                <h2><?= (!empty($teacherCount)) ? $teacherCount : 0  ?></h2>
                            </div>
                            <a href="<?= baseurl() ?>/admin/facultyList" class="card-view text-center stretched-link">View</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-xl-3 col-md-6 col-6 mb-3">
                <div class="card shadow border-danger border-2">
                    <div class="card-body ">
                        <div class="row">
                            <p><i class="fa fa-users fa-2x text-secondary me-2 "></i>Classes</p>
                            <div class="col-12 text-center">
                                <h2>0</h2>
                            </div>
                            <a href="<?= baseurl() ?>/admin/alert_list" class="card-view text-center stretched-link">View</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-xl-3 col-md-6 col-6 mb-3">
                <div class="card shadow border-danger border-2">
                    <div class="card-body">
                        <div class="row">
                            <p><i class="fa fa-users fa-2x text-secondary me-2 "></i>empty</p>
                            <div class="col-12 text-center">
                                <h2>0</h2>
                            </div>
                            <a href="<?= baseurl() ?>" class="card-view text-center">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['LOGIN-SUCCESS']) && $_SESSION['LOGIN-SUCCESS']) : Session::successToast("LOGIN-SUCCESS"); ?>
    <!-- SHOW TOAST -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myToast = new bootstrap.Toast(document.getElementById('myToast'));
            myToast.show();
        });
    </script>
    
    </div> <!--  PAGE CONTENT  -->
<?php
endif;
require_once(__DIR__ . "/partials/Main.footer.php"); ?>