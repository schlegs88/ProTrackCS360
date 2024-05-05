<?php
session_start();
$update = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = $_SESSION['host'];
    $dbusername = $_SESSION['dbusername'];
    $dbpassword = $_SESSION['dbpassword'];
    $dbname = $_SESSION['dbname'];
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE assigned SET score = ? WHERE StudentID = ? AND Pid = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statements: " . $conn->error);
    }

    $successMessage = "";

    foreach ($_POST['score'] as $pid => $studentData) {
        foreach ($studentData as $studentId => $score) {
            $dueDate = $_POST['DueDate'][$pid][$studentId]; // Matching due date for the score
                
            $stmt->bind_param("iii", $score, $studentId, $pid);
            $stmt->execute();

            if (($stmt->affected_rows > 0)) {
                $successMessage = "Records updated successfully<br>";
                $update = true;
            } elseif($update == false) {
                $successMessage = "No changes made or error updating record for student $studentId on project $pid: " . $conn->error . "<br>";
            }
        }
    }

    $stmt->close();
    $conn->close();

    $_SESSION['success'] = $successMessage;
    header("Location: instructorgrades.php");
    exit();
} else {
    header("Location: instructorgrades.php");
    exit();
}
?>
