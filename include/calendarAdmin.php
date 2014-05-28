<?php
function wpbs_replaceCustom($str){
    return str_replace( 
        array(
            '--AMP--',
            '--DOUBLEQUOTE--',
            '--QUOTE--',
            '--LT--',
            '--GT--'
        ),
        array(
            '&',
            '"',
            "'",
            '<',
            '>'
        ),
        $str );
}
function wpbs_edit_dates($options){
    
    foreach($options as $key => $value){
        if(empty($$key))
            $$key = $value;
    }
    
    if(!empty($customRange) && $customRange == true){
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        
        $output = "<div class='edit-dates-popup'>";
            $output .= "<h3>".date('F Y',$startDate)."</h3>";
            $output .= '<div class="wpbs-dates-editor wp-dates-editor-popup"><ul>';
            
            $currentMonth = date('F',$startDate);
            for($i=$startDate;$i<=$endDate;$i=$i + 60*60*24):
                if($currentMonth != date('F',$i)){
                    $currentMonth = date('F',$i);
                    $output .= "</ul></div><div class='wpbs-clear'></div><h3>".date('F Y',$i)."</h3><div class='wpbs-dates-editor'><ul>";
                }
                $output .= wpbs_edit_date($calendarData,$calendarLegend,date('j',$i),$i,$calendarLanguage);
            endfor;
            $output .= "</ul></div>";   
        $output .= "</div>";
        
        $output .= "<div class='bulk-edit-dates-popup'>";
            $output .= "<h3>Bulk Edit Dates</h3>";
            $output .= "<div class='bulk-edit-dates-popup-container'>";
                $output .= '<select class="bulk-edit-legend-select">';
                foreach(json_decode($calendarLegend,true) as $key => $value ): $selected = null;
                    if(!empty($value['name'][$calendarLanguage])) $legendName = $value['name'][$calendarLanguage]; else $legendName = $value['name']['default'];
                    if(!empty($status) && $status == $key) $selected = ' selected="selected"';
                    $output .= '<option class="wpbs-option-'.$key.'" value="' . $key . '"' . $selected . '>' . $legendName . '</option>';
                endforeach;
                $output .= "</select>";
                
                $output .= "<input type='text' class='bulk-edit-legend-text'>";
                
                $output .= "<input type='button' class='button button-secondary bulk-edit-legend-apply' value='Apply Changes' />";
            $output .= "</div>";
        $output .= "</div>";
        
    } else {
        $output = '<div class="wpbs-dates-editor"><ul>';
        for($i=1;$i<=date('t',$currentTimestamp);$i++):
            $output .= wpbs_edit_date($calendarData,$calendarLegend,$i,$currentTimestamp,$calendarLanguage);
        endfor;
        $output .= "</ul></div>";     
        $output .= "<input type='hidden' name='wpbsCalendarData' id='inputCalendarData' value='".$calendarData."' />";
        $output .= "<input type='hidden' id='wpbs_booking_action' name='wpbs_booking_action' />";
        $output .= "<input type='hidden' id='wpbs_booking_id' name='wpbs_booking_id' />";   
    }
    
    return $output;
    
    
}

function wpbs_edit_date($calendarData,$legend,$day,$timestamp,$language){
    $calendarData = json_decode($calendarData,true);
    $status = 'default';
    if(!empty($calendarData[date('Y',$timestamp)][date('n',$timestamp)][$day]))
        $status = $calendarData[date('Y',$timestamp)][date('n',$timestamp)][$day];
    $description = '';   
    if(!empty($calendarData[date('Y',$timestamp)][date('n',$timestamp)]["description-" . $day]))
        $description = $calendarData[date('Y',$timestamp)][date('n',$timestamp)]["description-" . $day]; 
        
    $output = '<li>';
        $output .= '<span class="wpbs-select-status status-'.$status.'">';
            $output .= '<span class="wpbs-day-split-top wpbs-day-split-top-'.$status.'"></span>';
            $output .= '<span class="wpbs-day-split-bottom wpbs-day-split-bottom-'.$status.'"></span>';    
            $output .= '<span class="wpbs-day-split-day">'.$day.'</span>';
        $output .= '</span>';
        
        $output .= '<select class="wpbs-day-select wpbs-day-'.$day.'" data-name="wpbs-day-'.$day.'" data-year="wpbs-year-'.date('Y',$timestamp).'" data-month="wpbs-month-'.date('n',$timestamp).'">';
        foreach(json_decode($legend,true) as $key => $value ): $selected = null;
            if(!empty($value['name'][$language])) $legendName = $value['name'][$language]; else $legendName = $value['name']['default'];
            if(!empty($status) && $status == $key) $selected = ' selected="selected"';
            $output .= '<option class="wpbs-option-'.$key.'" value="' . $key . '"' . $selected . '>' . $legendName . '</option>';
        endforeach;
        $output .= "</select>";
        $output .= '<input class="wpbs-input-description" type="text" value="'. htmlentities(wpbs_replaceCustom(stripslashes($description)),ENT_QUOTES,'UTF-8').'" data-name="wpbs-day-'.$day.'" data-year="wpbs-year-'.date('Y',$timestamp).'" data-month="wpbs-month-'.date('n',$timestamp).'" />';
    $output .= "</li>";
    
    return $output;
}

function wpbs_edit_legend($calendarLegend,$showEdit, $calendarID){
    ob_start();
    ?>
    <div class="wpbs-calendar-legend-container">
        <?php echo wpbs_print_legend($calendarLegend,wpbs_get_admin_language(),false);?>
        <a class="button button-secondary" href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=full-version');?>">Edit Legend</a>
    </div>
    <?php
    $output = ob_get_contents();
    ob_clean();
    return $output;
}

function wpbs_batch_update($calendarLegend){
    return false;
}
