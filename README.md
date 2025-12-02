# SQL Injection Demo

> Petite application de démonstration pour comparer une version vulnérable et une version sécurisée (PHP + MySQL). Le but est pédagogique : montrer comment fonctionnent les injections SQL et comment s'en protéger.

---

## Arborescence principale

- `config/`
  - `database.php` — configuration PDO et `session_start()` (connexion locale XAMPP)
- `includes/`
  - `functions.php` — fonctions utilitaires (sécurité affichage, formatage, etc.)
  - `header.php` — en-tête HTML commun
- `vulnerable/` — pages volontairement vulnérables (ex : `login.php`, `orders.php`)
- `secure/` — pages corrigées (requêtes préparées, validation)
- `index.php` — page d'accueil du démonstrateur
- `logout.php` — déconnexion
- `setup.sql` — script SQL pour créer la base et insérer des données de démonstration

---

## Pré-requis

- XAMPP (Apache + MySQL) installé et en cours d'exécution
- Navigateur web (Chrome, Firefox, etc.)

---

## Installation rapide (local)

1. Placez le dossier du projet dans le répertoire web de XAMPP, par exemple :

   `C:\xampp\htdocs\new\sql_injection_demo`

2. Démarrez Apache et MySQL depuis le panneau XAMPP.

3. Importez la base de données à partir du fichier `setup.sql` :

```bash
# Depuis bash.exe (ou ajustez le chemin vers mysql)
/c/xampp/mysql/bin/mysql -u root < /c/xampp/htdocs/new/sql_injection_demo/setup.sql
```

Ou utilisez phpMyAdmin et importez `setup.sql` manuellement.

4. Vérifiez la configuration de la connexion dans `config/database.php`. Par défaut la configuration est :

```php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'demo_sqli';
$DB_USER = 'root';
$DB_PASS = '';
```

Modifiez si nécessaire selon votre environnement.

---

## Utilisation

- Ouvrez la page d'accueil :
  - `http://localhost/new/sql_injection_demo/index.php`
- Accédez à la version vulnérable :
  - `http://localhost/new/sql_injection_demo/vulnerable/login.php`
  - `http://localhost/new/sql_injection_demo/vulnerable/orders.php`
- Accédez à la version sécurisée :
  - `http://localhost/new/sql_injection_demo/secure/login.php`
  - `http://localhost/new/sql_injection_demo/secure/orders.php`

---

## Comptes de test

Les comptes insérés dans `setup.sql` (pour la démonstration) :

- `admin` / `admin123` (role: admin)
- `manager` / `manager123` (role: user)
- `user1` / `pass123` (role: user)
- `alice` / `alice2024` (role: user)
- `reda` / `reda1234` (role: admin)  ← utilisateur ajouté pour la démo

Note : pour la simplicité pédagogique les mots de passe sont en clair dans `setup.sql`. La version `secure/login.php` accepte aussi des mots de passe hachés via `password_verify()`.

---

## Que montre ce projet ?

- `vulnerable/` contient du code démontrant les mauvaises pratiques : concaténation directe des entrées utilisateur dans les requêtes SQL, affichage de la requête exécutée, absence de hachage des mots de passe.
- `secure/` contient des implémentations corrigées : utilisation de PDO + prepared statements, validation minimale des entrées, gestion de session plus sûre (regenerate id).

---

## Bonnes pratiques recommandées

- Ne jamais concaténer des entrées utilisateur dans une requête SQL.
- Utiliser `PDO` et des requêtes préparées (prepared statements).
- Stocker les mots de passe hachés (`password_hash()` / `password_verify()`).
- Regénérer l'ID de session au moment de la connexion (`session_regenerate_id(true)`).
- Mettre en place des protections CSRF pour les formulaires sensibles.

---

## Convertir les mots de passe en hachés (optionnel)

Si vous souhaitez rendre la base plus réaliste, vous pouvez remplacer les mots de passe en clair par des bcrypt hashes. Exemple en PHP :

```php
echo password_hash('reda1234', PASSWORD_BCRYPT);
```

Ensuite, mettez à jour `setup.sql` ou exécutez un `UPDATE` dans la base pour remplacer les valeurs de la colonne `password`.

---

## Sécurité et avertissement

Ce projet est destiné à un usage local et pédagogique uniquement. Ne pas déployer ce code tel quel en production.

---

## Questions / Suite

Si vous voulez que je :
- transforme tous les mots de passe du `setup.sql` en hachés, ou
- ajoute une démonstration vidéo pas-à-pas (script prêt à lire), ou
- ajoute des protections CSRF et un README plus technique,

dites lequel et je m'en occupe.

---

Auteur : projet de démonstration (fichiers modifiés pour la démo locale)
