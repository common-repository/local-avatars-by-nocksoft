<?php


/* Show user settings */
add_action("show_user_profile", "nstla_usersettings", 9);
add_action("edit_user_profile", "nstla_usersettings", 9);
function nstla_usersettings($user) {
    ?>
    <h3>Local Avatars by Nocksoft</h3>

    <p><?php echo __("Here you can make further settings for your avatar or other personal settings. The WordPress administrator can adjust global settings under Settings -> Local Avatars.", "local-avatars-by-nocksoft"); ?></p>

    <table class="form-table">
        <tr>
            <th><label for="nstla_setting_localavatar"><?php echo __("Local Avatar", "local-avatars-by-nocksoft"); ?></label></th>
            <td>
                <p>
                    <input type="checkbox" id="nstla_setting_localavatar" name="nstla_setting_localavatar" <?php checked(get_the_author_meta("nstla_setting_localavatar", $user->ID)); ?>>
                    <label for="nstla_setting_localavatar"><?php echo __("Use a local avatar instead of Gravatar (choose your avatar below)", "local-avatars-by-nocksoft"); ?></label>
                </p>
            
                <?php
                    $avatarurl = nstla_get_avatarurl($user->ID, true, true);
                    $gravatarurl = nstla_get_gravatar_url($user->ID);
                ?>
                <p><img id="nstla_avatarimg" loading="lazy" width="96" height="96" src="<?php echo esc_url($avatarurl); ?>"></p>
                <p><input type="text" id="nstla_avatarinput" name="nstla_setting_avatarurl" class="regular-text" placeholder="<?php echo __("Avatar URL (e.g. https://yoursite.com/avatar.jpg) -> will be filled automatically", "local-avatars-by-nocksoft"); ?>" value="<?php echo esc_url($avatarurl); ?>"
                    gravatarurl="<?php echo esc_url($gravatarurl); ?>" avatarid="<?php echo attachment_url_to_postid($avatarurl); ?>" /></p>
                <p class="description"><?php echo __("Please select an avatar using the button below (square avatars are recommended). Gravatar may be used as fallback.", "local-avatars-by-nocksoft"); ?></p>
                <p>
                    <input type="button" id="nstla_setavatar" class="button" value="<?php echo __("Choose Avatar", "local-avatars-by-nocksoft"); ?>"/>
                    <input type="button" id="nstla_deleteavatar" class="button" value="<?php echo __("Remove Avatar", "local-avatars-by-nocksoft"); ?>"/>
                </p>
            </td>
        </tr>
    </table>
    <?php
}


/* Save user settings */
add_action("personal_options_update", "nstla_save_usersettings");
add_action("edit_user_profile_update", "nstla_save_usersettings");
function nstla_save_usersettings($user_id) {
    if (!current_user_can("edit_user", $user_id)) {
        return false;
    }
    else {
		$nstla_setting_localavatar = isset($_POST["nstla_setting_localavatar"]) ? boolval($_POST["nstla_setting_localavatar"]) : false;
        update_usermeta($user_id, "nstla_setting_localavatar", $nstla_setting_localavatar);
        update_usermeta($user_id, "nstla_setting_avatarurl", sanitize_url($_POST["nstla_setting_avatarurl"]));
    }
}

?>