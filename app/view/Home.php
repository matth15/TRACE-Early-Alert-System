<?php

$page_title = "Home";
require_once __DIR__ . '/partials/Header.inc.php'; //HEADER
?>
<header class="header-site " id="home">
  <?php
  require_once(__DIR__ . '/partials/Nav.inc.php') //NABAR
  ?>
  <div class="container early-alert-intro">
    <div class="col-12 col-lg-8">
      <h1>
        <strong><span>TRACE</span> College Early Alert</strong>
      </h1>
      <p>
      "Empowering Success through Vigilance: Trace College's Early Alert System is your academic guardian,
       ensuring your journey is seamless and supported. Stay ahead with timely notifications, personalized interventions,
        and dedicated support, making every challenge an opportunity to thrive. Let us guide you to success, one alert at a time."
      </p>
    </div>
  </div>
</header> <!-- HEADER SITE -->

<main>
  <section class="bg-light" id="about">
    <div class="container">
      <div class="row pt-5">
        <div class="d-block d-lg-flex">
          <div class="about-content col-12 col-lg-6">
            <h2>
              <strong>About</strong>
            </h2>
            <p> <!--  -->
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
              do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Ut enim ad minim veniam, quis nostrud exercitation ullamco
              laboris nisi ut aliquip ex ea commodo consequat. Duis aute
              irure dolor in reprehenderit in voluptate velit esse cillum
              dolore eu fugiat nulla pariatur. Excepteur sint occaecat
              cupidatat non proident, sunt in culpa qui officia deserunt
              mollit anim id est laborum.
            </p>
          </div>
          <div class="trace-ea-logo col-12 col-lg-6 pt-lg-5">
            <img class="img-fluid" src="/public/assets/images/trace-ea-logo-image.png" alt="TRACE College Logo" />
          </div>
        </div>
      </div>
    </div>
  </section> <!--ABOUT-->

  <section class="bg-light" id="mv">
    <div class="container">
      <div class="row py-4">
        <div class="col-lg-6 col-md-12">
          <div class="mv-content shadow rounded-3 ">
            <h5>Mission</h5>
            <p>
              <span></span> To provide a notification system that enables educational institutions to disseminate critical information in a timely way.
              <br>
              <span></span> To determine which students are most likely to experience academic, financial, personal, or social challenges. and,
               to help faculties and administrators be more efficient by giving a more convenient method of helping their students
            </p>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="mv-content shadow rounded-3 ">
            <h5>Vision</h5>
            <p>
            <span>  </span> TRACE Early Alert System envisions itself to be a major tool that will allow schools and education authorities to identify students with special needs and support them in a timely and suitable manner.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- MISSION & VISION -->

  <section class="text-light" id="contact">

  </section> <!-- CONTACT -->
</main>
<script>
  function navigateToSection(sectionId) {
    // Access the section with the specified id
    var section = document.getElementById(sectionId);

    // Scroll to the section
    if (section) {
      section.scrollIntoView({
        behavior: 'smooth' // Optional: Add smooth scrolling effect
      });
    }
  }
</script>
<?php
require_once(__DIR__ . '/partials/Footer.inc.php');
?>