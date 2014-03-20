<?php global $wpdb;?>
<?php $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars'; $wpdb->get_results( $sql, ARRAY_A ); if($wpdb->num_rows > 0 && empty($_GET['id'])) wp_die();?>
<?php $rows = $wpdb->get_results( $sql, ARRAY_A );?>
<div class="wrap wpbs-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>Edit Calendar</h2>
    <?php if(!empty($_GET['save']) && $_GET['save'] == 'ok'):?>
    <div id="message" class="updated">
        <p><?php echo __('The calendar was updated','wpbs')?></p>
    </div>
    <?php endif;?>
    <?php if(!(!empty($_GET['id']))) $_GET['id'] = 'wpbs-new-calendar';?>
    <?php $sql = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bs_calendars WHERE calendarID=%d',$_GET['id']); ?>
    <?php $calendar = $wpdb->get_row( $sql, ARRAY_A );?>
    <?php if($wpdb->num_rows > 0 || $_GET['id'] == 'wpbs-new-calendar'):?>
    
    
        <?php if($_GET['id'] == 'wpbs-new-calendar') {$calendar['calendarLegend'] = wpbs_defaultCalendarLegend(); $calendar['calendarData'] = '{}';}?>
        <div class="postbox-container meta-box-sortables">
            <?php echo wpbs_print_legend_css($calendar['calendarLegend'],(!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "", false); ?>
            <form action="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=save-calendar&noheader=true');?>" method="post">
            <div class="wpbs-buttons-wrapper">
                <input type="submit" class="button button-primary button-h2 saveCalendar" value="Save Changes" />
                <a class="button secondary-button button-h2 button-h2-back-margin" href="<?php echo admin_url( 'admin.php?page=wp-booking-system' );?>">Back</a> 
            </div>
            <input type="text" name="calendarTitle" class="fullTitle" id="calendarTitle" placeholder="Calendar title" value="<?php echo (!empty($calendar['calendarTitle'])) ? $calendar['calendarTitle'] : "" ;?>"/>
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Bookings</h3>
                    <div class="inside">
                        <?php wpbs_display_bookings((!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "");?>
                    </div>
                </div>
            </div> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Availability</h3>
                    <div class="inside">  
                         
                                             
                            <?php echo  wpbs_calendar( array( 'showDateEditor' => true, 'calendarData' => $calendar['calendarData'], 'calendarLegend' => $calendar['calendarLegend'], 'calendarID' => (!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "" ) );?>
                            <input type="hidden" value="<?php echo (!empty($calendar['calendarID'])) ? $calendar['calendarID'] : "" ;?>" name="calendarID" />   
                            
                                          
                    </div>
                </div>
            </div>  
            <br />
            <input type="submit" class="button button-primary saveCalendar" value="Save Changes" />
            </form>
        </div>
    <?php else:?>
        <?php echo __('Invalid calendar ID.','wpbs')?>
    <?php endif;?>     
    <?php if(!empty($_GET['goto']) && ($_GET['goto'] == 'trash' || $_GET['goto'] == 'accepted')):?>
        <script>
            wpbs(document).ready(function(){
                wpbs("#wpbs-bookings-tab-<?php echo $_GET['goto'];?>").click();
            })
        </script>
    <?php endif;?>
</div>

