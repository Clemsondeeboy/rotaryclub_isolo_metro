<?php

session_start();

require_once "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$search = trim($_GET['search'] ?? '');

if ($search !== '') {

    $stmt = $conn->prepare("
        SELECT
            id,
            fullname,
            email,
            phone,
            passport,
            status,
            created_at
        FROM membership_applications
        WHERE fullname LIKE ?
           OR email LIKE ?
           OR phone LIKE ?
        ORDER BY id DESC
    ");

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sss",
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $applications = $stmt->get_result();

} else {

    $applications = mysqli_query(
        $conn,
        "SELECT
            id,
            fullname,
            email,
            phone,
            passport,
            status,
            created_at
         FROM membership_applications
         ORDER BY id DESC"
    );
}

$total = 0;
$pending = 0;
$approved = 0;
$rejected = 0;


$result = mysqli_query(
    $conn,
    "SELECT
        COUNT(*) AS total,
        SUM(status = 'Pending') AS pending,
        SUM(status = 'Approved') AS approved,
        SUM(status = 'Rejected') AS rejected
     FROM membership_applications"
);

if ($result) {

    $stats = mysqli_fetch_assoc($result);

    $total = (int)($stats['total'] ?? 0);
    $pending = (int)($stats['pending'] ?? 0);
    $approved = (int)($stats['approved'] ?? 0);
    $rejected = (int)($stats['rejected'] ?? 0);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Membership Applications | Rotary Admin</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">
<link rel="shortcut icon" href="assets/images/white-logo.png" type="image/x-icon">
<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">


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

    color: #f0b400;

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

    background: #f0b400;

    color: #fff;
}


.sidebar a i {

    width: 25px;
}


.sidebar .logout {

    margin-top: 30px;
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

    padding: 20px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.05);

    height: 100%;
}


.stat-card h4 {

    font-weight: 700;

    margin-bottom: 3px;
}


.stat-card p {

    margin: 0;

    color: #6b7280;

    font-size: 14px;
}


.stat-icon {

    width: 45px;

    height: 45px;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 12px;

    font-size: 18px;
}

.table-card {

    background: white;

    border-radius: 15px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.05);

    overflow: hidden;
}


.table-header {

    padding: 20px;

    border-bottom: 1px solid #eee;
}


.table-header h5 {

    font-weight: 700;

    margin-bottom: 3px;
}


.table-header p {

    margin: 0;

    color: #6b7280;

    font-size: 14px;
}

.search-box {

    max-width: 400px;
}


.search-box .form-control {

    border-radius: 9px 0 0 9px;
}


.search-box .btn {

    border-radius: 0 9px 9px 0;
}

.table {

    margin-bottom: 0;
}


.table th {

    background: #f9fafb;

    color: #6b7280;

    font-size: 13px;

    text-transform: uppercase;

    white-space: nowrap;
}


.table td {

    vertical-align: middle;

    white-space: nowrap;
}

.passport {

    width: 45px;

    height: 45px;

    border-radius: 50%;

    object-fit: cover;

    border: 2px solid #eee;
}


.no-photo {

    width: 45px;

    height: 45px;

    border-radius: 50%;

    background: #f1f5f9;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #94a3b8;
}

.status {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;
}


.status-pending {

    background: #fff3cd;

    color: #856404;
}


.status-approved {

    background: #d1e7dd;

    color: #0f5132;
}


