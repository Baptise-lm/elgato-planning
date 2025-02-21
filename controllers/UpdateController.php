<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Planning.php';

header('Content-Type: application/json');

$planning = new Planning($pdo);

$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
  error_log('Invalid JSON: ' . json_last_error_msg());
  echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
  exit;
}

$eventId = $data['id'];
$newDate = $data['date'];

// Logs de débogage
error_log("Event ID: $eventId");
error_log("New Date: $newDate");

// Mettre à jour la date de l'événement dans la base de données
try {
  $planning->updateEventDate($eventId, $newDate);
  echo json_encode(['success' => true]);
} catch (Exception $e) {
  error_log("Error updating event date: " . $e->getMessage());
  echo json_encode(['success' => false, 'message' => 'Error updating event date: ' . $e->getMessage()]);
}
