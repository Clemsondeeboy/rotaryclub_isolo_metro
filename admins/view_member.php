<?php

session_start();

require_once "../config/db.php";

/*
|--------------------------------------------------------------------------
| ADMIN PROTECTION
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| GET MEMBER ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: members.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| GET MEMBER
|--------------------------------------------------------------------------
*/

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
        membership_id,
        approved_at,
        created_at
    FROM membership_applications
    WHERE id = ?
    AND status = 'Approved'
    LIMIT 1
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    $stmt->close();

    header("Location: members.php");
    exit();
}

$member = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| MEMBER PHOTO
|--------------------------------------------------------------------------
*/

$photo = "";

if (!empty($member['passport'])) {

    $photoPath = "../uploads/memberships/" . $member['passport'];

    if (file_exists($photoPath)) {
        $photo = $photoPath;
    }
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
<?php echo htmlspecialchars($member['fullname']); ?> | Rotary Member
</title>


<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<!-- Font Awesome -->

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">


<style>

/* =========================================================
   BODY
========================================================= */

body {

    margin: 0;

    background: #f5f7fa;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: #111827;
}


/* =========================================================
   SIDEBAR
========================================================= */

.sidebar {

    position: fixed;

    top: 0;
    left: 0;

    width: 250px;

    height: 100vh;

    background: #02287a;

    color: white;

    padding-top: 20px;

    z-index: 1000;
}


.brand {

    text-align: center;

    font-size: 21px;

    font-weight: 700;

    padding: 15px 10px 30px;
}


.brand i {

    color: #ffc107;

    margin-right: 8px;
}


.sidebar a {

    display: block;

    color: #d1d5db;

    text-decoration: none;

    padding: 14px 25px;

    font-size: 15px;

    transition: .2s;
}


.sidebar a:hover {


    background: #ffc107;

    color: #fff;
}


.sidebar a.active {


    background: #02287a;

    color: #ffc107;
}


.sidebar a i {

    width: 25px;
}


.logout {

    margin-top: 30px;
}


.main {

    margin-left: 250px;

    min-height: 100vh;
}


.topbar {

    height: 70px;

    background: white;

    padding: 0 30px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 2px 10px rgba(0,0,0,.05);
}


.topbar h4 {

    margin: 0;

    font-weight: 700;
}


.admin-name {

    color: #374151;

    font-size: 15px;
}


.content {

    padding: 35px 30px;
}


.back-btn {

    display: inline-block;

    margin-bottom: 20px;

    text-decoration: none;

    color: #374151;

    font-size: 14px;
}


.back-btn:hover {

    color: #111827;
}


.profile-card {

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 5px 25px rgba(0,0,0,.06);
}

.profile-header {

    background: #02287a;

    color: white;

    padding: 35px;

    display: flex;

    align-items: center;

    gap: 25px;
}


.profile-photo {

    width: 120px;

    height: 120px;

    border-radius: 50%;

    object-fit: cover;

    border: 5px solid white;

    background: #e5e7eb;
}


.no-photo {

    width: 120px;

    height: 120px;

    border-radius: 50%;

    background: #e5e7eb;

    color: #6b7280;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 45px;

    border: 5px solid white;
}


.profile-name {

    font-size: 28px;

    font-weight: 700;

    margin-bottom: 8px;
}


.profile-id {

    display: inline-block;

    background: #ffc107;

    color: #111827;

    padding: 7px 13px;

    border-radius: 7px;

    font-weight: 700;

    font-size: 13px;
}

.active-badge {

    display: inline-block;

    background: #d1e7dd;

    color: #0f5132;

    padding: 7px 13px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

    margin-left: 8px;
}


.profile-body {

    padding: 35px;
}


.section-title {

    font-size: 18px;

    font-weight: 700;

    margin-bottom: 20px;

    padding-bottom: 12px;

    border-bottom: 1px solid #e5e7eb;
}


.info-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

    margin-bottom: 35px;
}


.info-box {

    background: #f8fafc;

    border-radius: 10px;

    padding: 16px;
}


.info-label {

    color: #64748b;

    font-size: 12px;

    text-transform: uppercase;

    margin-bottom: 6px;

    font-weight: 600;
}


