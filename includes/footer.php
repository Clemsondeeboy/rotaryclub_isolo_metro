<footer class="footer">

<div class="container">

<div class="row">

<div class="col-lg-4">

<h4>
<img src="assets/images/metro-logo.png" alt="rotary-logo" height="80">
</h4>

<p>

<?php echo $site['about']; ?>

</p>

</div>

<div class="col-lg-4">

<h5>Quick Links</h5>

<ul class="list-unstyled">

<li><a href="index.php">Home</a></li>

<li><a href="about.php">About</a></li>

<li><a href="projects.php">Projects</a></li>

<li><a href="events.php">Events</a></li>

<li><a href="gallery.php">Gallery</a></li>

</ul>

</div>

<div class="col-lg-4">

<h5>Contact</h5>

<p>
  <i class="fa fa-location-dot"></i>  8/10 Oludegun St, off Ire-Akari Estate Road, Oshodi/Isolo Lagos
</p>

<p>
  <i class="fa fa-phone"></i>  +234 706 964 3781
</p>

<p>

<i class="fa fa-envelope"></i>

<?php echo $site['email']; ?>

</p>

</div>

</div>

<hr>

<div class="text-center">

© <?php echo date("Y"); ?>

<?php echo $site['site_name']; ?>

All Rights Reserved.

</div>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js"></script>

<script>

lightbox.option({

'resizeDuration':300,

'wrapAround':true,

'fadeDuration':300,

'imageFadeDuration':300

});

</script>
</body>

</html>
