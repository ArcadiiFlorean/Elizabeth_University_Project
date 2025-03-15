<?php
include 'config/db.php'; // Dacă db.php este într-un subfolder "config"

// Aici poți adăuga logica pentru a obține evenimentele și comentariile din baza de date
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunitatea Seabrook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Comunitatea Seabrook</h1>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="events.php">Evenimente</a></li>
                <li><a href="login.php">Autentificare</a></li>
                <li><a href="register.php">Înregistrare</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="events">
            <h2>Evenimente recente</h2>
            <?php
            // Aici poți adăuga un query pentru a obține evenimentele din baza de date
            $stmt = $pdo->query('SELECT * FROM events ORDER BY date DESC');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='event'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                echo "<p><em>Data: " . htmlspecialchars($row['date']) . "</em></p>";
                echo "</div>";
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Comunitatea Seabrook</p>
    </footer>
</body>
</html>
