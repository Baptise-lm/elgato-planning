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

<body class="font-regular bg-[#f8f9fa] m-0 p-0 flex flex-col items-center">
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
    <div class="flex flex-row">
      <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $previousMonth->format('Y-m'); ?>" class="no-underline text-dark-color font-regular py-2.5 px-5 border border-dark-color rounded-l-md transition-colors duration-300 hover:bg-dark-color hover:text-white">Mois précédent</a>
      <a href="<?php echo BASE_URL; ?>index.php?month=<?php echo $nextMonth->format('Y-m'); ?>" class="no-underline text-dark-color font-regular py-2.5 px-5 border border-dark-color rounded-r-md transition-colors duration-300 hover:bg-dark-color hover:text-white">Mois suivant</a>
    </div>
  </div>

  <div class="flex justify-between w-4/5 mx-auto my-4 gap-8">
    <div class="rounded-md overflow-hidden border border-dark-color">
      <table class="w-full border-collapse table-fixed">
        <thead>
          <tr>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Lun</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Mar</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Mer</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Jeu</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Ven</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-r border-dark-color overflow-hidden box-border">Sam</th>
            <th class="bg-gray-color text-dark-color font-bold py-2.5 px-2.5 text-center font-bold border-b border-dark-color overflow-hidden box-border">Dim</th>
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
                  echo '<td class="bg-light-color"></td>';
                  continue;
                }

                // Vérifier si le jour actuel dépasse le nombre de jours dans le mois
                if ($currentDay > $daysInMonth) {
                  echo '<td class="bg-light-color"></td>';
                  continue;
                }

                // Calculer la date actuelle
                $currentDate = $currentMonth->format('Y-m-') . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
                ?>
                <td class="border border-dark-color py-2.5 px-2.5 text-center align-top relative box-border" data-date="<?php echo $currentDate; ?>">
                  <div class="text-0.9rem text-dark-color bg-light-color w-5 h-5 rounded-full border border-dark-color flex justify-center items-center mb-1.5">
                    <span><?php echo $currentDay; ?></span>
                  </div>
                  <div>
                    <?php if (isset($monthEvents[$currentDate])): ?>
                      <?php foreach ($monthEvents[$currentDate] as $event): ?>
                        <div class="flex flex-col items-center justify-center bg-[#e9ecef] border border-[#ddd] rounded-md py-2.5 px-2.5 relative cursor-grab gap-2.5 mb-2.5" data-id="<?php echo $event['id']; ?>">
                          <?php echo $event['event']; ?>
                          <form method="POST" class="inline-block">
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                            <button type="submit" name="delete" class="bg-[rgb(138,1,1)]">
                              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path stroke="red" d="M3 6H21M5 6V20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20V6M8 6V4C8 2.89543 8.89543 2 10 2H14C15.1046 2 16 2.89543 16 4V6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path stroke="red" d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path stroke="red" d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </button>
                          </form>
                          <form method="POST" class="flex flex-col w-full gap-1.5">
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                            <input type="text" name="event" class="max-w-full" value="<?php echo $event['event']; ?>" required>
                            <input type="date" name="date" value="<?php echo $event['date']; ?>" required>
                            <button type="submit" name="update" class="bg-[#28a745] text-white border-none rounded-md py-1.5 px-2.5 cursor-pointer transition-colors duration-300 w-full hover:bg-[#218838]">Modifier</button>
                          </form>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="bg-light-color border border-dark-color rounded-md py-2.5 px-2.5 flex flex-col items-start">
                    <form method="POST" action="<?php echo BASE_URL; ?>controllers/Controller.php" class="flex flex-col w-full gap-1.5">
                      <input type="hidden" name="date" value="<?php echo $currentDate; ?>">
                      <input type="hidden" name="month" value="<?php echo $startDate; ?>">
                      <input type="text" name="event" placeholder="Ajouter un événement" required class="py-1.5 px-2.5 border border-[#ddd] rounded-md">
                      <button type="submit" name="add" class="bg-[#28a745] text-white border-none rounded-md py-1.5 px-2.5 cursor-pointer transition-colors duration-300 w-full hover:bg-[#218838]">Ajouter</button>
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

    <div class="py-2.5 px-2.5 border border-[#ddd] rounded-md bg-[#f8f9fa] w-1/4">
      <h2 class="mt-0 text-1.5em text-[#333]">Événements Prédéfinis</h2>
      <div class="min-h-[100px]">
        <?php foreach ($predefinedEvents as $event): ?>
          <div class="cursor-grab bg-[#e9ecef] border border-[#ddd] rounded-md py-2.5 px-2.5 mb-1.5">
            <?php echo $event['event']; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="bg-light-color border border-dark-color rounded-md py-2.5 px-2.5 flex flex-col items-start mt-2.5">
        <form method="POST" action="<?php echo BASE_URL; ?>controllers/Controller.php" class="flex flex-col w-full gap-1.5">
          <input type="hidden" name="month" value="<?php echo $startDate; ?>">
          <input type="text" name="event" placeholder="Ajouter un événement prédéfini" required class="py-1.5 px-2.5 border border-[#ddd] rounded-md">
          <button type="submit" name="add_predefined" class="bg-[rgb(65,120,204)] text-white border-none rounded-md py-1.5 px-2.5 cursor-pointer transition-colors duration-300 w-full">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>