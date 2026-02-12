# 🚀 Guide d'installation après clonage

Guide rapide pour configurer le projet après avoir cloné le dépôt.

## 📋 Prérequis

-   PHP 8.2+ (extensions: ctype, iconv, pdo, pdo_sqlite)
-   Composer
-   Node.js 18+ et npm
-   Git

## 🔧 Installation rapide (2 minutes !)

### 1. Cloner le dépôt

```bash
git clone https://github.com/chrisplc/projet-php-2025.git
cd projet-php-2025
```

### 2. Installer les dépendances

```bash
# Dépendances PHP
composer install

# Dépendances JavaScript
npm install
```

### 3. Configurer l'environnement

```bash
cp .env .env.local
```

Éditez `.env.local` et configurez la base de données SQLite (déjà incluse dans le projet) :

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"
```

**🎉 C'est tout !** La base de données est déjà dans le projet avec toutes les données.

### 4. Compiler les assets

```bash
npm run build
```

### 5. Lancer le serveur

```bash
symfony server:start
# OU: php -S localhost:8000 -t public
```

✅ **Application accessible à : http://localhost:8000**

**Compte admin :** `admin@test.com` / `admin`

---

## 📝 Résumé rapide (copier-coller)

```bash
# 1. Cloner
git clone https://github.com/chrisplc/projet-php-2025.git
cd projet-php-2025

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env .env.local
# Éditez .env.local et mettez : DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"

# 4. Compiler les assets
npm run build

# 5. Lancer le serveur
symfony server:start
```

**Temps total estimé** : ~2-3 minutes

---

## 🐛 Problèmes courants

### Erreur de permissions

```bash
chmod -R 755 database/
```

### Erreur avec les assets

```bash
rm -rf public/build
npm run build
```

### La base de données est corrompue

```bash
# Recréer la base de données SQLite
php scripts/create-sqlite-database.php
```

---

## 🔄 Mise à jour du projet

Quand vous récupérez les dernières modifications :

```bash
# 1. Récupérer le code (et la base de données)
git pull origin main

# 2. Installer les nouvelles dépendances (si nécessaire)
composer install
npm install

# 3. Recompiler les assets
npm run build
```

**Note :** La base de données est versionnée dans Git, donc vous récupérez automatiquement les dernières données.

---

## 📞 Besoin d'aide ?

1. Vérifiez que vous avez bien suivi toutes les étapes
2. Consultez les logs dans `var/log/`
3. Contactez l'équipe

---

**Dernière mise à jour** : Décembre 2024
