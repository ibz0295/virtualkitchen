<?php
session_start();
include('db.php'); 


if (!isset($_SESSION['uid'])) {
    header('Location: login.php');
    exit();
}

$successMessage = $errorMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);
    $ingredients = htmlspecialchars($_POST['ingredients']);
    $instructions = htmlspecialchars($_POST['instructions']);
    $uid = $_SESSION['uid'];
    $imagePath = '';

   
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "images/";
        $targetFilePath = $targetDir . uniqid() . "_" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        } else {
            $errorMessage = "Failed to upload image.";
        }
    }

   
    $sql = "INSERT INTO recipes (name, description, type, ingredients, instructions, image, uid) 
            VALUES (:name, :description, :type, :ingredients, :instructions, :image, :uid)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':ingredients', $ingredients);
    $stmt->bindParam(':instructions', $instructions);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':uid', $uid);

    if ($stmt->execute()) {
        $successMessage = "Recipe added successfully!";
    } else {
        $errorMessage = "Failed to add recipe. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Recipe</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Add a New Recipe</h1>

   
        <?php if ($successMessage): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php elseif ($errorMessage): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        
        <form action="add-recipe.php" method="POST" enctype="multipart/form-data" class="recipe-form">
            <div class="form-group">
                <label for="name">Recipe Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter the recipe name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Write a short description" required></textarea>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="French">French</option>
                    <option value="Italian">Italian</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Indian">Indian</option>
                    <option value="Mexican">Mexican</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" placeholder="List the ingredients separated by commas" required></textarea>
            </div>
            <div class="form-group">
                <label for="instructions">Cooking Instructions:</label>
                <textarea id="instructions" name="instructions" placeholder="List the steps separated by periods" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Recipe Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit">Add Recipe</button>
            </div>
        </form>
    </main>
    <footer>
    <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk | 240125594</p>
    </footer>
</body>
</html>



