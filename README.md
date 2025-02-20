# Gestion de Planning Hebdomadaire

Ce projet est une application web de gestion de planning hebdomadaire en PHP avec une base de données MySQL. Il permet d'ajouter, modifier, supprimer des tâches et de naviguer de semaine en semaine.

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache, Nginx, etc.)

## Installation

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/votre-utilisateur/planning-hebdomadaire.git
   cd planning-hebdomadaire

   ```

2. **Configurer la base de données**

Créez une base de données MySQL et importez le fichier database.sql pour créer la table des tâches.

```
CREATE DATABASE planning_db;
USE planning_db;
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    event VARCHAR(255) NOT NULL
);
```

3. **Configurer la connexion à la base de données**

Mettez à jour le fichier config.php avec vos informations de connexion à la base de données.

```
<?php
\$host = 'localhost';
\$db = 'planning_db';
\$user = 'root';
\$pass = '';
\$charset = 'utf8mb4';

\$dsn = "mysql\:host=\$host;dbname=\$db;charset=\$charset";
\$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    \$pdo = new PDO(\$dsn, \$user, \$pass, \$options);
} catch (\PDOException \$e) {
    throw new \PDOException(\$e->getMessage(), (int)\$e->getCode());
}
?>
```

4. **Démarrer le serveur web**

Placez le projet dans le répertoire de votre serveur web (par exemple, htdocs pour Apache) et démarrez le serveur.

## Structure du projet

```
/planning_app
    /css
        style.css
    /js
        script.js
    /classes
        Planning.php
    config.php
    index.php
```

/css : Contient les fichiers CSS pour le style de l'application.
/js : Contient les fichiers JavaScript (actuellement vide, mais peut être utilisé pour ajouter des fonctionnalités JavaScript).
/classes : Contient la classe Planning pour gérer les tâches.
config.php : Contient la configuration de la connexion à la base de données.
index.php : Point d'entrée de l'application, affiche le calendrier hebdomadaire et les formulaires pour le CRUD.

## Fonctionnalités

1. Affichage du calendrier hebdomadaire : Affiche les tâches pour chaque jour de la semaine.
2. Navigation entre les semaines : Permet de naviguer vers la semaine précédente et la semaine suivante.
3. CRUD pour les tâches : Permet d'ajouter, modifier et supprimer des tâches.

## Utilisation

1. Accéder à l'application : Ouvrez votre navigateur et accédez à l'URL de votre serveur web (par exemple, http://localhost/planning_app).
2. Naviguer entre les semaines : Utilisez les liens "Semaine précédente" et "Semaine suivante" pour naviguer entre les semaines.
3. Gérer les tâches : Utilisez les formulaires pour ajouter, modifier ou supprimer des tâches.
