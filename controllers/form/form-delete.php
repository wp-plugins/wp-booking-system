<?php 
global $wpdb;

$formID = $_GET['id'];

$sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_forms WHERE formID=%d',$formID);
$calendar = $wpdb->get_row( $sql, ARRAY_A );
if($wpdb->num_rows > 0):
    $wpdb->delete( $wpdb->prefix . 'bs_forms', array('formID' => $formID));
    
endif;

wp_redirect(admin_url('admin.php?page=wp-booking-system-forms'));
die();
?>     