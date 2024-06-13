<?php
    include 'connect.php';
    define('UPLPATH', 'images/');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Dohvaćanje članka iz baze podataka prema id-u
        $query = "SELECT * FROM projektdbs WHERE id = $id";
        $result = mysqli_query($dbc, $query);
    
        // Provjera je li članak pronađen
        if (mysqli_num_rows($result) > 0) {
            $programmingLanguage = mysqli_fetch_assoc($result);
        } else {
            header("Location: index.php");
            exit();
        }
    
        mysqli_close($dbc);
    } else {
        // Ako id nije postavljen, preusmjeri na index.php ili prikaži poruku o grešci
        header("Location: index.php");
        exit();
    }
    ?>
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Clanak</title>
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
    
    <div class="article-content">
        <h2 class="article-page-title"><?php echo htmlspecialchars($programmingLanguage['title']); ?></h2>
        <p class="article-page-text-title"><?php echo htmlspecialchars($programmingLanguage['summary']); ?></p>
        <img src="<?php echo UPLPATH . htmlspecialchars($programmingLanguage['picture']); ?>" alt="picture" class="picture">
        <hr class="image-divider">
        <p class="article-page-text"><?php echo nl2br(htmlspecialchars($programmingLanguage['content'])); ?></p>
    </div>

    <footer>
        <p class="footer-text">Laura Šestak | 2024 | lsestak@tvz.hr</p>
    </footer>


</body>
</html>