.info-value {

    font-size: 15px;

    color: #111827;

    word-break: break-word;
}


.text-box {

    background: #f8fafc;

    padding: 18px;

    border-radius: 10px;

    color: #374151;

    line-height: 1.7;

    margin-bottom: 25px;
}


.actions {

    padding-top: 25px;

    border-top: 1px solid #e5e7eb;

    display: flex;

    gap: 10px;

    flex-wrap: wrap;
}


.btn-print {

    background: #ffc107;

    color: #111827;

    border: none;

    padding: 11px 18px;

    border-radius: 8px;

    font-weight: 600;
}


.btn-print:hover {

    background: #e0a800;

}


.btn-back {

    background: #111827;

    color: white;

    border: none;

    padding: 11px 18px;

    border-radius: 8px;

    text-decoration: none;
}


.btn-back:hover {


    background: #02287a;

    color: #ffc107;
}

@media(max-width: 900px) {

    .sidebar {

        width: 70px;
    }

    .brand span,
    .sidebar a span {

        display: none;
    }

    .sidebar a {

        text-align: center;

        padding: 15px 5px;
    }

    .sidebar a i {

        width: auto;
    }

    .main {

        margin-left: 70px;
    }

}


@media(max-width: 650px) {

    .content {

        padding: 20px 15px;
    }

    .topbar {

        padding: 0 15px;
    }

    .admin-name {

        display: none;
    }

    .profile-header {

        flex-direction: column;

        text-align: center;
    }

    .profile-body {

        padding: 20px;
    }

    .info-grid {

        grid-template-columns: 1fr;
    }

}


