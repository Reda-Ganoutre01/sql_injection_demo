CREATE DATABASE IF NOT EXISTS demo_sqli CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE demo_sqli;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des clients
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des produits
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des commandes
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer des utilisateurs de test
INSERT INTO users (username, password, email, role) VALUES
('admin', 'admin234', 'admin@gmail.com', 'admin'),
('reda', 'reda1234', 'reda@gmail.com', 'admin'),
('user1', 'pass123', 'user1@example.com', 'user'),
('alice', 'alice2024', 'alice@example.com', 'user');

-- Ajouter l'administrateur demandé

-- Insérer des clients
INSERT INTO clients (name, email, phone, address) VALUES
('Reda Ganoutre', 'reda.ganoutre@email.com', '0612345678', '123 Rue de Agadi,'),
('Marie Martin', 'marie.martin@email.com', '0623456789', '45 Avenue des Champs, 69001 Lyon'),
('Pierre Durand', 'pierre.durand@email.com', '0634567890', '78 Boulevard Victor Hugo, 13001 Marseille'),
('Sophie Bernard', 'sophie.bernard@email.com', '0645678901', '12 Rue Nationale, 59000 Lille'),
('Lucas Petit', 'lucas.petit@email.com', '0656789012', '89 Cours Lafayette, 83000 Toulon');

-- Insérer des produits
INSERT INTO products (name, price, stock, description) VALUES
('Laptop Dell XPS 15', 1299.99, 15, 'Ordinateur portable haute performance, écran 15.6" 4K'),
('iPhone 15 Pro Max', 1399.00, 25, 'Smartphone Apple dernière génération, 256GB'),
('Samsung Galaxy S24', 999.00, 30, 'Smartphone Android premium'),
('iPad Pro 12.9"', 1199.00, 20, 'Tablette Apple professionnelle avec M2'),
('MacBook Pro M3', 2499.00, 10, 'Ordinateur portable Apple avec puce M3'),
('AirPods Pro 2', 279.00, 50, 'Écouteurs sans fil avec réduction de bruit active'),
('Sony WH-1000XM5', 349.00, 35, 'Casque audio sans fil premium'),
('Dell Monitor 27"', 399.00, 40, 'Écran 4K professionnel'),
('Logitech MX Master 3', 99.00, 60, 'Souris sans fil ergonomique'),
('Mechanical Keyboard', 149.00, 45, 'Clavier mécanique RGB pour gaming');

-- Insérer des commandes
INSERT INTO orders (client_id, product_id, quantity, total_price, status) VALUES
(1, 1, 1, 1299.99, 'delivered'),
(1, 6, 2, 558.00, 'delivered'),
(1, 2, 1, 1399.00, 'shipped'),
(1, 9, 1, 99.00, 'processing');


update table orders SET total_price= 0 WHERE id=1;