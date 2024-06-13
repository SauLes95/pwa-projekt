<?php
    include 'connect.php';
    define('UPLPATH', 'images/');

    if (isset($_GET['category'])) {
        $category = $_GET['category'];
    
        // Dohvaćanje ne-arhiviranih vijesti iz određene kategorije iz baze podataka
        $query = "SELECT * FROM projektdbs WHERE category = '$category'";
        $result = mysqli_query($dbc, $query);
        $programmingLanguages = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $programmingLanguages[] = $row;
        }
    
        mysqli_close($dbc);
    } else {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Category</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <div class="header-container">
        </div>

        <nav class="nav-bar">
            <ul class="nav-ul">
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?category=Procedural programming language">Procedural Programming Languages</a></li>
                <li><a href="kategorija.php?category=Object-oriented language">Object-Oriented Languages</a></li>
                <li><a href="unos.html">Form</a></li>
                <li><a href="prijava.php">Prijava</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="articles-group">
        <h2 class="category-title"><?php echo ucfirst($category); ?></h2>
        <?php if (!empty($programmingLanguages)): ?>
            <?php foreach ($programmingLanguages as $programmingLanguage): ?>
                <div class="articles-row">
                    <div class="article">
                        <a href="clanak.php?id=<?php echo $programmingLanguage['id']; ?>"><img src="<?php echo UPLPATH . htmlspecialchars($programmingLanguage['picture']); ?>" alt="picture" class="section-img"></a>
                        <a href="clanak.php?id=<?php echo $programmingLanguage['id']; ?>"><h3 class="article-title"><?php echo $programmingLanguage['title']; ?></h3></a>
                        <p class="article-description"><?php echo $programmingLanguage['summary']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No articles found in this category.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p class="footer-text">Laura Šestak | 2024 | lsestak@tvz.hr</p>
    </footer>

</body>
</html>
