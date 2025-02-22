<?php
include 'connect.php';
$message = "";

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        $message = "Signup successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .signup-container h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 25px;
        }

        .signup-container input, .signup-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .signup-container input:focus, .signup-container select:focus {
            border-color: #007bff;
            outline: none;
        }

        .signup-container button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }

        .signup-container button:hover {
            background-color: #0056b3;
        }

        .signup-container a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            margin-top: 15px;
            display: inline-block;
        }

        .signup-container a:hover {
            text-decoration: underline;
        }

        .message {
            color: green;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>

<div class="signup-container">
    <h2>Create Your Account</h2>
    <?php if ($message != "") { ?>
        <p class="message"><?php echo $message; ?></p>
    <?php } ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Create a password" required>
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="signup">Sign Up</button>
    </form>
    <a href="login.php">Already have an account? Log in here</a>
</div>

</body>
</html>
