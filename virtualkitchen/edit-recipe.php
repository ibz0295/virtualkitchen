<?php
session_start();
include('db.php'); // Include the database connection

if (!isset($_SESSION['uid'])) {
    header('Location: login.php');
    exit();
}

// Get user ID from session
$uid = $_SESSION['uid'];

// Check if a recipe ID is provided in the URL
$recipeId = isset($_GET['rid']) ? intval($_GET['rid']) : null;

// Fetch all recipes created by the user or a specific recipe
if (!$recipeId) {
    // Fetch all recipes created by the user if no specific recipe is selected
    $sql = "SELECT * FROM recipes WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch specific recipe details for editing
    $sql = "SELECT * FROM recipes WHERE rid = :rid AND uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':rid', $recipeId, PDO::PARAM_INT);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->execute();
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        die("Recipe not found or you do not have permission to edit this recipe.");
    }
}

// Handle form submission for updating a recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);
    $cookingtime = intval($_POST['cookingtime']);
    $ingredients = htmlspecialchars($_POST['ingredients']);
    $instructions = htmlspecialchars($_POST['instructions']);
    $imagePath = $recipe['image']; // Keep the existing image path

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "images/";
        $targetFilePath = $targetDir . uniqid() . "_" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath; // Update the image path with the new image
        } else {
            echo "<p class='error-message'>Failed to upload image. Please try again.</p>";
        }
    }

    // Update the recipe in the database
    $sql = "UPDATE recipes 
            SET name = :name, description = :description, type = :type, 
               ingredients = :ingredients, instructions = :instructions, image = :image 
            WHERE rid = :rid AND uid = :uid";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':ingredients', $ingredients);
    $stmt->bindParam(':instructions', $instructions);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':rid', $recipeId);
    $stmt->bindParam(':uid', $uid);

    if ($stmt->execute()) {
        header("Location: recipes.php?message=Recipe+updated+successfully");
        exit();
    } else {
        echo "<p class='error-message'>Failed to update recipe. Please try again.</p>";
    }
}

// Handle recipe deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $sql = "DELETE FROM recipes WHERE rid = :rid AND uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':rid', $recipeId, PDO::PARAM_INT);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: recipes.php?message=Recipe+deleted+successfully");
        exit();
    } else {
        echo "<p class='error-message'>Failed to delete recipe. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
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
        <h1>Edit Recipe</h1>

        
        <?php if (!$recipeId): ?>
            <h2>Select a recipe to edit:</h2>
            <ul class="recipe-list">
                <?php foreach ($recipes as $r): ?>
                    <li>
                        <a href="edit-recipe.php?rid=<?php echo htmlspecialchars($r['rid']); ?>">
                            <?php echo htmlspecialchars($r['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        
        <?php if ($recipeId && $recipe): ?>
            <form action="edit-recipe.php?rid=<?php echo $recipeId; ?>" method="POST" enctype="multipart/form-data" class="recipe-form">
                <div class="form-group">
                    <label for="name">Recipe Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($recipe['name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($recipe['description'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="type" name="type" required>
                        <option value="French" <?php echo $recipe['type'] === 'French' ? 'selected' : ''; ?>>French</option>
                        <option value="Italian" <?php echo $recipe['type'] === 'Italian' ? 'selected' : ''; ?>>Italian</option>
                        <option value="Chinese" <?php echo $recipe['type'] === 'Chinese' ? 'selected' : ''; ?>>Chinese</option>
                        <option value="Indian" <?php echo $recipe['type'] === 'Indian' ? 'selected' : ''; ?>>Indian</option>
                        <option value="Mexican" <?php echo $recipe['type'] === 'Mexican' ? 'selected' : ''; ?>>Mexican</option>
                        <option value="Others" <?php echo $recipe['type'] === 'Others' ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="ingredients">Ingredients:</label>
                    <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="instructions">Cooking Instructions:</label>
                    <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($recipe['instructions'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Update Recipe Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if (!empty($recipe['image'])): ?>
                        <p>Current Image:</p>
                        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <button type="submit" name="update">Update Recipe</button>
                    <button type="submit" name="delete" class="delete-btn">Delete Recipe</button>
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

