<div class="modal fade" id="event_modal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="registration_info"></div>
        <br>
        Registration
        <br>
        Name
        <input type="text" id="registration_name" required size="20" />
        <br>
        Phone
        <input type="text" id="registration_phone" required size="20" />
        <br>
        Email
        <input type="email" id="registration_email" required size="20" />
        <br>
        <div id="validation"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Registration</button>
      </div>
    </div>
  </div>
</div>