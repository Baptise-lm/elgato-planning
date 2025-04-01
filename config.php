<?php

/**
 * Configuration de la base de données
 *
 * Ce fichier configure la connexion à la base de données et définit l'URL de base du projet.
 */

define('BASE_URL', '/Test_planning/planning_elgato_MVC/'); // Définissez l'URL de base de votre projet

try {
  $pdo = new PDO('mysql:host=localhost;dbname=planning_marlou', 'root', 'root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Connexion échouée : ' . $e->getMessage());
}