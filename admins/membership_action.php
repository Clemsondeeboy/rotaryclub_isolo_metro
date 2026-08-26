<?php

session_start();

require_once "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: membership_applications.php");
    exit();
}


$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$action = $_POST['action'] ?? '';

if ($id <= 0) {
    header("Location: membership_applications.php");
    exit();
}

if (!in_array($action, ['approve', 'reject'], true)) {
    header("Location: view_application.php?id=" . $id);
    exit();
}


if ($action === 'approve') {


    $stmt = $conn->prepare("
        SELECT status, membership_id
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

    if ($application['status'] === 'Approved' &&
        !empty($application['membership_id'])) {

        header(
            "Location: view_application.php?id=" . $id . "&updated=1"
        );

        exit();
    }

    $year = date("Y");

    $result = mysqli_query(
        $conn,
        "SELECT membership_id
         FROM membership_applications
         WHERE membership_id IS NOT NULL
         AND membership_id LIKE 'ROT-$year-%'
         ORDER BY id DESC
         LIMIT 1"
    );

    $nextNumber = 1;

    if ($result && mysqli_num_rows($result) > 0) {

        $last = mysqli_fetch_assoc($result);

        /*
        Example:
        ROT-2026-0007
        */

        $parts = explode("-", $last['membership_id']);

        if (isset($parts[2])) {

            $lastNumber = (int)$parts[2];

            $nextNumber = $lastNumber + 1;
        }
    }


    $membershipId = "ROT-" . $year . "-" .
                    str_pad(
                        $nextNumber,
                        4,
                        "0",
                        STR_PAD_LEFT
                    );

    $stmt = $conn->prepare("
        UPDATE membership_applications
        SET
            status = 'Approved',
            membership_id = ?,
            approved_at = NOW()
        WHERE id = ?
    ");

    $stmt->bind_param(
        "si",
        $membershipId,
        $id
    );


    if ($stmt->execute()) {

        $stmt->close();

        header(
            "Location: view_application.php?id=" . $id . "&updated=1"
        );

        exit();
    }


    $stmt->close();

    header(
        "Location: view_application.php?id=" . $id . "&error=1"
    );

    exit();
}


if ($action === 'reject') {

    $stmt = $conn->prepare("
        UPDATE membership_applications
        SET
            status = 'Rejected',
            membership_id = NULL,
            approved_at = NULL
        WHERE id = ?
    ");

    $stmt->bind_param(
        "i",
        $id
    );


    if ($stmt->execute()) {

        $stmt->close();

        header(
            "Location: view_application.php?id=" . $id . "&updated=1"
        );

        exit();
    }


    $stmt->close();

    header(
        "Location: view_application.php?id=" . $id . "&error=1"
    );

    exit();
}

?>