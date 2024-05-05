<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $delivName = $_POST['NewDeliverableName'];
  $duedate = $_POST['NewDeliverableDueDate'];
  $phase = $_POST['NewDeliverablePhase'];
  $Pid = $_POST['Pid'];
  $instructor_id = $_SESSION['UserID'];

  $host = $_SESSION['host'];
  $dbusername = $_SESSION['dbusername'];
  $dbpassword = $_SESSION['dbpassword'];
  $dbname = $_SESSION['dbname'];
  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

  echo "<script>console.log('PHP POST Data:', " . json_encode($_POST) . ");</script>";

  // Prepare SQL statement
  $sql = "INSERT INTO deliverables (delivName, duedate, phase, Pid) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // Check if preparation was successful
  if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
  }

  foreach ($delivName as $i => $name) {
    // Bind parameters
    $stmt->bind_param("ssii", $name, $duedate[$i], $phase[$i], $Pid[$i]);

    // Execute each query
    if (!$stmt->execute()) {
      echo "Error inserting data: " . $stmt->error;
    } else {
      echo "New record created successfully<br>";
    }
  }
}

// Close connections
$stmt->close();
$conn->close();

// Redirect to the instructor page
header("Location: instructor.php");
exit();
?>