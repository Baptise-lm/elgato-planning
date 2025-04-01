<?php

/**
 * Configuration de la base de données
 *
 * Ce fichier configure la connexion à la base de données et définit l'URL de base du projet.
 */

define('BASE_URL', '/planning-doriane/elgato-planning/'); // Définissez l'URL de base de votre projet

try {
  $pdo = new PDO('mysql:host=127.0.0.1;port=8889;dbname=projetDoriane', 'root', 'root');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Connexion échouée : ' . $e->getMessage());
}