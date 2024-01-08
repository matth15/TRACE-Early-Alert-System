<?php

$page_title = "Add Faculty";

require_once __DIR__ . "/partials/Main.header.php"
?>
<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Add Faculty</h4>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <div class="wrapper">
        <div class="container-fluid table-container">
            <form id="addFacultyForm">
                <div class="row">
                    <div class="col-12 col-md-7 col-xl-5" id="alertMessage"></div>
                </div>
                <div class="row text-secondary">

                    <div class="col-6">
                        <label for="firstname">First name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Firstname">
                    </div>
                    <div class="col-6">
                        <label for="lastname">Last name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Lastname">
                    </div>
                    <div class="col-6">
                        <label for="email">TRACE Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="TRACE E-mail">
                    </div>
                    <div class="col-6">
                        <label for="password">Create Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Create passowrd">
                    </div>

                    <div class="col-12 my-3 d-flex justify-content-end">
                        <button class="btn btn-success" type="button" id="saveFacultyBtn">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="<?php baseurl() ?>/public/assets/main.faculty.js"></script>
<?php require_once __DIR__ . "/partials/Main.footer.php" ?>