<?php

require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: join.php");
    exit();
}

$fullname     = trim($_POST['fullname'] ?? '');
$email        = trim($_POST['email'] ?? '');
$phone        = trim($_POST['phone'] ?? '');
$gender       = trim($_POST['gender'] ?? '');
$dob          = trim($_POST['dob'] ?? '');
$occupation   = trim($_POST['occupation'] ?? '');
$organization = trim($_POST['organization'] ?? '');
$address      = trim($_POST['address'] ?? '');
$reason       = trim($_POST['reason'] ?? '');

if (
    empty($fullname) ||
    empty($email) ||
    empty($phone) ||
    empty($gender) ||
    empty($reason)
) {
    header("Location: join.php?error=1");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: join.php?error=invalid_email");
    exit();
}

if (!in_array($gender, ['Male', 'Female'], true)) {
    header("Location: join.php?error=1");
    exit();
}

$check = $conn->prepare("
    SELECT id
    FROM membership_applications
    WHERE email = ?
    LIMIT 1
");

$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {

    $check->close();

    header("Location: join.php?error=already_registered");
    exit();
}

$check->close();

$passportName = null;

if (isset($_FILES['passport']) && $_FILES['passport']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['passport']['error'] !== UPLOAD_ERR_OK) {
        header("Location: join.php?error=upload");
        exit();
    }

    if ($_FILES['passport']['size'] > 2 * 1024 * 1024) {
        header("Location: join.php?error=file_size");
        exit();
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    if (!$finfo) {
        header("Location: join.php?error=upload");
        exit();
    }

    $mime = finfo_file($finfo, $_FILES['passport']['tmp_name']);
    finfo_close($finfo);

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($allowedTypes[$mime])) {
        header("Location: join.php?error=invalid_file");
        exit();
    }

    $uploadDir = __DIR__ . "/uploads/memberships/";

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            header("Location: join.php?error=upload");
            exit();
        }
    }

    $extension = $allowedTypes[$mime];

    $passportName =
        "member_" .
        time() .
        "_" .
        bin2hex(random_bytes(5)) .
        "." .
        $extension;

    $destination = $uploadDir . $passportName;
    if (!move_uploaded_file($_FILES['passport']['tmp_name'], $destination)) {

        header("Location: join.php?error=upload");
        exit();
    }
}

$dobValue = !empty($dob) ? $dob : null;
$status = "Pending";

$sql = "
    INSERT INTO membership_applications
    (
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
        status
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    if ($passportName && file_exists($destination)) {
        unlink($destination);
    }

    header("Location: join.php?error=1");
    exit();
}


$stmt->bind_param(
    "sssssssssss",
    $fullname,
    $email,
    $phone,
    $gender,
    $dobValue,
    $occupation,
    $organization,
    $address,
    $reason,
    $passportName,
    $status
);


if (!$stmt->execute()) {
    if ($passportName && file_exists($destination)) {
        unlink($destination);
    }

    $stmt->close();

    header("Location: join.php?error=1");
    exit();
}

$stmt->close();

if (
    isset($_SERVER['SERVER_NAME']) &&
    (
        $_SERVER['SERVER_NAME'] === 'localhost' ||
        $_SERVER['SERVER_NAME'] === '127.0.0.1'
    )
) {

    $message = "

=============================
NEW MEMBERSHIP APPLICATION
=============================

Full Name: $fullname
Email: $email
Phone: $phone
Gender: $gender
Date of Birth: $dob
Occupation: $occupation
Organization: $organization
Address: $address

Reason For Joining:
$reason

Passport: $passportName

Status: Pending

Submitted On: " . date("d M Y h:i A") . "

----------------------------------------

";

    file_put_contents(
        __DIR__ . "/data.txt",
        $message,
        FILE_APPEND | LOCK_EX
    );
}

header("Location: join.php?success=1");
exit();

?>