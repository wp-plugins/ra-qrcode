=== ra_qrcode ===
Contributors: RobertoAlicata
Tags: qr code, qrcode, qr code generator, qrcode generator, qr code shortcode
Donate link: http://www.robertoalicata.it
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

a simple WordPress plugin to generate a QR code with a configurable shortcode.

== Description ==
Usage:
write [qrcode] to generate a QRcode for the actual url with size of 100x100 pixels

you can specify these attributes:
size 	(it indicates the size in pixels for width and height, default: 100)
alt  	(it indicates the alternative text for the image: default "scan QR code")
content (leave it blank to pass the actual url or write the content to encode)
click 	(write "yes" to make the image clickable)

example: [qrcode size=200 content="www.robertoalicata.it" alt="scan me NOW" click="yes"]

== Installation ==
1. Upload the plugin directory to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
.

== Screenshots ==
1. the simplest shortcode
2. the qr code generated

== Changelog ==
1.0.0 Fisrt stable version
0.1.0 First version of the plugin

== Upgrade Notice ==
.