<?php

function wpbs_submitForm_callback() {
    
    global $wpdb;
    $error = null;
    $submitForm = true;
    $formID = $_POST['wpbs-form-id'];
    $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_forms WHERE formID=%d',$formID);
    $form = $wpdb->get_row( $sql, ARRAY_A );
    if(count($form) > 0): 
        $fields = json_decode($form['formData'],true); 
        if(!empty($fields)) foreach($fields as $field):
            //backup form data in case of error
            if(!empty($_POST['wpbs-field-' . $field['fieldId']]))
                $error[$field['fieldId']]['value'] = $_POST['wpbs-field-' . $field['fieldId']];
            
            
            
            if($field['fieldRequired'] == 1 && !is_array(@$_POST['wpbs-field-' . $field['fieldId']]) && esc_html(trim(@$_POST['wpbs-field-' . $field['fieldId']])) === '' ){
                $error[$field['fieldId']]['error'] = true;
                $submitForm = false;
            }    
            if($field['fieldType'] == 'email' && !empty($_POST['wpbs-field-' . $field['fieldId']])){
                if(is_email($_POST['wpbs-field-' . $field['fieldId']]) == false){
                    $error[$field['fieldId']]['error'] = true;
                    $submitForm = false;    
                }
            }                          
        endforeach;
        
        $error['startDate'] = (!empty($_POST['wpbs-form-start-date'])) ? $_POST['wpbs-form-start-date'] : false;
        $error['endDate'] = (!empty($_POST['wpbs-form-end-date'])) ? $_POST['wpbs-form-end-date'] : false;        
        
        if(!(!empty($_POST['wpbs-form-start-date']) && !empty($_POST['wpbs-form-end-date']))){
            $error['noDates'] = true;
            
            $error['startDate'] = $_POST['wpbs-form-start-date'];
            $submitForm = false;
        };
        
    else:
        return __("WP Booking System: Invalid form ID.",'wpbs');
    endif;
    
    if($submitForm != true){
        echo wpbs_display_form($formID,esc_html($_POST['wpbs-form-language']),$error,esc_html($_POST['wpbs-form-calendar-ID']));
    } else {
        $formOptions = json_decode($form['formOptions'],true);
        echo "<p>".$formOptions['confirmationMessage']."</p>";
        echo '<script>wpbs_clear_selection();</script>';
        //prepare form data
        $bookingData = null;
        if(count($form) > 0):  
            $fields = json_decode($form['formData'],true);
            if(!empty($fields)) foreach($fields as $field):
                @$bookingData[$field['fieldName']] = $_POST['wpbs-field-' . $field['fieldId']];
            endforeach;
        endif;
        //insert data into db
        if($_POST['wpbs-form-start-date'] > $_POST['wpbs-form-end-date']){
            $temp = $_POST['wpbs-form-start-date'];
            $_POST['wpbs-form-start-date'] = $_POST['wpbs-form-end-date'];
            $_POST['wpbs-form-end-date'] = $temp;
        } 
        
        $wpdb->insert( $wpdb->prefix.'bs_bookings', array('calendarID' => $_POST['wpbs-form-calendar-ID'], 'formID' => $_POST['wpbs-form-id'], 'startDate' => $_POST['wpbs-form-start-date'], 'endDate' => $_POST['wpbs-form-end-date'], 'createdDate' => time(), 'bookingData' => json_encode($bookingData), 'bookingStatus' => 'pending'));
        $bookingID = $wpdb->insert_id;
        
        $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_calendars WHERE calendarID=%d',$_POST['wpbs-form-calendar-ID']);
        $calendar = $wpdb->get_row( $sql, ARRAY_A );
        
        
        //send email
        $to = $formOptions['sendTo'];
        $subject = "New booking";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: '.get_option('blogname').' <'.get_option('admin_email').'>' . "\r\n";
        
        $message  = 'A new booking is made via your website!';
        $message .= '<br /><br />';
        
        $message .= '<strong>Website: </strong>' . get_bloginfo('url') . '<br />';
        $message .= '<strong>Calendar: </strong>' . $calendar['calendarTitle'] . ' (ID: '.$_POST['wpbs-form-calendar-ID'].')<br />';
        $message .= '<strong>Booking ID: </strong>' . $bookingID . '<br /><br />';
        
        $message .= '<strong>Check-in: </strong>' . wpbs_timeFormat($_POST['wpbs-form-start-date']) . '<br />';
        $message .= '<strong>Check-out: </strong>' . wpbs_timeFormat($_POST['wpbs-form-end-date']) . '<br /><br />';
        
        
        if(!empty($bookingData)) foreach($bookingData as $formField => $formValue){
            if(!is_array($formValue))
                $message .= '<strong>'.$formField.': </strong> '.$formValue.'<br />';
            else
                $message .= '<strong>'.$formField.': </strong> '.implode(', ',$formValue).'<br />';
        }        
        $message .= "<br />Powered by WP Booking System<br />";
        wp_mail($to, $subject, $message, $headers);
        
    }
        
    
	die(); 
}
