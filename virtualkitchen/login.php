<?php
session_start();
include('connect.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
       
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php'); 
            exit();
        } else {
            $errorMessage = "<p style='color:red;'>Invalid password. Please try again.</p>";
        }
    } else {
        $errorMessage = "<p style='color:red;'>No account found with that email. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
        <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <h1>Login to Your Account</h1>
    </header>
    <main>
        <?php
        if (isset($errorMessage)) {
            echo $errorMessage;
        }
        ?>
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Log In</button>
        </form>
    </main>
</body>
</html>
