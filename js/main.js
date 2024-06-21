jQuery(document).ready(function ($) {
  var calendarEl = document.getElementById('calendarId');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: events_data, // don't include last day
    eventClick: function (info) {

      $("#event_modal #validation").text('');
      $("#event_modal #registration_name").val('');
      $("#event_modal #registration_phone").val('');
      $("#event_modal #registration_email").val('');

      let event = info.event;
      $.ajax({
        url: ajax_object.ajax_url + '?action=get_event_details',
        method: 'POST',
        data: { id: event.id },
        success: function (response) {
          $('#event_modal #eventModalLabel').text(response.data.title);

          let imgTag = $('<img />', {
            src: response.data.img,
          });

          $('#event_modal #registration_info').html('');
          $('#event_modal #registration_info').append(imgTag).append('<br><br>').append('Date: ' + response.data.start + " " + response.data.end.slice(0, -9));

          $('#event_modal').modal('show');
        },
        error: function (xhr, status, error) {
          var response = xhr.responseJSON;
          if (response) {
            console.log(response.data);
          } else {
            console.log('Error');
          }
        }
      });
    },
  });
  calendar.render();


  // ============================ registration
  $("#event_modal .btn-primary").click(function () {
    $.ajax({
      url: ajax_object.ajax_url + '?action=event_registration',
      method: 'POST',
      data: {
        name: $("#event_modal #registration_name").val(),
        phone: $("#event_modal #registration_phone").val(),
        email: $("#event_modal #registration_email").val(),
        event: $('#event_modal #eventModalLabel').text(),
      },
      success: function (response) {
        $('#event_modal').modal('hide');
      },
      error: function (xhr) {
        let response = xhr.responseJSON;

        if (response) {
          if (response.data === "not all data") {
            $("#event_modal #validation").text(response.data)
          }
          console.log(response.data);
        } else {
          console.log('Error');
        }
      }
    });
  });
});