<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';

    $picture = $_FILES['picture']['name'];
    $title=$_POST['title'];
    $summary=$_POST['summary'];
    $content=$_POST['content'];
    $category=$_POST['category'];
    $display = isset($_POST['display']) ? 1 : 0;
    $picture = "";


    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == UPLOAD_ERR_OK) {
        $image_name = uniqid() . '_' . basename($_FILES["picture"]["name"]);
        $target_path = "images/" . $image_name;
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_path)) {
            $picture = $image_name;
        } else {
            echo "Greška prilikom spremanja slike.";
            $picture = "";
        }
    } else {
        echo "Došlo je do greške prilikom uploada slike.";
        $image = "";
    }


    $query = "INSERT INTO projektdbs (title, summary, content, category, picture, display ) VALUES ('$title', '$summary', '$content', '$category', '$picture', '$display')";
    $result = mysqli_query($dbc, $query) or die('Error querying databese.');
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Prikaz unosa</title>
</head>
<body>
    <header>
    <div class="header-container"></div>
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

    <section>
        <div role="main">
            <div class="row">
                <p class="category"><?php echo $category; ?></p>
                <h1 class="title"><?php echo $title; ?></h1>
                <p>AUTOR:</p>
                <p>OBJAVLJENO:</p>
            </div>

            <section class="picture">
                <?php 
                if (!empty($picture)) { 
                    echo "<img src='images/$picture' alt='Slika' style='max-width:100%; height:300px;'>"; 
                } else {
                    echo "<p>No image uploaded.</p>";
                }
                ?>
            </section>

            <section class="summary">
                <p><?php echo $summary; ?></p>
            </section>

            <section class="content">
                <p><?php echo $content; ?></p>
            </section>
        </div>


    </section>

    <footer>
            <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>
</body>
</html>
