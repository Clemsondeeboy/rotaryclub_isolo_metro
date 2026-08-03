<?php

include "includes/header.php";
include "includes/navbar.php";

?>

<div id="heroSlider" class="carousel slide carousel-fade" data-bs-ride="carousel">

    <!-- <div class="carousel-indicators">

        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active"></button>

        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1"></button>

        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="2"></button>

    </div> -->

    <div class="carousel-inner">
        <div class="carousel-item active">

           <img src="assets/images/slide1.png" class="d-block w-100">

            <div class="carousel-overlay"></div>

            <div class="carousel-caption">

                <h1><?php echo $site['site_name']; ?></h1>

                <h4><?php echo $site['slogan']; ?></h4>

                <p>
                    Together we transform communities through
                    humanitarian service, leadership and fellowship.
                </p>

               <div class="caption-button">
               <a href="about.php" class="btn btn-warning btn-lg">
                    Learn More
                </a>

                <a href="join.php" class="btn btn-outline-light btn-lg">
                    Join Us
                </a>
               </div>

            </div>

        </div>

        <div class="carousel-item">

            <img src="assets/images/slide2.png" class="d-block w-100 hero-img">

            <div class="carousel-overlay"></div>

            <div class="carousel-caption">

                <h1>Service Above Self</h1>

                <p>
                    Creating lasting change in Isolo Metro through
                    impactful community projects.
                </p>

                <a href="projects.php" class="btn btn-warning btn-lg">
                    Our Projects
                </a>

            </div>

        </div>


        <div class="carousel-item">

            <img src="assets/images/slide3.png" class="d-block w-100 hero-img">

            <div class="carousel-overlay"></div>

            <div class="carousel-caption">

                <h1>Join Rotary Today</h1>

                <p>
                    Together we can inspire hope, empower youth
                    and improve lives.
                </p>

                <a href="contact.php" class="btn btn-warning btn-lg">
                    Contact Us
                </a>

            </div>

        </div>

    </div>


    <button class="carousel-control-prev"
        type="button"
        data-bs-target="#heroSlider"
        data-bs-slide="prev">

        <span class="carousel-control-prev-icon"></span>

    </button>

    <button class="carousel-control-next"
        type="button"
        data-bs-target="#heroSlider"
        data-bs-slide="next">

        <span class="carousel-control-next-icon"></span>

    </button>

</div>


<section class="fellowship-section mt-5">

<div class="container">

<div class="top-title text-center">

<h2>CREATE LASTING IMPACT</h2>

</div>

<div class="welcome-box">

<h1>

YOU ARE WELCOME TO <br>

OUR FELLOWSHIP

</h1>

<div class="row g-3 mt-5">

<div class="col-lg-3 col-md-6">

<div class="leader-card">

<img src="assets/images/paul harris.png" class="img-fluid">

<div class="leader-info">

<h5>Paul Harris</h5>

<p>Founder</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="leader-card">

<img src="assets/images/olayinka hakeem.png" class="img-fluid">

<div class="leader-info">

<h5>Olayinka Hakeem B.</h5>

<p>RI President (2026–2027)</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="leader-card">

<img src="assets/images/bukola olabisi.png" class="img-fluid">

<div class="leader-info">

<h5>Bukola Olabisi B.</h5>

<p>DG District 9111 (2026–2027)</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="leader-card">

<img src="assets/images/lu abikoye.png" class="img-fluid">

<div class="leader-info">

<h5>LU Abikoye</h5>

<p>President (2026–2027)</p>

</div>

</div>

</div>

</div>

</div>

</div>

</section>

<section class="latest-projects">
       <div class="w3l-blog-block-5 " id="blog">
      <div class="container py-md-5">
        <div
          class="title-main text-center mx-auto mb-md-5 mb-4"
          style="max-width: 700px"
        >
          <h5 class="small-title mb-2">projects</h5>
          <h3 class="title-style">Our Lastest Projects</h3>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 mt-md-0 mt-4">
            <div class="blog-card-single mt-5">
              <div class="grids5-info">
                <a href="#blog"><img src="assets/images/healthcare.png" alt="" /></a>
                <div class="blog-info">
                  <h4><a href="#blog">Rotary Club of Isolo Metropolitan Sponsors Vision 2025 Eye Cataract Surgery</a></h4>
                  <p>
                    With a heart committed to service and a vision for a brighter future, the Rotary Club of Isolo Metropolitan proudly sponsored the **Eye Cataract Surgery Initiative**, organized by District 9111 under the banner of *Vision 2025*.
                  </p>
                  <div
                    class="d-flex align-items-center justify-content-between mt-4"
                  >
                    <a
                      href="http://rotaryisolometro.org/events/2025/01/17/rotary-club-of-isolo-metropolitan-sponsors-vision-2025-eye-cataract-surgery/" target="_blank"
                      class="btn btn-warning"
                      >Read More<i class="fas fa-arrow-right ms-1"></i
                    ></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="blog-card-single mt-5">
              <div class="grids5-info">
                <a href="#blog"><img src="assets/images/projects4.png" alt="" /></a>
                <div class="blog-info">
                  <h4>
                    <a href="#blog">The “Say No to Hunger” project aimed to combat food insecurity by providing meals to vulnerable individuals and families in the community @ Ikotun Roundabout, Lagos</a>
                  </h4>
                  <p>
                    All reactions: 2Rotary Club of Isolo Metropolitan and 1 other
                  </p>
                  <div
                    class="d-flex align-items-center justify-content-between mt-4"
                  >
                    <a
                      href="http://rotaryisolometro.org/events/2024/12/07/the-say-no-to-hunger-project-aimed-to-combat-food-insecurity-by-providing-meals-to-vulnerable-individuals-and-families-in-the-community-ikotun-roundabout-lagos/" target="_blank"
                      class="btn btn-warning"
                      >Read More<i class="fas fa-arrow-right ms-1"></i
                    ></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-lg-0 mt-4">
            <div class="blog-card-single mt-5">
              <div class="grids5-info">
                <a href="#blog"><img src="assets/images/projects3.png" alt="" /></a>
                <div class="blog-info">
                  <h4>
                    <a href="http://rotaryisolometro.org/events/2024/11/22/at-the-interact-club-of-matori-grammar-school-we-marked-the-world-interact-week-with-a-meaningful-talk-on-basic-education-and-literacy/" target="_blank">At the Interact Club of Matori Grammar School, we marked the World Interact Week with a meaningful talk on Basic Education and Literacy .</a>
                  </h4>
                  <p>
                    led by the Rotary President, Rtn. Adefunke Shodunke, others are President-Elect Rtn. Ganiyu Mapelujo, and…
                  </p>
                  <div
                    class="d-flex align-items-center justify-content-between mt-4"
                  >
                    <a
                    href="http://rotaryisolometro.org/events/2024/11/22/at-the-interact-club-of-matori-grammar-school-we-marked-the-world-interact-week-with-a-meaningful-talk-on-basic-education-and-literacy/" target="_blank"
                       class="btn btn-warning"
                      >Read More<i class="fas fa-arrow-right ms-1"></i
                    ></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php

include "includes/footer.php";

?>