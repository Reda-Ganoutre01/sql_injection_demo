<?php
// Détruit la session et redirige vers la page d'accueil
require_once __DIR__ . '/config/database.php';

// Supprimer toutes les variables de session
$_SESSION = [];

// Supprimer le cookie de session côté client si présent
if (ini_get('session.use_cookies')) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params['path'], $params['domain'], $params['secure'], $params['httponly']
	);
}

// Détruire la session côté serveur
session_destroy();

// Redirection vers l'accueil
header('Location: index.php');
exit();

