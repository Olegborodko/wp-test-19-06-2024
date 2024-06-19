document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendarId');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth'
  });
  calendar.render();
});