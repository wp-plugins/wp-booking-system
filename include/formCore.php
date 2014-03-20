<?php


function wpbs_display_form_field($field,$language,$error){
    
    $value = null; if(!empty($error['value'])) $value = $error['value']; 
    
    if(!empty($field['fieldLanguages'][$language])){
        $fieldName = esc_html($field['fieldLanguages'][$language]);
    } else {
        $fieldName =  esc_html($field['fieldName']);
    }
   
    
    
    $output = '<label class="wpbs-form-label';
        $output .= (!empty($error['error'])) ? " wpbs-form-error" : "";
    $output .= '" for="wpbs-field-'.$field['fieldId'].'">'. $fieldName;
        $output .= ($field['fieldRequired'] == 1) ? "*" : "";
    $output .= '</label>';
        
    switch($field['fieldType']){
        case 'text':            
            $output .= '<input class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" type="text" name="wpbs-field-'.$field['fieldId'].'" id="wpbs-field-'.$field['fieldId'].'" value="'.esc_html($value).'" />';
            break;
        case 'email':
            $output .= '<input class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" type="text" name="wpbs-field-'.$field['fieldId'].'" id="wpbs-field-'.$field['fieldId'].'" value="'.esc_html($value).'" />';
            break;
        case 'textarea':
            $output .= '<textarea class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" type="text" name="wpbs-field-'.$field['fieldId'].'" id="wpbs-field-'.$field['fieldId'].'">'.esc_html($value).'</textarea>';
            break;
        case 'checkbox':
            $options = explode('|',$field['fieldOptions']);
            $i = 0; foreach(array_filter($options) as $option){
                $checked = null;
                if(!empty($value) && in_array(esc_html(trim($option)),$value)) $checked = 'checked="checked"';
                $output .= '<label class="wpbs-form-label wpbs-form-label-checkbox" for="wpbs-field-'.$field['fieldId'].'-'.$i.'">';
                    $output .= '<input '.$checked.' class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" value="'.esc_html(trim($option)).'" type="checkbox" name="wpbs-field-'.$field['fieldId'].'[]" id="wpbs-field-'.$field['fieldId'].'-'.$i.'" />';
                $output .= esc_html(trim($option)).'</label>';
                $i++;
            }

            break;
        case 'radio':

            $options = explode('|',$field['fieldOptions']);
            $i = 0; foreach(array_filter($options) as $option){
                $checked = null;
                if(esc_html(trim($option)) == $value) $checked = 'checked="checked"';
                
                $output .= '<label class="wpbs-form-label wpbs-form-label-radio" for="wpbs-field-'.$field['fieldId'].'-'.$i.'">';
                    $output .= '<input '.$checked.' class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" value="'.esc_html(trim($option)).'" type="radio" name="wpbs-field-'.$field['fieldId'].'" id="wpbs-field-'.$field['fieldId'].'-'.$i.'" />';
                $output .= esc_html(trim($option)).'</label>';
                $i++;
            }
            break;
        case 'dropdown':
            $output .= '<select class="wpbs-form-field wpbs-form-field-'.$field['fieldType'].'" name="wpbs-field-'.$field['fieldId'].'" id="wpbs-field-'.$field['fieldId'].'" >';
            $options = explode('|',$field['fieldOptions']);
            foreach($options as $option){
                $selected = null;
                if($value == esc_html(trim($option))) $selected = 'selected="selected"';
                $output .= '<option '.$selected.' value="'.esc_html(trim($option)).'">'.esc_html(trim($option)).'</option>';
            }
            $output .= '</select>';
            break;
        default:
            $output .= "Error: Invalid Field Type";
    }
    return $output;
}

