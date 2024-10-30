<?php

/*
	Plugin Name: Local Avatars by Nocksoft
	Version: 1.0.1
	Author: Rafael Nockmann @ Nocksoft
	Author URI: https://nocksoft.de
	Plugin URI: https://github.com/Nocksoft/Local-Avatars-by-Nocksoft
	Description: Adds support for local avatars.
	Text Domain: local-avatars-by-nocksoft
	License: GNU General Public License v2 or later
    License URI: http://www.gnu.org/licenses/gpl-2.0.html
    Domain Path:  /languages
*/


if (is_admin()) {

	/* --- Settings link in plugin overview --- */
	add_filter("plugin_action_links_" . plugin_basename(__FILE__), "nstla_pluginsettingslink");
	function nstla_pluginsettingslink($links) {
		$settingslink = "<a href='options-general.php?page=nstla'>" . __("Settings", "local-avatars-by-nocksoft") . "</a>";
		array_push($links, $settingslink);
		return $links;
	}
	
	
	/* --- Load scripts --- */
	require_once plugin_dir_path(__FILE__) . "/php/setup.php";
	require_once plugin_dir_path(__FILE__) . "/php/settings-global.php";
	require_once plugin_dir_path(__FILE__) . "/php/settings-user.php";
	
	add_action("admin_enqueue_scripts", "nstla_loadadminscripts");
	function nstla_loadadminscripts() {
		/* --- Image picker for local Avatar --- */
		wp_enqueue_media();
		wp_enqueue_script("nstla_imagepicker", plugin_dir_url(__FILE__) . "js/imagepicker.js", array("jquery"), false, true);
	}
	
	
	/* --- Plugin setup --- */
	register_activation_hook(__FILE__, "nstla_activate_plugin");
	register_uninstall_hook(__FILE__, "nstla_uninstall_plugin");
	
}


/* --- Load scripts --- */
require_once plugin_dir_path(__FILE__) . "/php/avatars.php";
require_once plugin_dir_path(__FILE__) . "/php/settings.php";


/* --- Languages --- */
add_action("plugins_loaded", "nstla_load_plugin_textdomain");
function nstla_load_plugin_textdomain() {
    load_plugin_textdomain("local-avatars-by-nocksoft", FALSE, basename(dirname(__FILE__)) . "/languages/");
}

?>