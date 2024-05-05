<?php
session_start();
require 'config.php';
$pid = $_GET['pid'];
if (!ctype_digit($pid)) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid project ID']);
  exit;
}
// Specify the content type
header('Content-Type: application/json');




// Validate the project ID
if (!$pid || !is_numeric($pid)) {
  http_response_code(400);
  $error = ['error' => 'Project ID is required and must be numeric'];
  echo json_encode($error);
  error_log("Invalid Project ID: " . json_encode($error));
  exit;
}

// Attempt to connect to the database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
  http_response_code(500);
  $error = ['error' => 'Failed to connect to the database'];
  echo json_encode($error);
  error_log("Database connection error: " . $conn->connect_error);
  exit;
}

// Prepare the SQL statement
$sql = "SELECT delivName, dueDate, phase, deliverableid, Pid FROM deliverables WHERE Pid = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  $error = ['error' => 'Failed to prepare the statement'];
  echo json_encode($error);
  error_log("SQL Prepare Error: " . $conn->error);
  exit;
}

// Bind the parameters and execute
$stmt->bind_param("i", $pid);
if (!$stmt->execute()) {
  http_response_code(500);
  $error = ['error' => 'Failed to execute the query'];
  echo json_encode($error);
  error_log("SQL Execution Error: " . $stmt->error);
  exit;
}

// Fetch the results
$result = $stmt->get_result();
$deliverables = [];

while ($row = $result->fetch_assoc()) {
  $deliverables[] = $row;
}

// Output the array as JSON
echo json_encode($deliverables);

// Clean up
$stmt->close();
$conn->close();
?>