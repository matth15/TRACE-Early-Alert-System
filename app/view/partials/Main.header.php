<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>
        <?php if (isset($page_title)) {
            echo "$page_title";
        } ?> - TRACE Early Alert
    </title>

    <link rel="stylesheet" href="<?= baseurl() ?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= baseurl() ?>/public/assets/main.style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        var baseurl = '<?php echo baseurl(); ?>';
        var userType = '<?php echo Session::getUserType(); ?>';
    </script>
</head>

<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light " id="sidebar-wrapper">
            <div class="sidebar-heading  text-center py-1 py-sm-4  text-uppercase border-bottom ">
                <h2 class="fw-bold primary-text">Trace Early Alert</h2>
            </div>
            <div class="list-group list-group-flush ">
                <span class="list-category fw-bold">Main</span>

                <?php
                if(Session::getUserType()==='student'){
                    echo '<a href="" class="list-group-item sub-btn list-group-item-action bg-transparent second-text active"><i class="fa-solid fa-school me-2"></i>Inbox</a>';
                }
                if (Session::getUserType() === "admin" || Session::getUserType() === "teacher") {

                    //dashboard
                    echo '<a href="' . baseurl() . '/' . Session::getUserType() . '/dashboard" class="list-group-item bg-transparent second-text "><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>';

                    //student list
                    echo '<div class="list-group-menu"><a class="list-group-item sub-btn list-group-item-action bg-transparent second-text "><i class="fa-solid fa-bars-progress me-2"></i>Manage Student<i class="fa-solid fa-angle-right fa-dropdown ms-3"></i></a>
                    <div class="sub-menu" >
                    <a href="' . baseurl() . '/' . Session::getUserType() . '/StudentList" class ="sub-item"><i class="fa-solid fa-table me-2 py-1"></i>Student Table</a>';
                    if(Session::getUserType()==="admin"){
                        echo '  <a href="'.baseurl(). '/'.Session::getUserType().'/AddStudent" class ="sub-item"><i class="fa-solid fa-plus me-2 py-1"></i>Add Student</a>';
                    }
                    echo '</div> </div>';

                    // echo '<a href="'. baseurl() .'/'.Session::getUserType().'/studentList" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="dropdown-logo fa-solid fa-user me-2"></i>Student</a>';
                }
                if (Session::getUserType() === "admin") {
                    echo '<div class="list-group-menu"><a class="list-group-item sub-btn list-group-item-action bg-transparent second-text "><i class="dropdown-logo fa-solid fa-school me-2"></i>Manage Faculty<i class="fa-solid fa-angle-right fa-dropdown ms-3"></i></a>';
                    echo ' <div class="sub-menu" >
            <a href="' . baseurl() . '/' . Session::getUserType() . '/facultyList" class ="sub-item"><i class="fa-solid fa-table me-2 py-1"></i>Faculty Table</a>
            <a href="'.baseurl().'/admin/addFaculty" class ="sub-item"><i class="fa-solid fa-plus me-2 py-1"></i>Add Faculty</a>
            </div>
            </div>';
                }

                if(Session::getUserType() === 'student'){
                    echo '<a href="' . baseurl() . '/' . Session::getUserType() . '/classroom" class="list-group-item list-group-item-action bg-transparent second-text "><i class="dropdown-logo fa-solid fa-school me-2"></i>Classroom</a>';
                }
                if(Session::getUserType() === "admin" || Session::getUserType()==="teacher"){
                    if(Session::getUserType()==="admin"){
                        $m = "Manage Classes";
                    }
                    else{
                        $m ="Classroom";
                    }
                    echo '<div class="list-group-menu">
                    <a class="list-group-item sub-btn list-group-item-action bg-transparent second-text "><i class="dropdown-logo fa-solid fa-school me-2"></i>'.$m.'<i class="fa-solid fa-angle-right fa-dropdown ms-3"></i></a>';
                    echo '<div class="sub-menu" >
                    <a href="'.baseurl().'/classroom" class="sub-item"><i class="fa-solid fa-table me-2 py-1"></i>Classes</a>
                    <a href="'.baseurl().'/classroom/create" class="sub-item"><i class="fa-solid fa-plus me-2 py-1"></i>Create Classroom</a>';
                    echo '</div></div>';
                }

                ?>
                <?php if (Session::getUserType() === "admin" || Session::getUserType() === "teacher") {
                    echo '<span class="list-category fw-bold">Early Alert</span>';
                    if (Session::getUserType() === "admin") {
                        echo '<a href="' . baseurl() . '/admin/configuration" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="dropdown-logo fas fa-project-diagram me-2"></i>Configuration</a>';
                    }
                    echo '<a href="<?= baseurl() ?>/earlyalert/history" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="dropdown-logo fa-solid fa-clock-rotate-left me-2"></i>History</a>';
                }
                ?>

            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-2 py-sm-3 px-4">
                <div class="d-flex align-items-center">
                    <i class="navbar-menu fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="m-0">Menu</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2 "></i><?= Session::getUserName() ?> <span class="badge rounded-pill bg-info text-dark"><?= Session::getUserType() ?></span>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= baseurl() ?>/account/profile"><i class=" fa-solid fa-address-card me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="<?= baseurl() ?>/account/settings"><i class=" fa-solid fa-gear me-2"></i>Settings</a></li>
                                <li><a class="dropdown-item" href="<?= baseurl() ?>/account/logout"><i class="fas text-danger fa-power-off me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>