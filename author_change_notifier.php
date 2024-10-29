<?php

/*
* Plugin Name: Author Change Notifier
* Plugin URI: http://e5ta9er.com/
* Description: Author Change Notifier (ACN): If you run a business directory or a classifieds website and you want to give the advertizers the ability to claim other posts in the website then this plugin is right for you. Once you change the author/owner/user who originally created the post, this plugin will send custom email notifications to the previous as well as the new author/owner/user who now has control over the post or listing. Notice that this is just a NOTIFICATION plugin, it is not an A-Z solution for claiming posts. You can create a custom form using other plugins to allow your users to send you claims. Then once you manually modify the author of the post, ACN will step in and notify the previous and new author of the change.
* Version: 1.0.1
* Author: Abdullah al-Sheikh Hasan
* Author URI: http://plugins.e5ta9er.com
* Installation: Extract and upload zip file contents to wp-content/plugins directory of your WordPress installation, then activate the plugin.
* License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

require_once('acn_emailer.php');

//If admim, sho admin menus
function add_plugin_menu()
{
	add_options_page('Author Change Notifier', 'Author Change Notifier',
		'manage_options', 'acn-admin-panel', 'acn_show_admin_page');
}


//Register initial settings
function register_acn_settings()
{
	register_setting('acn-settings-group', 'acn_ex_author_msg', 'validate_email_text');
	register_setting('acn-settings-group', 'acn_new_author_msg', 'validate_email_text');
    register_setting('acn-settings-group', 'acn_ex_author_subject', 'validate_email_subject');
    register_setting('acn-settings-group', 'acn_new_author_subject', 'validate_email_subject');
    register_setting('acn-settings-group', 'acn_email_from', 'validate_email');
    register_setting('acn-settings-group', 'acn_sender_name', 'validate_name');
}

//Show admin HTML
function acn_show_admin_page()
{
?>
    <style>
    p.acn_help{
        font-size: xx-small;
        font-style: italic;
        color: gray;
    }
    </style>
	<div class="wrap">
	<h2>Author Change Notifier Settings</h2>
    <div id="acn_error_message" class="error" style="display:none;"></div>
	<form id="acn_form" method="post" action="options.php">
    <?php settings_fields('acn-settings-group'); ?>
	<table class="form-table">
    <!-- Sender name -->
	<tr valign="top">
	<th scope="row">Sender Name:</th>
	<td>
    <input type="text" size="63" id="acn_sender_name" name="acn_sender_name" value="<?php echo get_option('acn_sender_name')?>"/>
    <p class="acn_help">The name that will appear as the sender of the email notification.</p>
    </td>
	</tr>      
    <!-- Sender email address -->
	<tr valign="top">
	<th scope="row">Sender Email address:</th>
	<td>
    <input type="text" size="63" id="acn_email_from" name="acn_email_from" value="<?php echo get_option('acn_email_from')?>"/>
    <p class="acn_help">The email address that will appear as the sender of the email notification. It is not recommended to change this.</p>
    </td>
	</tr>    
    <!-- Email subject 1 -->
	<tr valign="top">
	<th scope="row">Ex-author Email Subject</th>
	<td>
    <input type="text" size="63" id="acn_ex_author_subject" name="acn_ex_author_subject" value="<?php echo get_option('acn_ex_author_subject')?>"/>
    <p class="acn_help">The subject of the email which will be sent to the previous author of the post.</p>
    </td>
	</tr>
	<!-- Email body 1 -->
	<tr valign="top">
	<th scope="row">Ex-author Email Text</th>
	<td>
    <textarea id="acn_ex_author_msg" name="acn_ex_author_msg" cols="40" rows="10"><?php echo get_option('acn_ex_author_msg')?></textarea>
    <p class="acn_help">The text of the email which will be sent to the previous author of the post.</p>
    <p class="acn_help">You can include the following placeholders in the email text to make your email text show dynamic content as you please.<br/>
<strong>%post_title%</strong> will be replaced with the title of the post.<br/>
<strong>%ex_author_login%</strong> will be replaced with the user name of the previous author of the post.<br/>
<strong>%new_author_login%</strong> will be replaced with the user name of the new author of the post.<br/>
<strong>%ex_author_email%</strong> will be replaced with the email address of the previous author of the post.<br/>
<strong>%new_author_email%</strong> will be replaced with the email address of the new author of the post.<br/>
<strong>%ex_author_id%</strong> will be replaced with the account id of the previous author of the post.<br/>
<strong>%new_author_id%</strong> will be replaced with the account id of the new author of the post.<br/>
<strong>%post_id%</strong> will be replaced with the id of the post.</p>
    </td>
	</tr>
    <!-- Email subject 2 -->
	<tr valign="top">
	<th scope="row">New-author Email Subject</th>
	<td>
    <input type="text" size="63" id="acn_new_author_subject" name="acn_new_author_subject" value="<?php echo get_option('acn_new_author_subject')?>"/>
    <p class="acn_help">The subject of the email which will be sent to the new author of the post.</p>
    </td>
	</tr>
	<!-- Email body 2 -->
	<tr valign="top">
	<th scope="row">New-author Email Text</th>
	<td>
    <textarea id="acn_new_author_msg" name="acn_new_author_msg" cols="40" rows="10"><?php echo get_option('acn_new_author_msg')?></textarea>
    <p class="acn_help">The text of the email which will be sent to the new author of the post.</p>
    <p class="acn_help">You can include the following placeholders in the email text to make your email text show dynamic content as you please.<br/>
<strong>%post_title%</strong> will be replaced with the title of the post.<br/>
<strong>%ex_author_login%</strong> will be replaced with the user name of the previous author of the post.<br/>
<strong>%new_author_login%</strong> will be replaced with the user name of the new author of the post.<br/>
<strong>%ex_author_email%</strong> will be replaced with the email address of the previous author of the post.<br/>
<strong>%new_author_email%</strong> will be replaced with the email address of the new author of the post.<br/>
<strong>%ex_author_id%</strong> will be replaced with the account id of the previous author of the post.<br/>
<strong>%new_author_id%</strong> will be replaced with the account id of the new author of the post.<br/>
<strong>%post_id%</strong> will be replaced with the id of the post.</p>    
    </td>
	</tr>
	</table>
	<p class="submit"><input type="button" class="button-primary" value="<?php echo  _('Save Changes')?>" onclick="if(acn_validate()) jQuery('#acn_form').submit();"/></p>
	</form>
	</div>
    <!-- Javascript for client side validation -->
    <script>
    function acn_validate(){
        if(jQuery('#acn_sender_name').val().length <= 5)
        {
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: Email sender name is too short!</p>');
            jQuery('#acn_sender_name').foucs();
            return false;
        }        
        var email_pattern = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        if(!email_pattern.test(jQuery('#acn_email_from').val()))
        {
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: From email address is invalid!</p>');
            jQuery('#acn_email_from').foucs();
            return false;            
        }
        if(jQuery('#acn_ex_author_subject').val().length <= 10)
        {
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: ex-author email subject is too short!</p>');
            jQuery('#acn_ex_author_subject').foucs();
            return false;
        }
        if(jQuery('#acn_new_author_subject').val().length <= 10)
        {
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: new-author email subject is too short!</p>');
            jQuery('#acn_new_author_subject').foucs();
            return false;
        }        
        if(jQuery('#acn_ex_author_msg').val().length <= 10)
        {
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: ex-author email text is too short!</p>');
            jQuery('#acn_ex_author_msg').foucs();
            return false;
        }
        else if(jQuery('#acn_new_author_msg').val().length <= 10){
            jQuery('#acn_error_message').css('display', 'block').html('<p>Error: new author email text is too short!</p>');
            jQuery('#acn_new_author_msg').foucs();
            return false;
        }
        return true;
    }
    </script>
<?php
}

function validate_email_text($input)
{
	if (mb_strlen($input) <= 10) {
		set_transient('acn_error', 'Email text is too short!', 60 * 60 * 24);
	}
    return $input;
}

function validate_email_subject($input)
{
	if (mb_strlen($input) <= 10) {
		set_transient('acn_error', 'Email subject is too short!', 60 * 60 * 24);
	}
    return $input;
}

function validate_name($input)
{
	if (mb_strlen($input) <= 10) {
		set_transient('acn_error', 'Email sender name is too short!', 60 * 60 * 24);
	}
    return $input;
}

function validate_email($input)
{
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$input)) {
		set_transient('acn_error', 'Email address is invalid!', 60 * 60 * 24);
	}
    return $input;
}

function acn_show_error_message()
{
	if (get_transient('acn_error')) {
		unset($_GET['updated']);
        unset($_GET['settings-updated']);
		echo '<div id="message" class="error"><p>' . get_transient('acn_error') . '</p></div>';
		delete_transient('acn_error');
	}
}

//Plugin activation: populate main options
function acn_plugin_activate(){
    add_option('acn_email_from',get_option('admin_email'));
    add_option('acn_sender_name',get_option('blogname'));
    add_option('acn_ex_author_subject','Important notification');
    add_option('acn_new_author_subject','Important notification');
    add_option('acn_ex_author_msg','Dear %ex_author_login%,

This is to inform you that your post (%post_title%) has been claimed by another user. The ability to update or delete the post has also been transfered to that user.

This decision has been made after the other user has shown substantial evidence of his ownership of the business referred to in that post of concern.

You do not have to reply to this e-mail and thanks for your understanding.

Best Regards,
' . get_option('blogname') . ' Team');
    add_option('acn_new_author_msg','Dear %new_author_login%,

This is to inform you that the team at e5ta9er.com has authorized your claim of the post (%post_title%) and that the right to update the post (%post_title%) has been transferred to your account.

To view that post please go to: ' . get_bloginfo('siteurl') . '/?p=%post_id%

Kind Regards,
' . get_option('blogname') . ' Team');
}

//Adds settings link to plugins page
function add_acn_settings_link($links, $file){
    static $this_plugin;
    if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
    if($file == $this_plugin){
        $settings_link = '<a href="options-general.php?page=acn-admin-panel">'.__("Settings", "photosmash-galleries").'</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}

//Hooks
add_action('post_updated', 'check_if_author_changed', 10, 3);
add_filter('plugin_action_links', 'add_acn_settings_link', 10, 2);
register_activation_hook( __FILE__, 'acn_plugin_activate' );
if (is_admin()) {
	add_action('admin_init', 'register_acn_settings');
	add_action('admin_menu', 'add_plugin_menu');
	add_action('admin_notices', 'acn_show_error_message');
}

?>