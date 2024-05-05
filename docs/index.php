<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTrac</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>

    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <h1>ProTrack</h1>
        <p>A web tool for academic database projects</p>
    </header>
    <?php
    session_start();
    $host = $_SESSION['host'];
    $dbusername = $_SESSION['dbusername'];
    $dbpassword = $_SESSION['dbpassword'];
    $dbname = $_SESSION['dbname'];
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" style="text-align: center; font-size: 24px;">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);  // Clear the message after displaying it
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" style="color: red; text-align: center; font-size: 24px;">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);  // Clear the message after displaying it
    }
    ?>
    <!--call to action-->
    <section>

        <h2>Sign In</h2>

        <!-- Sign In Form -->
        <form action="login.php" method="POST">
            <input type="text" name="email" class="form-control" placeholder="example@email.com"><br>
            <input type="password" name="password" class="form-control" placeholder="Enter Password"><br>
            <button type="submit">Login</button><br>

        </form>
        <div class="centered">
            <button onclick="location.href='signup.php'">Sign Up</button>
        </div>

    </section>

    <!-- Footer Section -->
    <footer>
        <nav>
            <a href="#terms">Terms and Conditions</a>
            <a href="#priv">Privacy Policy</a>
            <a href="#cookies">Cookie Policy</a>
        </nav>
        <p>&copy; 2024 Joseph Schlegel. All rights reserved.</p>
    </footer>

</body>

</html>