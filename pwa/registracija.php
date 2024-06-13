<?php
session_start();
require 'connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    $confirm_lozinka = $_POST['confirm_pass'];
    $admin_prava = isset($_POST['admin_prava']) ? 1 : 0;

    if ($lozinka !== $confirm_lozinka) {
        $_SESSION['message'] = "Passwords do not match!";
        header("Location: registracija.php");
        exit;
    }

    $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

    // Check if the username already exists
    $sql = "SELECT username FROM korisnik WHERE username = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Username already exists!";
    } else {
        // Insert new user
        $sql = "INSERT INTO korisnik (ime, prezime, username, lozinka, admin_prava) VALUES (?, ?, ?, ?, ?)";
        $stmt = $dbc->prepare($sql);
        $stmt->bind_param('ssssi', $ime, $prezime, $username, $hashed_password, $admin_prava);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful!";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $dbc->close();

    header("Location: registracija.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Registracija</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div class="header-container">
    </div>

    <header>
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

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <form method="post" action="registracija.php" class="container">
        <div class="form-item">
            <label for="ime">Ime:</label>
            <div class="form-field">
                <input type="text" id="ime" name="ime" required>
            </div>
        </div>
        <div class="form-item">
            <label for="prezime">Prezime:</label>
            <div class="form-field">
                <input type="text" id="prezime" name="prezime" required>
            </div>
        </div>
        <div class="form-item">
            <label for="username">Korisničko ime:</label>
            <div class="form-field">
                <input type="text" id="username" name="username" required>
            </div>
        </div>
        <div class="form-item">
            <label for="pass">Lozinka:</label>
            <div class="form-field">
                <input type="password" id="pass" name="pass" required>
            </div>
        </div>
        <div class="form-item">
            <label for="confirm_pass">Potvrdite lozinku:</label>
            <div class="form-field">
                <input type="password" id="confirm_pass" name="confirm_pass" required>
            </div>
        </div>
        <div class="form-item">
            <label for="admin_prava">Admin prava:</label>
            <div class="form-field">
                <input type="checkbox" id="admin_prava" name="admin_prava">
            </div>
        </div>
        <div class="form-item">
            <button type="submit">Registriraj se</button>
        </div>
    </form>

    <footer>
        <p class="footer-text">Laura Šestak| 2024 | lsestak@tvz.hr</p>
    </footer>

</body>
</html>



