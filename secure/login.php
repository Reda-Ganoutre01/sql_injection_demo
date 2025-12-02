<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$pageTitle = "Login Sécurisé";
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            $stored = $user['password'];
            $valid = false;
            if (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0) {
                $valid = password_verify($password, $stored);
            } else {
                $valid = ($password === $stored);
            }

            if ($valid) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['mode'] = 'secure';

                header('Location: dashboard.php');
                exit();
            }
        }

        $error = 'Identifiants incorrects.';
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="navbar">
    <div class="navbar-brand">🔒 Mode Sécurisé</div>
    <div class="navbar-menu">
        <span class="badge badge-secure">MODE SÉCURISÉ</span>
        <a href="../vulnerable/login.php">Voir la version vulnérable</a>
        <a href="../index.php">Accueil</a>
    </div>
</div>

<div class="card" style="max-width:600px; margin:0 auto;">
    <h1 style="color:#333; margin-bottom:20px;">🔒 Connexion (Sécurisé)</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo clean($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success" style="width:100%">Se connecter</button>
    </form>

     <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 10px;">
        <strong>🔑 Comptes légitimes :</strong><br>
        reda / reda1234<br>
        manager / manager123<br>
        user1 / pass123
    </div>
</div>

</div>
</body>
</html>
