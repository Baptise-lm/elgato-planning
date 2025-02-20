document.addEventListener('DOMContentLoaded', function () {
  const eventContainers = document.querySelectorAll('.event-container');

  eventContainers.forEach(container => {
      Sortable.create(container, {
          group: 'shared',
          animation: 150,
          onEnd: function (evt) {
              const eventId = evt.item.getAttribute('data-id');
              const newDate = evt.to.closest('.calendar-day').getAttribute('data-date');
              console.log('Event ID:', eventId);
              console.log('New Date:', newDate);
              if (newDate) {
                  updateEventDate(eventId, newDate);
              } else {
                  console.error('New Date is null');
              }
          }
      });
  });

  function updateEventDate(eventId, newDate) {
      fetch('update_date.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id: eventId, date: newDate })
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Date mise à jour avec succès');
          } else {
              console.error('Erreur lors de la mise à jour de la date:', data.message);
          }
      })
      .catch(error => console.error('Erreur:', error));
  }
});
