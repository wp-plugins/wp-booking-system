<?php
function bookingModalData_callback() {
    global $wpdb;
    $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars WHERE calendarID = ' . $_POST['calendarID'];
    $calendar = $wpdb->get_row( $sql, ARRAY_A );
    echo '<div class="wpbs-modal-box-content wpbs-calendar-'.$calendar['calendarID'].'">';
        echo wpbs_edit_dates( array( 'customRange' => true, 'startDate' => $_POST['startDate'], 'endDate' => $_POST['endDate'], 'calendarData' => $calendar['calendarData'], 'calendarLegend' => $calendar['calendarLegend'], 'currentTimestamp' => time(), 'calendarLanguage' => 'en' ) ) ;    
        
    echo '</div>';
	die(); 
}

function bookingMarkAsRead_callback() {
    global $wpdb;
    $wpdb->update( $wpdb->prefix.'bs_bookings', array('bookingRead' => '1'), array('bookingID' => $_POST['bookingID']) );     
	die(); 
}

