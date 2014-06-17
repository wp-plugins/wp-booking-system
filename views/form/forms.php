<?php global $wpdb;?>
<div class="wrap wpbs-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>Forms - WP Booking System 
    <?php $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_forms LIMIT 1';?>
    <?php $rows = $wpdb->get_results( $sql, ARRAY_A );?>
    <?php if($wpdb->num_rows == 0):?>
    <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system-forms&do=edit-form');?>" class="add-new-h2">Add New</a>
    <?php else:?>
    <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system&do=full-version');?>" class="add-new-h2">Add New</a>
    <?php endif;?>
    
    </h2>
    <?php if(!empty($status) && $status == 1):?>
    <div id="message" class="updated">
        <p><?php echo __('The form was updated','wpbs')?></p>
    </div>
    <?php endif;?>

    
    
    
    <?php if($wpdb->num_rows > 0):?>
    <table class="widefat wp-list-table wpbs-table wpbs-table-800">
        <thead>
            <tr>
                <th class="wpbs-table-id"><?php echo __('ID','wpbs')?></th>
                <th><?php echo __('Form Title','wpbs')?></th>   
                
            </tr>
        </thead>
        
        <tbody>                
            <?php $i=0; foreach($rows as $form):?>
            <tr<?php if($i++%2==0):?> class="alternate"<?php endif;?>>
                <td class="wpbs-table-id">#<?php echo $form['formID']; ?></td>
                <td class="post-title page-title column-title">
                    <strong><a class="row-title" href="<?php echo admin_url( 'admin.php?page=wp-booking-system-forms&do=edit-form&id=' . $form['formID']);?>"><?php echo $form['formTitle']; ?></a></strong>
                    <div class="row-actions">
                        <span class="edit"><a href="<?php echo admin_url( 'admin.php?page=wp-booking-system-forms&do=edit-form&id=' . $form['formID']);?>" title="Edit this item">Edit</a> | </span>
                        <span class="trash"><a onclick="return confirm('Are you sure you want to delete this form?');" class="submitdelete" href="<?php echo admin_url( 'admin.php?page=wp-booking-system-forms&do=delete-form&id=' . $form['formID'] . '&noheader=true');?>">Delete</a></span>
                    </div>
                </td>
               
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php else:?>
        <?php echo __('No forms found.','wpbs')?> <a href="<?php echo admin_url( 'admin.php?page=wp-booking-system-forms&do=edit-form');?>">Click here to create your first form.</a>
    <?php endif;?>
</div>