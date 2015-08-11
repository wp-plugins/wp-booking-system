<?php

/**
 * Calendars
 */
function wpbs_calendars(){
    $do = (!empty($_GET['do'])) ? $_GET['do'] : 'calendars';
    switch($do){
        /** Views */
        case 'calendars': 
            include WPBS_DIR_PATH . '/views/calendar/calendars.php';
            break;
        case 'edit-calendar':
            include WPBS_DIR_PATH . '/views/calendar/edit-calendar.php';
            break;
        case 'edit-legend':
            include WPBS_DIR_PATH . '/views/calendar/edit-legend.php';
            break;
        case 'edit-legend-item':
            include WPBS_DIR_PATH . '/views/calendar/edit-legend-item.php';
            break;
        case 'full-version':
            include WPBS_DIR_PATH . '/views/calendar/full-version.php';
            break;
            
        /** Controllers */    
        case 'save-calendar':
            include WPBS_DIR_PATH . '/controllers/calendar/calendar-save.php';
            break;
        case 'save-legend':
            include WPBS_DIR_PATH . '/controllers/calendar/legend-save.php';
            break;
        case 'calendar-delete':
            include WPBS_DIR_PATH . '/controllers/calendar/calendar-delete.php';
            break;   
            
        case 'legend-set-default':
            include WPBS_DIR_PATH . '/controllers/calendar/legend-set-default.php';
            break;
        case 'legend-set-visibility':
            include WPBS_DIR_PATH . '/controllers/calendar/legend-set-visibility.php';
            break;
        case 'legend-set-order':
            include WPBS_DIR_PATH . '/controllers/calendar/legend-set-order.php';
            break;
        case 'legend-delete':
            include WPBS_DIR_PATH . '/controllers/calendar/legend-delete.php';
            break;
        case 'booking-delete':
            include WPBS_DIR_PATH . '/controllers/bookings/booking-delete.php';
            break;
        default:
            include WPBS_DIR_PATH . '/views/calendar/calendars.php';
    }
}


/**
 * Forms
 */
function wpbs_forms(){
   $do = (!empty($_GET['do'])) ? $_GET['do'] : 'forms';
    switch($do){
        /** Views */
        case 'forms': 
            include WPBS_DIR_PATH . '/views/form/forms.php';
            break;
        case 'edit-form':
            include WPBS_DIR_PATH . '/views/form/edit-form.php';
            break;
                    
        /** Controllers */    
        case 'save-form':
            include WPBS_DIR_PATH . '/controllers/form/form-save.php';
            break;
        case 'delete-form':
            include WPBS_DIR_PATH . '/controllers/form/form-delete.php';
            break;
        default:
            include WPBS_DIR_PATH . '/views/form/forms.php';
    }
}


/**
 * Settings
 */
function wpbs_settings(){ 
    $do = (!empty($_GET['do'])) ? $_GET['do'] : 'settings';
    switch($do){
        /** Views */
        case 'settings': 
            include WPBS_DIR_PATH . '/views/settings/settings.php';
            break;
        case 'save': 
            include WPBS_DIR_PATH . '/controllers/settings/save-settings.php';
            break;
        default:
            include WPBS_DIR_PATH . '/views/settings/settings.php';
        }
}
