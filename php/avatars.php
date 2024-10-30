<?php

/* Returns the avatar URL. */
function nstla_get_avatarurl($user_id, $fallback = false, $forcelocalifexists = false) {
	/* Local Avatar disabled -> Gravatar */
	if (!get_user_meta($user_id, "nstla_setting_localavatar")) {
		if (!$forcelocalifexists) {
			$url = get_avatar_url($user_id);
		}
		else {
			$url = get_user_meta($user_id, "nstla_setting_avatarurl", true);
			if (empty($url)) $url = get_avatar_url($user_id);
		}
	}
	/* Local Avatar enabled -> No Gravatar */
	else {
		$url = get_user_meta($user_id, "nstla_setting_avatarurl", true);
		if ($fallback && empty($url)) $url = get_avatar_url($user_id);
		// if ($fallback && (empty($url) || parse_url($url, PHP_URL_HOST) != $_SERVER["SERVER_NAME"])) $url = plugin_dir_url(__DIR__) . "avatar_200.png"; -> Possible fallback if local avatars should be enforced through a global setting in a future version?
	}

	return $url;
}


/* Returns always the Gravatar URL. */
function nstla_get_gravatar_url($user_id) {
	remove_filter("get_avatar_data", "nstla_get_avatar_data");
	$gravatarurl = get_avatar_url($user_id);
	add_filter("get_avatar_data", "nstla_get_avatar_data", 10, 2);

	return $gravatarurl;
}


/**
 * Overrides the avatar data.
 * https://developer.wordpress.org/reference/functions/get_avatar_data/
 * https://developer.wordpress.org/reference/hooks/get_avatar_data/
 */
add_filter("get_avatar_data", "nstla_get_avatar_data", 10, 2);
function nstla_get_avatar_data($args, $id_or_email) {
	if (!empty($args["force_default"])) {
		return $args;
	}

	$user_id = nstla_get_user_id($id_or_email);

	if (get_user_meta($user_id, "nstla_setting_localavatar")) {
		$url = nstla_get_avatarurl($user_id, false, false);
		if (!empty($url)) $args["url"] = $url;
	}
	
	return $args;
}


function nstla_get_user_id($id_or_email) {
	$user_id = null;
	
	if (is_numeric($id_or_email)) {
		$user_id = (int)$id_or_email;
	}
	else if (is_string($id_or_email) && ($user = get_user_by("email", $id_or_email))) {
		$user_id = $user->ID;
	}
	else if (is_object($id_or_email) && !empty($id_or_email->user_id)) {
		$user_id = (int)$id_or_email->user_id;
	}

	return $user_id;
}


/* Redirect Gravatar to local avatar */
add_filter("get_avatar", "nstla_redirect_gravatar");
add_filter("get_avatar_url", "nstla_redirect_gravatar");
function nstla_redirect_gravatar($url) {
	global $nstla_setting_redirectgravatar_all;
	global $nstla_setting_localavatar_default;
	global $nstla_setting_localavatar_default_custom_url;
	
	if ($nstla_setting_redirectgravatar_all == true
		&& strpos($url, "gravatar.com") !== false) {
			
			if (in_array($nstla_setting_localavatar_default, array("pingu", "mystery"))) {
				$url = plugin_dir_url(__DIR__) . "img/local-avatar-$nstla_setting_localavatar_default.png";
			}
			else if ($nstla_setting_localavatar_default == "custom") {
				$url = $nstla_setting_localavatar_default_custom_url;
			}
			else {
				global $nstla_setting_default_localavatar_default;
				$url = plugin_dir_url(__DIR__) . "img/local-avatar-$nstla_setting_default_localavatar_default.png";
			}
	}
	
	return $url;
}
	

?>