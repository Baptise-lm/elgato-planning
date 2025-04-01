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
    <?php
    $formatter = new IntlDateFormatter(
      'fr_FR',
      IntlDateFormatter::FULL,
      IntlDateFormatter::NONE,
      'Europe/Paris',
      IntlDateFormatter::GREGORIAN,
      'MMMM yyyy'
    );
    ?>
    <span><?php echo ucfirst($formatter->format($currentMonth)); ?></span>
    <div class="navigation-container">
      <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $previousMonth->format('Y-m'); ?>">Mois précédent</a>
      <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $nextMonth->format('Y-m'); ?>">Mois suivant</a>
    </div>
  </div>

  <div class="main-content">
    <div class="calendar-container">
      <table class="calendar">
        <thead>
          <tr>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mer</th>
            <th>Jeu</th>
            <th>Ven</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth->format('m'), $currentMonth->format('Y'));
          $firstDayOfWeek = date('N', strtotime($startDate)); // Jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)

          // Ajuster le premier jour de la semaine si le mois commence par un week-end
          if ($firstDayOfWeek == 6) { // Samedi
            $firstDayOfWeek = 1; // Décaler au lundi suivant
          } elseif ($firstDayOfWeek == 7) { // Dimanche
            $firstDayOfWeek = 1; // Décaler au lundi suivant
          }

          // Initialiser le jour actuel
          $currentDay = 1;

          // Calculer le nombre de jours ouvrés (lundi à vendredi) dans le mois
          $workDays = 0;
          for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayOfWeek = date('N', strtotime($currentMonth->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT)));
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Lundi à vendredi
              $workDays++;
            }
          }

          // Calculer le nombre de semaines nécessaires pour afficher ces jours ouvrés
          $nbWeeks = ceil(($workDays + $firstDayOfWeek - 1) / 5); // Diviser les jours ouvrés par 5 (jours par semaine)

          for ($i = 0; $i < $nbWeeks; $i++): // Maximum 6 semaines dans un mois
          ?>
            <tr>
              <?php for ($j = 1; $j <= 5; $j++): // Afficher uniquement lundi à vendredi 
              ?>
                <?php
                // Calculer la date actuelle
                $currentDate = $currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT);

                // Vérifier si le jour actuel dépasse le nombre de jours dans le mois
                if ($currentDay > $daysInMonth) {
                  echo '<td class="empty"></td>';
                  continue;
                }

                // Vérifier si le jour est un week-end
                $dayOfWeek = date('N', strtotime($currentDate));
                if ($dayOfWeek == 6 || $dayOfWeek == 7) { // Samedi ou dimanche
                  $currentDay++;
                  $j--; // Ne pas avancer dans la colonne
                  continue;
                }
                ?>
                <td class="calendar-day" data-date="<?php echo $currentDate; ?>">
                  <div class="day-header">
                    <span><?php echo $currentDay; ?></span>
                  </div>
                  <div class="event-container">
                    <?php if (isset($monthEvents[$currentDate])): ?>
                      <?php foreach ($monthEvents[$currentDate] as $event): ?>
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
                      <input type="hidden" name="date" value="<?php echo $currentDate; ?>">
                      <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                      <input type="text" name="event" placeholder="Ajouter un événement" required>
                      <button type="submit" name="add">Ajouter</button>
                    </form>
                  </div>
                </td>
                <?php $currentDay++; ?>
              <?php endfor; ?>
            </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>

    <!-- Ajouter un bloc d'événements prédéfinis -->
    <div class="predefined-events">
      <h2>Événements Prédéfinis</h2>
      <div class="event-container" id="predefined-event-container">
        <?php foreach ($predefinedEvents as $event): ?>
          <div class="event" draggable="true">
            <?php echo $event['event']; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <form method="POST" action="<?php echo BASE_URL; ?>controllers/Controller.php">
        <input type="hidden" name="month" value="<?php echo $startDate; ?>">
        <input type="text" name="event" placeholder="Ajouter un événement prédéfini" required>
        <button type="submit" name="add_predefined">Ajouter</button>
      </form>
    </div>
  </div>
</body>

</html>