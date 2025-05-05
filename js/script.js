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
                    if (eventId) {
                        updateEventDate(eventId, newDate, evt.item);
                    } else {
                        addPredefinedEventToCalendar(evt.item.textContent.trim(), newDate);
                    }
                } else {
                    console.error('New Date is null');
                }
            }
        });
    });

    function updateEventDate(eventId, newDate, eventElement) {
        fetch('controllers/UpdateController.php', {
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
                const dateElement = eventElement.querySelector('.day-header span');
                if (dateElement) {
                    dateElement.textContent = newDate;
                }
            } else {
                console.error('Erreur lors de la mise à jour de la date:', data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }

    function addPredefinedEventToCalendar(eventName, newDate) {
        fetch('controllers/Controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `date=${newDate}&event=${encodeURIComponent(eventName)}&add=`
        })
        .then(response => response.text())
        .then(data => {
            console.log('Événement ajouté avec succès:', data);
            // Optionally, update the UI to reflect the new event
        })
        .catch(error => console.error('Erreur:', error));
    }
});
