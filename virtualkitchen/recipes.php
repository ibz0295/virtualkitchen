<?php

include('db.php');


$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';


if ($search) {
    $sql = "SELECT * FROM recipes WHERE name LIKE :search OR type LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
} else {
    $sql = "SELECT * FROM recipes"; 
    $stmt = $pdo->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Kitchen Recipes</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php" class="active">Recipes</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Recipes</h1>

        
        <form id="search-form" action="recipes.php" method="GET" class="search-container">
            <input type="text" name="search" id="search-bar" placeholder="Search recipes by name or type..." value="<?php echo $search; ?>" required>
            <button type="submit">Search</button>
        </form>

       
        <div class="button-container">
            <button onclick="window.location.href='add-recipe.php'" class="action-btn add-btn">Add Recipe</button>
            <button onclick="window.location.href='edit-recipe.php'" class="action-btn edit-btn">Edit Recipe</button>
        </div>

        
        <section class="recipe-list">
            <?php
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="recipe">';
                    echo '<h2>' . htmlspecialchars($row['name'] ?? 'Unnamed Recipe') . '</h2>';
                    echo '<img src="' . htmlspecialchars($row['image'] ?? 'images/default-image.jpg') . '" alt="' . htmlspecialchars($row['name'] ?? 'Unnamed Recipe') . '" class="recipe-image">';
                    echo '<p><strong>Type:</strong> ' . htmlspecialchars($row['type'] ?? 'Unknown') . '</p>';
                    echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description'] ?? 'No description available.') . '</p>';
                    echo '<h3>Ingredients:</h3>';
                    echo '<ul>';
                    foreach (explode(',', $row['ingredients'] ?? '') as $ingredient) {
                        echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
                    }
                    echo '</ul>';
                    echo '<h3>Instructions:</h3>';
                    echo '<ol>';
                    foreach (explode('.', $row['instructions'] ?? '') as $instruction) {
                        echo '<li>' . htmlspecialchars(trim($instruction)) . '</li>';
                    }
                    echo '</ol>';
                    echo '</div>';
                }
            } else {
                echo '<p>No recipes found!</p>';
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk | 240125594</p>
    </footer>
</body>
</html>
