<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProTrack - Sign Up</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <!-- Add any additional meta tags, stylesheets, or scripts here -->
</head>

<body>

  <!-- Header Section -->
  <header>
    <h1>ProTrack</h1>
    <!-- Navigation Bar -->
  </header>

  <!-- Sign Up Section -->
  <section>
    <h2>Sign Up</h2>

    <!-- Sign Up Form -->
    <form action="signup_process.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <div class="mb-3">
        <label for="user_type" class="form-label">User Type</label>
        <select class="form-select" id="user_type" name="user_type" required>
          <option value="" disabled selected>Select User Type</option>
          <option value="student">Student</option>
          <option value="instructor">Instructor</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Or add alternative sign-up options (e.g., social media or third-party login) -->
    <div class="alternative-signup">
      <p>Or sign up with:</p>
      <button class="button">Google</button>
      <button class="button">Facebook</button>
    </div>

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
