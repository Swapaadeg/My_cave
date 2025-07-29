# My_cave

Application Symfony pour la gestion de cave à vin personnelle.

## Installation
1. Cloner le dépôt :
   ```bash
   git clone git@github.com:utilisateur/repo.git
   ```
2. Installer les dépendances :
   ```bash
   composer install
   ```
3. Copier le fichier d'environnement :
   ```bash
   cp .env .env.local
   ```
4. Configurer la base de données dans `.env.local`
5. Lancer les migrations :
   ```bash
   php bin/console doctrine:migration:sync-metadata-storage
   php bin/console doctrine:migrations:migrate
   ```
6. Compiler les assets (si nécessaire) :
   ```bash
   npm install
   npm run build
   ```

## Configuration
- Symfony 6.x
- Base de données MySQL
- Envoi d’emails via SMTP
- Variables d’environnement dans `.env.local`

## Utilisation
Lancer le serveur Symfony :
```bash
symfony serve
```
Accéder à l’application sur [http://localhost:8000](http://localhost:8000)

## Tests
Lancer les tests avec PHPUnit :
```bash
php bin/phpunit
```

## Compte User
gertrude@gertrude.com
123456

## Compte Admin
swap@gmail.com
123456
## Liens utiles
- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [EasyAdmin](https://github.com/EasyCorp/EasyAdminBundle)

## Auteur
Marie RIVIER
