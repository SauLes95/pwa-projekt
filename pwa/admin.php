<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: prijava.php");
    exit();
}

require 'connect.php'; 
define('UPLPATH', 'images/');


if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM projektdbs WHERE id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM projektdbs";
$result = $dbc->query($query);
$programmingLanguages = [];
while ($row = $result->fetch_assoc()) {
    $programmingLanguages[] = $row;
}

$dbc->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Administracija</title>
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
                <li><a href="prijava.php">Prijava</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </nav>
    </header>
        
    <div class="admin-content">
        <h2 class="admin-title">Manage Articles</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Summary</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Archived</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programmingLanguages as $programmingLanguage): ?>
                <tr>
                    <td><?php echo $programmingLanguage['id']; ?></td>
                    <td><?php echo $programmingLanguage['title']; ?></td>
                    <td><?php echo $programmingLanguage['category']; ?></td>
                    <td class="truncate"><?php echo $programmingLanguage['summary']; ?></td>
                    <td class="truncate"><?php echo $programmingLanguage['content']; ?></td>
                    <td><img src="<?php echo UPLPATH . htmlspecialchars($programmingLanguage['picture']); ?>" alt="Article Image" style="max-width: 300px; max-height: 300px; width: auto; height: auto;"></td>
                    <td><?php echo $programmingLanguage['display'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form method="GET" action="administracija.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $programmingLanguage['id']; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $programmingLanguage['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>

</body>
</html>


