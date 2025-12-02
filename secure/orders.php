<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin('secure');
$pageTitle = 'Commandes Clients - Sécurisé';

$user = getCurrentUser($pdo);
$search = '';
$orders = [];

// Recherche sécurisée avec prepared statements
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = trim($_GET['search']);

    // Si c'est un entier, rechercher par id exact, sinon LIKE
    if (ctype_digit($search)) {
        $stmt = $pdo->prepare("SELECT o.*, c.name as client_name, c.email as client_email, c.phone as client_phone,
                              p.name as product_name, p.price as product_price
                              FROM orders o
                              JOIN clients c ON o.client_id = c.id
                              JOIN products p ON o.product_id = p.id
                              WHERE o.id = :id
                              ORDER BY o.order_date DESC");
        $stmt->execute(['id' => $search]);
        $orders = $stmt->fetchAll();
    } else {
        $like = '%' . $search . '%';
        $stmt = $pdo->prepare("SELECT o.*, c.name as client_name, c.email as client_email, c.phone as client_phone,
                              p.name as product_name, p.price as product_price
                              FROM orders o
                              JOIN clients c ON o.client_id = c.id
                              JOIN products p ON o.product_id = p.id
                              WHERE c.name LIKE :q OR p.name LIKE :q
                              ORDER BY o.order_date DESC");
        $stmt->execute(['q' => $like]);
        $orders = $stmt->fetchAll();
    }
} else {
    $stmt = $pdo->query("SELECT o.*, c.name as client_name, p.name as product_name, p.price as product_price
                         FROM orders o
                         JOIN clients c ON o.client_id = c.id
                         JOIN products p ON o.product_id = p.id
                         ORDER BY o.order_date DESC
                         LIMIT 100");
    $orders = $stmt->fetchAll();
}

include __DIR__ . '/../includes/header.php';
?>

<div class="navbar">
    <div class="navbar-brand">🔒 Commandes - Sécurisé</div>
    <div class="navbar-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="orders.php" class="active">Commandes</a>
        <span class="badge"><?php echo clean($user['username']); ?></span>
        <?php if (isAdmin()): ?>
            <span class="badge">ADMIN</span>
        <?php endif; ?>
        <a href="../logout.php" class="btn btn-secondary">Déconnexion</a>
    </div>
</div>

<div class="card">
    <h1 style="color:#333; margin-bottom:20px;">🔎 Recherche de commandes (Sécurisé)</h1>
    <form method="GET" action="">
        <div class="form-group">
            <label>Rechercher (client, produit ou ID)</label>
            <input type="text" name="search" class="form-control" placeholder="Ex: Jean, iPhone, 12" value="<?php echo clean($search); ?>">
        </div>
        <button type="submit" class="btn btn-success">Rechercher</button>
    </form>

    <h2 style="color:#333; margin-top:20px;">Résultats</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Produit</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr><td colspan="10">Aucune commande trouvée.</td></tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo clean($order['client_name']); ?></td>
                    <td><?php echo clean($order['client_email'] ?? ''); ?></td>
                    <td><?php echo clean($order['client_phone'] ?? ''); ?></td>
                    <td><?php echo clean($order['product_name']); ?></td>
                    <td><?php echo formatPrice($order['product_price']); ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo formatPrice($order['total_price']); ?></td>
                    <td style="color: <?php echo getStatusColor($order['status']); ?>; font-weight: bold;">
                        <?php echo translateStatus($order['status']); ?>
                    </td>
                    <td><?php echo formatDate($order['order_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
