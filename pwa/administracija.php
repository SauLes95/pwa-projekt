<?php
include 'connect.php';
define('UPLPATH', 'images/');
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
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?category=Procedural programming language">Procedural Programming Languages</a></li>
                <li><a href="kategorija.php?category=Object-oriented language">Object-Oriented Languages</a></li>
                <li><a href="unos.html">Form</a></li>
                <li><a href="#">Administracija</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </nav>
    </header>

    <?php
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM projektdbs WHERE id = $id";
        $result = mysqli_query($dbc, $query);
    }

    if (isset($_POST['update'])) {
        $picture = $_FILES['picture']['name'];
        $title = $_POST['title'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        if (isset($_POST['display'])) {
            $display = 1;
        } else {
            $display = 0;
        }

        $target_dir = 'images/' . $picture;
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir);

        $id = $_POST['id'];
        $query = "UPDATE projektdbs SET title = '$title', summary = '$summary', content = '$content', picture = '$picture', category = '$category', display = '$display' WHERE id = $id";
        $result = mysqli_query($dbc, $query);
    }

    $editId = isset($_GET['edit']) ? $_GET['edit'] : null;

    if ($editId) {
        $query = "SELECT * FROM projektdbs WHERE id = $editId";
        $result = mysqli_query($dbc, $query);
        if ($row = mysqli_fetch_array($result)) {
            echo '<form enctype="multipart/form-data" action="" method="POST">
                <div class="form-item">
                    <label for="title">Naslov vjesti:</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" value="' . $row['title'] . '">
                    </div>
                </div>

                <div class="form-item">
                    <label for="summary">Summary:</label>
                    <div class="form-field">
                        <textarea name="summary" id="" cols="30" rows="10" class="formfield-textual">' . $row['summary'] . '</textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label for="content">Content:</label>
                    <div class="form-field">
                        <textarea name="content" id="" cols="30" rows="10" class="formfield-textual">' . $row['content'] . '</textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label for="picture">Slika:</label>
                    <div class="form-field">
                        <input type="file" class="input-text" id="picture" value="' . $row['picture'] . '" name="picture"/> <br><img src="' . UPLPATH . $row['picture'] . '" style="max-width: 300px; max-height: 300px; width: auto; height: auto;">
                    </div>
                </div>

                <div class="form-item">
                    <label for="category">Kategorija vijesti:</label>
                    <div class="form-field">
                        <select name="category" id="" class="form-field-textual" value="' . $row['category'] . '">
                            <option value="Procedural programming language">Procedural programming language</option>
                            <option value="Object-oriented language">Object-oriented language</option>
                        </select>
                    </div>
                </div>

                <div class="form-item">
                    <label>Spremiti u arhivu:
                        <div class="form-field">';
            if ($row['display'] == 0) {
                echo '<input type="checkbox" name="display" id="display"/> Arhiviraj?';
            } else {
                echo '<input type="checkbox" name="display" id="display" checked/> Arhiviraj?';
            }
            echo '</div>
                    </label>
                </div>

                <div class="form-item">
                    <input type="hidden" name="id" class="form-field-textual" value="' . $row['id'] . '">
                    <button type="reset" value="Reset">Reset</button>
                    <button type="submit" name="update" value="Update">Update</button>
                    <button type="submit" name="delete" value="Delete">Delete</button>
                </div>
            </form>';
        }
    } else {
        $query = "SELECT * FROM projektdbs";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="article-item">
                <h3>' . $row['title'] . '</h3>
                <p>' . $row['summary'] . '</p>
                <a href="?edit=' . $row['id'] . '">Edit</a>
            </div>';
        }
    }
    ?>

    <footer>
        <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>

</body>
</html>
