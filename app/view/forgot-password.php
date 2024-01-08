<?php
$page_title = "Forgot password";
require __DIR__ . '/partials/Header.inc.php';
include __DIR__ . '/partials/Nav.inc.php';
?>
<section class="form-section forgot-password-section" id="form-section">
    <div class="wrapper ">
        <div class="container shadow bg-light rounded-3 p-2 p-sm-3">
            <div class="row">
                <h1>
                    Forgot password
                </h1>
                <form action="<?= baseurl() ?>/auth/forgot_password" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">
                    <?php Session::success('FORGOT-PASSWORD-SUCCESS') ?  Session::success('FORGOT-PASSWORD-SUCCESS') : ''; ?>
                    <?php Session::danger('FORGOT-PASSWORD-DANGER') ?  Session::danger('FORGOT-PASSWORD-DANGER') : ''; ?>
                    <hr>
                    <div class="col-12 py-1">
                        <div class="form-group col-12">
                            <input type="email" class="form-control rounded-1" name="email" placeholder="Trace email">
                        </div>
                        <div class="form-group d-flex justify-content-end col-12 py-2">
                            <button type="submit" class="btn btn-primary m-0 " name="forgot-password_submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include(__DIR__ . '/partials/Footer.inc.php');
?>