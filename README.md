# Planning Mensuel MVC

Ce projet est une application de planning mensuel basée sur le modèle MVC (Model-View-Controller). Il permet de gérer des événements sur un calendrier mensuel avec des fonctionnalités de création, de mise à jour, de suppression et de drag-and-drop des événements.

## Table des Matières

- [Installation](#installation)
- [Configuration](#configuration)
- [Structure du Projet](#structure-du-projet)
- [Fonctionnalités](#fonctionnalités)
- [Utilisation](#utilisation)

## Installation

1. **Cloner le dépôt** :

```bash
git clone https://github.com/votre_utilisateur/planning_mvc.git
cd planning_mvc
```

````

2. **Installer les dépendances** :

Assurez-vous d'avoir PHP et MySQL installés sur votre machine.
Configurez votre serveur web (Apache, Nginx, etc.) pour servir le projet.

3. **Configurer la base de données** :

Créez une base de données MySQL et importez le fichier SQL fourni dans le dossier sql pour créer les tables nécessaires.

## Configuration

1. **Configurer la connexion à la base de données** :
   Ouvrez le fichier config.php et modifiez les paramètres de connexion à la base de données.

```
define('BASE_URL', '/votre_projet/'); // Définissez l'URL de base de votre projet

try {
    $pdo = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}
```

## Structure du Projet

Le projet est organisé en suivant le modèle MVC (Model-View-Controller).

planning_mvc/
│
├── config.php
├── index.php
│
├── controllers/
│ ├── Controller.php
│ └── UpdateController.php
│
├── models/
│ └── Planning.php
│
├── views/
│ └── Accueil.php
│
├── css/
│ └── style.css
│
└── js/
└── script.js

- config.php : Configuration de la base de données.
- controllers/Controller.php : Contrôleur principal pour gérer les requêtes utilisateur.
- controllers/UpdateController.php : Contrôleur pour mettre à jour la date des événements.
- models/Planning.php : Modèle pour les opérations de la base de données.
- views/Accueil.php : Vue pour l'affichage du calendrier.
- css/style.css : Fichier CSS pour le style du calendrier.
- js/script.js : Fichier JavaScript pour le drag-and-drop des événements.

## Fonctionnalités

- Création d'événements : Ajoutez des événements à des dates spécifiques.
- Mise à jour d'événements : Modifiez les événements existants.
- Suppression d'événements : Supprimez les événements existants.
- Drag-and-drop : Déplacez les événements entre les jours du calendrier.
- Navigation mensuelle : Naviguez entre les mois précédents et suivants.

## Utilisation

1. Ajouter un événement : Utilisez le formulaire en bas de chaque jour pour ajouter un nouvel événement.
2. Modifier un événement : Utilisez le formulaire intégré dans chaque événement pour le modifier.
3. Supprimer un événement : Utilisez le bouton "Supprimer" intégré dans chaque événement.
4. Déplacer un événement : Utilisez le drag-and-drop pour déplacer les événements entre les jours du calendrier.
````
