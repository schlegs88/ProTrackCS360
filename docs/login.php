<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //retrieve form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  //database connection

  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "auth";

  $_SESSION['host'] = $host;
  $_SESSION['dbusername'] = $dbusername;
  $_SESSION['dbpassword'] = $dbpassword;
  $_SESSION['dbname'] = $dbname;


  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //validate Login authentication
  $query = "SELECT * FROM accounts WHERE email='$email';";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $hashed_password = $row['Pass'];

  echo "<script>console.log('PHP variable: " . addslashes($hashed_password) . "');</script>";
  echo "<script>console.log('PHP variable: " . addslashes($password) . "');</script>";
  if (password_verify($password, $hashed_password)) {
    //Login Success

    $userType = $row['UserType'];
    $_SESSION['UserID'] = $row['id'];
    if ($userType == 0) {
      header("Location: student.php");
    } else if ($userType == 1) {
      header("Location: instructor.php");
    } else {

    }
    exit();
  } else {
    //Login Failed
    $_SESSION['error'] = "Invalid email or password";
    header("Location: index.php");
    exit();
  }

  $conn->close();
}
?>