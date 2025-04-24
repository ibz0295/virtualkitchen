<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


include('db.php');


$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Search Results</h1>

        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search recipes..." value="<?php echo $search; ?>" required>
            <button type="submit">Search</button>
        </form>

        <section class="search-results">
            <?php
            if ($search) {
                try {
                    
                    $sql = "SELECT name, type, description, image, ingredients, instructions 
                            FROM recipes 
                            WHERE name LIKE :search OR type LIKE :search";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($recipe = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="recipe-card">';
                            echo '<img src="' . htmlspecialchars($recipe['image']) . '" alt="' . htmlspecialchars($recipe['name']) . '" class="recipe-image">';
                            echo '<h2>' . htmlspecialchars($recipe['name']) . '</h2>';
                            echo '<p><strong>Type:</strong> ' . htmlspecialchars($recipe['type']) . '</p>';
                            echo '<p><strong>Description:</strong> ' . htmlspecialchars($recipe['description']) . '</p>';
                            echo '<h3>Ingredients:</h3>';
                            echo '<ul>';
                            foreach (explode(',', $recipe['ingredients']) as $ingredient) {
                                echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
                            }
                            echo '</ul>';
                            echo '<h3>Instructions:</h3>';
                            echo '<ol>';
                            foreach (explode('.', $recipe['instructions']) as $instruction) {
                                if (!empty(trim($instruction))) {
                                    echo '<li>' . htmlspecialchars(trim($instruction)) . '</li>';
                                }
                            }
                            echo '</ol>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No recipes found for "' . htmlspecialchars($search) . '". Try a different search term.</p>';
                    }
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
            } else {
                echo '<p>Please enter a search term.</p>';
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk</p>
    </footer>
</body>
</html>
