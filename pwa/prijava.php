<?php
session_start();
require 'connect.php'; 

$message = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koristimo $connection kao varijablu konekcije, provjerite da li se koristi u connect.php
    $stmt = $dbc->prepare("SELECT username, lozinka, admin_prava FROM korisnik WHERE username = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($dbc->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dbUsername, $dbPassword, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $dbPassword)) {
        if ($role == 1) { // 1 indicates admin
            $_SESSION['username'] = $dbUsername;
            $_SESSION['role'] = 'admin';
            header("Location: admin.php"); 
            exit();
        } else {
            $message = "Hello $dbUsername, you do not have admin rights.";
        }
    } else {
        $message = "Incorrect username or password. Please register first.";
        $message .= ' <a href="registracija.php">Register here</a>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Prijava</title>
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
                <li><a href="#">Prijava</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </nav>
    </header>
        
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form action="prijava.php" method="POST" class="article-form">
        <div class="form-item">
            <label for="username">Username:</label>
            <div class="form-field">
                <input type="text" name="username" id="username" class="form-field-textual">
            </div>
        </div>
        <div class="form-item">
            <label for="password">Password:</label>
            <div class="form-field">
                <input type="password" name="password" id="password" class="form-field-textual">
            </div>
        </div>
        <div class="form-item">
            <button type="submit">Login</button>
        </div>
    </form>
    
    <footer>
        <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>


</body>
</html>