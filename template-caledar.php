<?php
/*
Template Name: calendar
*/

get_header();

$events = get_events_data();
wp_localize_script('main', 'events_data', $events);

include('template-parts/modal.php');

?>
<div class="calendar-block">
  <div id="calendarId"></div>
</div>

<?php
get_footer();