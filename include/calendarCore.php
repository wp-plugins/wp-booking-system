<?php
/**
 * This function prepares the calendar
 */
function wpbs_calendar($options = array()){
    
    $default_options = array('ajaxCall' => false, 'monthToShow' => null, 'yearToShow' => null, 'currentCalendar' => 1, 'totalCalendars' => 1 , 'firstDayOfWeek' => 1, 'showDropdown' => 1, 'calendarLanguage' => 'en', 'calendarData' => null, 'currentTimestamp' => mktime(0, 0, 0, gmdate('n') , 15, gmdate('Y')),'calendarLegend' => false, 'calendarID' => false, 'formID' => false, 'showDateEditor' => false, 'showLegend' => false, 'calendarSelection' => '', 'calendarHistory' => 1);
   
    
    foreach($default_options as $key => $value){
        if(empty($$key))
            $$key = $value;
    }
    
    extract($options);  

    if($ajaxCall == false):    
        echo '<div class="wpbs-container wpbs-calendar-'.$calendarID.'">';
        echo '<div class="wpbs-calendars">';
    endif;
    
    if($showDateEditor == true){
        wpbs_edit_dates( array( 'calendarData' => $calendarData, 'calendarLegend' => $calendarLegend, 'currentTimestamp' => $currentTimestamp, 'calendarLanguage' => ($showDateEditor) ? wpbs_get_admin_language() : $calendarLanguage ) ) ;
        
    }
          
   
    $calendarTimestamp = mktime(0, 0, 0, gmdate('n',$currentTimestamp), 1, gmdate('Y',$currentTimestamp));    
    $displayMonth = gmdate('n', $calendarTimestamp);
    $displayYear = gmdate('Y', $calendarTimestamp);
    showCalendar(array('monthToShow' => $displayMonth, 'yearToShow' => $displayYear, 'currentCalendar' => 1, 'totalCalendars' => $totalCalendars , 'firstDayOfWeek' => ($firstDayOfWeek == 7) ? 0 : $firstDayOfWeek, 'calendarLanguage' => ($showDateEditor) ? wpbs_get_admin_language() : $calendarLanguage , 'showDropdown' => $showDropdown, 'calendarData' => $calendarData, 'calendarID' => $calendarID, 'calendarLegend' => $calendarLegend, 'calendarSelection' => $calendarSelection, 'calendarHistory' => $calendarHistory));

    
    if($showDateEditor == true){
        wpbs_edit_legend($calendarLegend, true, $calendarID);
        wpbs_batch_update($calendarLegend);
        
    }
    
    if($showDateEditor != true){
        $calendarData = json_decode($calendarData,true);
        foreach($calendarData as $year => $months){
            foreach($months as $month => $days){
                foreach($days as $day => $status){
                    if (strpos($day,'description') !== false) {
                        unset( $calendarData[$year][$month][$day] );
                    }
                }
            }
        }
        $calendarData = json_encode($calendarData);
    }
    
    echo "<div class='wpbs-clear'></div>";
    
    echo '<div class="wpbs-calendar-options">';
    echo '    <div class="wpbs-show-dropdown">' . $showDropdown . '</div>'; 
    echo '    <div class="wpbs-current-timestamp">' . $currentTimestamp . '</div>'; 
    echo '    <div class="wpbs-total-calendars">' . $totalCalendars . '</div>';
    echo '    <div class="wpbs-calendar-data">' . html_entity_decode( $calendarData ) . '</div>';
    echo '    <div class="wpbs-calendar-legend">' . html_entity_decode( $calendarLegend ) . '</div>';
    echo '    <div class="wpbs-calendar-history">' . $calendarHistory . '</div>';
    echo '    <div class="wpbs-calendar-language">' . $calendarLanguage . '</div>';
    echo '    <div class="wpbs-calendar-week-start">' . $firstDayOfWeek . '</div>';
    echo '    <div class="wpbs-calendar-ID">' . $calendarID . '</div>';
    echo '    <div class="wpbs-calendar-selection">'.$calendarSelection.'</div>';
    echo '</div>';
    
     
    
    
    if($ajaxCall == false): 
        
        echo '</div>';
        
        if($showLegend == 'yes'){
            echo '<div class="wpbs-legend">';
                wpbs_print_legend($calendarLegend,$calendarLanguage);  
            echo '<div class="wpbs-clear"><!-- --></div></div>';   
        }
        if($showDateEditor == false){
            echo '<div class="wpbs-form"><form class="wpbs-form-form">';
                wpbs_display_form($formID,$calendarLanguage,false,$calendarID);
            echo '<div class="wpbs-clear"><!-- --></div></form></div>';
        }
        
        echo '</div><div class="wpbs-clear"></div>';
        
    endif;
}
/**
 * This function is displays the calendar with the parameters given from the previous function
 */
