<?php 
global $wpdb;

$calendarId = $_GET['id'];

$sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_calendars WHERE calendarID=%d',$calendarId);
$calendar = $wpdb->get_row( $sql, ARRAY_A );
if($wpdb->num_rows > 0):
    $wpdb->delete( $wpdb->prefix . 'bs_calendars', array('calendarID' => $calendarId));
    
endif;

wp_redirect(admin_url('admin.php?page=wp-booking-system'));
die();
?>     