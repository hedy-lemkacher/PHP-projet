# 🚀 Démarrage rapide - Spektacles

Guide ultra-rapide pour démarrer le projet en **2 minutes** !

## ⚡ Installation express

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

---

## 📋 Prérequis

- PHP 8.2+ (extensions: ctype, iconv, pdo, pdo_sqlite)
- Composer
- Node.js 18+ et npm
- Symfony CLI (optionnel, pour `symfony server:start`)

---

## 🔧 Configuration de l'environnement

### Créer le fichier `.env.local`

Le fichier `.env` n'est **pas** versionné dans Git pour des raisons de sécurité. Vous devez créer votre propre fichier `.env.local` :

```bash
cp .env .env.local
```

Puis éditez `.env.local` et configurez la base de données :

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"
```

**Note :** La base de données SQLite (`database/data.db`) est déjà incluse dans le projet avec des données de test.

---

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

---

## 🐛 Problèmes courants

### Erreur "DATABASE_URL not found"

➡️ Créez le fichier `.env.local` avec la configuration de la base de données (voir ci-dessus).

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

---

## 📚 Documentation complète

Pour plus de détails, consultez :
- **[APRES_CLONAGE.md](APRES_CLONAGE.md)** - Guide d'installation détaillé
- **[README.md](README.md)** - Documentation complète du projet
- **[docs/SCHEMA_ARCHITECTURE.md](docs/SCHEMA_ARCHITECTURE.md)** - Architecture et schéma de la base de données

---

## ✨ Fonctionnalités

### 👤 Utilisateurs
- Inscription et authentification
- Catalogue de spectacles
- Réservation en ligne avec calcul automatique
- Confirmation de réservation

### 🔐 Administrateurs
- Tableau de bord EasyAdmin
- Gestion CRUD (utilisateurs, spectacles, réservations)
- Statistiques détaillées
- Alertes pour spectacles à faible stock

---

**Dernière mise à jour** : Décembre 2024

