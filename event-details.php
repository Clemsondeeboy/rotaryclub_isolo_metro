<?php
include("includes/recent-events.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!isset($recentEvents[$id])) {
    die("Event not found.");
}

$event = $recentEvents[$id];

include("includes/header.php");
include("includes/navbar.php");

$totalEvents = count($recentEvents);

$prev = ($id > 1) ? $id - 1 : null;
$next = ($id < $totalEvents) ? $id + 1 : null;
?>

<style>
.hero-image{
    width:100%;
    height:420px;
    object-fit:cover;
    border-radius:15px;
}

.sidebar-card{
    border:none;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.event-content p{
    font-size:17px;
    line-height:1.9;
    color:#555;
}

.info-box{
    background:#fff8e1;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.gallery img{
    border-radius:10px;
    transition:.3s;
    cursor:pointer;
}

.gallery img:hover{
    transform:scale(1.04);
}

.badge-category{
    background:#ffc107;
    color:#000;
    padding:8px 15px;
    font-size:14px;
}

.share-btn a{
    margin-right:8px;
}
</style>

<section class="py-5">

<div class="container">

<div class="row">

<!-- LEFT -->

<div class="col-lg-8">

<img
src="assets/images/<?php echo $event['image']; ?>"
class="hero-image shadow mb-4"
alt="<?php echo $event['title']; ?>">
<span class="badge badge-category mb-3">

<?php echo $event['category']; ?>

</span>

<h2 class="fw-bold mt-3">

<?php echo $event['title']; ?>

</h2>

<p class="text-muted">

<i class="fas fa-calendar-alt text-warning"></i>

<?php echo $event['date']; ?>

</p>

<div class="info-box">

<div class="row">

<div class="col-md-6">

<strong>Author</strong><br>

<?php echo $event['author']; ?>

</div>

<div class="col-md-6">

<strong>Location</strong><br>

<?php echo $event['location']; ?>

</div>

</div>

</div>

<div class="event-content">

<?php echo $event['content']; ?>

</div>

<?php if (!empty($event['gallery'])) { ?>

<hr class="my-5">

<h4 class="fw-bold mb-4">
    Photo Gallery
</h4>

<div class="row gallery">

<?php foreach ($event['gallery'] as $img) { ?>

    <div class="col-lg-4 col-md-6 col-6 mb-4">

        <img
            src="assets/images/<?php echo $img; ?>"
            class="img-fluid rounded shadow"
            alt="Gallery Image">

    </div>

<?php } ?>

</div>

<?php } ?>

<hr class="mt-5">

<div class="d-flex justify-content-between">

<div>

<?php

if($prev){

?>

<a
href="event-details.php?id=<?php echo $prev; ?>"
class="btn btn-outline-warning">

<i class="fas fa-arrow-left"></i>

Previous

</a>

<?php

}

?>

</div>

<div>

<?php

if($next){

?>

<a
href="event-details.php?id=<?php echo $next; ?>"
class="btn btn-warning">

Next

<i class="fas fa-arrow-right"></i>

</a>

<?php

}

?>

</div>

</div>

<div class="mt-4">


</div>

</div>



<div class="col-lg-4">

<div class="card sidebar-card">

<div class="card-body">

<h4 class="fw-bold">

Recent Activities

</h4>

<hr>

<?php

foreach($recentEvents as $key=>$item){

?>

<div class="mb-4 <?php echo ($key == $id) ? 'border-start border-4 border-warning ps-2' : ''; ?>">

<a
href="event-details.php?id=<?php echo $key; ?>"
class="text-decoration-none text-dark">

<img

src="assets/images/<?php echo $item['image']; ?>"

class="img-fluid rounded shadow-sm mb-2">

<h6 class="fw-bold">

<?php echo $item['title']; ?>

</h6>

</a>

<small class="text-muted">

<?php echo $item['date']; ?>

</small>

</div>

<hr>

<?php

}

?>

<h5 class="fw-bold mt-4">

Share This Event

</h5>

<div class="share-btn mt-3">

<a href="#"
class="btn btn-primary">

<i class="fab fa-facebook-f"></i>

</a>

<a href="#"
class="btn btn-success">

<i class="fab fa-whatsapp"></i>

</a>

<a href="#"
class="btn btn-info">

<i class="fab fa-twitter"></i>

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</section>

<?php

include("includes/footer.php");

?>