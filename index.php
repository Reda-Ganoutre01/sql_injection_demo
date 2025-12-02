<?php
$pageTitle = "Accueil - Démo SQL Injection";
include 'includes/header.php';
?>

<div class="card" style="text-align: center; padding: 50px;">
    <h1 style="font-size: 42px; color: #333; margin-bottom: 20px;">
        🔐 Démonstration SQL Injection
    </h1>
    <p style="font-size: 18px; color: #666; margin-bottom: 40px;">
        Comparez une application vulnérable vs sécurisée
    </p>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; max-width: 900px; margin: 0 auto;">
        <div style="background: #ffebee; padding: 40px; border-radius: 15px; border: 3px solid #f44336;">
            <h2 style="color: #c62828; margin-bottom: 15px;">⚠️ Version Vulnérable</h2>
            <p style="color: #666; margin-bottom: 20px;">
                Découvrez comment fonctionnent les injections SQL
            </p>
            <a href="vulnerable/login.php" class="btn btn-danger">Accéder à la version vulnérable</a>
        </div>
        
        <div style="background: #e8f5e9; padding: 40px; border-radius: 15px; border: 3px solid #4caf50;">
            <h2 style="color: #2e7d32; margin-bottom: 15px;">✅ Version Sécurisée</h2>
            <p style="color: #666; margin-bottom: 20px;">
                Apprenez les bonnes pratiques de sécurité
            </p>
            <a href="secure/login.php" class="btn btn-success">Accéder à la version sécurisée</a>
        </div>
    </div>
    
    <!-- <div style="margin-top: 50px; padding: 30px; background: #fff3e0; border-radius: 15px;">
        <h3 style="color: #e65100; margin-bottom: 15px;">📚 Objectifs pédagogiques</h3>
        <ul style="text-align: left; max-width: 700px; margin: 0 auto; color: #666; line-height: 1.8;">
            <li>✓ Comprendre les vulnérabilités SQL Injection</li>
            <li>✓ Apprendre à exploiter ces failles (à des fins éducatives)</li>
            <li>✓ Découvrir les bonnes pratiques de sécurité</li>
            <li>✓ Implémenter des requêtes préparées (Prepared Statements)</li>
            <li>✓ Protéger efficacement vos applications web</li>
        </ul>
    </div> -->
</div>

</div>
</body>
</html>