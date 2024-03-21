<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //retrieve form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  //database connection

  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "auth";

  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
  }

  //validate Login authentication
  $query = "SELECT *FROM login WHERE username='$username' AND password='$password'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    //Login Success
    $columnData = $result->fetchAll(PDO::FETCH_COLUMN, 2);
    if ($columnData == 0) {
      header("Location: student.php");
    } else {
      header("Location: instructor.php");
    }
    exit();
  } else {
    exit();
  }

  $conn->close();
}
?>