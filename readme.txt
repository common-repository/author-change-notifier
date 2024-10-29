=== Plugin Name ===
Contributors: abdullah82
Tags: author, notify, notification, business, directory, classifieds, listing, claim, email, e-mail
Requires at least: 2.7
Tested up to: 3.1.2
Stable tag: 1.0.2
License: GPLv2

== Description ==
Author Change Notifier (ACN): If you run a business directory or a classifieds website and you want to give the advertizers the ability to claim other posts in the website then this plugin is right for you. Once you change the author/owner/user who originally created the post, this plugin will send custom email notifications to the previous as well as the new author/owner/user who now has control over the post or listing. Notice that this is just a NOTIFICATION plugin, it is not an A-Z solution for claiming posts. You can create a custom form using other plugins to allow your users to send you claims. Then once you manually modify the author of the post, ACN will step in and notify the previous and new author of the change.

ACN features:
1. Custom email subject and text to be sent to the previous author
2. Custom email subject and text to be sent to the new author
3. Placeholders inside email text like: %post_title%, %new_author_email%, etc. Those will be replaced with actual values once the emails are sent.
you put the stable version, in order to eliminate any doubt.

== Installation ==
Automatically install using Wordpress (Plugins) menu,
or:
1. Download the zip file and extract it
2. Upload its contents to the `/wp-content/plugins/` directory which is inside the Wordpress root directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What is the mailing functionality used by this plugin? =

This plugin uses Wordpress' built-in e-mail functionality, e.g. (wp_mail). Therefore you should make sure Wordpress e-mailing is already working correctly.

= Can this plugin help me change the author of a certain post? =

No. This plugin only notifies authors of posts when the user in charge changes authors of posts from the admin panel.

= Does the plugin notify authors of Pages if the admin changes the author of a page? =

Currently, the plugin only works with posts.

= Where can I change Author Change Notifier's settings? =

You can do that by going to the admin panel, then choosing the (Settings) menu, then choosing the (Author Change Notifier) sub-menu.

== Changelog ==

= 1.0 =
* Author Change Notifier released.

= 1.0.1 =
* Minor fixes.

= 1.0.2 =
* Spelling corections.

== Screenshots ==

1. Author Change Notifier settings