<?php

include('connect.php');


$registrationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    
    if ($password === $confirmPassword) {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $registrationSuccess = true; 
        } else {
            echo "<p style='color:red;'>Error inserting data: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Passwords do not match. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="register.php" class="active">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Register to Join Our Community</h1>

        <?php if ($registrationSuccess): ?>
            
            <p class="success-message">
                Thank you for registering, <strong><?php echo htmlspecialchars($username); ?></strong>! You can now <a href="login.php">log in</a>.
            </p>
        <?php else: ?>
            
            <form id="registerForm" method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter a password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Register</button>
                </div>
            </form>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk | 240125594</p>
    </footer>
</body>
</html>
