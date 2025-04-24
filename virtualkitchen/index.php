<?php

include('db.php');


$sql = "SELECT rid, name, type, description FROM recipes";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Kitchen Home</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header class="main-header">
    <img src="images/my-logo.png?<?php echo time(); ?>" alt="Logo of Virtual Kitchen" class="logo">
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="welcome-section">
        <h1>Welcome to Our Culinary Virtual Kitchen</h1>
        <p>Discover the finest recipes from the comfort of your home.</p>
        <form action="search.php" method="GET" class="search-container">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="text" name="search" id="search-bar" placeholder="Search recipes..." required>
            <button type="submit" class="action-btn">Search</button>
        </form>
    </section>

    <img src="images/my-banner.png?<?php echo time(); ?>" alt="Virtual Kitchen Banner" class="banner">

    <main>
        <section>
            <h2>Our History</h2>
            <p>Since 2025, our virtual kitchen has been dedicated to bringing you the best and most amazing culinary experiences. Our journey began with a simple idea: to make authentic worldwide cuisine accessible to everyone. Founded by a group of passionate chefs and food enthusiasts, we started by sharing traditional recipes passed down through generations.</p>
            <p>Over the years, we have expanded our repertoire to include modern twists on classic dishes, always staying true to the rich cultural heritage of every region of the world. Our virtual kitchen has become a hub for food lovers, where people can explore new flavors, learn cooking techniques, and connect with a community of fellow culinary adventurers.</p>
            <p>Our commitment to quality and authenticity has earned us a loyal following, and we continue to innovate and inspire with each new recipe we share. Join us on this delicious journey and discover the magic of worldwide cuisine.</p>

            <h2>All Recipes</h2>
            <section class="recipe-list">
                <?php if ($stmt->rowCount() > 0): ?>
                    <ul>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <li class="recipe-item">
                                <div class="recipe-info">
                                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p><strong>Type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
                                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                    <a href="recipe-details.php?rid=<?php echo $row['rid']; ?>" class="action-btn">View Details</a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No recipes found!</p>
                <?php endif; ?>
            </section>

            <p>Explore our collection of recipes and bring the taste of the world to your home. <a href="recipes.php">Check out our recipes!</a></p>

            
            <h2>Cooking Tips</h2>
            <section class="cooking-tips">
                <p>Cooking is both an art and a science! Here are some quick tips to make your culinary adventures more enjoyable:</p>
                <ul>
                    <li><strong>Taste as you cook:</strong> Adjust seasonings to ensure balanced flavors in every dish.</li>
                    <li><strong>Let meats rest:</strong> Resting meat after cooking locks in juices and enhances flavor.</li>
                    <li><strong>Prep ingredients beforehand:</strong> Prepping ensures a smooth cooking process and prevents last-minute stress.</li>
                    <li><strong>Sharpen your knives:</strong> A sharp knife is safer and makes chopping more efficient.</li>
                    <li><strong>Cook with fresh ingredients:</strong> Fresh produce always adds vibrant flavors and aromas to your meals.</li>
                </ul>
            </section>

         
            <h2>Featured Chefs</h2>
            <section class="featured-chefs">
                <p>Meet the creative minds behind our amazing recipes! These talented chefs and food enthusiasts have brought their passion for cooking to life, inspiring us all to try something new:</p>
                <ul>
                    <li><strong>Chef Maria Lopez:</strong> Renowned for her contemporary Mediterranean dishes, blending tradition with innovation.</li>
                    <li><strong>Chef Superman:</strong> An expert in worldwide cuisine with a flair for bold and rich flavors.</li>
                    <li><strong>Chef Priya Shah:</strong> Specializing in authentic Indian recipes, bringing spices and aromas to the forefront.</li>
                    <li><strong>Chef Alex Tanaka:</strong> Famous for his precision in Japanese culinary art, from sushi rolls to ramen perfection.</li>
                </ul>
                <p>Learn more about these chefs and their incredible culinary journeys by exploring their recipes!</p>
            </section>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Culinary Virtual Kitchen. All rights reserved.</p>
        <p>Ibrahim Bah | 240125594@astonsac.uk | 240125594</p>
    </footer>
</body>
</html>

