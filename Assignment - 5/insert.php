<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$cc = $_POST['cc'];
$phone = $_POST['phone'];
$country = $_POST['country'];
$pro = $_POST['pro'];
$address = $_POST['address'];
if (!empty($fname) || !empty($lname) || !empty($email) || !empty($cc) || !empty($phone) || !empty($country) || !empty($pro) || !empty($address)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "users";
    
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From users Where email = ? Limit 1";
     $INSERT = "INSERT Into users (fname,lname,email,cc,phone,country,pro,address) values(?, ?, ?, ?, ?, ?, ?, ?)";
    
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssiisss", $fname, $lname, $email, $cc, $phone,$country,$pro,$address);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>