<?php
    include 'connect.php';
    define('UPLPATH', 'images/');

    $query = "SELECT * FROM projektdbs WHERE display = 0";
    $result = mysqli_query($dbc, $query);
    $programmingLanguages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $programmingLanguages[] = $row;
}

mysqli_close($dbc);

// Grupiranje vijesti po kategorijama
$categories = [
    'Procedural programming language' => [],
    'Object-oriented language' => [],
];

foreach ($programmingLanguages as $programmingLanguage) {
    if (isset($categories[$programmingLanguage['category']])) {
        $categories[$programmingLanguage['category']][] = $programmingLanguage;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Programming Languages</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <div class="header-container">
        </div>

        <nav class="nav-bar">
            <ul class="nav-ul">
                <li><a href="#">Home</a></li>
                <li><a href="kategorija.php?category=Procedural programming language">Procedural Programming Languages</a></li>
                <li><a href="kategorija.php?category=Object-oriented language">Object-Oriented Languages</a></li>
                <li><a href="unos.html">Form</a></li>
                <li><a href="prijava.php">Prijava</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="article-section">
    <?php foreach ($categories as $category => $articles): ?>
        <div class="category">
            <h2 class="category-title"><a href=""><?php echo $category; ?></a></h2>
            <div class="articles-grid">
                <?php foreach (array_slice($articles, 0, 3) as $programmingLanguage): ?>
                    <div class="article">
                        <a href="clanak.php?id=<?php echo $programmingLanguage['id']; ?>">
                        <img class="article-img" src="<?php echo UPLPATH . htmlspecialchars($programmingLanguage['picture']); ?>" alt="Picture">
                            <h3 class="article-title"><?php echo $programmingLanguage['title']; ?></h3>
                        </a>
                        <p class="article-description"><?php echo $programmingLanguage['summary']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>


    <footer>
            <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>
</body>
</html>
