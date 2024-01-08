<div class="content-wrapper" id="page_heading_title">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-12">
                <h4 class="text-secondary">Classroom</h4>
            </div>
        </div>
    </div>
</div>
<div id="classroom-nav">
    <div class="container-fluid shadow-sm pt-3">
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs border-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (rtrim($_SERVER['REQUEST_URI'], '/') === '/classroom') ? 'active' : ''; ?>" aria-current="page" href="<?php baseurl() ?>/classroom">Classroom</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (rtrim($_SERVER['REQUEST_URI'], '/') === '/classroom/people') ? 'active' : ''; ?>" href="<?php baseurl() ?>/classroom/people">People</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>