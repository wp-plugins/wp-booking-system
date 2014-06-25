<?php
global $wpdb;

if(!empty($_POST['formID'])){
    $wpdb->update( $wpdb->prefix.'bs_forms', array('formTitle' => $_POST['formTitle'], 'formData' => stripslashes($_POST['formData'])), array('formID' => $_POST['formID']) );     
    $formID = $_POST['formID'];
} else {
    $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_forms'; 
    $wpdb->get_results( $sql, ARRAY_A ); 
    if($wpdb->num_rows > 0) wp_die();
    
    $wpdb->insert( $wpdb->prefix.'bs_forms', array('formTitle' => $_POST['formTitle'], 'formData' => stripslashes($_POST['formData'])));
    $formID = $wpdb->insert_id;     
}

$emails = '';
if(!empty($_POST['receive_emails']) && $_POST['receive_emails'] == 'yes' && !empty($_POST['sendto'])){
    $emails = explode(",",$_POST['sendto']);
    foreach($emails as $email){
        if(is_email($email))
            $emailList[] = sanitize_email($email);
    }
    $emails = implode(",",$emailList);
}

$formOptions['sendTo'] = $emails;
$formOptions['confirmationMessage'] = esc_html(trim($_POST['confirmation']));
$formOptions['submitLabel']['default'] = esc_html(trim($_POST['submitLabel']));
$activeLanguages = json_decode(get_option('wpbs-languages'),true); foreach ($activeLanguages as $code => $language){
    $formOptions['submitLabel'][$code] = esc_html(trim($_POST['submitLabel_' . $code]));
}

if(empty($formOptions['confirmationMessage'])) $formOptions['confirmationMessage'] = "The form was successfully submitted.";
if(empty($formOptions['submitLabel']['default'])) $formOptions['submitLabel']['default'] = "Book";

$wpdb->update( $wpdb->prefix.'bs_forms', array('formOptions' => json_encode($formOptions)), array('formID' => $formID) );   

wp_redirect(admin_url('admin.php?page=wp-booking-system-forms&do=edit-form&id='.$formID.'&save=ok'));
die();
?>