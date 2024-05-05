<?php
session_start();  // Start the session
require 'config.php';  // Include the database configuration file
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect POST data
  $delivName = $_POST['delivName'];
  $dueDate = $_POST['dueDate'];
  $phase = $_POST['phase'];
  $delivIds = $_POST['delivId'];
  /*$deliverableNames = $_POST['DeliverableName'];
  $deliverableDueDates = $_POST['DeliverableDueDate'];
  $deliverablePhases = $_POST['DeliverablePhase'];*/
  // Database configuration and connection
  echo "<script>console.log('PHP POST Data:', " . json_encode($_POST) . ");</script>";





  $sql = "UPDATE deliverables SET delivName = ?, duedate = ?, phase = ? WHERE deliverableid = ?";
  $stmt = $conn->prepare($sql);

  $successMessage = "";

  $errorOccurred = false;

  // Update projects
  foreach ($delivIds as $i => $delivId) {
    $stmt->bind_param("ssii", $delivName[$i], $dueDate[$i], $phase[$i], $delivId);
    if (!$stmt->execute()) {
      error_log("Error updating deliverable record: " . $stmt->error); // Log to error log
      echo "Error updating deliverable record: " . $stmt->error . "<br>"; // Display or handle appropriately
      $errorOccurred = true;
    }
  }

  if ($errorOccurred) {
    $successMessage .= "Transaction rolled back due to errors.<br>";
  } else {
    $successMessage .= "Deliverables updated successfully<br>";
  }

  $stmt->close();
  //$deliverable_stmt->close();
  $conn->close();

  // Store messages in session to avoid issues with header redirection
  $_SESSION['message'] = $successMessage;
  header("Location: instructor.php");
  exit();
} else {
  header("Location: instructor.php");
  exit();
}



?>