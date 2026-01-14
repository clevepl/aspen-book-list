=== Aspen List ===
Contributors:      Cleveland Public Library (will skora and Tyrone Fontaine)
Tags:              aspen,
Tested up to:      6.9
Stable tag:        0.3.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Display a list of books (or other items) from Aspen's Discovery Catalog into WordPress as a block.

This is intended for libraries and their websites; Aspen Discovery's API is not intended to be used by end users at this time (sorry).

LIMITATION: only will display the first 25 items on a list; then links to the entire list.

== Description ==

The WordPress block was built with Create-Block(https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) and uses wp-scripts.

== Installation ==

This section describes how to install the plugin and get it working.

1. Work with Aspen support and direct them to make an authorized API token for you.
2. In your website's wp-config.php, add the line
define( 'ASPEN_API_AUTHORIZATION_TOKEN', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
with your API key replacing XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.
3. In your website's wp-config.php, add the line
define( 'ASPEN_API_CATALOG_URL', 'https://search.aspen-discovery.org');

Replace https://search.aspen-discovery.org with your catalog's URL; do not include a trailing backslash at the end of your catalog's URL.

4. Download https://github.com/clevepl/aspen-book-list/archive/refs/heads/main.zip and unzip directory into your plugins directory folder
5. Activate the plugin through the 'Plugins' screen in WordPress (or WP-CLI).

== For Development ==

If you wish to customize this, you will need to be familiar with the wordPress block building process (https://developer.wordpress.org/block-editor/getting-started/tutorial/ is a good place to start)

1. Clone repository
2. run `npm run install` within the directory
3. If you are adding a new class, run `composer dump-autoload -o` in plugin's root foldeer

== Frequently Asked Questions ==

= Does this use WordPress' interactivity API ?  =

No, not yet; might be on the radar.

= Why does the list's contents not display within the block editor?  =

Eventually.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.3.0 =
* BREAKING: Block has been renamed from cpl/aspen-book-list to cpl/aspen-list; Existing blocks will not work.
This name change will enable us to sync changes from our production instance (hosted elsewhere) to this repository.
* Rename textdomain, PHP class

= 0.2.2 =
* Add a link to the entire list if the list has more than 25 items

= 0.2.1 =
* Cache list results for 1 week

= 0.2.0 =
* Rewritten in OOP (Object-Oriented Programming)
* eliminate crashes when errors occur

= 0.1.4 =
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
