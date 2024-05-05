<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $projectName = $_POST['ProjectName'];
  $possibleScore = $_POST['possibleScore'];
  $projectDescription = $_POST['ProjectDescription'];
  $instructor_id = $_SESSION['UserID'];
}
$host = $_SESSION['host'];
$dbusername = $_SESSION['dbusername'];
$dbpassword = $_SESSION['dbpassword'];
$dbname = $_SESSION['dbname'];
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Prepare SQL statement
$sql = "INSERT INTO projects (ProjectName, PossibleScore, ProjectDescription, InstructorID) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
  die('MySQL prepare error: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param("siss", $projectName, $possibleScore, $projectDescription, $instructor_id);

// Loop through each project data set and insert it
foreach ($_POST['ProjectName'] as $key => $projectName) {
  $possibleScore = (int) $_POST['possibleScore'][$key]; // Ensure integer type
  $projectDescription = $_POST['ProjectDescription'][$key];

  // Execute each query
  if (!$stmt->execute()) {
    echo "Error inserting data: " . $stmt->error;
  } else {
    echo "New record created successfully<br>";
    header("Location: instructor.php");
  }
}

// Close connections
$stmt->close();
$conn->close();
?>