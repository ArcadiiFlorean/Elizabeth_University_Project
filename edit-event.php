<?php
session_start();
include('includes/header.php');
include 'config/db.php'; // Dacă db.php este într-un subfolder "config"

if (!isset($_GET['id'])) {
    echo "ID-ul evenimentului nu a fost specificat.";
    exit;
}

$event_id = $_GET['id'];
$query = "SELECT * FROM events WHERE id = '$event_id' AND user_id = '{$_SESSION['user_id']}'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Nu aveți permisiunea să editați acest eveniment.";
    exit;
}

$event = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = $_POST['date'];

    $update_query = "UPDATE events SET title = '$title', description = '$description', date = '$date' WHERE id = '$event_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "Evenimentul a fost actualizat cu succes!";
        header("Location: index.php");
    } else {
        echo "Eroare la actualizarea evenimentului: " . mysqli_error($conn);
    }
}
?>

<main>
    <h1>Editați Evenimentul</h1>
    <form action="edit-event.php?id=<?php echo $event['id']; ?>" method="post">
        <input type="text" name="title" value="<?php echo $event['title']; ?>" required><br>
        <textarea name="description" required><?php echo $event['description']; ?></textarea><br>
        <input type="date" name="date" value="<?php echo $event['date']; ?>" required><br>
        <button type="submit">Actualizează Eveniment</button>
    </form>
</main>

<?php include('includes/footer.php'); ?>
