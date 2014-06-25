<?php
/**
 * Plugin Name: WP Booking System
 * Plugin URI:  http://www.wpbookingsystem.com
 * Description: WP Booking System.
 * Version:     1.1
 * Author:      WP Booking System
 * Author URI:  http://www.wpbookingsystem.com
 *
 * Copyright (c) 2014 WP Booking System
 */
include 'include/createTables.php';
register_activation_hook( __FILE__, 'wpbs_install' );


define("WPBS_PATH",plugins_url('',__FILE__));
define("WPBS_DIR_PATH",dirname(__FILE__));



include 'include/calendarLanguages.php';
include 'include/calendarFunctions.php';
include 'include/calendarAdmin.php';
include 'include/calendarCore.php';
include 'include/calendarAjax.php';

include 'include/formCore.php';
include 'include/formAjax.php';

include 'include/bookingCore.php';
include 'include/bookingAjax.php';

include 'include/pluginStructure.php';
include 'include/pluginShortcodeButton.php';
include 'include/pluginShortcode.php';
include 'include/pluginWidget.php';



if (is_admin()) {
	add_action('admin_menu', 'wpbs_menu');   
    function wpbs_admin_enqueue_files() {
        wp_enqueue_script('postbox');
		wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-sortable');
        
        wp_enqueue_style( 'wpbs-calendar', WPBS_PATH . '/css/wpbs-calendar.css' );
        wp_enqueue_style( 'wpbs-admin', WPBS_PATH . '/css/wpbs-admin.css' );
        wp_enqueue_style( 'colorpicker', WPBS_PATH . '/css/colorpicker.css' );
        

        wp_enqueue_script('wpbs-admin', WPBS_PATH . '/js/wpbs-admin.js', array('jquery'));
        wp_enqueue_script('wpbs-admin-forms', WPBS_PATH . '/js/wpbs-forms.js', array('jquery','jquery-ui-sortable'));
        wp_enqueue_script('wpbs-admin-bookings', WPBS_PATH . '/js/wpbs-bookings.js', array('jquery'));
        wp_enqueue_script('wpbs-colorpicker', WPBS_PATH . '/js/colorpicker.js', array('jquery'));
        wp_enqueue_script('custom-select', WPBS_PATH . '/js/custom-select.js', array('jquery'));
        
        wp_enqueue_script('data-tables', WPBS_PATH . '/js/jquery.dataTables.min.js', array('jquery'));
        
        
        
    }
    add_action( 'admin_init', 'wpbs_admin_enqueue_files' );       
} else {
    function wpbs_enqueue_files() {

        wp_enqueue_style( 'wpbs-calendar', WPBS_PATH . '/css/wpbs-calendar.css' );
        wp_enqueue_script('wpbs', WPBS_PATH . '/js/wpbs.js', array('jquery'));
        wp_enqueue_script('custom-select', WPBS_PATH . '/js/custom-select.js', array('jquery'));
    }
    add_action( 'init', 'wpbs_enqueue_files' );
    add_action('wp_head','wpbs_ajaxurl');
}

//Admin Menu
function wpbs_menu(){
    add_menu_page( 'WP Booking System', 'WP Booking System', 'read_private_pages', 'wp-booking-system', 'wpbs_calendars', WPBS_PATH . '/images/date-button.gif' , '375.457' );
    add_submenu_page( 'wp-booking-system', __('Calendars','wpbs'), __('Calendars','wpbs'), 'read_private_pages', 'wp-booking-system', 'wpbs_calendars' );
    add_submenu_page( 'wp-booking-system', __('Forms','wpbs'), __('Forms','wpbs'), 'read_private_pages', 'wp-booking-system-forms', 'wpbs_forms' );
    add_submenu_page( 'wp-booking-system', __('Settings','wpbs'), __('Settings','wpbs'), 'read_private_pages', 'wp-booking-system-settings', 'wpbs_settings' );  
    
    add_action('admin_print_scripts-toplevel_page_wp-booking-system', 'wpbs_dashboard_toggle');
    add_action('admin_print_scripts-wp-booking-system_page_wp-booking-system-forms', 'wpbs_dashboard_toggle');
    add_action('admin_print_scripts-wp-booking-system_page_wp-booking-system-settings', 'wpbs_dashboard_toggle');
    
}

function wpbs_dashboard_toggle(){
    wp_enqueue_script('dashboard');
}

// Ajax Hooks
add_action('wp_ajax_changeDayAdmin', 'changeDayAdmin_callback');
add_action('wp_ajax_changeDay', 'changeDay_callback');
add_action('wp_ajax_nopriv_changeDay', 'changeDay_callback');

add_action('wp_ajax_submitForm' , 'wpbs_submitForm_callback');
add_action('wp_ajax_nopriv_submitForm' , 'wpbs_submitForm_callback');

add_action('wp_ajax_bookingModalData' , 'bookingModalData_callback');
add_action('wp_ajax_bookingMarkAsRead' , 'bookingMarkAsRead_callback');


function wpbs_ajaxurl() {
    ?>
    <script type="text/javascript">var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
    <?php
}



add_filter( 'admin_menu', 'wpbs_add_submenu_count');

function wpbs_add_submenu_count(){
    global $wpdb, $menu;
    $sql = 'SELECT bookingRead FROM ' . $wpdb->prefix . 'bs_bookings WHERE bookingRead = 0';
    $rows = $wpdb->get_results( $sql, ARRAY_A );
    $count = $wpdb->num_rows;
    $menu['375.457'][0] .= " <span class='update-plugins count-$count'><span class='plugin-count'>" . number_format_i18n($count) . '</span></span>';
}

add_action('wp_before_admin_bar_render', 'wpbs_admin_bar_notifications',1);

function wpbs_admin_bar_notifications($wp_admin_bar){
    global $wp_admin_bar, $wpdb;
    
    $sql = 'SELECT bookingRead FROM ' . $wpdb->prefix . 'bs_bookings WHERE bookingRead = 0';
    $rows = $wpdb->get_results( $sql, ARRAY_A );
    $count = $wpdb->num_rows;
    $args = array(
        'id' => 'wp-bookig-system-admin',
        'href' => admin_url('admin.php?page=wp-booking-system'),
        'parent' => 'root-default',
    );
    if($count == 1){
        $title = ' New Booking';
    } else{
        $title = ' New Bookings';
    }
    $args['meta']['title'] = $title;
    if($count == 0){
        $display = '<span class="wpbs-ab-text">'.$count.' '.$title.'</span>';
    } else{
        $display = '<span class="wpbs-update-bubble">'.$count.'</span><span class="wpbs-ab-text-active">'.$title.'</span>';
    }
    $args['title'] = $display;
    $wp_admin_bar->add_node($args);
}


