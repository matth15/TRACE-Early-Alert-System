<?php

$page_title = "Sign Up";
require_once(__DIR__ . '/partials/Header.inc.php');

require_once(__DIR__ . '/partials/Nav.inc.php');
?>

<section class="form-section signup-form" id="form-section">
    <div class="wrapper px-1">
    <div class="container bg-light shadow rounded-3 mt-5">

        <form action="<?= baseurl() ?>/auth/signup" method="POST">
            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">
            <div class="row p-2 p-sm-3 ">
                <h1>SIGN UP</h1>
                <!-- start error display -->
                <?php Session::warning('Signup-Warning') ? Session::warning('Signup-Warning') : '' ?>
                <?php Session::danger('Signup-Error') ? Session::danger('Signup-Error') : '' ?>
                <!-- end error display -->
                <hr>
                <div class="col col-sm-6 col-12 ">
                    <input type="text" value="<?= old_value('firstname') ?>" name="firstname" class="form-control rounded-2" placeholder="First name">
                </div>
                <div class="col col-sm-6 col-12 ">
                    <input type="text" value="<?= old_value('lastname') ?>" name="lastname" class="form-control rounded-2" placeholder="Last name">
                </div>
                <div class="col col-12 ">
                    <input type="email" value="<?= old_value('email') ?>" name="email" class="form-control rounded-2" placeholder="TRACE Email">
                </div>
                <div class="col col-12 ">
                    <input type="tel" value="<?= old_value('phoneNo') ?>" name="phoneNo" class="form-control rounded-2" placeholder="+63 Parent Phone No">

                </div>
                <div class="col signup-password col-sm-6 col-12 ">
                    <input type="password" value="<?= old_value('password') ?>" name="password" class="form-control rounded-2" placeholder="Create Password">
                </div>
                <div class="col col-sm-6 col-12">
                    <input type="password" value="<?= old_value('confirm_password') ?>" name="confirm_password" class="form-control rounded-2" placeholder="Confirm Password">

                </div>
                <div class="col col-12">
                    <select name="grade_level" class="form-select rounded-2">
                        <option value="" selected disabled>Grade Level</option>
                        <option value="11" disabled>Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <div class="col col-12 ">
                    <select name="strand" class="form-select rounded-1 ">
                        <option value="" selected disabled>Strand</option>
                        <option value="ABM" disabled>ABM</option>
                        <option value="STEM" disabled>STEM</option>
                        <option value="HUMSS">HUMSS</option>
                        <option value="TVL-ICT" disabled>TVL-ICT</option>
                        <option value="TVL-HE" disabled>TVL-HE</option>
                        <option value="TVL-HE" disabled>TVL-ART & DESIGN</option>
                        <option value="GAS" disabled>GAS</option>
                    </select>
                </div>
                <div class="col col-12">
                    <select name="class" class="form-select rounded-1">
                        <option value="" disabled selected>Class</option>
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
                <div class="d-grid col-12 mx-auto py-3">
                    <button type="submit" class="btn btn-sm btn-success ">Sign up</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>

<?php require_once(__DIR__ . '/partials/Footer.inc.php') ?>