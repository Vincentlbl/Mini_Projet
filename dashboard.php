<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_signup.php");
    exit();
}

$username = $_SESSION['username'];
$message_post = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = $_POST['message'];
    if (!empty($user_message)) {
        $pdo = new PDO('mysql:host=localhost;dbname=guestbook', 'root', '');
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->execute([$user['id'], $user_message]);
        $message_post = "Message envoyé.";
    }
}

$pdo = new PDO('mysql:host=localhost;dbname=guestbook', 'root', '');
$stmt = $pdo->query("SELECT messages.message, users.username, messages.created_at FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($username); ?>!</h2>
    <p><a href="logout.php">Se déconnecter</a></p>

    <h3>Laissez un message :</h3>
    <form method="post" action="">
        <textarea name="message" rows="4" cols="50" placeholder="Votre message..."></textarea><br>
        <button type="submit" name="post_message">Envoyer</button>
    </form>
    <p><?php echo $message_post; ?></p>

    <h3>Messages :</h3>
    <?php foreach ($messages as $msg): ?>
        <div>
            <p><strong><?php echo htmlspecialchars($msg['username']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?> <em>(le <?php echo $msg['created_at']; ?>)</em></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
