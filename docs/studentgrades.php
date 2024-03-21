<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>John Doe - Sign In</title>
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
          <a class="nav-link" href="student.php">Dashboard</a>
          <a class="nav-link" href="calendar.php">Calendar</a>
          <a class="nav-link" href="studentgrades.php">Grades</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Display grades -->
  <section>
    <?php
    session_start();
    //Database connection parameters
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";
    $studentID = $_SESSION['UserID'];
    //Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    //Check connection
    if ($conn->connect_error) {
      die ("Connection failed: " . $conn->connect_error);
    }
    //Prepare SQL query
    $sql = "SELECT * FROM projects WHERE StudentID = ?";
    //Prepare statement
    $stmt = $conn->prepare($sql);
    // Bind parameters
    $stmt->bind_param("i", $studentID); // Assuming student_id is an integer, change "i" if it's a different type
    //Execute statement
    $stmt->execute();
    //Get result
    $result = $stmt->get_result();

    //Check if there are rows returned
    if ($result->num_rows > 0) {
      // Print table headers
      echo "<table border='1'>";
      echo "<tr><th>Project Name</th><th>Score</th><th>Possible Score</th></tr>";

      // Fetch and output each row
      while ($row = $result->fetch_assoc()) {
        // Output each row with labels
        echo "<tr>";
        echo "<td>" . $row['ProjectName'] . "</td>";
        echo "<td>" . $row['score'] . "</td>";
        echo "<td>" . $row['possibleScore'] . "</td>";
        echo "</tr>";
      }
    } else {
      echo "No grades found for student ID: " . $studentID;
    }

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
    ?>

  </section><br>
</body>
<!-- Footer Section -->
<footer>
  <nav>
    <a href="#terms">Terms and Conditions</a>
    <a href="#priv">Privacy Policy</a>
    <a href="#cookies">Cookie Policy</a>
  </nav>
  <!-- Add any additional footer content here -->
</footer>



</html>