function showCalendar($options = array())
{   
    
    
    foreach($options as $key => $value){
            $$key = $value;
    }   
        
    $calendarData = json_decode($calendarData,true);
    
    if (($monthToShow === null) or ($yearToShow === null)) {
        $today = getdate();
        $monthToShow = $today['mon'];
        $yearToShow = $today['year'];
    } else {
        $today = getdate(mktime(0, 0, 0, $monthToShow, 1, $yearToShow));
    }
    
    $calendarSelection = explode('-',$calendarSelection);
    $selectionStart = (!empty($calendarSelection[0])) ?  $calendarSelection[0] : 0;
    $selectionEnd = (!empty($calendarSelection[1])) ?  $calendarSelection[1] : 0;
    $goingBackwards = false;
    if($selectionStart != 0 && $selectionEnd !=0 && $selectionStart > $selectionEnd){
        $temp = $selectionStart;
        $selectionStart = $selectionEnd;
        $selectionEnd = $temp;
        $goingBackwards = true;
    } 
    
    
    $notBookable = false;
    
    // get first and last days of the month
    $firstDay = getdate(mktime(0, 0, 0, $monthToShow, 1, $yearToShow));
    $lastDay = getdate(mktime(0, 0, 0, $monthToShow + 1, 0, $yearToShow)); //trick! day = 0

    // Create a table with the necessary header information
    echo '<div class="wpbs-calendar">';
    echo '<div class="wpbs-heading">';
    if($currentCalendar == 1){
        echo '<a href="#" class="wpbs-prev"><img src="'.WPBS_PATH.'/images/arrow-left.png" /></a>';
        if($showDropdown == true){
            echo '<div class="wpbs-select-container"><select class="wpbs-dropdown">';
                for($d=0;$d<12;$d++){
                    echo '<option value="' . mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow) . '">' . wpbsMonth(gmdate('F',mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow)), $calendarLanguage) . " " . gmdate('Y',mktime(0, 0, 0, $monthToShow + $d, 15, $yearToShow)) . '</option>';
                }
            echo '</select></div>';
        } else {
            echo wpbsMonth($today['month'],$calendarLanguage) . " " . $today['year'];
        }
    } else {
        echo "<span>" . wpbsMonth($today['month'],$calendarLanguage) . " " . $today['year'] . "</span>";    
    }        
    
    if($currentCalendar == $totalCalendars)
        echo '<a href="#" class="wpbs-next"><img src="'.WPBS_PATH.'/images/arrow-right.png" /></a>';
    echo "</div>";

    echo '<ul class="wpbs-weekdays">';
    
    $dayText = wpbsDoW($calendarLanguage);
    for ($i = 0; $i < 7; $i++) { // put 7 days in header, starting at appropriate day ($firstDayOfWeek)
        echo '<li>' . $dayText[$firstDayOfWeek + $i] . '</li>';
    }
    echo '</ul>';
    
    echo '<ul>';
    // Display the first calendar row with correct start of week
    if ($firstDayOfWeek <= $firstDay['wday']) {
        $blanks = $firstDay['wday'] - $firstDayOfWeek;
    } else {
        $blanks = $firstDay['wday'] - $firstDayOfWeek + 7;
    }
    for ($i = 1; $i <= $blanks; $i++) {
        echo '<li class="wpbs-pad"><!-- --></li>';
    }
    
    $actday = 0; // used to count and represent each day
    // Note: loop below starts using the residual value of $i from loop above
    for ( /* use value of $i resulting from last loop*/; $i <= 7; $i++) {
        
        if(!empty($calendarData[$yearToShow][$monthToShow][++$actday]))
            $status = $calendarData[$yearToShow][$monthToShow][$actday];
        else 
            $status = 'default';
            
        
        $dataOrder = wpbs_days_passed($yearToShow,$monthToShow,$actday);
        $dataTimestamp = mktime(0,0,0,$monthToShow,$actday,$yearToShow);    
            
        //handle past dates    
        if($dataTimestamp + (60*60*24) < time()  && $calendarHistory != 1){
            if($calendarHistory == 2) $status = 'default'; //show default
            if($calendarHistory == 3) $status = 'wpbs-grey-out-history'; //grey-out
        }  
        
        
        $selectedClass = ''; if(wpbs_check_range($dataTimestamp, $selectionStart, $selectionEnd)) $selectedClass = 'wpbs-bookable-hover';
        elseif($dataTimestamp == $selectionStart || $dataTimestamp == $selectionEnd) $selectedClass = 'wpbs-bookable-clicked';
        
        if($actday == 1 && $currentCalendar == 1 && $dataTimestamp > $selectionStart && $selectionStart != 0 && $selectionEnd == 0 && $goingBackwards == false){
            $selectedClass = 'wpbs-bookable-clicked';
        }

        if($dataTimestamp > $selectionStart && $selectionStart != 0 && $selectionEnd == 0){
            for($c = $selectionStart; $c <= $dataTimestamp; $c = $c + 60*60*24){
                if(!empty($calendarData[date('Y',$c)][date('n',$c)][date('j',$c)]))
                    $searchStatus = $calendarData[date('Y',$c)][date('n',$c)][date('j',$c)];
                else 
                    $searchStatus = 'default';
                if(wpbs_check_if_bookable($searchStatus,$calendarLegend,date('Y',$c),date('n',$c),date('j',$c)) != 'wpbs-bookable')
                    $notBookable = true;
            }
        }

        
        
        $bookableClass = wpbs_check_if_bookable($status,$calendarLegend,$yearToShow,$monthToShow,$actday);
        if($notBookable == true){
            $selectedClass = '';
            $bookableClass = 'wpbs-not-bookable';
        }
        if($selectionStart != 0 && $selectionStart < $dataTimestamp && $selectionStart > $dataTimestamp &&  $bookableClass != '' && $selectionEnd == 0 ) $bookableClass = 'wpbs-not-bookable';
        
        echo '<li data-timestamp="'.$dataTimestamp.'" data-order="'.$dataOrder.'" class="'.$bookableClass.' wpbs-bookable-'.$dataOrder.' wpbs-day wpbs-day-'.$actday.' status-' . $status .  ' '.$selectedClass.' ">';
        echo '<span class="wpbs-day-split-top wpbs-day-split-top-'.$status.'"></span>';
        echo '<span class="wpbs-day-split-bottom wpbs-day-split-bottom-'.$status.'"></span>';    
        echo '<span class="wpbs-day-split-day">'.$actday.'</span></li>';    
    
        
        
    }
    echo '</ul>';

    // Get how many complete weeks are in the actual month
    $fullWeeks = floor(($lastDay['mday'] - $actday) / 7);
    for ($i = 0; $i < $fullWeeks; $i++) {
        echo '<ul>';
        for ($j = 0; $j < 7; $j++) {
            if(!empty($calendarData[$yearToShow][$monthToShow][++$actday]))
                $status = $calendarData[$yearToShow][$monthToShow][$actday];
            else 
                $status = 'default';
                
                
            $dataOrder = wpbs_days_passed($yearToShow,$monthToShow,$actday);
            $dataTimestamp = mktime(0,0,0,$monthToShow,$actday,$yearToShow);
            //handle past dates    
            if($dataTimestamp + (60*60*24) < time()  && $calendarHistory != 1){
                if($calendarHistory == 2) $status = 'default'; //show default
                if($calendarHistory == 3) $status = 'wpbs-grey-out-history'; //grey-out   
            }
            
            
            $selectedClass = '';
            if(wpbs_check_range($dataTimestamp, $selectionStart, $selectionEnd)) $selectedClass = 'wpbs-bookable-hover';
            elseif($dataTimestamp == $selectionStart || $dataTimestamp == $selectionEnd) $selectedClass = 'wpbs-bookable-clicked';
            
            $bookableClass = wpbs_check_if_bookable($status,$calendarLegend,$yearToShow,$monthToShow,$actday);
            if($notBookable == true){
                $selectedClass = '';
                $bookableClass = 'wpbs-not-bookable';
            }
            if($selectionStart != 0 && $selectionStart < $dataTimestamp && $selectionStart > $dataTimestamp  && $bookableClass != '' && $selectionEnd == 0 ) $bookableClass = 'wpbs-not-bookable';
            
            echo '<li data-timestamp="'.$dataTimestamp.'" data-order="'.$dataOrder.'" class="'.$bookableClass.' wpbs-bookable-'.$dataOrder.' wpbs-day wpbs-day-'.$actday.' status-' . $status .  ' '.$selectedClass.' ">';
            echo '<span class="wpbs-day-split-top wpbs-day-split-top-'.$status.'"></span>';
            echo '<span class="wpbs-day-split-bottom wpbs-day-split-bottom-'.$status.'"></span>';    
            echo '<span class="wpbs-day-split-day">'.$actday.'</span></li>';    
        }
        echo '</ul>';
    }

    //Now display the partial last week of the month (if there is one)
    if ($actday < $lastDay['mday']) {
        echo '<ul>';
        $actday++;
        for ($i = 0; $i < 7; $i++) {
            if ($actday <= $lastDay['mday']) {
            if(!empty($calendarData[$yearToShow][$monthToShow][$actday]))
                $status = $calendarData[$yearToShow][$monthToShow][$actday];
            else 
                $status = 'default';
                
            $dataOrder = wpbs_days_passed($yearToShow,$monthToShow,$actday);
            $dataTimestamp = mktime(0,0,0,$monthToShow,$actday,$yearToShow);
            
            //handle past dates    
            if($dataTimestamp + (60*60*24) < time()  && $calendarHistory != 1){
                if($calendarHistory == 2) $status = 'default'; //show default
                if($calendarHistory == 3) $status = 'wpbs-grey-out-history'; //grey-out    
            }
                       
            
            $selectedClass = ''; 
            if(wpbs_check_range($dataTimestamp, $selectionStart, $selectionEnd)) $selectedClass = 'wpbs-bookable-hover';
            elseif($dataTimestamp == $selectionStart || $dataTimestamp == $selectionEnd) $selectedClass = 'wpbs-bookable-clicked';
            
            if($actday == date('t',$dataTimestamp) && $currentCalendar == 2 && $dataTimestamp < $selectionStart && $selectionStart != 0 && $selectionEnd == 0){
            $selectedClass = 'wpbs-bookable-clicked';
        }
            
            
            $bookableClass = wpbs_check_if_bookable($status,$calendarLegend,$yearToShow,$monthToShow,$actday);
            if($notBookable == true){
                $selectedClass = '';
                $bookableClass = 'wpbs-not-bookable';
            }
            if($selectionStart != 0 && $selectionStart < $dataTimestamp && $selectionStart > $dataTimestamp  && $bookableClass != '' && $selectionEnd == 0 ) $bookableClass = 'wpbs-not-bookable';
            
            
            echo '<li data-timestamp="'.$dataTimestamp.'" data-order="'.$dataOrder.'" class="'.$bookableClass.' wpbs-bookable-'.$dataOrder.' wpbs-day wpbs-day-'.$actday.' status-' . $status .  ' '.$selectedClass.' ">';
            echo '<span class="wpbs-day-split-top wpbs-day-split-top-'.$status.'"></span>';
            echo '<span class="wpbs-day-split-bottom wpbs-day-split-bottom-'.$status.'"></span>';    
            echo '<span class="wpbs-day-split-day">'.$actday++.'</span></li>';    
            } else {
                echo '<li class="wpbs-pad"><!-- --></li>';
            }
        }
        echo '</ul>';
    }
    echo '<div class="wpbs-loading"><img src="'.WPBS_PATH.'/images/ajax-loader.gif" /></div></div>';
}