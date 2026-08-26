<?php

session_start();

require_once "../config/db.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: membership_applications.php");
    exit();
}


$stmt = $conn->prepare("
    SELECT
        id,
        fullname,
        email,
        phone,
        gender,
        dob,
        occupation,
        organization,
        address,
        reason,
        passport,
        status,
        created_at
    FROM membership_applications
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    $stmt->close();

    header("Location: membership_applications.php");
    exit();
}

$application = $result->fetch_assoc();

$stmt->close();


$status = $application['status'];

$statusClass = "status-pending";

if ($status === "Approved") {
    $statusClass = "status-approved";
} elseif ($status === "Rejected") {
    $statusClass = "status-rejected";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
View Application | Rotary Admin
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

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

    width: 250px;

    height: 100vh;

    background: #003dc2;

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


.card-box {

    background: white;

    border-radius: 16px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.06);

    padding: 30px;

    margin-bottom: 25px;
}


.profile-section {

    display: flex;

    align-items: center;

    gap: 25px;

    padding-bottom: 25px;

    border-bottom: 1px solid #eee;
}


.passport {

    width: 140px;

    height: 160px;

    object-fit: cover;

    border-radius: 12px;

    border: 1px solid #ddd;
}


.no-photo {

    width: 140px;

    height: 160px;

    border-radius: 12px;

    background: #f1f5f9;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #94a3b8;

    font-size: 45px;
}


.profile-info h3 {

    font-weight: 700;

    margin-bottom: 5px;
}


.profile-info p {

    margin-bottom: 5px;

    color: #6b7280;
}

.status {

    display: inline-block;

    padding: 7px 14px;

    border-radius: 20px;

    font-size: 13px;

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

.info-title {

    font-size: 18px;

    font-weight: 700;

    margin-bottom: 20px;
}


.info-item {

    margin-bottom: 20px;
}


.info-label {

    display: block;

    color: #6b7280;

    font-size: 13px;

    margin-bottom: 5px;
}


.info-value {

    font-weight: 500;

    word-break: break-word;
}

.reason-box {

    background: #f8fafc;

    border-left: 4px solid #f0b400;

    padding: 20px;

    border-radius: 8px;

    line-height: 1.7;

    white-space: pre-line;
}

.action-box {

    display: flex;

    gap: 10px;

    flex-wrap: wrap;
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

    .profile-section {

        flex-direction: column;

        text-align: center;
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

        Application Details

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


<!-- CONTENT -->

<div class="content">


<!-- BACK BUTTON -->

<div class="mb-4">

    <a
    href="membership_applications.php"
    class="btn btn-outline-dark">

        <i class="fa-solid fa-arrow-left me-2"></i>

        Back to Applications

    </a>

</div>

<div class="card-box">


<div class="profile-section">


<!-- PASSPORT -->

<div>

<?php if (!empty($application['passport'])): ?>

<img
src="../uploads/memberships/<?php echo htmlspecialchars($application['passport']); ?>"
class="passport"
alt="Passport Photograph">

<?php else: ?>

<div class="no-photo">

<i class="fa-solid fa-user"></i>

</div>

<?php endif; ?>

</div>


<!-- PROFILE INFORMATION -->

<div class="profile-info">

<h3>

<?php

echo htmlspecialchars(
    $application['fullname']
);

?>

</h3>


<p>

<i class="fa-solid fa-envelope me-2"></i>

<?php

echo htmlspecialchars(
    $application['email']
);

?>

</p>


<p>

<i class="fa-solid fa-phone me-2"></i>

<?php

echo htmlspecialchars(
    $application['phone']
);

?>

</p>


<p class="mt-3">

<span class="status <?php echo $statusClass; ?>">

<?php

echo htmlspecialchars(
    $status
);

?>

</span>

</p>

</div>


</div>


</div>
<div class="card-box">


<div class="info-title">

<i class="fa-solid fa-user me-2"></i>

Personal Information

</div>


<div class="row">


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Full Name
</span>

<div class="info-value">

<?php

echo htmlspecialchars(
    $application['fullname']
);

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Gender
</span>

<div class="info-value">

<?php

echo htmlspecialchars(
    $application['gender']
);

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Date of Birth
</span>

<div class="info-value">

<?php

if (!empty($application['dob'])) {

    echo date(
        "d F Y",
        strtotime($application['dob'])
    );

} else {

    echo "Not provided";

}

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Phone Number
</span>

<div class="info-value">

<?php

echo htmlspecialchars(
    $application['phone']
);

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Email Address
</span>

<div class="info-value">

<?php

echo htmlspecialchars(
    $application['email']
);

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Occupation
</span>

<div class="info-value">

<?php

echo !empty($application['occupation'])
    ? htmlspecialchars($application['occupation'])
    : "Not provided";

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Organization
</span>

<div class="info-value">

<?php

echo !empty($application['organization'])
    ? htmlspecialchars($application['organization'])
    : "Not provided";

?>

</div>

</div>

</div>


<div class="col-md-6">

<div class="info-item">

<span class="info-label">
Application Date
</span>

<div class="info-value">

<?php

echo date(
    "d F Y, h:i A",
    strtotime($application['created_at'])
);

?>

</div>

</div>

</div>


<div class="col-md-12">

<div class="info-item">

<span class="info-label">
Residential Address
</span>

<div class="info-value">

<?php

echo !empty($application['address'])
    ? nl2br(htmlspecialchars($application['address']))
    : "Not provided";

?>

</div>

</div>

</div>


</div>


</div>

<div class="card-box">


<div class="info-title">

<i class="fa-solid fa-heart me-2"></i>

Why They Want To Become A Rotarian

</div>


<div class="reason-box">

<?php

echo nl2br(
    htmlspecialchars(
        $application['reason']
    )
);

?>

</div>


</div>

<div class="card-box">


<div class="info-title">

<i class="fa-solid fa-clipboard-check me-2"></i>

Application Decision

</div>


<div class="action-box">


<?php if ($status === "Pending"): ?>


<form
action="membership_action.php"
method="POST"
onsubmit="return confirm('Are you sure you want to approve this application?');">

<input
type="hidden"
name="id"
value="<?php echo (int)$application['id']; ?>">

<input
type="hidden"
name="action"
value="approve">


<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-check me-2"></i>

Approve Application

</button>

</form>


<form
action="membership_action.php"
method="POST"
onsubmit="return confirm('Are you sure you want to reject this application?');">

<input
type="hidden"
name="id"
value="<?php echo (int)$application['id']; ?>">

<input
type="hidden"
name="action"
value="reject">


<button
type="submit"
class="btn btn-danger">

<i class="fa-solid fa-xmark me-2"></i>

Reject Application

</button>

</form>


<?php elseif ($status === "Approved"): ?>


<div class="alert alert-success mb-0">

<i class="fa-solid fa-circle-check me-2"></i>

This application has been approved.

</div>


<?php elseif ($status === "Rejected"): ?>


<div class="alert alert-danger mb-0">

<i class="fa-solid fa-circle-xmark me-2"></i>

This application has been rejected.

</div>


<?php endif; ?>


</div>


</div>


</div>

</div>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>