.status-rejected {

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


    .topbar {

        padding: 15px;
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


    <a href="dashboard.php">

        <i class="fa-solid fa-gauge"></i>

        <span>Dashboard</span>

    </a>


    <a
    href="membership_applications.php"
    class="active">

        <i class="fa-solid fa-users"></i>

        <span>Membership Applications</span>

    </a>
    <a
    href="members.php">
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


    <div class="logout">

        <a href="logout.php">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Logout</span>

        </a>

    </div>

</div>

<div class="main">


<!-- TOPBAR -->

<div class="topbar">

    <h4>

        Membership Applications

    </h4>


    <div>

        <i class="fa-solid fa-user-circle me-2"></i>

        <?php
        echo htmlspecialchars(
            $_SESSION['admin_name'] ?? 'Administrator'
        );
        ?>

    </div>

</div>


<div class="content">

<div class="mb-4">
<!-- 
    <h3 class="fw-bold">

        Membership Applications

    </h3> -->

    <p class="text-muted">

        Review and manage people who have applied to join the Rotary Club.

    </p>

</div>

<div class="row g-4 mb-4">


<!-- TOTAL -->

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#e8f0fe;color:#2563eb;">

<i class="fa-solid fa-users"></i>

</div>

<h4>

<?php echo $total; ?>

</h4>

<p>Total Applications</p>

</div>

</div>


<!-- PENDING -->

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#fff3cd;color:#856404;">

<i class="fa-solid fa-clock"></i>

</div>

<h4>

<?php echo $pending; ?>

</h4>

<p>Pending</p>

</div>

</div>


<!-- APPROVED -->

<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#d1e7dd;color:#0f5132;">

<i class="fa-solid fa-circle-check"></i>

</div>

<h4>

<?php echo $approved; ?>

</h4>

<p>Approved</p>

</div>

</div>


<div class="col-xl-3 col-md-6">

<div class="stat-card">

<div
class="stat-icon"
style="background:#f8d7da;color:#842029;">

<i class="fa-solid fa-circle-xmark"></i>

</div>

<h4>

<?php echo $rejected; ?>

</h4>

<p>Rejected</p>

</div>

</div>

</div>

<div class="table-card">


<div class="table-header">


<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">


<div>

<h5>

All Applications

</h5>

<p>

Manage membership applications from this page.

</p>

</div>


<!-- SEARCH -->

<form
method="GET"
class="d-flex search-box">

<input
type="text"
name="search"
class="form-control"
placeholder="Search name, email or phone..."
value="<?php echo htmlspecialchars($search); ?>">

<button
type="submit"
class="btn btn-dark">

<i class="fa-solid fa-search"></i>

</button>

</form>


</div>

</div>


<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th>#</th>

<th>Applicant</th>

<th>Contact</th>

<th>Date Applied</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>


<tbody>


<?php if ($applications && mysqli_num_rows($applications) > 0): ?>


<?php $number = 1; ?>


<?php while ($application = mysqli_fetch_assoc($applications)): ?>


<tr>

<td>

<?php echo $number++; ?>

</td>

<td>

<div class="d-flex align-items-center gap-3">


<?php if (!empty($application['passport'])): ?>

<img
src="../uploads/memberships/<?php echo htmlspecialchars($application['passport']); ?>"
class="passport"
alt="Passport">


<?php else: ?>

<div class="no-photo">

<i class="fa-solid fa-user"></i>

</div>

<?php endif; ?>


<div>

<strong>

<?php
echo htmlspecialchars(
    $application['fullname']
);
?>

</strong>

<br>

<small class="text-muted">

<?php
echo htmlspecialchars(
    $application['email']
);
?>

</small>

</div>


</div>

</td>

<td>

<?php
echo htmlspecialchars(
    $application['phone']
);
?>

</td>


<!-- DATE -->

<td>

<?php

echo date(
    "d M Y",
    strtotime($application['created_at'])
);

?>

<br>

<small class="text-muted">

<?php

echo date(
    "h:i A",
    strtotime($application['created_at'])
);

?>

</small>

</td>

<td>

<?php

$status = $application['status'];

$statusClass = "status-pending";

if ($status === "Approved") {

    $statusClass = "status-approved";

} elseif ($status === "Rejected") {

    $statusClass = "status-rejected";

}

?>

<span class="status <?php echo $statusClass; ?>">

<?php echo htmlspecialchars($status); ?>

</span>

</td>

<td>

<a
href="view_application.php?id=<?php echo (int)$application['id']; ?>"
class="btn btn-sm btn-outline-dark">

<i class="fa-solid fa-eye me-1"></i>

View

</a>

</td>


</tr>


<?php endwhile; ?>


<?php else: ?>


<tr>

<td
colspan="6"
class="text-center py-5">


<i
class="fa-solid fa-folder-open fa-3x text-muted mb-3">
</i>


<h6>

No applications found.

</h6>


<?php if ($search !== ''): ?>

<p class="text-muted mb-0">

No application matched:

<strong>
<?php echo htmlspecialchars($search); ?>
</strong>

</p>


<a
href="membership_applications.php"
class="btn btn-sm btn-warning mt-3">

Clear Search

</a>

<?php else: ?>

<p class="text-muted mb-0">

There are currently no membership applications.

</p>

<?php endif; ?>


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