<?php

include('db.php');


$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;


$sql = "SELECT r.*, u.username AS owner 
        FROM recipes r 
        LEFT JOIN users u ON r.uid = u.uid 
        WHERE r.rid = :rid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
$stmt->execute();
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    die("Recipe not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
        <img src="images/my-logo.png" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1><?php echo htmlspecialchars($recipe['name']); ?></h1>
        
        <img src="<?php echo htmlspecialchars($recipe['image'] ?? 'images/default-image.jpg'); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="recipe-image-normal">
        <p><strong>Type:</strong> <?php echo htmlspecialchars($recipe['type']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($recipe['description']); ?></p>

        <p><strong>Ingredients:</strong></p>
        <ul>
            <?php foreach (explode(',', $recipe['ingredients']) as $ingredient): ?>
                <li><?php echo htmlspecialchars(trim($ingredient)); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Cooking Instructions:</strong></p>
        <ol>
            <?php foreach (explode('.', $recipe['instructions']) as $step): ?>
                <li><?php echo htmlspecialchars(trim($step)); ?></li>
            <?php endforeach; ?>
        </ol>
        <p><strong>Owner:</strong> <?php echo htmlspecialchars($recipe['owner'] ?? 'Unknown'); ?></p>
    </main>
    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
    </footer>
</body>
</html>

