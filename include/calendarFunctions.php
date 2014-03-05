<?php
function wpbs_print_legend_css($legend, $calendarID = null, $hoverCSS = true){
    echo "<style>";
    foreach(json_decode($legend,true) as $key => $value ){
        if(!empty($value["splitColor"])){
            
            echo ".wpbs-calendar-".$calendarID." .wpbs-day-split-top-" . $key . " {border-color: " . $value['color'] ." transparent transparent transparent; _border-color: " . $value['color'] ." #000000 #000000 #000000;}";
            echo ".wpbs-calendar-".$calendarID." .wpbs-day-split-bottom-" . $key . " {border-color: transparent transparent " . $value['splitColor'] ." transparent; _border-color:  #000000 #000000 " . $value['splitColor'] ." #000000;}";
        } else {
            echo ".wpbs-calendar-".$calendarID." .status-" . $key . " {background-color: " . $value['color'] ."}";
            echo ".wpbs-calendar-".$calendarID." .wpbs-day-split-top-" . $key . " {display:none;} ";
            echo ".wpbs-calendar-".$calendarID." .wpbs-day-split-bottom-" . $key . " {display:none;} ";
        }
    }
    
    $wpbsOptions = json_decode(get_option('wpbs-options'),true);
    
    echo ".status-wpbs-grey-out-history {background-color:".$wpbsOptions['historyColor']."}";
    echo ".status-wpbs-grey-out-history .wpbs-day-split-top, .status-wpbs-grey-out-history .wpbs-day-split-bottom {display:none;}";
    
    if($hoverCSS == true):
    
        echo "li.wpbs-bookable:hover, li.wpbs-bookable-clicked, li.wpbs-bookable-clicked:hover, li.wpbs-bookable-hover, li.wpbs-bookable-hover:hover {height:28px !important; width:28px !important; border: 1px solid ".$wpbsOptions['selectedBorder']." !important; background:".$wpbsOptions['selectedColor']." !important; cursor:pointer; line-height:28px !important; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; color:#fff !important; }";
        echo "li.wpbs-bookable:hover span {color:#fff !important;}";
        echo "li.wpbs-bookable-hover span.wpbs-day-split-bottom, li.wpbs-bookable-hover span.wpbs-day-split-top, li.wpbs-bookable-hover:hover span.wpbs-day-split-bottom, li.wpbs-bookable-hover:hover span.wpbs-day-split-top, li.wpbs-bookable:hover span.wpbs-day-split-top, li.wpbs-bookable:hover span.wpbs-day-split-bottom {display:none !important;}";
        echo "li.wpbs-bookable-clicked span, li.wpbs-bookable-clicked:hover span, li.wpbs-bookable-hover span, li.wpbs-bookable-hover:hover span {color:#ffffff !important;  }";
        echo "li.wpbs-bookable-clicked .wpbs-day-split-top, li.wpbs-bookable-clicked:hover .wpbs-day-split-top, li.wpbs-bookable-hover .wpbs-day-split-top, li.wpbs-bookable-hover:hover .wpbs-day-split-top {border-color:".$wpbsOptions['selectedColor']." !important;}";
        echo "li.wpbs-bookable-clicked .wpbs-day-split-bottom, li.wpbs-bookable-clicked:hover .wpbs-day-split-bottom, li.wpbs-bookable-hover .wpbs-day-split-bottom, li.wpbs-bookable-hover:hover .wpbs-day-split-bottom {border-color:".$wpbsOptions['selectedColor']." !important;}";
    endif;
    echo "</style>";
    
}

function wpbs_timeFormat($timestamp){
    $wpbsOptions = json_decode(get_option('wpbs-options'),true);
    return date($wpbsOptions['dateFormat'], $timestamp);
}

function wpbs_defaultCalendarLegend(){
    return get_option('wpbs-default-legend');
}

function wpbs_print_legend($legend,$language,$hideLegend = true){

    foreach(json_decode($legend,true) as $key => $value ):
        if(!(!empty($value['hide']) && $value['hide'] == 'hide') || $hideLegend == false){
           if(!empty($value['name'][$language])) $legendName = $value['name'][$language]; else $legendName = $value['name']['default'];
            echo '<span class="wpbs-legend-item"><span class="wpbs-legend-color status-' . $key . '">
                    <span class="wpbs-day-split-top wpbs-day-split-top-'.$key.'"></span>
                    <span class="wpbs-day-split-bottom wpbs-day-split-bottom-'.$key.'"></span>    
                </span><p>' . $legendName . '</p></span>'; 
        }
        
    endforeach;
}
function wpbs_get_admin_language(){
    $activeLanguages = json_decode(get_option('wpbs-languages'),true);
    if(array_key_exists(substr(get_bloginfo('language'),0,2),$activeLanguages)){
        return substr(get_bloginfo('language'),0,2);    
    }
    return 'en';
    
}

function wpbs_get_locale(){
    return substr(get_locale(),0,2);
}

function wpbs_check_if_bookable($legend,$calendarLegend,$y,$m,$d){
    $calendarLegend = json_decode($calendarLegend,true);
    if(!empty($calendarLegend[$legend]['bookable']) && $calendarLegend[$legend]['bookable'] == 'yes' && wpbs_days_passed($y,$m,$d))
        return "wpbs-bookable";
    return false;
}

function wpbs_days_passed($y,$m,$d){
    $day = (mktime(0,0,0,$m,$d,$y) - mktime(0,0,0,date('n'),date('j'),date('y'))) / 60 / 60 / 24;
    if($day >= 0)
        return $day + 1;
    return false;
}

function wpbs_check_range($int,$min,$max){
    return ($int > $min && $int < $max);
}

function wpbs_html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text{$i};
        $result .= $symbol;

        switch ($symbol)
        {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes)
                   $in_double_quotes = false;
               else
                   $in_double_quotes = true;

            break;

            case "'":
              if ($in_single_quotes)
                  $in_single_quotes = false;
              else
                  $in_single_quotes = true;

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}
