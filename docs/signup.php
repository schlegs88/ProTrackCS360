<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Protrack360</title>
  <link rel="stylesheet" type="text/css" href="styles.css">


  <!-- Add any additional meta tags, stylesheets, or scripts here -->
</head>

<body>

  <!-- Header Section -->
  <header>
    <h1>ProTrack</h1>
    <!-- Navigation Bar -->
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
  if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger" style="color: red; text-align: center; font-size: 24px;">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);  // Clear the message after displaying it
  }

  if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success" style="text-align: center; font-size: 24px;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);  // Clear the message after displaying it
  }

  ?>
  <!-- Sign Up Section -->
  <section>
    <h2>Sign Up</h2>

    <!-- Sign Up Form -->
    <form action="signup_proc.php" method="POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" class="input-custom" required>
      <label for="email">Email address</label>
      <input type="email" id="email" name="email" style="width: 100% !important;
                                                         padding: 12px !important;
                                                         border: 2px solid #ddd !important;
                                                         border-radius: 5px !important;
                                                         box-sizing: border-box !important;
                                                         font-size: 16px !important;
                                                         margin-top: 6px !important;
                                                         transition: border-color 0.3s ease !important;" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="input-custom" required>
      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" class="input-custom" required>
      <label for="user_type">User Type</label>
      <select id="user_type" name="user_type" style="width: 100% !important;
                                                     padding: 12px !important;
                                                     border: 2px solid #ddd !important;
                                                     border-radius: 5px !important;
                                                     box-sizing: border-box !important;
                                                     font-size: 16px !important;
                                                     margin-top: 6px !important;
                                                     transition: border-color 0.3s ease !important;" required>
        <option value="" disabled selected>Select User Type</option>
        <option value=0>Student</option>
        <option value=1>Instructor</option>
      </select>
      <button type="submit" class="btn btn-primary">Submit</button>


    </form>
    <td>
      <button onclick="window.location.href='index.php';">Sign In</button>
    </td>


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