<?php
function wpbs_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id'        => null,
        'form'        => null,
		'title'     => 'no',
        'legend'    => 'no',
        'start'     => '1',
        'display'   => '1',
        'language'  => 'en',
        'history'  => '1',
        'month' => 0,
        'year' => 0
	), $atts, 'wpbs' ) );
    
    
    if($id == null) return "WP Booking System: ID parameter missing.";
    if($form == null) return "WP Booking System: Form ID parameter missing.";
    
    if(!in_array($month,array(1,2,3,4,5,6,7,8,9,10,11,12))) {$month = gmdate('m');}
    if(intval($year) < 1970 || intval($year) > 2100) { $year = gmdate("Y");}
    
    if(!in_array($title,array('yes','no'))) $title = 'no';
    if(!in_array($legend,array('yes','no'))) $legend = 'no';
    if(!in_array(absint($start),array(1,2,3,4,5,6,7))) $start = 1;
    if(!in_array(absint($display),array(1))) $display = 1;
    if(!in_array(absint($history),array(1,2,3))) $history = 1;    
    
    
    global $wpdb;
    
    if($language == 'auto'){
        $language = wpbs_get_locale();
    } else {
        $activeLanguages = json_decode(get_option('wpbs-languages'),true); if(!array_key_exists($language,$activeLanguages)) $language = 'en';    
    }
    
    $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_calendars WHERE calendarID=%d',$id);
    $calendar = $wpdb->get_row( $sql, ARRAY_A );
    if($wpdb->num_rows > 0):
        ob_start();
        wpbs_print_legend_css($calendar['calendarLegend'],$calendar['calendarID']);
        if($title == 'yes') echo '<h2>' . $calendar['calendarTitle'] . "</h2>";
        wpbs_calendar(array('ajaxCall' => false, 'calendarHistory' => $history, 'calendarID' => $calendar['calendarID'], 'formID' => $form, 'calendarData' => $calendar['calendarData'], 'totalCalendars' => $display, 'firstDayOfWeek' => $start, 'showDateEditor' => false, 'calendarLegend' => $calendar['calendarLegend'], 'showLegend' => $legend, 'calendarLanguage' => $language, 'currentTimestamp' => strtotime(date("F", mktime(0, 0, 0, $month, 15, date('Y'))) . " " . $year) ));
        $calendarOutput = ob_get_contents();
        ob_end_clean();
        return $calendarOutput;
    else:
        return 'WP Booking System: Invalid calendar ID.';
    endif;
	
}
add_shortcode( 'wpbs', 'wpbs_shortcode' );

