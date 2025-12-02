<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin('secure');
$pageTitle = 'Dashboard Sécurisé';

$user = getCurrentUser($pdo);

// Statistiques (les requêtes ne dépendent pas d'entrées utilisateur)
$totalClients = $pdo->query("SELECT COUNT(*) as count FROM clients")->fetch()['count'] ?? 0;
$totalOrders = $pdo->query("SELECT COUNT(*) as count FROM orders")->fetch()['count'] ?? 0;
$totalRevenue = $pdo->query("SELECT SUM(total_price) as total FROM orders")->fetch()['total'] ?? 0;
$pendingOrders = $pdo->prepare("SELECT COUNT(*) as count FROM orders WHERE status = :status");
$pendingOrders->execute(['status' => 'pending']);
$pendingOrders = $pendingOrders->fetch()['count'] ?? 0;

include __DIR__ . '/../includes/header.php';
?>

<div class="navbar">
    <div class="navbar-brand">🔒 Dashboard Sécurisé</div>
    <div class="navbar-menu">
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="orders.php">Commandes Clients</a>
        <span class="badge"><?php echo clean($user['username']); ?></span>
        <?php if (isAdmin()): ?>
            <span class="badge">ADMIN</span>
        <?php endif; ?>
        <a href="../logout.php" class="btn btn-secondary">Déconnexion</a>
    </div>
</div>

<h1 style="color: white; margin-bottom: 30px;">📊 Tableau de bord (Sécurisé)</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Clients Total</div>
        <div class="stat-value"><?php echo $totalClients; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Commandes Total</div>
        <div class="stat-value"><?php echo $totalOrders; ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Chiffre d'affaires</div>
        <div class="stat-value"><?php echo formatPrice($totalRevenue); ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En attente</div>
        <div class="stat-value"><?php echo $pendingOrders; ?></div>
    </div>
</div>

<div class="card">
    <h2 style="color: #333; margin-bottom: 20px;">👤 Informations utilisateur</h2>
    <table>
        <tr>
            <th>Nom d'utilisateur</th>
            <td><?php echo clean($user['username']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo clean($user['email']); ?></td>
        </tr>
        <tr>
            <th>Rôle</th>
            <td><?php echo clean($user['role']); ?></td>
        </tr>
        <tr>
            <th>Membre depuis</th>
            <td><?php echo formatDate($user['created_at']); ?></td>
        </tr>
    </table>
</div>

<div class="card">
    <h2 style="color: #333; margin-bottom: 20px;">📦 Dernières commandes</h2>
    <?php
    $recentOrders = $pdo->query("SELECT o.*, c.name as client_name, p.name as product_name
                                 FROM orders o
                                 JOIN clients c ON o.client_id = c.id
                                 JOIN products p ON o.product_id = p.id
                                 ORDER BY o.order_date DESC
                                 LIMIT 10")->fetchAll();
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo clean($order['client_name']); ?></td>
                    <td><?php echo clean($order['product_name']); ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo formatPrice($order['total_price']); ?></td>
                    <td style="color: <?php echo getStatusColor($order['status']); ?>; font-weight: bold;">
                        <?php echo translateStatus($order['status']); ?>
                    </td>
                    <td><?php echo formatDate($order['order_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
