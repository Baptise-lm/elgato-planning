<?php

/**
 * Configuration de la base de données
 *
 * Ce fichier configure la connexion à la base de données et définit l'URL de base du projet.
 */

// Définissez l'URL de base de votre projet
define('BASE_URL', '/Test_planning/planning_elgato_MVC/');

try {
  // Connexion à la base de données
  $pdo = new PDO('mysql:host=localhost;dbname=planning_marlou', 'root', 'root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Gérer les erreurs de connexion
  die('Connexion échouée : ' . $e->getMessage());
}
