<?php

session_start();

require_once "../config/db.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


$search = trim($_GET['search'] ?? '');


if ($search !== "") {

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
        WHERE status = 'Approved'
        AND (
            fullname LIKE ?
            OR email LIKE ?
            OR phone LIKE ?
            OR membership_id LIKE ?
            OR organization LIKE ?
        )
        ORDER BY approved_at DESC, id DESC
    ");

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sssss",
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

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
        WHERE status = 'Approved'
        ORDER BY approved_at DESC, id DESC
    ");

    $stmt->execute();

    $result = $stmt->get_result();
}

$countQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM membership_applications
     WHERE status = 'Approved'"
);

$countRow = mysqli_fetch_assoc($countQuery);

$totalMembers = $countRow['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Members | Rotary Admin</title>


<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<!-- Font Awesome -->

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">


<style>

body {

    margin: 0;

    background: #f5f7fa;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: #111827;
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

    z-index: 1000;
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

    padding: 14px 25px;

    transition: 0.2s;

    font-size: 15px;
}


.sidebar a:hover {

    background: #02287a;

    color: #ffc107;
}


.sidebar a.active {

background: #ffc107;

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

    height: 70px;

    background: white;

    padding: 0 30px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
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


.page-description {

    color: #64748b;

    margin-bottom: 25px;
}


.stat-card {

    background: white;

    border-radius: 16px;

    padding: 25px;

    box-shadow:
        0 4px 20px rgba(0,0,0,0.05);

    margin-bottom: 30px;
}


.stat-icon {

    width: 55px;

    height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #e8f0ff;

    color: #2563eb;

    font-size: 22px;

    margin-bottom: 15px;
}


.stat-number {

    font-size: 28px;

    font-weight: 700;

    margin-bottom: 2px;
}


.stat-label {

    color: #64748b;

    font-size: 14px;
}

.members-card {

    background: white;

    border-radius: 16px;

    box-shadow:
        0 4px 20px rgba(0,0,0,0.05);

    overflow: hidden;
}


.members-header {

    padding: 25px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    border-bottom: 1px solid #eee;
}


.members-header h4 {

    margin: 0 0 5px;

    font-weight: 700;
}


.members-header p {

    margin: 0;

    color: #64748b;

    font-size: 14px;
}


.search-box {

    display: flex;

    width: 300px;
}


.search-box input {

    border-radius: 10px 0 0 10px;

    border: 1px solid #d1d5db;

    padding: 10px 13px;

    width: 100%;

    outline: none;
}


.search-box button {

    width: 50px;

    border: none;

    background: #111827;

    color: white;

    border-radius: 0 10px 10px 0;
}

.table-container {

    overflow-x: auto;
}


table {

    width: 100%;

    border-collapse: collapse;
}


thead th {

    background: #f8fafc;

    color: #64748b;

    font-size: 12px;

    text-transform: uppercase;

    padding: 16px 14px;

    white-space: nowrap;
}


tbody td {

    padding: 15px 14px;

    border-top: 1px solid #eee;

    vertical-align: middle;

    font-size: 14px;
}


tbody tr:hover {

    background: #fafafa;
}

.member-info {

    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 220px;
}


.member-photo {

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

    display: flex;

    align-items: center;

    justify-content: center;

    background: #e5e7eb;

    color: #6b7280;

    font-size: 18px;
}


.member-name {

    font-weight: 700;

    color: #111827;
}


.member-email {

    color: #64748b;

    font-size: 12px;

    margin-top: 3px;
}

.membership-id {

    display: inline-block;

    padding: 6px 10px;

    border-radius: 7px;

    background: #fff3cd;

    color: #e9b007;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;
}

.status {

    display: inline-block;

    padding: 6px 11px;

    border-radius: 20px;

    background: #d1e7dd;

    color: #0f5132;

    font-size: 12px;

    font-weight: 600;
}

.view-btn {

    border: 1px solid #111827;

    background: white;

    color: #111827;

    padding: 7px 12px;

    border-radius: 7px;

    text-decoration: none;

    font-size: 13px;

    white-space: nowrap;
}


.view-btn:hover {

    background: #cf9f00;

    color: white;
}

.empty-state {

    text-align: center;

    padding: 70px 20px;

    color: #64748b;
}


.empty-state i {

    font-size: 55px;

    margin-bottom: 20px;

    color: #cbd5e1;
}


.empty-state h5 {

    color: #374151;

    margin-bottom: 8px;
}

@media(max-width: 900px) {

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

    .members-header {

        flex-direction: column;

        align-items: flex-start;
    }

    .search-box {

        width: 100%;
    }

}


@media(max-width: 600px) {

    .content {

        padding: 20px 15px;
    }

    .topbar {

        padding: 0 15px;
    }

    .topbar h4 {

        font-size: 17px;
    }

    .admin-name {

        display: none;
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


    <!-- Dashboard -->

    <a href="dashboard.php">

        <i class="fa-solid fa-gauge"></i>

        <span>Dashboard</span>

    </a>


    <!-- Membership Applications -->

    <a href="membership_applications.php">

        <i class="fa-solid fa-users"></i>

        <span>Membership Applications</span>

    </a>


    <!-- Members -->

    <a href="members.php" class="active">

        <i class="fa-solid fa-user-group"></i>

        <span>Members</span>

    </a>


    <!-- Events -->

    <a href="events.php">

        <i class="fa-solid fa-calendar-days"></i>

        <span>Events</span>

    </a>


    <!-- Gallery -->

    <a href="gallery.php">

        <i class="fa-solid fa-images"></i>

        <span>Gallery</span>

    </a>


    <!-- Settings -->

    <a href="settings.php">

        <i class="fa-solid fa-gear"></i>

        <span>Settings</span>

    </a>


    <!-- Logout -->

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
            Members
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


        <h2 class="fw-bold mb-2">
            Rotary Members
        </h2>


        <p class="page-description">

            View and manage all approved members of the Rotary Club.

        </p>



        <div class="row">

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-user-group"></i>

                    </div>


                    <div class="stat-number">

                        <?php echo (int)$totalMembers; ?>

                    </div>


                    <div class="stat-label">

                        Total Approved Members

                    </div>

                </div>

            </div>

        </div>


        <div class="members-card">


            <div class="members-header">


                <div>

                    <h4>
                        All Members
                    </h4>

                    <p>
                        Approved membership applications appear here.
                    </p>

                </div>



                <!-- SEARCH -->

                <form
                method="GET"
                action="members.php"
                class="search-box">

                    <input
                    type="text"
                    name="search"
                    value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Search name, ID, email or phone...">

                    <button type="submit">

                        <i class="fa-solid fa-search"></i>

                    </button>

                </form>


            </div>



            <!-- TABLE -->

            <div class="table-container">


            <?php if ($result->num_rows > 0): ?>


                <table>


                    <thead>

                        <tr>

                            <th>#</th>

                            <th>MEMBER</th>

                            <th>MEMBERSHIP ID</th>

                            <th>PHONE</th>

                            <th>ORGANIZATION</th>

                            <th>DATE JOINED</th>

                            <th>STATUS</th>

                            <th>ACTION</th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    $number = 1;

                    while ($member = $result->fetch_assoc()):

                    ?>


                        <tr>


                            <!-- NUMBER -->

                            <td>

                                <?php echo $number++; ?>

                            </td>



                            <!-- MEMBER -->

                            <td>

                                <div class="member-info">


                                    <?php if (!empty($member['passport'])): ?>

                                        <img
                                        src="../uploads/memberships/<?php echo htmlspecialchars($member['passport']); ?>"
                                        alt="Member"
                                        class="member-photo">

                                    <?php else: ?>

                                        <div class="no-photo">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                    <?php endif; ?>


                                    <div>

                                        <div class="member-name">

                                            <?php

                                            echo htmlspecialchars(
                                                $member['fullname']
                                            );

                                            ?>

                                        </div>


                                        <div class="member-email">

                                            <?php

                                            echo htmlspecialchars(
                                                $member['email']
                                            );

                                            ?>

                                        </div>

                                    </div>


                                </div>

                            </td>



                            <!-- MEMBERSHIP ID -->

                            <td>

                                <?php if (!empty($member['membership_id'])): ?>

                                    <span class="membership-id">

                                        <?php

                                        echo htmlspecialchars(
                                            $member['membership_id']
                                        );

                                        ?>

                                    </span>

                                <?php else: ?>

                                    <span class="text-muted">

                                        Not assigned

                                    </span>

                                <?php endif; ?>

                            </td>



                            <!-- PHONE -->

                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $member['phone']
                                );

                                ?>

                            </td>



                            <!-- ORGANIZATION -->

                            <td>

                                <?php

                                echo !empty($member['organization'])

                                    ? htmlspecialchars(
                                        $member['organization']
                                    )

                                    : '<span class="text-muted">
                                        Not provided
                                      </span>';

                                ?>

                            </td>



                            <!-- DATE JOINED -->

                            <td>

                                <?php

                                if (!empty($member['approved_at'])) {

                                    echo date(
                                        "d M Y",
                                        strtotime(
                                            $member['approved_at']
                                        )
                                    );

                                    echo "<br>";

                                    echo '<small class="text-muted">';

                                    echo date(
                                        "h:i A",
                                        strtotime(
                                            $member['approved_at']
                                        )
                                    );

                                    echo '</small>';

                                } else {

                                    echo date(
                                        "d M Y",
                                        strtotime(
                                            $member['created_at']
                                        )
                                    );

                                }

                                ?>

                            </td>



                            <!-- STATUS -->

                            <td>

                                <span class="status">

                                    Active

                                </span>

                            </td>



                            <!-- ACTION -->

                            <td>

                                <a
                                href="view_member.php?id=<?php echo (int)$member['id']; ?>"
                                class="view-btn">

                                    <i class="fa-solid fa-eye me-1"></i>

                                    View

                                </a>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                    </tbody>

                </table>


            <?php else: ?>


                <!-- EMPTY -->

                <div class="empty-state">

                    <i class="fa-solid fa-user-group"></i>


                    <h5>

                        <?php

                        if ($search !== "") {

                            echo "No members found";

                        } else {

                            echo "No approved members yet";

                        }

                        ?>

                    </h5>


                    <p>

                        <?php

                        if ($search !== "") {

                            echo "Try searching with another name, email, phone number or membership ID.";

                        } else {

                            echo "Approved membership applications will automatically appear here.";

                        }

                        ?>

                    </p>


                </div>


            <?php endif; ?>


            </div>

        </div>


    </div>

</div>


</body>

</html>

<?php

$stmt->close();

$conn->close();

?>