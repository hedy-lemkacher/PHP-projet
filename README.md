# 🎭 Spektacles - Plateforme de Réservation de Spectacles

Application web moderne développée avec **Symfony 7.3** pour la gestion et la réservation de spectacles en ligne.

## 🚀 Démarrage rapide (2 minutes !)

### ⚡ Installation express

```bash
# 1. Cloner le dépôt
git clone https://github.com/chrisplc/projet-php-2025.git
cd projet-php-2025

# 2. Installer les dépendances
composer install
npm install

# 3. Créer le fichier .env.local
echo 'DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"' > .env.local

# 4. Compiler les assets
npm run build

# 5. Lancer le serveur
symfony server:start
# OU: php -S localhost:8000 -t public
```

**🎉 C'est tout !** L'application est accessible sur **http://localhost:8000**

**Compte administrateur :** `admin@test.com` / `admin`

### 🔧 Configuration de l'environnement

Le fichier `.env` n'est **pas** versionné dans Git pour des raisons de sécurité. Vous devez créer votre propre fichier `.env.local` :

```bash
echo 'DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"' > .env.local
```

Ou si un fichier `.env` existe dans le projet :

```bash
cp .env .env.local
```

Puis éditez `.env.local` et configurez la base de données :

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"
```

**Explication de l'URL :**
- `%kernel.project_dir%` est un placeholder Symfony qui sera automatiquement remplacé par le chemin absolu de votre projet
- Par exemple, si votre projet est dans `/Users/votre-nom/projet-php-2025`, l'URL résolue sera :
  ```
  sqlite:///Users/votre-nom/projet-php-2025/database/data.db
  ```
- Le fichier de base de données se trouve dans le dossier `database/` à la racine du projet : `database/data.db`

**Note :** La base de données SQLite (`database/data.db`) est déjà incluse dans le projet avec des données de test.

## ✨ Fonctionnalités

### Utilisateurs
- Inscription et authentification
- Catalogue de spectacles
- Réservation en ligne avec calcul automatique
- Confirmation de réservation

### Administrateurs
- Dashboard EasyAdmin complet
- Gestion CRUD (utilisateurs, spectacles, réservations)
- Statistiques détaillées
- Vue d'ensemble avec alertes

## 🛠 Technologies

- **Backend** : PHP 8.2+, Symfony 7.3, Doctrine ORM, EasyAdmin
- **Frontend** : Twig, Tailwind CSS, Webpack Encore
- **Base de données** : SQLite (incluse dans le projet)

## 📦 Prérequis

- PHP 8.2+ (extensions: ctype, iconv, pdo, pdo_sqlite)
- Composer
- Node.js 18+ et npm
- Symfony CLI (optionnel)

## 📁 Structure du projet

```
projet-php-2025/
├── assets/              # Assets frontend
├── config/              # Configuration Symfony
├── database/            # Base de données SQLite (versionnée)
│   └── data.db         # Base de données avec toutes les données
├── migrations/          # Migrations Doctrine
├── public/              # Point d'entrée web
├── scripts/             # Scripts utilitaires
│   └── create-sqlite-database.php  # Création de la BDD SQLite
├── src/                 # Code source
│   ├── Command/         # Commandes console
│   ├── Controller/      # Contrôleurs
│   ├── Entity/          # Entités Doctrine
│   └── Repository/      # Repositories
└── templates/           # Templates Twig
```

## 🎯 Commandes utiles

### Créer un administrateur

```bash
php bin/console app:create-admin
```

### Générer des données de test

```bash
php bin/console app:generate-fixtures
# Avec options :
php bin/console app:generate-fixtures --users=20 --spectacles=10
```

### Vider le cache

```bash
php bin/console cache:clear
```

### Exécuter les migrations

```bash
php bin/console doctrine:migrations:migrate
```

### Recréer la base de données SQLite

```bash
php scripts/create-sqlite-database.php
```

## 📊 Modèle de données

- **Utilisateur** : email (PK), password, nom, prénom, roles
- **Spectacle** : id (PK), titre, prix, lieu, image, placesDisponibles
- **Reservation** : id (PK), utilisateur, spectacle, nombrePlaces, prixTotal, dateReservation

👉 **Schéma détaillé** : [docs/SCHEMA_ARCHITECTURE.md](docs/SCHEMA_ARCHITECTURE.md)

## 🔐 Sécurité

- Routes `/reservation/*` : Requiert `ROLE_USER`
- Routes `/admin/*` : Requiert `ROLE_ADMIN`
- Mots de passe hashés avec bcrypt/argon2i

## 📝 Compte admin par défaut

- **Email** : `admin@test.com`
- **Mot de passe** : `admin`

⚠️ **Important** : Changez ce mot de passe en production !

## 🔄 Synchronisation avec l'équipe

La base de données SQLite est versionnée dans Git, donc :

1. **Récupérer les dernières modifications** :
   ```bash
   git pull origin main
   ```
   Vous récupérez automatiquement la base de données à jour !

2. **Recompiler les assets** :
   ```bash
   npm run build
   ```

## 🐛 Dépannage

### Erreur "DATABASE_URL not found"

➡️ Créez le fichier `.env.local` avec la configuration de la base de données (voir section "Configuration de l'environnement" ci-dessus).

### Erreur de permissions sur la base de données

```bash
chmod -R 755 database/
```

### Les assets ne se chargent pas

```bash
rm -rf public/build
npm run build
```

### Port déjà utilisé

```bash
# Utiliser un autre port
symfony server:start -d --port=8001
# OU
php -S localhost:8001 -t public
```

### Base de données corrompue

```bash
php scripts/create-sqlite-database.php
```

## 📚 Documentation

Pour plus de détails, consultez :
- **[APRES_CLONAGE.md](APRES_CLONAGE.md)** - Guide d'installation détaillé
- **[DEPLOIEMENT_ALWAYSDATA.md](DEPLOIEMENT_ALWAYSDATA.md)** - Mise en ligne sans carte bancaire (Alwaysdata + SQLite)
- **[DEPLOIEMENT_RENDER.md](DEPLOIEMENT_RENDER.md)** - Déploiement via Render
- **[docs/SCHEMA_ARCHITECTURE.md](docs/SCHEMA_ARCHITECTURE.md)** - Architecture et schéma de la base de données

## 👥 Contributeurs

- Christian, Ayoub, Malo, Hedy

---

**Dernière mise à jour** : Décembre 2024
