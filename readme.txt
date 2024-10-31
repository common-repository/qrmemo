=== QRMemo ===
Contributors: mrpro64
Donate link: https://donate.stripe.com/9AQ9CP7rX6cR70AfYZ
Tags: qr code, shortcode, post types
Requires at least: 5.0
Tested up to: 6.6.2
Stable tag: 1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

QRMemo is a WordPress plugin that adds QR codes to the end of selected post types and allows generating QR codes via shortcode.

== Description ==

QRMemo is a versatile WordPress plugin that enables you to automatically generate and display QR codes at the end of specific post types. The QR codes added automatically contain the URL of the page or post they are appended to, making it easy for users to share or save the page.

The plugin also supports generating QR codes using a shortcode, allowing you to insert a QR code with custom text anywhere in your content.

**Key Features:**
* Automatically add QR codes containing the page URL to the end of posts, pages, and other custom post types.
* Customize which post types should display QR codes.
* Generate QR codes via shortcode, specifying custom text, size, margin, and alignment.

**Libraries Used:**
* [Endroid QR Code](https://github.com/endroid/qr-code) - A powerful library for generating QR codes in PHP.

== Installation ==

1. Upload the `qrmemo` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin settings under 'Settings' -> 'QRMemo'.

== Frequently Asked Questions ==

= How do I insert a QR code in my content? =

You can use the `[qrmemo]` shortcode to insert a QR code anywhere in your content. For example:

`[qrmemo text="Hello World" size="150" margin="10" align="center"]`

This shortcode generates a QR code with the specified text, size, margin, and alignment.

= Can I choose which post types display QR codes automatically? =

Yes! In the plugin settings, you can select the post types where QR codes should be automatically added.

== Screenshots ==

1. **Settings Page** - The settings page allows you to select which post types should display QR codes automatically.

== Changelog ==

= 1.0 =
* Initial stable release with support for adding QR codes to selected post types and shortcode generation.
* Simplified settings and removed unnecessary options for a streamlined user experience.

== Upgrade Notice ==

= 1.0 =
Initial stable release. Review your settings after upgrading to ensure proper configuration.

== License ==

This plugin is licensed under the GPLv2 or later. For more details, see [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html).