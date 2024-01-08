<?php
$page_title = "Classroom";

require_once(__DIR__ . "/partials/Main.header.php"); ?>

<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Classroom</h4>
            </div>
        </div>
    </div>
</div>

<div id="classroom">
    <div class="container-fluid shadow-sm border">
        <div class="row">
            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-classroom" type="button" role="tab" aria-controls="nav-classroom" aria-selected="true">
                            Main class</button>
                        <?php
                        if (Session::getUserType() === "teacher") {
                        ?>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-otherclass" type="button" role="tab" aria-controls="nav-otherclass" aria-selected="false">
                                Other class</button>
                    </div>
                <?php }
                ?>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-classroom" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <?php if (Session::getUserType() === "student") { ?>
                                <div class="col-12">
                                    <nav class="navbar navbar-light">
                                        <div class="container-fluid">
                                            <form class="d-flex">
                                                <input class="form-control me-2" type="search" id="search" placeholder="Class code" aria-label="Search">
                                                <button class="btn btn-primary btn-sm" id="joinMainClassBtn" type="button">Join</button>
                                            </form>
                                        </div>
                                    </nav>
                                </div>
                                

                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    if (Session::getUserType() === "teacher") { ?>
                        <div class="tab-pane fade" id="nav-otherclass" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-12" id="alertMessage"></div>
                                <div class="col-12">
                                    <nav class="navbar navbar-light">
                                        <div class="container-fluid">
                                            <form class="d-flex">
                                                <input class="form-control me-2" type="search" id="search" placeholder="Class code" aria-label="Search">
                                                <button class="btn btn-primary btn-sm" id="joinClassBtn" type="button">Join</button>
                                            </form>

                                        </div>
                                    </nav>
                                </div>

                            </div>

                            <div class="row" id="main">


                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>


        </div>

    </div>

</div>

</div> <!--  PAGE CONTENT  -->

<script src="<?php baseurl() ?>/public/assets/main.classroom.js"></script>
<?php require_once(__DIR__ . "/partials/Main.footer.php") ?>