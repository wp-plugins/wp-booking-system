<?php

/** Save Languages **/
$languages = array('en' => 'English','ca' => 'Catalan','hr' => 'Croatian','cz' => 'Czech','da' => 'Danish','nl' => 'Dutch','et' => 'Estonian','fi' => 'Finnish','fr' => 'French','de' => 'German','el' => 'Greek','hu' => 'Hungarian','it' => 'Italian', 'no' => 'Norwegian','pl' => 'Polish','pt' => 'Portugese','ro' => 'Romanian','ru' => 'Russian','sk' => 'Slovak','sl' => 'Slovenian','es' => 'Spanish','sv' => 'Swedish','tr' => 'Turkish','uk' => 'Ukrainian');

foreach($languages as $code => $language):
    if(!empty($_POST[$code]))
        $activeLanguages[$code] = $language;
endforeach;
if(empty($activeLanguages)) $activeLanguages['en'] = 'English';

update_option('wpbs-languages',json_encode($activeLanguages));

if(!empty($_POST['selectedColor']))
    $wpbsOptions['selectedColor'] = $_POST['selectedColor'];
else $wpbsOptions['selectedColor'] = '#3399cc';

if(!empty($_POST['selectedBorder']))
    $wpbsOptions['selectedBorder'] = $_POST['selectedBorder'];
else $wpbsOptions['selectedBorder'] = '#336699';

if(!empty($_POST['historyColor']))
    $wpbsOptions['historyColor'] = $_POST['historyColor'];
else $wpbsOptions['historyColor'] = '#eaeaea';

$wpbsOptions['dateFormat'] = $_POST['dateFormat'];

update_option('wpbs-options',json_encode($wpbsOptions));


wp_redirect(admin_url('admin.php?page=wp-booking-system-settings&save=ok'));
die();
