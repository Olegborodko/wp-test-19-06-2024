document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendarId');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: events_data, // don't include last day
  });
  calendar.render();
});