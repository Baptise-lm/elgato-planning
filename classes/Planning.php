<?php
require_once 'config.php';

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

  public function getWeekEvents($startDate)
  {
    $weekEvents = [];
    for ($i = 0; $i < 7; $i++) {
      $date = date('Y-m-d', strtotime($startDate . ' + ' . $i . ' days'));
      $weekEvents[$date] = $this->getEvents($date);
    }
    return $weekEvents;
  }

  public function updateEvent($id, $date, $event)
  {
    $sql = "UPDATE tasks SET date = :date, event = :event WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['date' => $date, 'event' => $event, 'id' => $id]);
  }

  public function deleteEvent($id)
  {
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
  }
}
