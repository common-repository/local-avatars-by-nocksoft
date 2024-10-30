<?php

function nstla_activate_plugin() {
	require plugin_dir_path(__FILE__) . "settings-defaults.php";
	
	add_option("nstla_setting_redirectgravatar_all", $nstla_setting_default_redirectgravatar_all);
	add_option("nstla_setting_localavatar_default", $nstla_setting_default_localavatar_default);
	add_option("nstla_setting_localavatar_default_custom_url", $nstla_setting_default_localavatar_default_custom_url);
	
	/* Migrate user settings from Author Box by Nocksoft */
	$users = get_users();
    foreach ($users as $user) {
        $id = $user->ID;
		
		$localavatar = get_user_meta($id, "nstab_setting_localavatar");
		if ($localavatar) {
			add_user_meta($id, "nstla_setting_localavatar", boolval($localavatar));
		}
        delete_user_meta($id, "nstab_setting_localavatar");
		
		$url = get_user_meta($id, "nstab_setting_avatarurl", true);
		if ($url) {
			add_user_meta($id, "nstla_setting_avatarurl", $url);
		}
        delete_user_meta($id, "nstab_setting_avatarurl");
    }
}

/* https://developer.wordpress.org/plugins/plugin-basics/uninstall-methods/ */
function nstla_uninstall_plugin() {
	
	delete_option("nstla_setting_redirectgravatar_all");
	delete_option("nstla_setting_localavatar_default");
	delete_option("nstla_setting_localavatar_default_custom_url");
	
	/* Clear user settings */
    $users = get_users();
    foreach ($users as $user) {
        $id = $user->ID;
        delete_user_meta($id, "nstla_setting_localavatar");
        delete_user_meta($id, "nstla_setting_avatarurl");
    }
}

?>