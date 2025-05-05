<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planning Mensuel</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  <script defer src="<?php echo BASE_URL; ?>js/script.js"></script>
  <style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
    </style>
</head>

<body>
  <h1 class="text-3xl font-bold underline text-clifford">Planning Mensuel</h1>
  <div class="flex justify-between items-center mx-auto my-5 w-4/5 font-bold">
    <span>
      <?php
      $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        'MMMM yyyy'
      );
      echo ucfirst($formatter->format($currentMonth->getTimestamp()));
      ?>
    </span>
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
            <th>Sam</th>
            <th>Dim</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth->format('m'), $currentMonth->format('Y'));
          $firstDayOfWeek = date('N', strtotime($currentMonth->format('Y-m-01'))); // Jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)

          // Initialiser le jour actuel
          $currentDay = 1;

          // Calculer le nombre de semaines nécessaires pour afficher tous les jours du mois
          $nbWeeks = ceil(($daysInMonth + $firstDayOfWeek - 1) / 7); // Diviser par 7 (jours par semaine)

          for ($i = 0; $i < $nbWeeks; $i++): // Maximum 6 semaines dans un mois
          ?>
            <tr>
              <?php for ($j = 1; $j <= 7; $j++): // Afficher tous les jours de la semaine (lundi à dimanche)
              ?>
                <?php
                // Si on est dans la première semaine et que le jour de la semaine est avant le premier jour du mois
                if ($i === 0 && $j < $firstDayOfWeek) {
                  echo '<td class="empty"></td>';
                  continue;
                }

                // Vérifier si le jour actuel dépasse le nombre de jours dans le mois
                if ($currentDay > $daysInMonth) {
                  echo '<td class="empty"></td>';
                  continue;
                }

                // Calculer la date actuelle
                $currentDate = $currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
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
                          <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                            <button type="submit" name="delete" class="delete-button">
                              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path stroke="red" d="M3 6H21M5 6V20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20V6M8 6V4C8 2.89543 8.89543 2 10 2H14C15.1046 2 16 2.89543 16 4V6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path stroke="red" d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path stroke="red" d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </button>
                          </form>
                          <form method="POST" class="submit-date">
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                            <input type="text" name="event" class="tag_task" value="<?php echo $event['event']; ?>" required>
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

    <div class="predefined-events">
      <h2>Événements Prédéfinis</h2>
      <div class="event-container" id="predefined-event-container">
        <?php foreach ($predefinedEvents as $event): ?>
          <div class="event" draggable="true">
            <?php echo $event['event']; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="no-drag" style="margin-top: 10px;">
        <form method="POST" action="<?php echo BASE_URL; ?>controllers/Controller.php">
          <input type="hidden" name="month" value="<?php echo $startDate; ?>">
          <input type="text" name="event" placeholder="Ajouter un événement prédéfini" required>
          <button type="submit" name="add_predefined" style="background-color:rgb(65, 120, 204);">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>