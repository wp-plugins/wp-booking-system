<?php global $wpdb;?>

<div class="wrap wpbs-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>Settings</h2>
    <?php if(!empty($_GET['save']) && $_GET['save'] == 'ok'):?>
    <div id="message" class="updated">
        <p><?php echo __('The settings were saved.','wpbs')?></p>
    </div>
    <?php endif;?>
    
        <div class="postbox-container  meta-box-sortables">
            
            <form action="<?php echo admin_url( 'admin.php?page=wp-booking-system-settings&do=save&noheader=true');?>" method="post">
            <div class="wpbs-buttons-wrapper">
                <input type="submit" class="button button-primary button-h2" value="Save Changes" /> 
            </div>                        
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">General Settings</h3>
                    <div class="inside">     
                        <?php $wpbsOptions = json_decode(get_option('wpbs-options'),true);?>  
                        <div class="wpbs-settings-col">
                            <div class="wpbs-settings-col-left">
                                <strong>Date Format</strong>                                
                            </div>
                            <div class="wpbs-settings-col-right wpbs-date-format">
                                <label><input class="small" type="radio" id="" name="dateFormat" <?php if($wpbsOptions['dateFormat'] == 'j F Y'): ?>checked="checked"<?php endif;?> value="j F Y" /> 25 July 2013</label>
                                <label><input class="small" type="radio" id="" name="dateFormat"<?php if($wpbsOptions['dateFormat'] == 'F j, Y'): ?>checked="checked"<?php endif;?> value="F j, Y" /> July 25, 2013</label>
                                <label><input class="small" type="radio" id="" name="dateFormat"<?php if($wpbsOptions['dateFormat'] == 'Y/m/d'): ?>checked="checked"<?php endif;?> value="Y/m/d" /> 2013/07/25</label>
                                <label><input class="small" type="radio" id="" name="dateFormat"<?php if($wpbsOptions['dateFormat'] == 'm/d/Y'): ?>checked="checked"<?php endif;?> value="m/d/Y" /> 07/25/2013</label>
                                <label><input class="small" type="radio" id="" name="dateFormat"<?php if($wpbsOptions['dateFormat'] == 'd/m/Y'): ?>checked="checked"<?php endif;?> value="d/m/Y" /> 25/07/2013</label>
                            </div>
                            <div class="wpbs-clear"></div>                            
                        </div>                  
                        <div class="wpbs-settings-col wpbs-colorpicker">
                            <div class="wpbs-settings-col-left">
                                <strong>Selected date background</strong>                                
                            </div>
                            <div class="wpbs-settings-col-right">
                                <span class="color-box" id="selectedColorBox"  style="background-color:<?php echo $wpbsOptions['selectedColor'];?>"><!-- --></span>
                                <input class="small" type="text" id="selectedColor" name="selectedColor" value="<?php echo $wpbsOptions['selectedColor'];?>" /> 
                                <small>The color that is being used for selected days on the front-end.</small>
                            </div>
                            <div class="wpbs-clear"></div>                            
                        </div>  
                        
                        <div class="wpbs-settings-col">
                            <div class="wpbs-settings-col-left">
                                <strong>Selected date border color</strong>                                
                            </div>
                            <div class="wpbs-settings-col-right wpbs-colorpicker">
                                <span class="color-box" id="selectedBorderBox"  style="background-color:<?php echo $wpbsOptions['selectedBorder'];?>;"><!-- --></span>
                                <input class="small" type="text" id="selectedBorder" name="selectedBorder" value="<?php echo $wpbsOptions['selectedBorder'];?>" />
                                <small>The border color that is being used for selected days on the front-end.</small>
                            </div>
                            <div class="wpbs-clear"></div>                            
                        </div>  
                        <div class="wpbs-settings-col">
                            <div class="wpbs-settings-col-left">
                                <strong>Booking History Color</strong>                                
                            </div>
                            <div class="wpbs-settings-col-right wpbs-colorpicker">
                                <span class="color-box" id="historyColorBox"  style="background-color:<?php echo $wpbsOptions['historyColor'];?>;"><!-- --></span>
                                <input class="small" type="text" id="historyColor" name="historyColor" value="<?php echo $wpbsOptions['historyColor'];?>" />
                                <small>The color that will be used if you select 'Use Booking History Color' when you generate a shortcode.</small>
                            </div>
                            <div class="wpbs-clear"></div>                            
                        </div>  
                    </div>
                </div>
            </div> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Languages</h3>
                    <div class="inside">
                        <?php $activeLanguages = json_decode(get_option('wpbs-languages'),true);?>
                        <?php $languages = array('en' => 'English','ca' => 'Catalan','hr' => 'Croatian','cz' => 'Czech','da' => 'Danish','nl' => 'Dutch','et' => 'Estonian','fi' => 'Finnish','fr' => 'French','de' => 'German','el' => 'Greek','hu' => 'Hungarian','it' => 'Italian', 'no' => 'Norwegian' ,'pl' => 'Polish','pt' => 'Portugese','ro' => 'Romanian','ru' => 'Russian','sk' => 'Slovak','sl' => 'Slovenian','es' => 'Spanish','sv' => 'Swedish','tr' => 'Turkish','uk' => 'Ukrainian');?>    
                        <div class="wpbs-settings-col">
                            <div class="wpbs-settings-col-left">
                                <strong>Languages</strong><br />
                                <small>What languages do you <br />want to use?</small>
                            </div>
                            <div class="wpbs-settings-col-right">
                                <?php foreach($languages as $code => $language):?>
                                    <label><input type="checkbox" name="<?php echo $code;?>" <?php if(in_array($language,$activeLanguages)):?>checked="checked"<?php endif;?> value="<?php echo $code;?>" /> <?php echo $language;?></label>
                                <?php endforeach;?>
                            </div>
                            <div class="wpbs-clear"></div>
                            
                        </div> 
                        
                    </div>
                </div>
            </div> 
            <br /><input type="submit" class="button button-primary" value="Save Changes" /> 
            </form>
        </div>
</div>
<script>
var wpbs = jQuery.noConflict();
wpbs(document).ready(function(){
    wpbs('#selectedColor').ColorPicker({
		color: '<?php echo $wpbsOptions['selectedColor'];?>',
		onShow: function (colpkr) {
			wpbs(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			wpbs(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			wpbs('#selectedColorBox').css('backgroundColor', '#' + hex);
            wpbs('#selectedColor').val('#' + hex);
		}
	});
    wpbs('#selectedBorder').ColorPicker({
		color: '<?php echo $wpbsOptions['selectedBorder'];?>',
		onShow: function (colpkr) {
			wpbs(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			wpbs(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			wpbs('#selectedBorderBox').css('backgroundColor', '#' + hex);
            wpbs('#selectedBorder').val('#' + hex);
		}
	});
    wpbs('#historyColor').ColorPicker({
		color: '<?php echo $wpbsOptions['historyColor'];?>',
		onShow: function (colpkr) {
			wpbs(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			wpbs(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			wpbs('#historyColorBox').css('backgroundColor', '#' + hex);
            wpbs('#historyColor').val('#' + hex);
		}
	});
 });
</script>