function wpbs_display_form($ID,$language = 'en',$errors = false, $calendarID){
    global $wpdb;
    $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_forms WHERE formID=%d',$ID);
    $form = $wpdb->get_row( $sql, ARRAY_A );
    $output = '';
    if(!empty($errors['noDates']) && $errors['noDates'] == true){
        $output .= '<div class="wpbs-form-item">';    
            $output .= '<label class="wpbs-form-label wpbs-form-error">Please select a date range.</label>';
        $output .= '</div>';
    } 
    if($wpdb->num_rows > 0):
        $formOptions = json_decode($form['formOptions'],true);      
        
         
        foreach(json_decode($form['formData'],true) as $field):
            $output .= '<div class="wpbs-form-item">';
                $error = null; if(!empty($errors[$field['fieldId']])) $error = $errors[$field['fieldId']];
                $output .= wpbs_display_form_field($field,$language,$error);
            $output .= '</div>';
        endforeach;
        $output .= '<input type="hidden" name="wpbs-form-id" value="'.$form["formID"].'" />';
        $output .= '<input type="hidden" name="wpbs-form-calendar-ID" value="'.$calendarID.'" />';
        $output .= '<input type="hidden" name="wpbs-form-language" value="'.$language.'" />';
        $output .= '<input type="hidden" name="wpbs-form-start-date" class="wpbs-start-date" value="'.$errors['startDate'].'" />';
        $output .= '<input type="hidden" name="wpbs-form-end-date" class="wpbs-end-date" value="'.$errors['endDate'].'" />';
        $output .= '<div class="wpbs-form-item">';
            if(!empty($formOptions['submitLabel'][$language]))
                $submitLabel = esc_html($formOptions['submitLabel'][$language]);
            else
                $submitLabel = esc_html($formOptions['submitLabel']['default']);                
            $output .= '<input type="button" name="wpbs-form-submit" value="'.$submitLabel.'" class="wpbs-form-submit" />';
            $output .= '<div class="wpbs-form-loading"><img src="'.WPBS_PATH.'/images/ajax-loader.gif" /></div>';
        $output .= '</div>';
        return $output;
    else:
        return 'WP Booking System: Invalid form ID.';
    endif;
    
}
function wpbs_edit_form($options = array()){
    $default_options = array('formData' => '{}');
    foreach($default_options as $key => $value){
        if(empty($$key))
            $$key = $value;
    }    
    extract($options);
    
    $activeLanguages = json_decode(get_option('wpbs-languages'),true);
    
    if(empty($formData)) $formData = "{}";
    
    echo '<div id="wpbs-form-container">';
        $i = 1; foreach(json_decode($formData,true) as $field):
            $fieldTypeFancy = str_replace(array('text','email','textarea','checkbox','radio','dropdown'),array('Text','Email','Textarea','Checkboxes','Radio Buttons','Dropdown'),$field['fieldType']);
            echo '<div class="wpbs-form-field wpbs-form-field-'. $field['fieldId'] .'" data-order="'. $i++ .'" id="wpbs-form-field-'. $field['fieldId'] .'">';
            echo     '<a href="#" class="wpbs-form-move" title="Move"><!-- --></a>';
            echo     '<a href="#" class="wpbs-form-delete" title="Delete"><!-- --></a>';
            
            echo     '<span class="wpbs-field-name">'.$field['fieldName'].'&nbsp;</span><span class="wpbs-field-type">'.$fieldTypeFancy.'</span>';
            
            echo     '<div class="wpbs-field-options" style="display:none;">';
            echo         '<p><label>Title</label><input type="text" name="fieldName" class="fieldName" value="'.esc_html($field['fieldName']).'"></p>';
            echo         '<p><label>Type</label><select class="fieldType" name="fieldType">
                            <option'; if($field["fieldType"] == 'text') echo " selected='selected'";  echo' value="text">Text</option>
                            <option'; if($field["fieldType"] == 'email') echo " selected='selected'";  echo' value="email">Email</option>
                            <option'; if($field["fieldType"] == 'textarea') echo " selected='selected'";  echo' value="textarea">Textarea</option>
                            <option'; if($field["fieldType"] == 'checkbox') echo " selected='selected'";  echo' value="checkbox">Checkboxes</option>
                            <option'; if($field["fieldType"] == 'radio') echo " selected='selected'";  echo' value="radio">Radio Buttons</option>
                            <option'; if($field["fieldType"] == 'dropdown') echo " selected='selected'";  echo' value="dropdown">Dropdown</option>
                         </select></p>';
            
            echo         '<p style="'; if(!($field["fieldType"] == 'dropdown' || $field["fieldType"] == 'radio' || $field["fieldType"] == 'checkbox')) echo "display:none";  echo'" class="fieldOptionsContainer"><label>Options</label><input type="text" value="'.esc_html($field['fieldOptions']).'" name="fieldOptions" class="fieldOptions"><small><em>Separate values with an | (eg. Option 1|Option 2|Option 3)</em></small></p>';
            echo         '<p><label>Required</label><input'; if($field["fieldRequired"] == 'true') echo " checked='checked'";  echo' type="checkbox" name="fieldRequired" class="fieldRequired"></p>';
            echo         '<div class="wpbs-form-line"><!-- --></div>';
            foreach ($activeLanguages as $code => $language) {
            echo         '<p><label>'.$language.'</label><input type="text" name="'.$code.'" value="'.esc_html($field["fieldLanguages"][$code]).'" class="languageField languageField-'.$code.'"></p>';
            }
            echo     '</div>';
            echo '</div>';
        endforeach;
    echo '</div>';
    
    echo '<input type="button" id="add-field" value="Add New Field" class="button button-secondary">';
    
        
    echo "<input type='hidden' id='wpbs-form-json' name='formData' value='".$formData."' />";
    
    echo '<script>';    
    foreach($activeLanguages as $code => $language):
        echo "activeLanguages['".$code."'] = '".$language."';";                     
    endforeach;
    echo '</script>';  
}