<?php
require_once 'config.php';
require_once 'classes/Planning.php';

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
  header('Location: index.php?week=' . $_POST['week']);
  exit;
}

// Gérer la navigation entre les semaines
$currentWeek = isset($_GET['week']) ? new DateTime($_GET['week']) : new DateTime('this week');
$startDate = $currentWeek->format('Y-m-d');
$previousWeek = clone $currentWeek;
$previousWeek->modify('-1 week');
$nextWeek = clone $currentWeek;
$nextWeek->modify('+1 week');

$weekEvents = $planning->getWeekEvents($startDate);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planning Hebdomadaire</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <h1>Planning Hebdomadaire</h1>
  <div class="navigation">
    <a href="?week=<?php echo $previousWeek->format('Y-m-d'); ?>">Semaine précédente</a>
    <span>Semaine du <?php echo $currentWeek->format('d F'); ?> - <?php echo $currentWeek->modify('+6 days')->format('d F'); ?></span>
    <a href="?week=<?php echo $nextWeek->format('Y-m-d'); ?>">Semaine suivante</a>
  </div>
  <div class="calendar">
    <?php foreach ($weekEvents as $date => $events): ?>
      <div class="calendar-day">
        <h3><?php echo date('l', strtotime($date)); ?></h3>
        <p><?php echo date('d/m/Y', strtotime($date)); ?></p>
        <?php foreach ($events as $event): ?>
          <div class="event">
            <?php echo $event['event']; ?>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
              <input type="hidden" name="week" value="<?php echo $startDate; ?>">
              <button type="submit" name="delete">Supprimer</button>
            </form>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
              <input type="hidden" name="week" value="<?php echo $startDate; ?>">
              <input type="text" name="event" value="<?php echo $event['event']; ?>" required>
              <input type="date" name="date" value="<?php echo $event['date']; ?>" required>
              <button type="submit" name="update">Modifier</button>
            </form>
          </div>
        <?php endforeach; ?>
        <form method="POST">
          <input type="hidden" name="date" value="<?php echo $date; ?>">
          <input type="hidden" name="week" value="<?php echo $startDate; ?>">
          <input type="text" name="event" placeholder="Ajouter un événement" required>
          <button type="submit" name="add">Ajouter</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</body>

</html>