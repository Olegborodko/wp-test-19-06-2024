<?php

function create_post_type_event()
{
  register_post_type(
    'event',
    array(
      'labels' => array(
        'name' => __('Events'),
        'singular_name' => __('Event')
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'thumbnail'),
    )
  );
}
add_action('init', 'create_post_type_event');

function create_post_type_lead()
{
  register_post_type(
    'lead',
    array(
      'labels' => array(
        'name' => __('Leads'),
        'singular_name' => __('Lead')
      ),
      'public' => false,
      'show_ui' => true,
      'supports' => array('title', 'custom-fields'),
    )
  );
}
add_action('init', 'create_post_type_lead');

function fish_enqueue_scripts_styles()
{
  wp_enqueue_script('jquery');

  wp_enqueue_script('fullcalendar-script', get_stylesheet_directory_uri() . '/js/fullcalendar.min.js', array('jquery'), '1.0.0', true);

  wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('fullcalendar-script'), '1.0.0', true);

  wp_enqueue_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'bootstrap', 'fullcalendar-script'), '1.0.0', true);

  wp_localize_script('main', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

  wp_enqueue_style('child-style', get_stylesheet_uri(), array(), '1.0.1');

  wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0.1');
}
add_action('wp_enqueue_scripts', 'fish_enqueue_scripts_styles');

function get_events_data()
{
  $events = array();

  $query = new WP_Query(
    array(
      'post_type' => 'event',
      'posts_per_page' => -1,
    )
  );

  while ($query->have_posts()) {
    $query->the_post();

    $id = get_the_ID();
    $event_title = get_the_title();
    $event_start_date = get_field('start_date');
    $event_end_date = get_field('end_date') . 'T23:59:00';

    $thumbnail_id = get_post_thumbnail_id($id);
    if ($thumbnail_id) {
      $thumbnail_image = wp_get_attachment_image_src($thumbnail_id, 'full');
      if ($thumbnail_image) {
        $thumbnail_url = $thumbnail_image[0];
      }
    }

    $events[] = array(
      'id' => $id,
      'title' => $event_title,
      'start' => $event_start_date,
      'end' => $event_end_date,
      'img' => $thumbnail_url,
    );
  }

  wp_reset_postdata();

  return $events;
}

function get_event_details()
{
  $event_id = isset($_POST['id']) ? intval($_POST['id']) : false;
  if (!$event_id) {
    wp_send_json_error("entry not found", 404);
  }

  $events = get_events_data();

  foreach ($events as $event) {
    if ($event['id'] === $event_id) {
      wp_send_json_success($event);
      return;
    }
  }

  wp_send_json_error("entry not found", 404);
}
add_action('wp_ajax_get_event_details', 'get_event_details');
add_action('wp_ajax_nopriv_get_event_details', 'get_event_details');

function event_registration()
{
  $name = $_POST['name'] ?? false;
  $email = $_POST['email'] ?? false;
  $phone = $_POST['phone'] ?? false;
  $event = $_POST['event'] ?? false;

  if (empty($name) || empty($email) || empty($phone) || empty($event)) {
    wp_send_json_error("not all data", 400);
  }

  $lead_post = array(
    'post_title' => 'Lead ' . date('Y-m-d H:i:s'),
    'post_type' => 'lead',
    'post_status' => 'publish',
  );

  $lead_id = wp_insert_post($lead_post);

  if ($lead_id) {
    update_field('name', $name, $lead_id);
    update_field('email', $email, $lead_id);
    update_field('phone', $phone, $lead_id);
    update_field('event', $event, $lead_id);
    wp_send_json_success(true, 200);
  } else {
    wp_send_json_error("Failed to save lead", 500);
  }
}
add_action('wp_ajax_event_registration', 'event_registration');
add_action('wp_ajax_nopriv_event_registration', 'event_registration');


function set_custom_edit_lead_columns($columns)
{
  $new_columns = array();

  $new_columns['title'] = $columns['title'];
  $new_columns['lead_email'] = __('Email');
  $new_columns['lead_event'] = __('Event');
  $new_columns['date'] = $columns['date'];

  return $new_columns;
}
add_filter('manage_lead_posts_columns', 'set_custom_edit_lead_columns');

function custom_lead_column($column, $post_id)
{
  switch ($column) {
    case 'lead_event':
      $event = get_post_meta($post_id, 'event', true);
      echo $event ? $event : '';
      break;
    case 'lead_email':
      $email = get_post_meta($post_id, 'email', true);
      echo $email ? $email : '';
      break;
  }
}
add_action('manage_lead_posts_custom_column', 'custom_lead_column', 10, 2);