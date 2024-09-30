<?php
session_start();
$message_login = "";
$message_signup = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['login_username'];
        $password = $_POST['login_password'];

        $pdo = new PDO('mysql:host=localhost;dbname=guestbook', 'root', '');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message_login = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }

    if (isset($_POST['signup'])) {
        $username = $_POST['signup_username'];
        $password = $_POST['signup_password'];

        if (!empty($username) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $pdo = new PDO('mysql:host=localhost;dbname=guestbook', 'root', '');
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);

            header("Location: login_signup.php");
            exit();
        } else {
            $message_signup = "Veuillez remplir tous les champs.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription</title>
</head>
<body>
    <h1>Espace membre</h1>
    
    <h2>Connexion</h2>
    <form method="post" action="">
        <label for="login_username">Nom d'utilisateur :</label>
        <input type="text" name="login_username" required><br>
        <label for="login_password">Mot de passe :</label>
        <input type="password" name="login_password" required><br>
        <button type="submit" name="login">Se connecter</button>
    </form>
    <p><?php echo $message_login; ?></p>

    <h2>Inscription</h2>
    <form method="post" action="">
        <label for="signup_username">Nom d'utilisateur :</label>
        <input type="text" name="signup_username" required><br>
        <label for="signup_password">Mot de passe :</label>
        <input type="password" name="signup_password" required><br>
        <button type="submit" name="signup">S'inscrire</button>
    </form>
    <p><?php echo $message_signup; ?></p>
</body>
</html>
