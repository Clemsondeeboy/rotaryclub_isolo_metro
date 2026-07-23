<?php
include "includes/header.php";
include "includes/navbar.php";
?>


<section class="contact-banner py-5">
    <div class="w3l-breadcrumb py-lg-5">
        <div class="container text-center pt-5">

            <h1 class="display-4 fw-bold text-white">
                Contact Us
            </h1>

            <p class="lead text-white">
                We'd Love To Hear From You
            </p>

        </div>
    </div>
</section>

<section class="py-5 mt-5">

<div class="container">
  <div class="getin-touch text-center">
  <h2 class="fw-bold text-primary mb-4">

Get In Touch

</h2>

<p class="text-muted">
Have questions about Rotary Club of Isolo Metro?
</p>
<p class="text-muted mb-5">Want to become a member or partner with us?
Send us a message today.</p>
  </div>
<div class="row">

<div class="col-lg-5">

<div class="contact-box">

<div class="icon">

<i class="fas fa-map-marker-alt"></i>

</div>

<div>

<h5>Visit Us</h5>

<p>

15 Godwin Omonua Street,<br>

Ire-Akari Estate Road,<br>

Isolo, Lagos.

</p>

</div>

</div>


<div class="contact-box">

<div class="icon">

<i class="fas fa-phone"></i>

</div>

<div>

<h5>Call Us</h5>

<p>

+234 706 964 3781

</p>

</div>

</div>


<div class="contact-box">

<div class="icon">

<i class="fas fa-envelope"></i>

</div>

<div>

<h5>Email Us</h5>

<p>

info@rotaryisolometro.org

</p>

</div>

</div>

</div>

<div class="col-lg-7 mt-5 mt-lg-0">

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success">

Your message has been sent successfully.

</div>

<?php } ?>

<?php if(isset($_GET['error'])){ ?>

<div class="alert alert-danger">

Something went wrong. Please try again.

</div>

<?php } ?>

<div class="contact-form">

<h3 class="fw-bold mb-4">

Send Us A Message

</h3>

<form action="contact_process.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<input
type="text"
name="fullname"
class="form-control"
placeholder="Full Name"
required>

</div>

<div class="col-md-6 mb-3">

<input
type="email"
name="email"
class="form-control"
placeholder="Email Address"
required>

</div>

<div class="col-md-6 mb-3">

<input
type="text"
name="phone"
class="form-control"
placeholder="Phone Number" required>

</div>

<div class="col-md-6 mb-3">

<input
type="text"
name="subject"
class="form-control"
placeholder="Subject" required>

</div>

<div class="col-12 mb-3">

<textarea
name="message"
class="form-control"
rows="6"
placeholder="Write your message..."
required></textarea>

</div>

<div class="col-12">

<button
type="submit"
class="btn btn-warning btn-sm">

Send Message

</button>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</section>


<section class="py-5 bg-light">

<div class="container">

<div class="text-center mb-5">

<h2 class="fw-bold text-primary">

Find Us

</h2>

<p class="text-muted">

Visit Rotary Club of Isolo Metro or attend one of our weekly meetings.

</p>

</div>

<div class="rounded-4 overflow-hidden shadow">

<iframe
src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.0094048195037!2d3.322441599670996!3d6.520491546400208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8ffe30b943e1%3A0x2bfd2cafa16bc9e7!2sSaykins%20Events%20World!5e0!3m2!1sen!2sng!4v1747306672059!5m2!1sen!2sng"
width="100%"
height="450"
style="border:0;"
allowfullscreen=""
loading="lazy">
</iframe>

</div>

</div>

</section>


<section class="py-5">

<div class="container">

<div class="text-center">

<h2 class="fw-bold text-primary">

Stay Connected

</h2>

<p class="text-muted mb-4">

Follow Rotary Club of Isolo Metro on our social media platforms.

</p>

<div class="social-icons">

<a href="#" class="social-btn">

<i class="fab fa-facebook-f"></i>

</a>

<a href="#" class="social-btn">

<i class="fab fa-instagram"></i>

</a>

<a href="#" class="social-btn">

<i class="fab fa-linkedin-in"></i>

</a>

<a href="#" class="social-btn">

<i class="fab fa-youtube"></i>

</a>

</div>

</div>

</div>

</section>

<?php
include "includes/footer.php";
?>