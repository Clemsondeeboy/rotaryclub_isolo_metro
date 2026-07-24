<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">

<div class="container">

<a class="navbar-brand d-flex" href="index.php">

<?php
if(!empty($site['logo'])){
?>

<img src="uploads/settings/<?php echo $site['logo']; ?>">

<?php
}else{
?>

<h3 class="text-primary m-0">
  <img src="assets/images/metro-logo.png" alt="rotary-logo">
</h3>

<?php
}
?>

</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'about.php')? 'active' :'';?>" href="about.php">About</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'projects.php')? 'active' :'';?>" href="projects.php">Projects</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'events.php')? 'active' :'';?>" href="events.php">Events</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'gallery.php')? 'active' :'';?>" href="gallery.php">Gallery</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'news.php')? 'active' :'';?>" href="news.php">News</a>

</li>

<li class="nav-item">

<a class="nav-link <?php echo ($current_page == 'contact.php')? 'active' :'';?>" href="contact.php">Contact</a>

</li>

</ul>

<a href="join.php" class="btn btn-warning ms-3 px-4">
Join Us
</a>

</div>

</div>

</nav>