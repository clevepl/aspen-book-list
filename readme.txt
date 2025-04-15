=== Aspen Book List ===
Contributors:      Cleveland Public Library (will skora and Tyrone Fontaine)
Tags:              aspen,
Tested up to:      6.7
Stable tag:        0.1.4
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Display a list from Aspen's Discovery Catalog into WordPress as a block;

LIMITATION: only will display the first 25 items on a list (for now).

== Description ==

The WordPress block was built with Create-Block(https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) and uses wp-scripts.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Work with Aspen support and direct them to make an authorized API token for you.
2. In your website's wp-config.php, add the line
define( 'ASPEN_API_AUTHORIZATION_TOKEN', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
with your API key replacing XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.
3. In your website's wp-config.php, add the line
define( 'ASPEN_API_CATALOG_URL', 'https://search.aspen-discovery.org');

Replace https://search.aspen-discovery.org with your catalog's URL; Do not include the trailing backslash at the end of your catalog's URL.

4. Clone this repository and place it in the plugins folder.
5. Activate the plugin through the 'Plugins' screen in WordPress (or WP-CLI).


== For Development ==

1. Clone repository
2. run `npm run install` within the directory


== Frequently Asked Questions ==

= Does this use WordPress' interactivity API ?  =

No, not yet; might be on the radar.

= Why does the list not display within the editor?  =

It does now.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1.3 =
* Improved display on smaller screens
* clear error messages

= 0.1.3 =
* Customize your site's URL
* Display the list's content within the block editor

= 0.1.2 =
* Enter the listID to input any list you have !

= 0.1.0 =
* Internal release

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above. This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation." Arbitrary sections will be shown below the built-in sections outlined above.
