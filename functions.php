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
  wp_enqueue_script('fullcalendar-script', get_stylesheet_directory_uri() . '/js/fullcalendar.min.js', array('jquery'), '1.0.0', true);

  wp_enqueue_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('fullcalendar-script'), '1.0.0', true);

  wp_enqueue_style('child-style', get_stylesheet_uri(), array(), '1.0.1');
}
add_action('wp_enqueue_scripts', 'fish_enqueue_scripts_styles');

function get_events_data() {
  $events = array();

  $query = new WP_Query(array(
      'post_type' => 'event',
      'posts_per_page' => -1,
  ));

  while ($query->have_posts()) {
      $query->the_post();

      $id = get_the_ID();
      $event_title = get_the_title();
      $event_start_date = get_field('start_date');
      $event_end_date = get_field('end_date');

      $events[] = array(
          'id' => $id,
          'title' => $event_title,
          'start' => $event_start_date,
          'end' => $event_end_date,
      );
  }

  wp_reset_postdata();

  return $events;
}
