<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <!-- Add any additional meta tags, stylesheets, or scripts here -->
</head>

<body>

  <!-- Header Section -->
  <header>
    <h1>ProTrack</h1>
  </header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="index.php">Sign Out</a>
          <a class="nav-link" href="about.php">About</a>
          <a class="nav-link" href="instructor.php">Dashboard</a>
          <a class="nav-link" href="instructorcal.php">Calendar</a>
          <a class="nav-link" href="instructorgrades.php">Grades</a>
        </div>
      </div>
    </div>
  </nav>

  <section>
    <h2>Calendar</h2>

    <!-- embed calendar -->
    <br>
    <style>
      /* General reset for the table */
      table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        /* Ensures the table cells are evenly spaced */
      }

      th {
        border: 1px solid #ccc;
        height: 100px;
        /* Fixed height for each cell */
        vertical-align: top;
        padding: 8px;
        text-align: center;
        background-color: #0077fff;
        color: #333;
      }

      td {
        border: 1px solid #ccc;
        height: 100px;
        /* Fixed height for each cell */
        vertical-align: top;
        padding: 8px;
        text-align: right;
      }

      .table-number {
        height: 100px;
        /* Fixed height for each cell */
        vertical-align: top;
        padding: 8px;
        text-align: center;
      }

      th {}

      /* Highlighting today's date */
      .today {
        color: red;
        font-weight: bold;
      }

      /* Styling for project names */
      .project {
        color: blue;
        font-size: 0.85em;
        /* Smaller font size for project names */
        white-space: pre-wrap;
        /* Ensures the text wraps within the cell */
        word-wrap: break-word;
      }

      /* Styling for project names */
      .deliverable {
        color: green;
        font-size: 0.85em;
        /* Smaller font size for project names */
        white-space: pre-wrap;
        /* Ensures the text wraps within the cell */
        word-wrap: break-word;
      }
    </style>

    <?php
    session_start();
    require 'config.php';

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DueDate, ProjectName, Pid FROM projects WHERE InstructorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['UserID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $projects = [];

    while ($row = $result->fetch_assoc()) {
      $projects[] = $row;
    }
    $stmt->close();
    $deliverables = [];

    $sql = "SELECT d.delivName, d.duedate, p.ProjectName, d.Pid FROM deliverables AS d JOIN projects AS p ON p.Pid = d.Pid WHERE p.Pid = ?";
    $stmt = $conn->prepare($sql);
    foreach ($projects as $project) {
      $projectID = $project['Pid'];
      $stmt->bind_param("i", $projectID);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $deliverables[] = $row;
      }
    }
    $stmt->close();


    echo "<script> console.log('Projects: " . json_encode($projects) . "');</script>";
    echo "<script> console.log('Deliverables: " . json_encode($deliverables) . "');</script>";

    date_default_timezone_set('America/Los_Angeles');
    $yearMonth = date('Y-m');
    $daysInMonth = date('t', strtotime($yearMonth));
    $startDayOfMonth = date('w', strtotime($yearMonth . "-01"));

    // Assuming `$projects` and `$deliverables` are populated as discussed
    echo "<table>";
    echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";

    $currentDay = 1;
    $i = 0;
    echo "<tr>";
    for ($i = 0; $i < $startDayOfMonth; $i++) {
      echo "<td></td>"; // Fill initial empty cells
    }

    while ($currentDay <= $daysInMonth) {
      if ($i % 7 == 0 && $i != 0) {
        echo "</tr><tr>"; // Start a new row each week
      }
      echo "<td>";
      if ($currentDay == date('d') && date('Y-m') == $yearMonth) {
        echo "<span class='today'>$currentDay</span><br>"; // Highlight today's date
      } else {
        echo "<span class ='table-number'>$currentDay</span><br>";
      }

      // Check and print projects due on this day
      foreach ($projects as $project) {
        if ($currentDay == date('d', strtotime($project['DueDate'])) && date('Y-m', strtotime($project['DueDate'])) == $yearMonth) {
          echo "<span class='project'>" . htmlspecialchars($project['ProjectName']) . "</span><br>";
        }
      }

      foreach ($deliverables as $deliverable) {
        if ($currentDay == date('d', strtotime($deliverable['duedate'])) && date('Y-m', strtotime($deliverable['duedate'])) == $yearMonth) {
          echo "<span class='deliverable'>" . htmlspecialchars($deliverable['ProjectName']) . ": ". htmlspecialchars($deliverable['delivName']) . "</span><br>";
        }
      }

      echo "</td>";
      $currentDay++;
      $i++;
    }

    while ($i % 7 != 0) {
      echo "<td></td>"; // Fill remaining cells if the month ends before Saturday
      $i++;
    }
    echo "</tr>";
    echo "</table>";

    ?>


  </section>

  <footer>
    <nav>
      <a href="#terms">Terms and Conditions</a>
      <a href="#priv">Privacy Policy</a>
      <a href="#cookies">Cookie Policy</a>
    </nav>
    <!-- Add any additional footer content here -->
  </footer>

</body>

</html>