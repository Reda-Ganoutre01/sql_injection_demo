<?php
// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Rediriger vers le login si non connecté
function requireLogin($mode = 'secure') {
    if (!isLoggedIn()) {
        header("Location: /" . $mode . "/login.php");
        exit();
    }
}

// Récupérer l'utilisateur connecté
function getCurrentUser($pdo) {
    if (!isLoggedIn()) {
        return null;
    }
    
    $stmt = $pdo->prepare("SELECT id, username, email, role, created_at FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

// Vérifier si l'utilisateur est admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Nettoyer les entrées (pour affichage uniquement)
function clean($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Formater le prix
function formatPrice($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

// Formater la date
function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

// Traduire le statut de commande
function translateStatus($status) {
    $statuses = [
        'pending' => '⏳ En attente',
        'processing' => '⚙️ En traitement',
        'shipped' => '📦 Expédiée',
        'delivered' => '✅ Livrée',
        'cancelled' => '❌ Annulée'
    ];
    return $statuses[$status] ?? $status;
}

// Obtenir la couleur du statut
function getStatusColor($status) {
    $colors = [
        'pending' => '#ff9800',
        'processing' => '#2196f3',
        'shipped' => '#9c27b0',
        'delivered' => '#4caf50',
        'cancelled' => '#f44336'
    ];
    return $colors[$status] ?? '#777';
}
?>