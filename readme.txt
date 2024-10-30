CartCount for WooCommerce
Contributors: humorhenker
Donate link: https://roteserver.de/donate
Tags: WooCommerce WC
Requires at least: 5.0
Tested up to: 5.4
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds 2 shortcodes to easily get the current WooCommerce cartcount 

== Description ==

Do you ever wanted to add a custom cart counter to your WooCommerce shop?
Now you can do this easily by utilizing this plugin and add thes shortcodes `[wc_cart_count]` `[wc_cart_count_left]` to your shop theme.
wc_cart_count_left is intended to display the items left in order to fill a complete shipping package you will need to set the Fullcount setting accordingly in the settings for this plugin.

To dynamical change the value of the textelemnts displaying the cartcounts you can add `<p>` elements with the `cartcount` or `cartcountleft` class those will get updated with the ajax requests from WooCommerce. Extra attributes of those `<p>` will get lost when updating if you dont supply those attributes in the according settings fields.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Adjust the setting in the setting menu
1. Add the inculded shortcodes to your theme whereever you need them

== Frequently Asked Questions ==

if you have questions feel free to ask you can contact me at info (at) roteserver (dot) de

== Screenshots ==

nothing to show here since the plugin is pretty small and self-explanatory

== Changelog ==

= 1.0 =
* first release
= 1.1 =
* adding dynamical ajax updates and setting page

== Upgrade Notice ==

= 1.0 =
First release
= 1.1 =