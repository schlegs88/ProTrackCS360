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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = intval($_POST['user_type']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || $_POST['user_type'] === "") {
        $_SESSION['error'] = "All fields are required.";
        header("Location: signup.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: signup.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: signup.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    if ($stmt = $conn->prepare("SELECT id FROM accounts WHERE email = ?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $_SESSION['error'] = "Email already exists.";
            $stmt->close();
            header("Location: signup.php");
            exit();
        }
        $stmt->close();
    }

    // Insert the new user into the database
    if ($stmt = $conn->prepare("INSERT INTO accounts (UserName, email, Pass, UserType) VALUES (?, ?, ?, ?)")) {
        $stmt->bind_param("sssi", $name, $email, $hashed_password, $user_type);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful! Please login.";
            $stmt->close();
            $conn->close();
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "User registration failed: " . $stmt->error;
            $stmt->close();
            $conn->close();
            header("Location: signup.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Database error: Could not prepare statement.";
        header("Location: signup.php");
        exit();
    }
}
header("Location: signup.php");
exit();
?>
