<?php
include "includes/header.php";
include "includes/navbar.php";
?>


<section class="py-5">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-9">

<div class="card shadow round-4 border-0">

<div class="card-body p-5">

<h2 class="text-center mb-4">

Membership Application Form

</h2>

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success">

Your membership application has been submitted successfully.
We will contact you shortly.

</div>

<?php } ?>

<?php if(isset($_GET['error'])){ ?>

<div class="alert alert-danger">

Something went wrong. Please try again.

</div>

<?php } ?>

<form
action="join_process.php"
method="POST"
enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email Address</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Phone Number</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Gender</label>

<select
name="gender"
class="form-select"
required>

<option value="">Select Gender</option>

<option>Male</option>

<option>Female</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Date of Birth</label>

<input
type="date"
name="dob"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Occupation</label>

<input
type="text"
name="occupation"
class="form-control">

</div>

<div class="col-md-12 mb-3">

<label>Company / Organization</label>

<input
type="text"
name="organization"
class="form-control">

</div>

<div class="col-md-12 mb-3">

<label>Residential Address</label>

<textarea
name="address"
rows="3"
class="form-control"></textarea>

</div>

<div class="col-md-12 mb-3">

<label>Why do you want to become a Rotarian?</label>

<textarea
name="reason"
rows="5"
class="form-control"
required></textarea>

</div>

<div class="col-md-12 mb-4">

<label>Passport Photograph</label>

<input
type="file"
name="passport"
accept="image/*"
class="form-control">

</div>

<div class="col-md-12">

<div class="form-check mb-4">

<input
type="checkbox"
class="form-check-input"
required>

<label class="form-check-label">

I certify that the information provided above is correct.

</label>

</div>

<button
type="submit"
class="btn btn-warning btn-lg">

Submit Application

</button>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</section>

<?php include "includes/footer.php"; ?>