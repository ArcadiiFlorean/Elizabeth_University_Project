<?php
session_start();
include 'config/db.php';


if (!isset($_GET['id'])) {
    echo "ID-ul evenimentului nu a fost specificat.";
    exit;
}

$event_id = $_GET['id'];
$query = "SELECT * FROM events WHERE id = '$event_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Evenimentul nu a fost găsit.";
    exit;
}

$event = mysqli_fetch_assoc($result);
?>

<main>
    <h1><?php echo $event['title']; ?></h1>
    <p><?php echo $event['description']; ?></p>
    <p>Date: <?php echo $event['date']; ?></p>

    <h2>Comentarii:</h2>
    <div>
        <?php
        $comments_query = "SELECT * FROM comments WHERE event_id = '$event_id' ORDER BY created_at DESC";
        $comments_result = mysqli_query($conn, $comments_query);
        while ($comment = mysqli_fetch_assoc($comments_result)) {
            echo "<p><strong>User " . $comment['user_id'] . ":</strong> " . $comment['comment'] . "</p>";
        }
        ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <h3>Adaugă un Comentariu</h3>
        <form action="comment.php" method="post">
            <textarea name="comment" placeholder="Lasă un comentariu..." required></textarea><br>
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <button type="submit">Adaugă Comentariu</button>
        </form>
    <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
