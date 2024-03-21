<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>John Doe - Portfolio</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Add any additional meta tags, stylesheets, or scripts here -->
</head>

<body>

    <!-- Header Section -->
    <header>
        <h1>STUDENT</h1>

    </header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php">Sign Out</a>
                    <a class="nav-link" href="student.php">Dashboard</a>
                    <a class="nav-link" href="calendar.php">Calendar</a>
                    <a class="nav-link" href="studentgrades.php">Grades</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Portfolio Section -->
    <section>
        <h2>Dashboard</h2>

        <!-- Project 1 -->
        <div class="project">
            <h3>Project 1</h3>
            <p>Here you will view some basic info about your project.</p>
        </div>
        <?php
        session_start();
        $host = $_SESSION['host'];
        $dbusername = $_SESSION['dbusername'];
        $dbpassword = $_SESSION['dbpassword'];
        $dbname = $_SESSION['dbname'];
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        $studentID = $_SESSION['UserID'];
        // Student ID variable
        // Prepare SQL query
        $sql = "SELECT * FROM assigned NATURAL JOIN projects WHERE studentid = ?";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die ("Error in preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $studentID);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table>";
            echo "<tr><th>Project ID</th><th>Project Name</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Pid"] . "</td>";
                echo "<td>" . $row["ProjectName"] . "</td>";
                // You can access other columns similarly
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

        ?>

        <!-- Project 2 -->
        <div class="project">
            <h3>Project 2</h3>
            <p>Here you will view some basic info about your project.</p>
            <a href="#">View Project</a>
        </div>

        <!-- Add more projects as needed -->

    </section>

    <!-- Skills Section (optional, if not included on the home or about page) -->
    <section id="skills">
        <h2>Tools</h2>
        <ul>
            <li>Gantt</li>
            <li>Pert</li>
            <li>Calendar</li>
            <!-- Add more skills as needed -->
        </ul>
        <!-- Add more content as needed -->
    </section>

    <!-- Footer Section -->
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