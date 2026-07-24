<?php

require_once "config/db.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$fullname=trim($_POST['fullname']);
$email=trim($_POST['email']);
$phone=trim($_POST['phone']);
$gender=trim($_POST['gender']);
$dob=$_POST['dob'];
$occupation=trim($_POST['occupation']);
$organization=trim($_POST['organization']);
$address=trim($_POST['address']);
$reason=trim($_POST['reason']);

if(empty($fullname) || empty($email) || empty($phone) || empty($gender) || empty($reason)){

header("Location: join.php?error=1");
exit();

}

$check=mysqli_query($conn,"SELECT id FROM membership_applications WHERE email='$email'");

if(mysqli_num_rows($check)>0){

header("Location: join.php?error=2");
exit();

}

$passport="";

if(isset($_FILES['passport']) && $_FILES['passport']['error']==0){

$folder="assets/uploads/passports/";

if(!file_exists($folder)){

mkdir($folder,0777,true);

}

$ext=strtolower(pathinfo($_FILES['passport']['name'],PATHINFO_EXTENSION));

$passport=time().rand(1000,9999).".".$ext;

move_uploaded_file($_FILES['passport']['tmp_name'],$folder.$passport);

}

$sql="INSERT INTO membership_applications(

fullname,
email,
phone,
gender,
dob,
occupation,
organization,
address,
reason,
passport

)

VALUES(

'$fullname',
'$email',
'$phone',
'$gender',
'$dob',
'$occupation',
'$organization',
'$address',
'$reason',
'$passport'

)";

if(mysqli_query($conn,$sql)){

header("Location: join.php?success=1");

}else{

header("Location: join.php?error=1");

}

}else{

header("Location: join.php");

}
?>