<?php

$page_title = "Create Classroom";

require_once __DIR__ . "/partials/Main.header.php"
?>
<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Create Classroom</h4>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <div class="wrapper">
        <div class="container-fluid table-container">

            <form id="create">
                <div class="row">
                    <div class="col-12 col-lg-6" id="AlertMessage">

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 pb-2">
                        <input type="text" class="form-control" id="section" name="section" placeholder="Enter Section">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 pb-2">
                        <select id="grade" name="grade" class="form-select">
                            <option selected disabled>Select Grade</option>
                            <option value="11" disabled>Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 pb-2">
                        <select id="strand" name="strand" class="form-select">
                            <option selected disabled>Select Strand</option>
                            <option value="ABM" disabled>ABM</option>
                            <option value="GAS" disabled>GAS</option>
                            <option value="TVL-ART & DESIGN" disabled>TVL ART & DESIGN</option>
                            <option value="TVL-HE" disabled>TVL HE</option>
                            <option value="HUMSS">HUMSS</option>
                            <option value="TVL-ICT">TVL ICT</option>
                            <option value="STEM" disabled>STEM</option>

                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <select id="class" name="class" class="form-select">
                            <option selected disabled>Select Class</option>
                            <option value="">None</option>
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

                    <div class="col-12 py-2 d-flex justify-content-end ">
                        <button type="submit" class="btn btn-success" id="createBtn">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php baseurl() ?>/public/assets/main.classroom.js"></script>
<?php require_once __DIR__ . "/partials/Main.footer.php" ?>