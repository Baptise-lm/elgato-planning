# Planning PHP MVC

## Pourquoi avoir utilisé Tailwind CSS

L'utilisation de Tailwind CSS dans notre projet de calendrier dynamique en PHP avec le modèle MVC permet de développer rapidement des interfaces utilisateurs. De plus, Tailwind CSS s'intègre parfaitement avec les fichiers de vue, permettant une séparation claire des fichiers en modèle MVC.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [MAMP](https://www.mamp.info/) ou un autre serveur local (comme XAMPP ou WAMP).
- PHP 7.4 ou supérieur.
- MySQL.
- Un navigateur web.

## Installation

1. **Cloner le projet :**

   Clonez ce dépôt dans le dossier `htdocs` de MAMP (ou le dossier équivalent pour votre serveur local).

   ```bash
   git clone https://github.com/Baptise-lm/elgato-planning.git

   Configurer la base de données :
   ```

2. **Configurer la base de données :**

Ouvrez MAMP et démarrez les serveurs Apache et MySQL.

Créez une base de données nommée projetDoriane.

Importez le fichier SQL suivant pour créer les tables nécessaires : `./bdd/bdd.sql`

3. **Configurer le projet :**

Ouvrez le fichier config.php et vérifiez les informations de connexion à la base de données. Par défaut, les paramètres sont :
```php
<?php
$pdo = new PDO('mysql:host=localhost;dbname=nom-de-la-base', 'root', 'root');
```
Si vos identifiants MySQL diffèrent, modifiez-les en conséquence.

4. **Installer les dépendances JavaScript :**

Si vous souhaitez utiliser les dépendances définies dans package.json, installez-les avec npm :
```
npm install
npm install sortablejs --save
```

## Lancer le projet
Démarrez MAMP et assurez-vous que les serveurs Apache et MySQL sont actifs.

Accédez au projet dans votre navigateur en entrant l'URL suivante :
```
http://localhost/votre/chemin/vers/le/projet
```