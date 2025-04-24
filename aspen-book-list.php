<?php
/**
 * Plugin Name:       Aspen Book List
 * Description:       Display a list from the Aspen Discovery API
 * Version:           0.2.0
 * Requires at least: 6.7
 * Requires PHP:      8.X
 * Author:            Cleveland Public Library (Will skora and Tyrone Fontaine)
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       aspen-book-list
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// LOAD the AUTOLOADING class
require_once dirname(__FILE__)."/vendor/autoload.php";


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_aspen_book_list_block_init() {
	register_block_type( __DIR__ . '/build/aspen-book-list' );
}
add_action( 'init', 'create_block_aspen_book_list_block_init' );
