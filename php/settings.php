<?php

require plugin_dir_path(__FILE__) . "settings-defaults.php";

/* Global settings: general */
$nstla_setting_redirectgravatar_all = get_option("nstla_setting_redirectgravatar_all", $nstla_setting_default_redirectgravatar_all);
$nstla_setting_localavatar_default = get_option("nstla_setting_localavatar_default", $nstla_setting_default_localavatar_default);
$nstla_setting_localavatar_default_custom_url = get_option("nstla_setting_localavatar_default_custom_url", $nstla_setting_default_localavatar_default_custom_url);

?>