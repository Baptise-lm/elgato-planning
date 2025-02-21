<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planning Mensuel</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  <script defer src="<?php echo BASE_URL; ?>js/script.js"></script>
</head>

<body>
  <h1>Planning Mensuel</h1>
  <div class="navigation">
    <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $previousMonth->format('Y-m'); ?>">Mois précédent</a>
    <span>Mois de <?php echo $currentMonth->format('F Y'); ?></span>
    <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $nextMonth->format('Y-m'); ?>">Mois suivant</a>
  </div>
  <table class="calendar">
    <thead>
      <tr>
        <th>Lun</th>
        <th>Mar</th>
        <th>Mer</th>
        <th>Jeu</th>
        <th>Ven</th>
        <th>Sam</th>
        <th>Dim</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth->format('m'), $currentMonth->format('Y'));
      $firstDayOfWeek = date('N', strtotime($startDate));
      $currentDay = 1;
      for ($i = 0; $i < 6; $i++):
      ?>
        <tr>
          <?php for ($j = 1; $j <= 7; $j++): ?>
            <?php if (($i === 0 && $j < $firstDayOfWeek) || $currentDay > $daysInMonth): ?>
              <td class="empty"></td>
            <?php else: ?>
              <td class="calendar-day" data-date="<?php echo $currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT); ?>">
                <div class="day-header">
                  <span><?php echo $currentDay; ?></span>
                </div>
                <div class="event-container">
                  <?php if (isset($monthEvents[$currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT)])): ?>
                    <?php foreach ($monthEvents[$currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT)] as $event): ?>
                      <div class="event" data-id="<?php echo $event['id']; ?>">
                        <?php echo $event['event']; ?>
                        <form method="POST" style="display:inline;">
                          <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                          <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                          <button type="submit" name="delete">Supprimer</button>
                        </form>
                        <form method="POST" style="display:inline;">
                          <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                          <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                          <input type="text" name="event" value="<?php echo $event['event']; ?>" required>
                          <input type="date" name="date" value="<?php echo $event['date']; ?>" required>
                          <button type="submit" name="update">Modifier</button>
                        </form>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <div class="no-drag">
                  <form method="POST" action="<?php echo BASE_URL; ?>controllers/Controller.php">
                    <input type="hidden" name="date" value="<?php echo $currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT); ?>">
                    <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                    <input type="text" name="event" placeholder="Ajouter un événement" required>
                    <button type="submit" name="add">Ajouter</button>
                  </form>
                </div>
              </td>
              <?php $currentDay++; ?>
            <?php endif; ?>
          <?php endfor; ?>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</body>

</html>