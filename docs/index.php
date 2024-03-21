<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>css-2ndLab</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <h1>ProTrack</h1>
        <p>A web tool for academic database projects</p>
    </header>

    <!--call to action-->
    <section>
        <h2>Sign In</h2>

        <!-- Sign In Form -->
        <form action="login.php" method="POST">
            <input type="text" name="email" class="form-control" placeholder="example@email.com"><br>
            <input type="password" name="password" class="form-control" placeholder="Enter Password"><br>
            <input type="submit" value="Login" class="btn btn-primary">
            
        </form>
        <button onclick="location.href='signup.php'">Sign Up</button>

    </section>

    <!-- Footer Section -->
    <footer>
        <nav>
            <a href="#terms">Terms and Conditions</a>
            <a href="#priv">Privacy Policy</a>
            <a href="#cookies">Cookie Policy</a>
        </nav>
        <p>&copy; 2024 Owen McDaniel and Joseph Schlegel. All rights reserved.</p>
    </footer>

</body>

</html>