<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $studentID = $_POST['newAssignment']['StudentID'];
  $projectID = $_POST['newAssignment']['ProjectID'];
  $instructor_id = $_SESSION['UserID'];
}
$host = $_SESSION['host'];
$dbusername = $_SESSION['dbusername'];
$dbpassword = $_SESSION['dbpassword'];
$dbname = $_SESSION['dbname'];
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

$checkql = "SELECT * FROM assigned WHERE Pid = $projectID AND studentID = $studentID";
$checkresult = $conn->query($checkql);
if ($checkresult->num_rows > 0) {
  $_SESSION['error'] = "Student already assigned to project";
  header("Location: instructorgrades.php");
  exit();
}

// Prepare SQL statement
$sql = "INSERT INTO assigned (Pid, studentID, InstructorID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
  die('MySQL prepare error: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param("iii", $projectID, $studentID, $instructor_id);


// Execute each query
if (!$stmt->execute()) {
  $_SESSION['error'] = "Error inserting data: " . $stmt->error;
  header("Location: instructorgrades.php");
} else {
  $_SESSION['success'] = "New record created successfully<br>";
  header("Location: instructorgrades.php"); // Redirect to instructorgrades.php
}

// Close connections
$stmt->close();
$conn->close();
?>