@media print {

* {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
}

body {
    background: white !important;
}

.sidebar,
.topbar,
.back-btn,
.actions {
    display: none !important;
}

.main {
    margin-left: 0 !important;
}

.content {
    padding: 0 !important;
}

.profile-card {
    box-shadow: none !important;
    border: 1px solid #ddd !important;
}

.profile-header {
    background: #111827 !important;
    color: white !important;
    border-bottom: none !important;
}

.profile-id {
    background: #ffc107 !important;
    color: #111827 !important;
    border: none !important;
}

.active-badge {
    background: #d1e7dd !important;
    color: #0f5132 !important;
    border: none !important;
}

.info-box {
    background: #f8fafc !important;
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


    <a href="membership_applications.php">

        <i class="fa-solid fa-users"></i>

        <span>Membership Applications</span>

    </a>


    <a href="members.php" class="active">

        <i class="fa-solid fa-user-group"></i>

        <span>Members</span>

    </a>


    <a href="events.php">

        <i class="fa-solid fa-calendar-days"></i>

        <span>Events</span>

    </a>


    <a href="gallery.php">

        <i class="fa-solid fa-images"></i>

        <span>Gallery</span>

    </a>


    <a href="settings.php">

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
            Member Profile
        </h4>


        <div class="admin-name">

            <i class="fa-solid fa-circle-user me-2"></i>

            <?php

            echo htmlspecialchars(
                $_SESSION['admin_name'] ?? 'Rotary Administrator'
            );

            ?>

        </div>

    </div>



    <!-- CONTENT -->

    <div class="content">


        <a href="members.php" class="back-btn">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back to Members

        </a>



        <!-- PROFILE -->

        <div class="profile-card">


            <!-- HEADER -->

            <div class="profile-header">


                <?php if ($photo !== ""): ?>

                    <img
                    src="<?php echo htmlspecialchars($photo); ?>"
                    alt="Member Photo"
                    class="profile-photo">

                <?php else: ?>

                    <div class="no-photo">

                        <i class="fa-solid fa-user"></i>

                    </div>

                <?php endif; ?>


                <div>


                    <div class="profile-name">

                        <?php

                        echo htmlspecialchars(
                            $member['fullname']
                        );

                        ?>

                    </div>


                    <span class="profile-id">

                        <i class="fa-solid fa-id-card me-1"></i>

                        <?php

                        echo htmlspecialchars(
                            $member['membership_id']
                        );

                        ?>

                    </span>


                    <span class="active-badge">

                        <i class="fa-solid fa-circle-check me-1"></i>

                        Active Member

                    </span>


                </div>

            </div>



            <!-- BODY -->

            <div class="profile-body">


                <!-- PERSONAL INFORMATION -->

                <div class="section-title">

                    <i class="fa-solid fa-user me-2"></i>

                    Personal Information

                </div>


                <div class="info-grid">


                    <div class="info-box">

                        <div class="info-label">
                            Full Name
                        </div>

                        <div class="info-value">

                            <?php

                            echo htmlspecialchars(
                                $member['fullname']
                            );

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Email Address
                        </div>

                        <div class="info-value">

                            <?php

                            echo htmlspecialchars(
                                $member['email']
                            );

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Phone Number
                        </div>

                        <div class="info-value">

                            <?php

                            echo htmlspecialchars(
                                $member['phone']
                            );

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Gender
                        </div>

                        <div class="info-value">

                            <?php

                            echo htmlspecialchars(
                                $member['gender']
                            );

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Date of Birth
                        </div>

                        <div class="info-value">

                            <?php

                            if (!empty($member['dob'])) {

                                echo date(
                                    "d F Y",
                                    strtotime($member['dob'])
                                );

                            } else {

                                echo "Not provided";

                            }

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Occupation
                        </div>

                        <div class="info-value">

                            <?php

                            echo !empty($member['occupation'])
                                ? htmlspecialchars($member['occupation'])
                                : "Not provided";

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Organization
                        </div>

                        <div class="info-value">

                            <?php

                            echo !empty($member['organization'])
                                ? htmlspecialchars($member['organization'])
                                : "Not provided";

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Membership ID
                        </div>

                        <div class="info-value">

                            <strong>

                                <?php

                                echo htmlspecialchars(
                                    $member['membership_id']
                                );

                                ?>

                            </strong>

                        </div>

                    </div>

                </div>



                <!-- MEMBERSHIP INFORMATION -->

                <div class="section-title">

                    <i class="fa-solid fa-calendar-check me-2"></i>

                    Membership Information

                </div>


                <div class="info-grid">


                    <div class="info-box">

                        <div class="info-label">
                            Status
                        </div>

                        <div class="info-value">

                            <span class="active-badge ms-0">

                                <i class="fa-solid fa-circle-check me-1"></i>

                                Approved / Active

                            </span>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Date Joined
                        </div>

                        <div class="info-value">

                            <?php

                            if (!empty($member['approved_at'])) {

                                echo date(
                                    "d F Y",
                                    strtotime($member['approved_at'])
                                );

                            } else {

                                echo "Not available";

                            }

                            ?>

                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Approved At
                        </div>

                        <div class="info-value">

                            <?php

                            if (!empty($member['approved_at'])) {

                                echo date(
                                    "d M Y, h:i A",
                                    strtotime($member['approved_at'])
                                );

                            } else {

                                echo "Not available";

                            }

                            ?>

                        </div>

                    </div>

                </div>



                <!-- ADDRESS -->

                <div class="section-title">

                    <i class="fa-solid fa-location-dot me-2"></i>

                    Residential Address

                </div>


                <div class="text-box">

                    <?php

                    echo !empty($member['address'])

                        ? nl2br(
                            htmlspecialchars(
                                $member['address']
                            )
                        )

                        : "No address provided.";

                    ?>

                </div>



                <!-- REASON -->

                <div class="section-title">

                    <i class="fa-solid fa-comment-dots me-2"></i>

                    Reason For Joining

                </div>


                <div class="text-box">

                    <?php

                    echo !empty($member['reason'])

                        ? nl2br(
                            htmlspecialchars(
                                $member['reason']
                            )
                        )

                        : "No reason provided.";

                    ?>

                </div>



                <!-- ACTIONS -->

                <div class="actions">


                    <button
                    type="button"
                    onclick="window.print()"
                    class="btn-print">

                        <i class="fa-solid fa-print me-2"></i>

                        Print Member Profile

                    </button>


                    <a
                    href="members.php"
                    class="btn-back">

                        <i class="fa-solid fa-arrow-left me-2"></i>

                        Back to Members

                    </a>


                </div>


            </div>

        </div>


    </div>

</div>


</body>

</html>

<?php

$conn->close();

?>