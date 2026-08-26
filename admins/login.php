<?php

session_start();

require_once "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare("
            SELECT id, fullname, email, password, role
            FROM admins
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {

                session_regenerate_id(true);

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['fullname'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role'] = $admin['role'];

                header("Location: dashboard.php");
                exit();

            } else {

                $error = "Invalid email or password.";
            }

        } else {

            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Login | Rotary Club</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

<style>

body {
    min-height: 100vh;
    background: #f5f7fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-card {
    width: 100%;
    max-width: 430px;
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.12);
}

.logo {
    width: 85px;
    height: 85px;
    object-fit: contain;
    margin-bottom: 15px;
}

.form-control {
    padding: 12px 15px;
    border-radius: 10px;
}

.btn-login {
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card login-card"> 

<div class="card-body p-5">

<div class="text-center mb-4">
  <div class="mb-3">
  <img src="../assets/images/white-logo.png" alt="white-logo" width="100" height="50">
<i
class="fa-solid fa-users-gear fa-3x text-warning">
</i>

</div>

<h3 class="fw-bold">
Rotary Admin
</h3>

<p class="text-muted mb-0">
Administrator Login
</p>

</div>


<?php if ($error !== ""): ?>

<div class="alert alert-danger">

<i class="fa-solid fa-circle-exclamation me-2"></i>

<?php echo htmlspecialchars($error); ?>

</div>

<?php endif; ?>


<form method="POST">

<div class="mb-3">

<label class="form-label">
Email Address
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa-solid fa-envelope"></i>
</span>

<input
type="email"
name="email"
class="form-control"
placeholder="admin@example.com"
required>

</div>

</div>


<div class="mb-4">

<label class="form-label">
Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa-solid fa-lock"></i>
</span>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter password"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword()">

<i
class="fa-solid fa-eye"
id="eyeIcon">
</i>

</button>

</div>

</div>


<button
type="submit"
class="btn btn-warning btn-login w-100">

<i class="fa-solid fa-right-to-bracket me-2"></i>

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>


<script>

function togglePassword() {

    const password =
        document.getElementById("password");

    const icon =
        document.getElementById("eyeIcon");

    if (password.type === "password") {

        password.type = "text";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");
    }
}

</script>

</body>

</html>