<?php
global $wpdb;
$goto = '';
$sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_bookings WHERE bookingID = '. $_GET['bookingID'] .'';
$booking = $wpdb->get_row( $sql, ARRAY_A );
if($booking['bookingStatus'] == 'pending'){
    $wpdb->update( $wpdb->prefix.'bs_bookings', array('bookingStatus' => 'trash'), array('bookingID' => $_GET['bookingID']) );     
} elseif($booking['bookingStatus'] == 'trash') {
    $wpdb->delete( $wpdb->prefix.'bs_bookings', array( 'bookingID' => $_GET['bookingID'] ) );
    $goto = '&goto=trash';    
}
wp_redirect(admin_url('admin.php?page=wp-booking-system&do=edit-calendar&id='.$_GET['calendarID'] . $goto));

die();


?>