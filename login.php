<?php
// Include fișierul de configurare
include 'config/db.php'; // Dacă db.php este într-un subfolder "config"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifică dacă utilizatorul există în baza de date
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Logare reușită
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        echo "Autentificare eșuată!";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Autentificare</h1>
    </header>
    <main>
        <form action="login.php" method="post">
            <label for="username">Nume utilizator:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Parolă:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Autentificare</button>
        </form>
    </main>
</body>
</html>
