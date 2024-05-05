<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect POST data
    $projectNames = $_POST['ProjectName'];
    $possibleScores = $_POST['possibleScore'];
    $projectDescriptions = $_POST['ProjectDescription'];
    $dueDates = $_POST['duedate'];
    $projectIds = $_POST['ProjectId'];
    /*$deliverableNames = $_POST['DeliverableName'];
    $deliverableDueDates = $_POST['DeliverableDueDate'];
    $deliverablePhases = $_POST['DeliverablePhase'];*/
    echo "<script>console.log('PHP Variable: " . json_encode($_POST) . "');</script>";
    // Database configuration and connection
    $host = $_SESSION['host'];
    $dbusername = $_SESSION['dbusername'];
    $dbpassword = $_SESSION['dbpassword'];
    $dbname = $_SESSION['dbname'];
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    //echo "<script>console.log('PHP Variable: " . $conn . "');</script>";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Prepare SQL for updating projects
    $project_sql = "UPDATE projects SET ProjectName = ?, possibleScore = ?, ProjectDescription = ?, DueDate = ? WHERE Pid = ?";
    $project_stmt = $conn->prepare($project_sql);

    /*
// Prepare SQL for updating deliverables
$deliverable_sql = "UPDATE deliverables SET name = ?, duedate = ?, phase = ? WHERE deliverableid = ?";
$deliverable_stmt = $conn->prepare($deliverable_sql);   */


    $successMessage = "";
    $errorOccurred = false;

    // Update projects
    foreach ($projectIds as $i => $projectId) {
        $project_stmt->bind_param("sissi", $projectNames[$i], $possibleScores[$i], $projectDescriptions[$i], $dueDates[$i], $projectId);
        if (!$project_stmt->execute()) {
            $successMessage .= "Error updating project record: " . $project_stmt->error . "<br>";
            $errorOccurred = true;
        }
    }

    /*
    // Update deliverables
    foreach ($deliverableNames as $deliverableId => $name) {
        $dueDate = strtotime($deliverableDueDates[$deliverableId]);
        $phase = $deliverablePhases[$deliverableId];
        $deliverable_stmt->bind_param("sisi", $name, $dueDate, $phase, $deliverableId);
        if (!$deliverable_stmt->execute()) {
            $successMessage .= "Error updating deliverable record: " . $deliverable_stmt->error . "<br>";
            $errorOccurred = true;
        }
    }*/

    if ($errorOccurred) {
        $successMessage .= "Transaction rolled back due to errors.<br>";
    } else {
        $successMessage .= "Records updated successfully<br>";
    }

    $project_stmt->close();
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