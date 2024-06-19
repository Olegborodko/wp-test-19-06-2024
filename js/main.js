jQuery(document).ready(function ($) {
  var calendarEl = document.getElementById('calendarId');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: events_data, // don't include last day
    eventClick: function (info) {
      let event = info.event;
      $.ajax({
        url: ajax_object.ajax_url + '?action=get_event_details',
        method: 'POST',
        data: { id: event.id },
        success: function (response) {
          console.log(response.data);
          $('#event_modal #eventModalLabel').text(response.data.title);
          $('#event_modal .modal-body').text(response.data.start + " " + response.data.end);
          $('#event_modal').modal('show');
        },
        error: function (xhr, status, error) {
          console.log('Failed to fetch event details');
        }
      });
    },
  });
  calendar.render();
});