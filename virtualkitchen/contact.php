<?php

include('db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $confirmEmail = htmlspecialchars($_POST['confirmEmail']);
    $preferredDate = htmlspecialchars($_POST['date']);
    $subject = htmlspecialchars($_POST['subject']);
    $description = htmlspecialchars($_POST['description']);

    
    if ($email !== $confirmEmail) {
        $errorMessage = "Email addresses do not match!";
    } else {
        
        $sql = "INSERT INTO contact (name, email, confirm_email, preferred_date, subject, description) 
                VALUES (:name, :email, :confirm_email, :preferred_date, :subject, :description)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':confirm_email', $confirmEmail);
        $stmt->bindParam(':preferred_date', $preferredDate);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            $successMessage = "Your appointment request has been submitted successfully!";
        } else {
            $errorMessage = "Failed to submit your appointment request. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Contact Us</h1>

        
        <?php if (!empty($successMessage)): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php elseif (!empty($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

       
        <form id="contactForm" method="POST" action="contact.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="confirmEmail">Confirm Email:</label>
            <input type="email" id="confirmEmail" name="confirmEmail" required>

            <label for="date">Preferred Appointment Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk | 240125594</p>
    </footer>
</body>
</html>

