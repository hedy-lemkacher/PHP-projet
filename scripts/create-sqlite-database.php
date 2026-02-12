<?php
/**
 * Script pour créer une base de données SQLite pré-remplie avec toutes les données
 * 
 * Ce script crée database/data.db avec toutes les tables et données du dump SQL
 */

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Charger les variables d'environnement
$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

$databaseDir = dirname(__DIR__) . '/database';
$databaseFile = $databaseDir . '/data.db';

// Créer le dossier database/ s'il n'existe pas
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0755, true);
}

// Supprimer l'ancienne base de données si elle existe
if (file_exists($databaseFile)) {
    unlink($databaseFile);
}

echo "🔨 Création de la base de données SQLite...\n";

// Créer la base de données SQLite
$pdo = new PDO('sqlite:' . $databaseFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Activer les clés étrangères
$pdo->exec('PRAGMA foreign_keys = ON;');

echo "📊 Création des tables...\n";

// Créer la table doctrine_migration_versions
$pdo->exec("
    CREATE TABLE IF NOT EXISTS doctrine_migration_versions (
        version VARCHAR(191) NOT NULL PRIMARY KEY,
        executed_at DATETIME DEFAULT NULL,
        execution_time INTEGER DEFAULT NULL
    )
");

// Créer la table utilisateur
$pdo->exec("
    CREATE TABLE IF NOT EXISTS utilisateur (
        email VARCHAR(255) NOT NULL PRIMARY KEY,
        password VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,
        nom VARCHAR(255) NOT NULL,
        adresse VARCHAR(500) DEFAULT NULL,
        roles TEXT NOT NULL
    )
");

// Créer la table spectacle
$pdo->exec("
    CREATE TABLE IF NOT EXISTS spectacle (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        titre VARCHAR(255) NOT NULL,
        prix DECIMAL(10,2) NOT NULL,
        lieu VARCHAR(255) NOT NULL,
        image VARCHAR(500) DEFAULT NULL,
        places_disponibles INTEGER NOT NULL
    )
");

// Créer la table reservation
$pdo->exec("
    CREATE TABLE IF NOT EXISTS reservation (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        utilisateur_email VARCHAR(255) NOT NULL,
        spectacle_id INTEGER NOT NULL,
        nombre_places INTEGER NOT NULL,
        prix_unitaire DECIMAL(10,2) NOT NULL,
        prix_total DECIMAL(10,2) NOT NULL,
        date_reservation DATETIME NOT NULL,
        FOREIGN KEY (utilisateur_email) REFERENCES utilisateur(email),
        FOREIGN KEY (spectacle_id) REFERENCES spectacle(id)
    )
");

echo "📥 Insertion des données...\n";

// Insérer les migrations
$migrations = [
    ['DoctrineMigrations\\Version20251204194110', '2025-12-04 20:35:21', 3],
    ['DoctrineMigrations\\Version20251204194307', '2025-12-04 20:35:21', 24],
    ['DoctrineMigrations\\Version20251204194809', '2025-12-04 20:35:21', 2],
    ['DoctrineMigrations\\Version20251204201225', '2025-12-04 20:35:21', 30],
    ['DoctrineMigrations\\Version20251204201949', '2025-12-04 20:35:21', 9],
    ['DoctrineMigrations\\Version20251204203724', '2025-12-04 20:38:12', 7],
];

$stmt = $pdo->prepare("INSERT INTO doctrine_migration_versions (version, executed_at, execution_time) VALUES (?, ?, ?)");
foreach ($migrations as $migration) {
    $stmt->execute($migration);
}

// Insérer les utilisateurs
$users = [
    ['adele.joubert@sfr.fr', '$2y$13$d56Uhew4W/wr.LusfcPog.Gy6HNXnnDebtLwLCXr3O41c6pr13lpG', 'Olivier', 'Gaudin', "1, rue Éric Etienne\n82983 Laporte-sur-Mer", 'null'],
    ['admin@test.com', '$2y$13$qbSIAfcaEfVn0Z7uS/LvI.wPxbF4ZsXSescDnkBQ8IJLbhMuY2N2O', 'Administrateur', 'Admin', null, '["ROLE_ADMIN", "ROLE_USER"]'],
    ['anais.etienne@denis.com', '$2y$13$VpJDFnLM4UYDANqxUhwfGOmEe.dELd5w0is1OSLTUhtumO6UPFEU2', 'Anouk', 'Leroux', "89, avenue de Lelievre\n52399 Meunier", 'null'],
    ['antoine16@payet.com', '$2y$13$k8Pt9BdHpg8Bo74LF4ZcLeejsX9AIgaii1cfsf15XuHldsnOWdrzW', 'David', 'Faivre', "2, boulevard de Girard\n13219 Sanchez", 'null'],
    ['corinne22@masson.com', '$2y$13$cYBt3.XHnW2gNQzn5fpFIe25us55EnaLpu9Skq8ruz3A4Gw2csysW', 'Denise', 'Morel', 'rue Roy\n52380 Marechal', 'null'],
    ['delannoy.roger@yahoo.fr', '$2y$13$xWslNAUUlW2s84PFFRsPZ.IxTziMqaEs4dWVZ5gi72Tj8P6I4J9lG', 'Isaac', 'Turpin', "708, rue Inès Collin\n23247 Courtois", 'null'],
    ['josephine62@hotmail.fr', '$2y$13$mL52LC51FQVDUgXeVLtjL.BqhhTz2uCJY/b9E9zPcaa3LQ8M5rRAG', 'Constance', 'Riou', "40, chemin de Chevallier\n57349 Grenier-les-Bains", 'null'],
    ['lucas.chevallier@pinto.com', '$2y$13$1xUVJXM33l417CuBc.vc0ep4KPXcKzwBYP4xWqOvJiVAVdpW5nghW', 'Denis', 'Le Goff', "46, impasse de Leleu\n53635 ThibaultVille", 'null'],
    ['maggie.dupuy@etienne.net', '$2y$13$q4svHjvhA46j/17ClBWQTujcicn7xpWP3OLt/LIzzuS05NC2WKS4O', 'Isabelle', 'Dumas', 'rue Didier\n50603 Gonzalez-sur-Mer', 'null'],
    ['nbesnard@durand.fr', '$2y$13$q72Jp7DRuDEs9wdlpICyEegcOS/leIXPpLFvAliS9grEj0QjpupJC', 'Margaret', 'Martins', "4, boulevard Loiseau\n83213 Bouchet", 'null'],
    ['tgermain@sfr.fr', '$2y$13$Yo18t4H8UwUol1hevJfs4.7U9mWvYOhRexBOC.hdxDotw7daDFalG', 'Odette', 'Rousset', "993, chemin de Lacombe\n79705 DufourVille", 'null'],
];

$stmt = $pdo->prepare("INSERT INTO utilisateur (email, password, prenom, nom, adresse, roles) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($users as $user) {
    $stmt->execute($user);
}

// Insérer les spectacles
$spectacles = [
    ['Le Roi Lion', 35.00, 'Théâtre Mogador', 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=800&h=600&fit=crop', 4913],
    ['Mamma Mia!', 42.00, 'Théâtre de Paris', 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=800&h=600&fit=crop', 15],
    ['Les Misérables', 28.00, 'Opéra Bastille', 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=800&h=600&fit=crop', 8],
    ['Starmania', 38.00, 'Palais des Congrès', 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=800&h=600&fit=crop', 4],
    ['Notre-Dame de Paris', 32.00, 'Palais des Sports', 'https://images.unsplash.com/photo-1478147427282-58a87a120781?w=800&h=600&fit=crop', 18],
    ['Cats', 29.00, 'Théâtre du Châtelet', 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop', 5],
];

$stmt = $pdo->prepare("INSERT INTO spectacle (titre, prix, lieu, image, places_disponibles) VALUES (?, ?, ?, ?, ?)");
foreach ($spectacles as $spectacle) {
    $stmt->execute($spectacle);
}

// Insérer les réservations
$reservations = [
    ['admin@test.com', 6, 1, 29.00, 29.00, '2025-12-04 20:47:30'],
    ['admin@test.com', 1, 12, 35.00, 420.00, '2025-12-04 21:02:17'],
    ['admin@test.com', 4, 12, 38.00, 456.00, '2025-12-04 21:02:28'],
    ['admin@test.com', 4, 4, 38.00, 152.00, '2025-12-05 12:08:05'],
    ['admin@test.com', 1, 65, 35.00, 2275.00, '2025-12-08 16:25:10'],
    ['admin@test.com', 1, 22, 35.00, 770.00, '2025-12-08 16:38:14'],
];

$stmt = $pdo->prepare("INSERT INTO reservation (utilisateur_email, spectacle_id, nombre_places, prix_unitaire, prix_total, date_reservation) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($reservations as $reservation) {
    $stmt->execute($reservation);
}

echo "✅ Base de données SQLite créée avec succès : database/data.db\n";
echo "📝 Compte admin : admin@test.com / admin\n";

