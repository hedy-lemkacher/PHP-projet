# 🌐 Déploiement gratuit sur Alwaysdata (sans carte)

Ce guide déploie le projet Symfony avec SQLite, sans service PostgreSQL payant.

## 1) Créer le compte et le site

1. Créez votre compte sur `https://www.alwaysdata.com/`.
2. Dans l’interface Alwaysdata, créez un site :
   - **Type** : PHP
   - **Version PHP** : 8.2 ou plus
   - **Document root** : dossier `public/` du projet

## 2) Envoyer les fichiers

Uploadez le projet (Git / SFTP / File Manager) dans votre dossier d’hébergement.

Le dossier final doit contenir au moins :
- `public/`
- `src/`
- `vendor/`
- `config/`
- `templates/`
- `database/data.db`

## 3) Installer les dépendances (si besoin)

Si vous avez un terminal SSH sur l’hébergement :

```bash
composer install --no-dev --optimize-autoloader
```

Si vous n’avez pas SSH, faites la commande en local puis uploadez le dossier `vendor/`.

## 4) Configurer l’environnement de production

Créez un fichier `.env.local` à la racine du projet en vous basant sur `.env.alwaysdata.example` :

```env
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=mettez_une_longue_cle_secrete
DATABASE_URL="sqlite:///%kernel.project_dir%/database/data.db"
```

Pour générer une clé secrète locale :

```bash
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

## 5) Vérifier les droits d’écriture

Symfony doit pouvoir écrire dans :
- `var/cache`
- `var/log`
- `database/data.db`

## 6) Config Apache

Le fichier `public/.htaccess` est inclus dans le projet pour rediriger toutes les routes vers `index.php`.

## 7) Test final

1. Ouvrez votre URL Alwaysdata.
2. Vérifiez la page d’accueil.
3. Testez `/admin`.

Si erreur 500 :
- Vérifiez `.env.local`
- Vérifiez les permissions sur `var/` et `database/`
- Vérifiez la version PHP et extension SQLite (`pdo_sqlite`)

---

## Mise à jour

À chaque changement :
1. `git pull` (ou nouvel upload)
2. `composer install --no-dev --optimize-autoloader` (si dépendances changent)
3. Vider cache si besoin :

```bash
php bin/console cache:clear --env=prod
```
