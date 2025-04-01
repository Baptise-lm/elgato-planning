<?php

/**
 * Modèle Planning
 *
 * Ce fichier contient la logique de la base de données et les opérations CRUD.
 */

class Planning
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function addEvent($date, $event)
  {
    $sql = "INSERT INTO tasks (date, event) VALUES (:date, :event)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['date' => $date, 'event' => $event]);
  }

  public function getEvents($date)
  {
    $sql = "SELECT * FROM tasks WHERE date = :date";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['date' => $date]);
    return $stmt->fetchAll();
  }

  public function getMonthEvents($startDate)
  {
    $monthEvents = [];
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
    for ($i = 1; $i <= $daysInMonth; $i++) {
      $date = date('Y-m-d', strtotime($startDate . ' + ' . ($i - 1) . ' days'));
      $monthEvents[$date] = $this->getEvents($date);
    }
    return $monthEvents;
  }

  public function updateEvent($id, $date, $event)
  {
    $sql = "UPDATE tasks SET date = :date, event = :event WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['date' => $date, 'event' => $event, 'id' => $id]);
  }

  public function updateEventDate($id, $date)
  {
    $sql = "UPDATE tasks SET date = :date WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    try {
      $stmt->execute(['date' => $date, 'id' => $id]);
      error_log("Event $id updated to date $date");
    } catch (PDOException $e) {
      error_log("SQL Error: " . $e->getMessage());
      throw new Exception("Error updating event date in database");
    }
  }

  public function deleteEvent($id)
  {
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
  }

  public function getPredefinedEvents()
  {
    $sql = "SELECT * FROM predefined_events";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }

  public function addPredefinedEvent($event)
  {
    $sql = "INSERT INTO predefined_events (event) VALUES (:event)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['event' => $event]);
  }
}
