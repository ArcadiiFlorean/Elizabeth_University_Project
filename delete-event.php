<?php
session_start();
include 'config/db.php'; // Dacă db.php este într-un subfolder "config"

if (!isset($_GET['id'])) {
    echo "ID-ul evenimentului nu a fost specificat.";
    exit;
}

$event_id = $_GET['id'];

// Verificăm dacă utilizatorul logat este autorul evenimentului sau un admin
$query = "SELECT * FROM events WHERE id = '$event_id' AND (user_id = '{$_SESSION['user_id']}' OR '{$_SESSION['role']}' = 'admin')";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $delete_query = "DELETE FROM events WHERE id = '$event_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "Evenimentul a fost șters cu succes.";
        header("Location: index.php");
    } else {
        echo "Eroare la ștergerea evenimentului: " . mysqli_error($conn);
    }
} else {
    echo "Nu aveți permisiunea să ștergeți acest eveniment.";
}
?>
