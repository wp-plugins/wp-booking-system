<?php global $wpdb;?>
<div class="wrap wpbs-wrap">
    <div id="icon-themes" class="icon32"></div>
    <?php $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars LIMIT 1';?>
    <?php $rows = $wpdb->get_results( $sql, ARRAY_A );?>
    <h2>WP Booking System 
        <?php if($wpdb->num_rows == 0):?>
        <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=edit-calendar');?>" class="add-new-h2">Add New</a>
        <?php else:?>
        <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=full-version');?>" class="add-new-h2">Add New</a>
        <?php endif;?>
        
        </h2>
    <?php if(!empty($status) && $status == 1):?>
    <div id="message" class="updated">
        <p><?php echo __('The calendar was updated','wpbs')?></p>
    </div>
    <?php endif;?>

    
    
    
    <?php if($wpdb->num_rows > 0):?>
    <table class="widefat wp-list-table wpbs-table wpbs-table-800">
        <thead>
            <tr>
                <th class="wpbs-table-id"><?php echo __('ID','wpbs')?></th>
                <th><?php echo __('Calendar Title','wpbs')?></th>   
                <th><?php echo __('Date Created','wpbs')?></th>
                <th><?php echo __('Date Modified','wpbs')?></th>
            </tr>
        </thead>
        
        <tbody>                
            <?php $i=0; foreach($rows as $calendar):?>
            <?php $bCount = 'SELECT bookingRead FROM ' . $wpdb->prefix . 'bs_bookings WHERE calendarID = '.$calendar['calendarID'].' AND bookingRead=0';?>
            <?php $wpdb->get_results( $bCount, ARRAY_A );?>
            
            
            <tr<?php if($i++%2==0):?> class="alternate"<?php endif;?>>
                <td class="wpbs-table-id">#<?php echo $calendar['calendarID']; ?></td>
                <td class="post-title page-title column-title">
                    <strong><a class="row-title" href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=edit-calendar&id=' . $calendar['calendarID']);?>"><?php echo $calendar['calendarTitle']; ?></a><div class='wpbs-count wpbs-count-<?php echo $wpdb->num_rows;?>'><?php echo $wpdb->num_rows;?></div></strong>
                    <div class="row-actions">
                        <span class="edit"><a href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=edit-calendar&id=' . $calendar['calendarID']);?>" title="Edit this item">Edit</a> | </span>
                        <span class="trash"><a onclick="return confirm('Are you sure you want to delete this calendar?');" class="submitdelete" href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=calendar-delete&id=' . $calendar['calendarID'] . '&noheader=true');?>">Delete</a></span>
                    </div>
                </td>
                <td><?php echo wpbs_timeFormat($calendar['createdDate'])?></td>
                <td><?php echo wpbs_timeFormat($calendar['modifiedDate']) ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php else:?>
        <?php echo __('No calendars found.','wpbs')?> <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=edit-calendar');?>">Click here to create your first calendar.</a>
    <?php endif;?>
    <h2 class="compare-boxes-title">Need more calendars? Want a better booking system?</h2>
    <div id="compare-boxes">
        <div class="compare-box free">
            <h1>Free</h1>
            <ul>
                <li>Create 1 calendar</li>
            </ul>
            <div class="box-bottom">
                <h2>Your current version</h2>
            </div>
        </div>
        <div class="compare-box">
            <h1>Premium</h1>
            <ul>
                <li>Create unlimited calendars</li>
                <li>Create unlimited forms</li>
                <li>Display multiple months</li>
                <li>Create your own legend</li>                
                <li>Change the first day of the week</li>
                <li>Change the start month &amp; year</li>
                <li>Edit multiple dates with one click</li>
                <li>Display a tooltip with info</li>
                <li>Hide bookings from the past</li>
                <li>Show the week's number</li>
                <li>Auto-Pending</li>
                <li>User management</li>
                <li>Very easy to translate</li>
            </ul>
            <div class="price">
                <p><strong>&dollar;34</strong> one time payment</p>
            </div>
            <div class="box-bottom padding">
                <a class="compare-box-button" href="http://www.wpbookingsystem.com" target="_blank">Learn more!</a>
            </div>
            <small>100% money-back-guarantee!</small>
        </div>
        <div class="wpbs-clear"><!-- --></div>
    </div>
</div>