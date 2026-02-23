# 🌐 Mise en ligne sur Render (Symfony + Docker)

Ce projet est prêt pour un déploiement sur Render avec le fichier `render.yaml`.

## 1) Préparer le dépôt

1. Poussez le code sur votre dépôt GitHub (branche `main`).
2. Vérifiez que ces fichiers sont bien présents :
   - `Dockerfile`
   - `render.yaml`

## 2) Créer le service sur Render

1. Ouvrez Render → **New +** → **Blueprint**.
2. Connectez votre compte GitHub.
3. Sélectionnez votre dépôt.
4. Render détecte automatiquement `render.yaml` et crée :
   - 1 service web Docker (`php-projet`)
   - 1 base PostgreSQL (`mon-projet-db`)

## 3) Variables d’environnement (déjà prévues)

Le blueprint configure automatiquement :

- `APP_ENV=prod`
- `APP_DEBUG=0`
- `APP_SECRET` généré automatiquement
- `DATABASE_URL` injecté depuis la base PostgreSQL Render

## 4) Déploiement

Après validation, Render lance le build et le démarrage.

Au démarrage du conteneur :

1. Les migrations Doctrine sont exécutées automatiquement.
2. Le serveur PHP est lancé sur le port Render.

## 5) Vérifications après mise en ligne

1. Ouvrez l’URL Render (ex: `https://votre-app.onrender.com`).
2. Vérifiez la page d’accueil.
3. Connectez-vous en admin (si l’utilisateur existe dans la base prod) ou créez un admin.

Pour créer un admin en prod, ouvrez un shell Render et exécutez :

```bash
php bin/console app:create-admin
```

## 6) Dépannage rapide

### Erreur 500 en production

- Vérifiez les logs Render (service web).
- Vérifiez que la variable `DATABASE_URL` est bien présente.
- Exécutez manuellement les migrations :

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

### Assets manquants

Le build Docker exécute `composer install` et embarque le projet.
Si vous modifiez fortement le frontend, vérifiez aussi la chaîne build JS locale avant push.

---

## Option domaine personnalisé

Dans Render : **Settings** → **Custom Domains** → ajoutez votre domaine puis configurez vos DNS.
