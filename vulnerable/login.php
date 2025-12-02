<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

$pageTitle = "Login Vulnérable";
$error = '';
$sqlQuery = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $sqlQuery = $query;
    
    try {
        $result = $pdo->query($query);
        $user = $result->fetch();
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['mode'] = 'vulnerable';
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Identifiants incorrects";
        }
    } catch(PDOException $e) {
        $error = "Erreur SQL : " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="navbar">
    <div class="navbar-brand">🔓 Mode Vulnérable</div>
    <div class="navbar-menu">
        <span class="badge badge-vulnerable">ATTENTION: CODE NON SÉCURISÉ</span>
        <a href="../secure/login.php">Passer en mode sécurisé</a>
        <a href="../index.php">Accueil</a>
    </div>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="alert alert-danger">
        <strong>⚠️ ATTENTION :</strong> Cette page est volontairement vulnérable aux injections SQL à des fins éducatives. Ne jamais utiliser ce code en production !
    </div>
    
    <h1 style="color: #333; margin-bottom: 30px;">🔓 Connexion (Vulnérable)</h1>
    
    <?php if ($error): ?>
        <div class="alert alert-danger">❌ <?php echo clean($error); ?></div>
    <?php endif; ?>
    
    <?php if ($sqlQuery): ?>
        <div class="sql-query">
            <strong>🔍 Requête SQL exécutée :</strong><br>
            <?php echo clean($sqlQuery); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" placeholder="Entrez votre nom d'utilisateur" required>
        </div>
        
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>
        
        <button type="submit" class="btn btn-danger" style="width: 100%;">Se connecter</button>
    </form>
    
    <div style="margin-top: 30px; padding: 20px; background: #fff3e0; border-radius: 10px;">
        <h3 style="color: #e65100; margin-bottom: 15px;">💡 Essayez ces attaques :</h3>
        <div style="font-family: monospace; font-size: 14px; line-height: 2;">
            <strong>1. Bypass simple:</strong> admin' OR '1'='1<br>
            <strong>2. Commentaire SQL:</strong> admin'--<br>
            <strong>3. Toujours vrai:</strong> ' OR 1=1--<br>
            <strong>4. UNION SELECT:</strong> ' UNION SELECT 1,2,3,4,5--
        </div>
    </div>
    
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