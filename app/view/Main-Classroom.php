<?php

$page_title = "Classroom";

require_once(__DIR__ . "/partials/Main.header.php");
?>



<div class="main-classroom">
    <div class="wrapper">
        <div class="row">
            <div class="col-12"><a class="text-decoration-none" href="<?php baseurl() ?>/classroom">
                    Back
                </a>
            </div>
            <div class="col-12 ">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Class</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-people" type="button" role="tab" aria-controls="pills-people" aria-selected="false">People</button>
                    </li>       
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow-sm border">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $class['section'] ?></h5>
                                        <h6 class="card-subtitle mb-2"><?= $class['grade'] . ' ' . $class['strand'] . ' ' . $class['class'] ?></h6>
                                    </div>
                                </div>
                            </div>
                            <?php if (Session::getUserType() === "teacher" && $class['teacher_unique_id'] === Session::getUserUniqueId()) { ?>
                                <div class="col-5 col-md-4 col-xl-3 ">
                                    <div class="main-content shadow-sm">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Invitation code: </h5>
                                            </div>
                                            <div class="col">
                                                <h5><?= $class['invite_code'] ?></h5>

                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-success btn-sm mb-1" type="button">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php  } ?>
                            <div class="col-7 col-md-8 col-xl-9">
                                <div class="main-content shadow-sm">
                                    <div class="row">
                                        <div class="col">
                                            <h5>Early Alert</h5>
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item px-1" role="presentation">
                                                    <button class="btn btn-success  " id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-send" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Send alert</button>
                                                </li>
                                                <li class="nav-item px-1" role="presentation">
                                                    <button class="btn btn-secondary " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-show" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Students alert</button>
                                                </li>
                                                <li class="nav-item px-1" role="presentation">
                                                    <button class="btn btn-danger " id="pills-contact" data-bs-toggle="pill" data-bs-target="#pills-mark" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Mark student</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active" id="pills-send" role="tabpanel" aria-labelledby="pills-home-tab">

                                    </div>
                                    <div class="tab-pane fade" id="pills-show" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        s
                                    </div>
                                    <div class="tab-pane fade" id="pills-mark" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        s
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row" style="height: 80vh; overflow-y: scroll;">
                        <div class="col-12 people-list text-lg-center">
                            <h4>Teachers</h4>
                            <hr class="opacity-25 ">
                            <?php
                            echo '<p>' . $owner['name'] . '<br><small>' . $owner['email'] . '</small></p><hr>';
                            foreach ($teachers as $t) {
                                echo '<p>' . $t['name'] . '<br><small>' . $t['email'] . '</small>';
                                if (Session::getUserType() === "teacher" && $class['teacher_unique_id'] === Session::getUserUniqueId()) {
                                    echo ' <button type="button" value="' . $t['unique_id'] . '" class="btn btn-danger btn-sm">remove</button>';
                                }
                                echo '</p><hr>';
                            }

                            ?>
                        </div>
                        <div class="col-12 people-list text-lg-center">
                            <h4>Students</h4>
                            <hr class="opacity-25">

                            <?php
                            if (!empty($students)) {
                                foreach ($students as $s) {
                                    echo '<p>' . $s['name'] . '<br> <small>' . $s['email'] . '</small>';

                                    if (Session::getUserType() === "teacher" && $class['teacher_unique_id'] === Session::getUserUniqueId()) {
                                        echo ' <button type="button" value="' . $s['unique_id'] . '" class="btn btn-danger btn-sm">remove</button>';
                                    }
                                    echo '</p><hr>';
                                }
                            } else {
                                echo '<p>No student found</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>

<?php require_once(__DIR__ . "/partials/Main.footer.php"); ?>