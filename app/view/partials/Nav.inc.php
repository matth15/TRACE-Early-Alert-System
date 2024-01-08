<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary position-fixed w-100">
  <div class="container">
    <a href="<?= baseurl()?>" class="navbar-brand">
      <img class="trace-ea-logo" src="<?= baseurl()?>/public/assets/images/trace-ea-logo.png" alt="TRACE Early alert logo" />
      <span class="hidden-on-small-screens">TRACE</span>
      <span>Early Alert</span></a>
    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav fw-bold me-auto mb-2 mb-lg-0 ms-auto">
        <li class="nav-item">
          <a class="nav-link " href="<?= baseurl() ?>"><?= ($_SERVER['REQUEST_URI'] !== "/") ? '<i class=" fa-solid fa-house fa-lg me-2" style="color: #363636;"></i>' : '' ?>Home</a>
        </li>

        <?php if ($_SERVER['REQUEST_URI'] === "/") : ?>
          <li class="nav-item dropdown ">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown">About</a>
            <ul class="dropdown-menu dropdown-menu-dark text-light ">
              <li><a class="dropdown-item" onclick="navigateToSection('about')">About</a></li>
              <li>
                <hr class="dropdown-divider ">
              </li>
              <li><a class="dropdown-item" onclick="navigateToSection('mv')">Mission & Vision</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a  class="nav-link" onclick="navigateToSection('contact')" >Contact</a>
          </li>
          <li class="nav-item">
            <a  class="nav-link" href="<?= baseurl() ?>/team">Team</a>
          </li>
        <?php else : ?>

        <?php endif; ?>

      </ul>
      <div class="auth-btn flex-lg-row flex-md-column flex-sm-row ">
        <div class="col-lg-6 col-md-12 py-md-1 py-lg-0 me-1">
          <a href="<?= baseurl() ?>/auth/login" class="btn btn-primary btn-sm shadow-sm fw-bold">Log in</a>
        </div>
        <div class="col-lg-12 py-lg-0 py-md-1 ms-2 ms-md-0 ">
          <a href="<?= baseurl() ?>/auth/signup" class="btn btn-primary btn-sm shadow-sm fw-bold">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</nav>