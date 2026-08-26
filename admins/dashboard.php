<?php

session_start();

require_once "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['admin_name'] ?? 'Administrator';

$totalApplications = 0;
$pendingApplications = 0;
$approvedApplications = 0;
$rejectedApplications = 0;

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM membership_applications"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalApplications = (int)$row['total'];
}

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM membership_applications
     WHERE status = 'Pending'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $pendingApplications = (int)$row['total'];
}


$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM membership_applications
     WHERE status = 'Approved'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $approvedApplications = (int)$row['total'];
}

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM membership_applications
     WHERE status = 'Rejected'"
);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $rejectedApplications = (int)$row['total'];
}


$recentApplications = mysqli_query(
    $conn,
    "SELECT
        id,
        fullname,
        email,
        status,
        created_at
     FROM membership_applications
     ORDER BY id DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard | Rotary Club</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

    <link rel="shortcut icon" href="assets/images/white-logo.png" type="image/x-icon">

<style>

body {
    background: #f5f7fa;
}

.sidebar {

    position: fixed;

    top: 0;
    left: 0;

    /* width: 250px; */

    height: 100vh;

    background: #02287a;

    color: white;

    padding-top: 20px;
}


.sidebar .brand {

    text-align: center;

    font-size: 21px;

    font-weight: 700;

    padding: 15px 10px 30px;
}


.sidebar .brand i {

    color: #ffc107;

    margin-right: 8px;
}


.sidebar a {

    display: block;

    color: #d1d5db;

    text-decoration: none;

    padding: 13px 25px;

    transition: 0.2s;
}


.sidebar a:hover,
.sidebar a.active {


    background: #ffc107;

    color: #fff;
}


.sidebar a i {

    width: 25px;
}


.main {

    margin-left: 250px;

    min-height: 100vh;
}

.topbar {

    background: white;

    padding: 18px 30px;

    box-shadow: 0 2px 10px rgba(0,0,0,0.06);

    display: flex;

    justify-content: space-between;

    align-items: center;
}


.topbar h4 {

    margin: 0;

    font-weight: 700;
}

.content {

    padding: 30px;
}

.stat-card {

    background: white;

    border-radius: 15px;

    padding: 25px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.06);

    height: 100%;
}


.stat-icon {

    width: 55px;

    height: 55px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;

    margin-bottom: 15px;
}


.stat-card h2 {

    font-weight: 700;

    margin-bottom: 4px;
}


.stat-card p {

    color: #6b7280;

    margin: 0;
}

.table-card {

    background: white;

    border-radius: 15px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.06);

    overflow: hidden;
}


.table-card .card-header {

    background: white;

    padding: 20px;

    border-bottom: 1px solid #eee;
}


.table th {

    font-size: 13px;

    text-transform: uppercase;

    color: #6b7280;
}


.badge-pending {

    background: #fff3cd;

    color: #856404;
}


.badge-approved {

    background: #d1e7dd;

    color: #0f5132;
}


.badge-rejected {

    background: #f8d7da;

    color: #842029;
}

@media(max-width: 768px) {

    .sidebar {

        width: 70px;
    }

    .sidebar .brand span,
    .sidebar a span {

        display: none;
    }

    .sidebar a {

        text-align: center;

        padding: 15px 5px;
    }

    .sidebar a i {

        width: auto;

        font-size: 18px;
    }

    .main {

        margin-left: 70px;
    }

    .content {

        padding: 20px;
    }

}

</style>

</head>

<body>

<div class="sidebar">

    <div class="brand">

        <i class="fa-solid fa-users-gear"></i>

        <span>Rotary Admin</span>

    </div>


    <a href="dashboard.php" class="active">

        <i class="fa-solid fa-gauge"></i>

        <span>Dashboard</span>

    </a>


    <a href="membership_applications.php">

        <i class="fa-solid fa-users"></i>

        <span>Membership Applications</span>

    </a>

    <a href="members.php">

        <i class="fa-solid fa-users"></i>

        <span>Members</span>

    </a>


    <a href="#">

        <i class="fa-solid fa-calendar-days"></i>

        <span>Events</span>

    </a>


    <a href="#">

        <i class="fa-solid fa-images"></i>

        <span>Gallery</span>

    </a>


    <a href="#">

        <i class="fa-solid fa-gear"></i>

        <span>Settings</span>

    </a>


    <div style="margin-top: 30px;">

        <a href="login.php">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Logout</span>

        </a>

    </div>

</div>

<div class="main">
<div class="topbar">

    <div>

        <h4>Dashboard</h4>

    </div>


    <div>

        <i class="fa-solid fa-user-circle me-2"></i>

        <?php echo htmlspecialchars($adminName); ?>

    </div>

</div>

<div class="content">


<div class="mb-4">

    <h3 class="fw-bold">
        Welcome, <?php echo htmlspecialchars($adminName); ?> 👋
    </h3>

    <p class="text-muted">
        Here's what's happening with your membership applications.
    </p>

</div>

<div class="row g-4 mb-4">

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#e8f0fe; color:#2563eb;">

<i class="fa-solid fa-users"></i>

</div>

<h2>
<?php echo $totalApplications; ?>
</h2>

<p>Total Applications</p>

</div>

</div>

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#fff3cd; color:#856404;">

<i class="fa-solid fa-clock"></i>

</div>

<h2>
<?php echo $pendingApplications; ?>
</h2>

<p>Pending</p>

</div>

</div>


<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#d1e7dd; color:#0f5132;">

<i class="fa-solid fa-circle-check"></i>

</div>

<h2>
<?php echo $approvedApplications; ?>
</h2>

<p>Approved</p>

</div>

</div>

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#f8d7da; color:#842029;">

<i class="fa-solid fa-circle-xmark"></i>

</div>

<h2>
<?php echo $rejectedApplications; ?>
</h2>

<p>Rejected</p>

</div>

</div>

</div>

<div class="table-card">

<div class="card-header d-flex justify-content-between align-items-center">

<div>

<h5 class="mb-1 fw-bold">
Recent Membership Applications
</h5>

<small class="text-muted">
Latest 5 applications
</small>

</div>


<a
href="membership_applications.php"
class="btn btn-warning">

View All

</a>

</div>


<div class="table-responsive">

<table class="table table-hover mb-0">

<thead>

<tr>

<th>Applicant</th>

<th>Email</th>

<th>Date Applied</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>


<tbody>

<?php if ($recentApplications && mysqli_num_rows($recentApplications) > 0): ?>

<?php while ($application = mysqli_fetch_assoc($recentApplications)): ?>

<tr>

<td>

<strong>
<?php echo htmlspecialchars($application['fullname']); ?>
</strong>

</td>


<td>

<?php echo htmlspecialchars($application['email']); ?>

</td>


<td>

<?php

echo date(
    "d M Y",
    strtotime($application['created_at'])
);

?>

</td>


<td>

<?php

$status = $application['status'];

$badgeClass = "badge-pending";

if ($status === "Approved") {

    $badgeClass = "badge-approved";

} elseif ($status === "Rejected") {

    $badgeClass = "badge-rejected";
}

?>

<span class="badge <?php echo $badgeClass; ?>">

<?php echo htmlspecialchars($status); ?>

</span>

</td>


<td>

<a
href="view_application.php?id=<?php echo $application['id']; ?>"
class="btn btn-sm btn-outline-dark">

<i class="fa-solid fa-eye"></i>

View

</a>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="5" class="text-center py-5">

<i
class="fa-solid fa-users-slash fa-2x text-muted mb-3">
</i>

<p class="mb-0 text-muted">
No membership applications yet.
</p>

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>


</div>

</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>