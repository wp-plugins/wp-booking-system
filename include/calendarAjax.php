<?php
function changeDayAdmin_callback() {
    global $showDateEditor;
    $showDateEditor = true;
    changeDay_callback();
    die();
}
function changeDay_callback() {
    global $showDateEditor;
    if(in_array($_POST['showDropdown'],array(0,1))) $showDropdown = $_POST['showDropdown']; else $showDropdown = 1;
    if(in_array($_POST['totalCalendars'],array(1,2,3,4,5,6,7,8,9,10,11,12))) $totalCalendars = $_POST['totalCalendars']; else $totalCalendars = 1;
    if(in_array($_POST['weekStart'],array(1,2,3,4,5,6,7))) $firstDayOfWeek = $_POST['weekStart']; else $firstDayOfWeek = 1;
    
    if(!empty($_POST['currentTimestamp'])) $currentTimestamp = $_POST['currentTimestamp'];
    if(!empty($_POST['calendarData'])) $calendarData = $_POST['calendarData'];
    if(!empty($_POST['calendarLegend'])) $calendarLegend = $_POST['calendarLegend'];
    if(!empty($_POST['calendarHistory'])) $calendarHistory = $_POST['calendarHistory'];
    if(!empty($_POST['calendarID'])) $calendarID = $_POST['calendarID'];
    
    $calendarSelection = ''; if(!empty($_POST['calendarSelection'])) $calendarSelection = $_POST['calendarSelection'];
    
    
    
    if(!empty($_POST['calendarLanguage'])) $calendarLanguage = $_POST['calendarLanguage'];
    if(!empty($_POST['weekStart'])) $firstDayOfWeek = $_POST['weekStart'];
    
    
    $currentTimestamp = intval($currentTimestamp);    
    //hack $currentTimestamp to be the middle of the month.
    $currentTimestamp = strtotime("15 " . date(' F Y',$currentTimestamp));
    
    if(!empty($_POST['calendarDirection']) && $_POST['calendarDirection'] == 'next'){
        $currentTimestamp = strtotime(date('j F Y',$currentTimestamp) . " + 1 month");
    } elseif(!empty($_POST['calendarDirection']) && $_POST['calendarDirection'] == 'prev'){
        $currentTimestamp = strtotime(date('j F Y',$currentTimestamp) . " - 1 month");
    }


    echo wpbs_calendar(array('ajaxCall' => true, 'calendarLanguage' => $calendarLanguage, 'calendarHistory' => $calendarHistory, 'showDateEditor' => $showDateEditor, 'calendarID' => $calendarID, 'calendarData' => stripslashes($calendarData), 'currentTimestamp' => $currentTimestamp, 'showDropdown' => $showDropdown, 'totalCalendars' => $totalCalendars, 'firstDayOfWeek' => $firstDayOfWeek, 'calendarLegend' => stripslashes($calendarLegend), 'calendarSelection' => $calendarSelection));
    
	die(); 
}
