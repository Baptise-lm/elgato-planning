<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Planning.php';

$planning = new Planning($pdo);

// Gérer les requêtes POST pour le CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add'])) {
    $planning->addEvent($_POST['date'], $_POST['event']);
  } elseif (isset($_POST['update'])) {
    $planning->updateEvent($_POST['id'], $_POST['date'], $_POST['event']);
  } elseif (isset($_POST['delete'])) {
    $planning->deleteEvent($_POST['id']);
  }
  header('Location: ' . BASE_URL . 'index.php?month=' . $_POST['month']);
  exit;
}

// Gérer la navigation entre les mois
$currentMonth = isset($_GET['month']) ? new DateTime($_GET['month']) : new DateTime('first day of this month');
$startDate = $currentMonth->format('Y-m-d');
$previousMonth = clone $currentMonth;
$previousMonth->modify('-1 month');
$nextMonth = clone $currentMonth;
$nextMonth->modify('+1 month');

$monthEvents = $planning->getMonthEvents($startDate);

// Inclure la vue
include __DIR__ . '/../views/Accueil.php';
