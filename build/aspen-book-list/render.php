<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

 /**
 * cpl markup
 *
 * @var array    $attributes         Block attributes.
 * @var string   $content            Block content.
 * @var WP_Block $block              Block instance.
 */


$list_id = isset( $attributes['listID'] ) ? $attributes['listID'] : '';

// explicitly cast as integer
settype($list_id, 'integer');

// function get_api_key(): string {
// return defined( 'GOOGLE_PLACES_API_KEY' ) ? constant( 'GOOGLE_PLACES_API_KEY' ) : '';
// }

// TODO: MAKE THIS OOP, (ARE YOU DOWN WITH OOP, YEAH YOU KNOW ME?!)


$special_header_args = [
	'headers' => [
		'X-Custom-SPECIAL' => constant( 'ASPEN_API_AUTHORIZATION_TOKEN' ),
		'X-custom-CPL'     => 'WP_PHP_Aspen_block',
	],
];

// can abstract this out for a more generic block as a block attribute
$home_url = 'https://search.cpl.org';


$teh_request = wp_remote_get( 'https://search.cpl.org/API/ListAPI?method=getListTitles&id=' . $list_id , $special_header_args );

if ( is_wp_error( $teh_request ) ) {
	return false; // Bail early
}

// if headers response code is 403 - then bail and return; your API key is not authorized or there's a connection error with Aspen
// result-> in an array, titles
// however, an array is not thrown even though  echo $teh_request['response']['code']; will turn 403.
if ( $teh_request['response']['code'] === 403 ) {
	return new WP_Error( 'Bad response code, 403', 'Falling and cant get up' );
}

$body = wp_remote_retrieve_body( $teh_request );

$teh_data = json_decode( $body, true ); // true for an array

if ( ! empty( $teh_data ) ) {
	?>
<p <?php echo get_block_wrapper_attributes(); ?>> keep this for now, so i don't forget about block_wrapper_attributes </p>
	<h2><?php esc_html( $teh_data['result']['listTitle'], 'aspen-book-list' ); ?> </h2>

	<?php
	$my_array = $teh_data['result']['titles'];


	foreach ( $my_array as $item ) :

		$title       = $item['title'];
		$author      = $item['author'];
		$item_url    = $item['titleURL'];
		$image_small = $item['small_image'];
		$description = $item['description'];


		?>

	<div class="media-object-container">

	<div class="media-object__media">
	<img src="<?php echo esc_url( $home_url . $image_small, 'aspen-book-list' ); ?>" alt="Balloons">
	</div>
	<div class="media-object__object">
	<h3 class="cpl-flex--mini__item-name">
			<?php echo esc_html( $title ); ?>          </h3>
				<span class="cpl-flex--mini__item-date">
				By: <?php echo esc_html( $author ); ?>   </span><br>

				<p></p>             </li>


				<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $item_url, 'aspen-book-list' ); ?>">Reserve this item</a></div>
</div>
		</div>
	</div>

		<?php
	endforeach;

	// } // end of for loop
	?>

	<?php
} else {

	?>

<p> The API request was successful but there are no items in this list; this will be refined </p>


	<?php
}

?>
