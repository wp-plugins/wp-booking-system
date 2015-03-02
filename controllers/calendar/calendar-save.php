<?php
global $wpdb;

if(!empty($_POST['calendarID'])){
    $wpdb->update( $wpdb->prefix.'bs_calendars', array('calendarTitle' => $_POST['calendarTitle'], 'modifiedDate' => time()), array('calendarID' => $_POST['calendarID']) );
    
    if(json_decode(stripslashes($_POST['wpbsCalendarData']))){
        $wpdb->update( $wpdb->prefix.'bs_calendars', array('calendarData' => stripslashes($_POST['wpbsCalendarData'])), array('calendarID' => $_POST['calendarID']) ); 
    }
    $goto = '';
    if(!empty($_POST['wpbs_booking_action']) && !empty($_POST['wpbs_booking_id'])){
        if($_POST['wpbs_booking_action'] == 'accept'){
            $wpdb->update( $wpdb->prefix.'bs_bookings', array('bookingStatus' => 'accepted'), array('bookingID' => $_POST['wpbs_booking_id']) );  
        } elseif($_POST['wpbs_booking_action'] == 'delete'){
            $wpdb->update( $wpdb->prefix.'bs_bookings', array('bookingStatus' => 'trash'), array('bookingID' => $_POST['wpbs_booking_id']) );
            $goto = '&goto=accepted';
        }
    }         
    wp_redirect(admin_url('admin.php?page=wp-booking-system&do=edit-calendar&id='.$_POST['calendarID'].'&save=ok' . $goto));
} else {
    $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars'; 
    $wpdb->get_results( $sql, ARRAY_A ); 
    if($wpdb->num_rows > 0) wp_die();
    
    $wpdb->insert( $wpdb->prefix.'bs_calendars', array('calendarTitle' => $_POST['calendarTitle'], 'modifiedDate' => time(), 'createdDate' => time(), 'calendarLegend' => wpbs_defaultCalendarLegend()));    
    if(json_decode(stripslashes($_POST['wpbsCalendarData']))){
        $wpdb->update( $wpdb->prefix.'bs_calendars', array('calendarData' => stripslashes($_POST['wpbsCalendarData'])), array('calendarID' => $wpdb->insert_id) ); 
    }
    wp_redirect(admin_url('admin.php?page=wp-booking-system&do=edit-calendar&id='.$wpdb->insert_id.'&save=ok'));     
}
die();


?>