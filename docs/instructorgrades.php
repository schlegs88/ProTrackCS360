<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gradebook</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <!-- Add any additional meta tags, stylesheets, or scripts here -->
</head>
<!-- Header Section -->
<header>
  <h1>Gradebook</h1>
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

<body>
  <?php
  session_start();
  $host = $_SESSION['host'];
  $dbusername = $_SESSION['dbusername'];
  $dbpassword = $_SESSION['dbpassword'];
  $dbname = $_SESSION['dbname'];
  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
  if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success" style="text-align: center; font-size: 24px;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);  // Clear the message after displaying it
  }
  if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger" style="color: red; text-align: center; font-size: 24px;">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);  // Clear the message after displaying it
  }
  ?>

  <section class="clearfix">
    <form action="savegrades.php" method="POST">
      <table>
        <thead>
          <tr>
            <th>Student</th>
            <th>Project</th>
            <th>Score</th>
            <th>Due Date</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $instructor_id = $_SESSION['UserID'];


          $sql = "SELECT projects.ProjectName, assigned.score, accounts.UserName, projects.DueDate, assigned.Pid, assigned.StudentID, projects.possibleScore
            FROM projects
            INNER JOIN assigned ON projects.Pid = assigned.Pid
            INNER JOIN accounts ON assigned.StudentID = accounts.id
            WHERE projects.InstructorID = $instructor_id
            ORDER BY assigned.StudentID ASC, projects.DueDate ASC";

          $result = $conn->query($sql);
          if ($result === false) {
            die("SQL error: " . $conn->error);
          }
          if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["UserName"] . "</td>";
              echo "<td>" . $row["ProjectName"] . "</td>";
              echo "<td><input type='text' name='score[{$row['Pid']}][{$row['StudentID']}]' value='" . $row["score"] . "'>  /  ". $row["possibleScore"] ." </td>";
             if(strtotime($row["DueDate"]) < strtotime(date("Y-m-d"))){
              echo "<td style=\"color: red\">" . date("F j, Y", strtotime($row["DueDate"])). "</td>";
             }else{
              echo "<td>" . date("F j, Y", strtotime($row["DueDate"])). "</td>";
             }
              echo "<input type='hidden' name='Pid[{$row['Pid']}][{$row['StudentID']}]' value='" . $row["Pid"] . "'>";
              echo "<input type='hidden' name='StudentID[{$row['Pid']}][{$row['StudentID']}]' value='" . $row["StudentID"] . "'>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No projects found</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <input type="submit" value="Update Scores">
    </form>

    <form action="newassign.php" method="POST">
      <h2>Assign a New Project</h2>
      <table>
        <tr>
          <td>Select Student:</td>
          <td>
            <select name="newAssignment[StudentID]">
              <?php
              $studentQuery = "SELECT id, UserName FROM accounts WHERE UserType = 'Student'";
              $students = $conn->query($studentQuery);
              while ($student = $students->fetch_assoc()) {
                echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['UserName']) . "</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Select Project:</td>
          <td>
            <select name="newAssignment[ProjectID]">
              <?php
              $projectQuery = "SELECT Pid, ProjectName FROM projects WHERE InstructorID = $instructor_id";
              $projects = $conn->query($projectQuery);
              while ($project = $projects->fetch_assoc()) {
                echo "<option value='" . $project['Pid'] . "'>" . htmlspecialchars($project['ProjectName']) . "</option>";
              }
              ?>
            </select>
          </td>
        </tr>
      </table>
      <input type="submit" value="Assign New Project">
    </form>
  </section>

</body>
<footer>
  <nav>
    <a href="#terms">Terms and Conditions</a>
    <a href="#priv">Privacy Policy</a>
    <a href="#cookies">Cookie Policy</a>
  </nav>
  <p>&copy; 2024 Joseph Schlegel. All rights reserved.</p>

</html>