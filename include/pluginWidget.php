<?php
class wpbs_widget extends WP_Widget {
    function wpbs_widget() {
        parent::WP_Widget(false, $name = 'WP Booking System', array(
            'description' => 'WP Booking System Widget'
        ));
    }
    function widget($args, $instance) {
        global $post;
        extract( $args );
        
        echo $args['before_widget'];        
        
        echo '<div class="wpbs-widget">';       
        echo do_shortcode('[wpbs id="'.$instance['wpbs_select_calendar'].'" form="'.$instance['wpbs_select_form'].'" title="'.$instance['wpbs_show_title'].'" legend="'.$instance['wpbs_show_legend'].'" language="'.$instance['wpbs_calendar_language'].']');
        echo '</div>';
        
        echo $args['after_widget'];

    }
    function update($new_instance, $old_instance) {
        return $new_instance;
    }
    function form($instance) {
        global $wpdb;
        /**
        'id'        => null,
		'title'     => 'no',
        'legend'    => 'no',
        'start'     => '1',
        'display'   => '1',
        'language'  => 'en'
        */
        
        $calendarId = 0; if(!empty($instance['wpbs_select_calendar'])) 
            $calendarId = $instance['wpbs_select_calendar'];
            
        $formId = 0; if(!empty($instance['wpbs_select_form'])) 
            $formId = $instance['wpbs_select_form'];
        
        $showTitle = 'yes'; if(!empty($instance['wpbs_show_title'])) 
            $showTitle = $instance['wpbs_show_title'];
            
        $showLegend = 'yes'; if(!empty($instance['wpbs_show_legend'])) 
            $showLegend = $instance['wpbs_show_legend'];

        $calendarView = '1'; if(!empty($instance['wpbs_calendar_view'])) 
            $calendarView = $instance['wpbs_calendar_view'];
            
        
        $calendarStart = '1'; if(!empty($instance['wpbs_calendar_start'])) 
            $calendarStart = $instance['wpbs_calendar_start'];
        
        $calendarLanguage = 'en'; if(!empty($instance['wpbs_calendar_language'])) 
            $calendarLanguage = $instance['wpbs_calendar_language'];
        
        $calendarHistory = '1'; if(!empty($instance['wpbs_calendar_history'])) 
            $calendarHistory = $instance['wpbs_calendar_history'];
            
        $sql = 'SELECT * FROM ' . $wpdb->prefix . 'bs_calendars';
        $rows = $wpdb->get_results( $sql, ARRAY_A );
        
        $formQuery = 'SELECT * FROM ' . $wpdb->prefix . 'bs_forms';
        $forms = $wpdb->get_results( $formQuery, ARRAY_A );
        
        ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('wpbs_select_calendar'); ?>"><?php echo __('Calendar');?></label>
            <select name="<?php echo $this->get_field_name('wpbs_select_calendar'); ?>" id="<?php echo $this->get_field_id('wpbs_select_calendar'); ?>" class="widefat">
            <?php foreach($rows as $calendar):?>
                <option<?php if($calendar['calendarID']==$calendarId) echo ' selected="selected"';?> value="<?php echo $calendar['calendarID'];?>"><?php echo $calendar['calendarTitle'];?></option>
            <?php endforeach;?>   
            </select>
         </p> 
         
         <p>
            <label for="<?php echo $this->get_field_id('wpbs_select_form'); ?>"><?php echo __('Form');?></label>
            <select name="<?php echo $this->get_field_name('wpbs_select_form'); ?>" id="<?php echo $this->get_field_id('wpbs_select_form'); ?>" class="widefat">
            <?php foreach($forms as $form):?>
                <option<?php if($form['formID']==$formId) echo ' selected="selected"';?> value="<?php echo $form['formID'];?>"><?php echo $form['formTitle'];?></option>
            <?php endforeach;?>   
            </select>
         </p> 
           
         <p>
            <label for="<?php echo $this->get_field_id('wpbs_show_title'); ?>"><?php echo __('Display title?');?></label>
            <select name="<?php echo $this->get_field_name('wpbs_show_title'); ?>" id="<?php echo $this->get_field_id('wpbs_show_title'); ?>" class="widefat">
                <option value="yes">Yes</option>
                <option value="no"<?php if($showTitle=='no'):?> selected="selected"<?php endif;?>>No</option>
            </select>
         </p>   
         <p>   
            <label for="<?php echo $this->get_field_id('wpbs_show_legend'); ?>"><?php echo __('Display legend?');?></label>
            <select name="<?php echo $this->get_field_name('wpbs_show_legend'); ?>" id="<?php echo $this->get_field_id('wpbs_show_legend'); ?>" class="widefat">
                <option value="yes">Yes</option>
                <option value="no"<?php if($showLegend=='no'):?> selected="selected"<?php endif;?>>No</option>
            </select>
         </p>   
           
         <p>    
            <label for="<?php echo $this->get_field_id('wpbs_calendar_language'); ?>"><?php echo __('Language');?></label>
            <select name="<?php echo $this->get_field_name('wpbs_calendar_language'); ?>" id="<?php echo $this->get_field_id('wpbs_calendar_language'); ?>" class="widefat">
                <option value="auto">Auto (let WP choose)</option>
                <?php $activeLanguages = json_decode(get_option('wpbs-languages'),true);?>
                <?php foreach($activeLanguages as $code => $language):?>
                    <option value="<?php echo $code;?>"<?php if($calendarLanguage == $code):?> selected="selected"<?php endif;?>><?php echo $language;?></option>
                <?php endforeach;?>   
            </select>
        </p>
        
        <?php
    }
}
function wpbs_register_widget() {
	register_widget( 'wpbs_widget' );
}
add_action( 'widgets_init', 'wpbs_register_widget' );