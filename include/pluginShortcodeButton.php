<?php
add_action('media_buttons', 'wpbs_add_form_button', 20);
function wpbs_add_form_button(){
    $is_post_edit_page = in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'));
    if(!$is_post_edit_page)
        return;

    // do a version check for the new 3.5 UI
    $version = get_bloginfo('version');

    if ($version < 3.5) {
        // show button for v 3.4 and below
        $image_btn =  WPBS_PATH.'/images/date-button.gif';
        echo '<a href="#TB_inline?width=480&inlineId=wpbs_add_calendar" class="thickbox" id="add_wpbs" title="' . __("Add Gravity Form", 'wpbs') . '"><img src="'.$image_btn.'" alt="' . __("Add Calendar", 'wpbs') . '" /></a>';
    } else {
        // display button matching new UI
        echo '<style>.wpbs_media_icon{
                background:url('.WPBS_PATH.'/images/date-button.gif) no-repeat top left;
                display: inline-block;
                height: 16px;
                margin: 0 2px 0 0;
                vertical-align: text-top;
                width: 16px;
                }
                .wp-core-ui a.wpbs_media_link{
                 padding-left: 0.4em;
                }
                #TB_ajaxContent {width: 640px !important; height: 420px !important;}
             </style>
              <a href="#TB_inline?width=480&inlineId=wpbs_add_calendar" class="thickbox button wpbs_media_link" id="add_wpbs" title="' . __("Add Calendar", 'wpbs') . '"><span class="wpbs_media_icon "></span> ' . __("Add Calendar", "wpbs") . '</a>';
    }
}

add_action('admin_footer',  'wpbs_add_mce_popup');    
function wpbs_add_mce_popup(){
    global $wpdb;
    ?>
    <script>
        function wpbs_insert_shortcode(){
            var calendar_id = jQuery("#wpbs_calendar_id").val();
            if(calendar_id == ""){
                alert("Please select a calendar");
                return;
            }
            
            var form_id = jQuery("#wpbs_form_id").val();
            if(form_id == ""){
                alert("Please select a form");
                return;
            }

            var wpbs_calendar_title = jQuery("#wpbs_calendar_title").val();
            var wpbs_calendar_legend = jQuery("#wpbs_calendar_legend").val();
            var wpbs_calendar_language = jQuery("#wpbs_calendar_language").val();


            window.send_to_editor('[wpbs id="' + calendar_id + '" form="' + form_id + '" title="' + wpbs_calendar_title + '"  legend="' + wpbs_calendar_legend + '" language="' + wpbs_calendar_language + '"]');
        }
    </script>
    <?php $CalendarQuery = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars LIMIT 1';?>
    <?php $calendars = $wpdb->get_results( $CalendarQuery, ARRAY_A ); $calendarRows = $wpdb->num_rows;?>  
    
    <?php $FormQuery = 'SELECT * FROM ' . $wpdb->prefix . 'bs_forms LIMIT 1';?>
    <?php $forms = $wpdb->get_results( $FormQuery, ARRAY_A );  $formRows = $wpdb->num_rows;?>     
    <div id="wpbs_add_calendar" style="display:none;">
        <div class="wrap">
            <div>
            
                <div style="padding:0 15px 0 15px;">
                    <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;">Insert A Calendar</h3>
                    <h3>
                        Calendar Options
                    </h3>
                </div>
                <?php if($calendarRows > 0):?>
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong>Calendar</strong><br />
                    <select id="wpbs_calendar_id" style="width: 160px;">                
                                               
                        <?php foreach($calendars as $calendar):?>
                            <option value="<?php echo absint($calendar['calendarID']) ?>"><?php echo esc_html($calendar['calendarTitle']) ?></option>
                        <?php endforeach; ?>
                    </select> <br/>
                    
                </div>
                
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong>Display title?</strong><br />
                    <select id="wpbs_calendar_title" style="width: 160px;">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>                        
                    </select> <br/>                    
                </div>
                
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong>Display legend?</strong><br />
                    <select id="wpbs_calendar_legend" style="width: 160px;">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>                        
                    </select> <br/>                    
                </div>

                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong>Language</strong><br />
                    <select id="wpbs_calendar_language" style="width: 160px;">
                        <option value="auto">Auto (let WP choose)</option>
                        <?php $activeLanguages = json_decode(get_option('wpbs-languages'),true);?>
                        <?php foreach($activeLanguages as $code => $language):?>
                            <option value="<?php echo $code;?>"><?php echo $language;?></option>
                        <?php endforeach;?>                   
                    </select> <br/>                    
                </div>
                
                
                <?php else:?>
                <p style="padding:15px 15px 0 15px;">You have to create a calendar first.</p>
                <?php endif;?>
                
                
                
                
                <div style="padding:15px 15px 0 15px; clear:both;">
                    <h3>
                        Form Options
                    </h3>
                </div>
                <?php if($formRows > 0):?>
                <div style="padding:15px 15px 0 15px; float:left; width:160px; ">
                    <strong>Form</strong><br />
                    <select id="wpbs_form_id" style="width: 160px;">                                        
                        <?php foreach($forms as $form):?>
                            <option value="<?php echo absint($form['formID']) ?>"><?php echo esc_html(stripslashes($form['formTitle'])) ?></option>
                        <?php endforeach; ?>
                    </select> <br/>
                    
                </div>
                <?php else:?>
                <p style="padding:15px 15px 0 15px;">You have to create a form first.</p>
                <?php endif;?>
                
               
                <div style="clear:left; padding:15px 15px 0 15px;">
                    <?php if($formRows > 0 && $calendarRows > 0):?>
                    <input type="button" class="button-primary" value="Insert Calendar" onclick="wpbs_insert_shortcode();"/>&nbsp;&nbsp;&nbsp;
                    <?php endif;?>
                    <a class="button button-secondary" style="color: #333 !important;" href="#" onclick="tb_remove(); return false;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}