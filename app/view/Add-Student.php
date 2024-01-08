<?php

$page_title = "Add Student";

require_once __DIR__ . "/partials/Main.header.php"
?>
<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Add Student</h4>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <div class="wrapper">
        <div class="container-fluid table-container">
            <form id="addStudentForm">
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
                    <div class="col-6">
                        <label for="phoneNo">Parent Phone No</label>
                        <input type="tel" class="form-control" name="phoneNo" id="phoneNo" placeholder="+63">
                    </div>
                    <div class="col col-6">
                        <label for="grade_level">Grade Level</label>
                        <select  id="grade_level" name="grade_level" class="form-select" required>
                            <option selected disabled>--Select Grade--</option>
                            <option value="g11" disabled>Grade 11</option>
                            <option value="g12">Grade 12</option>
                        </select>
                    </div>
                    <div class="col col-6">
                        <label for="strand">Strand </label>
                        <select id="strand" name="strand" class="form-select" required>
                            <option selected disabled>--Select Strand--</option>
                            <option value="abm" disabled>ABM</option>
                            <option value="gas" disabled>GAS</option>
                            <option value="art_and_design" disabled>TVL ART & DESIGN</option>
                            <option value="he" disabled>TVL HE</option>
                            <option value="humss">HUMSS</option>
                            <option value="ict">TVL ICT</option>
                            <option value="stem" disabled>STEM</option>

                        </select>
                    </div>
                    <div class="col-6">
                        <label for="class">Class</label>
                        <select class="form-select" name="class" id="class" required >
                            <option selected disabled>--Select class--</option>
                            <?php
                            // Loop to generate options from 'A' to 'Z'
                            for ($letter = 'A'; $letter <= 'Z'; $letter++) {
                                echo '<option value="' . $letter . '">' . $letter . '</option>';
                                if ($letter === 'D') {
                                    break;
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 my-3 d-flex justify-content-end">
                        <button class="btn btn-success" type="button" id="saveStudentBtn">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="<?php baseurl() ?>/public/assets/main.student.js"></script>
<?php require_once __DIR__ . "/partials/Main.footer.php" ?>