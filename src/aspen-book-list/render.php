<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

/**
 * cpl markup
 *
 * @package Cpl // TODO update everywhere else
 *
 * @var array    $attributes         Block attributes.
 * @var string   $content            Block content.
 * @var WP_Block $block              Block instance.
 * @var array    $context    Block context.
 */

// function get_api_key(): string {
// return defined( 'GOOGLE_PLACES_API_KEY' ) ? constant( 'GOOGLE_PLACES_API_KEY' ) : '';
// }

// TODO: MAKE THIS OOP, (ARE YOU DOWN WITH OOP, YEAH YOU KNOW ME?!)

$list_id = isset( $attributes['listID'] ) ? $attributes['listID'] : '';


$catalog_url = esc_url( constant( 'ASPEN_API_CATALOG_URL' ), 'https' );
// TODO, HANDLE A ERROR BETTER TO VALIDATE$error_bad_catalog_url = new WP_Error(' ')

// explicitly cast as integer
settype( $list_id, 'integer' );

// reminder: ASPEN_API_AUTHORIZATION_TOKEN is defined in wp-config.php
$special_header_args = [
	'headers' => [
		'X-Custom-SPECIAL' => constant( 'ASPEN_API_AUTHORIZATION_TOKEN' ),
		'X-custom-CPL'     => 'WP_PHP_Aspen_block',
	],
];

// can abstract this out for a more generic block as a block attribute
$home_url = 'https://search.cpl.org';


$teh_request = wp_remote_get( $catalog_url . '/API/ListAPI?method=getListTitles&id=' . $list_id, $special_header_args );

if ( is_wp_error( $teh_request ) ) {
	return false; // Bail early
}

// if headers response code is 403 - then bail and return; your API key is not authorized or there's a connection error with Aspen
// result-> in an array, titles
// however, an error is not thrown even when echo $teh_request['response']['code']; will turn 403.
// TODO
if ( $teh_request['response']['code'] === 403 ) {
	return new WP_Error( 'Bad response code, 403', 'Falling and cant get up' );
}

$body = wp_remote_retrieve_body( $teh_request );

$teh_data = json_decode( $body, true );
if ( ! empty( $teh_data ) ) {
	?>
<p <?php echo get_block_wrapper_attributes(); ?>> keep this for now, so i don't forget about block_wrapper_attributes </p>

<div class="master-container">

	<?php
	$my_array = $teh_data['result']['titles'];


	foreach ( $my_array as $item ) :

		$title       = $item['title'];
		$author      = $item['author'];
		$item_url    = $item['titleURL'];
		$image_small = $item['image'];
		$description = $item['description'];


		?>

<div class="media-object-container">

	<div class="media-object__media">
	<img alt="cover for <?php echo esc_html( $title ); ?>" src="<?php echo esc_url( $home_url . $image_small, 'aspen-book-list' ); ?>" alt="Balloons">
	</div>
	<div class="media-object__object">

		<h3 class="cpl-flex--mini__item-name"><?php echo esc_html( $title ); ?></h3>

		<?php if ( ! empty( $author ) ) : ?>
	<span class="cpl-flex--mini__item-date">By: <?php echo esc_html( $author ); ?></span>
		<?php endif; ?>

		<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
			<div class="wp-block-button">
				<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $item_url, 'aspen-book-list' ); ?>">Reserve <span class="screen-reader-text"> <?php echo esc_html( $title ); ?></span></a></div>
			</div>
		</div>

	</div><!-- media-object__object -->

		<?php
	endforeach;

	// } // end of for loop
	?>

</div><!-- master-container -->

	<?php
} else {

	?>

<p> The API request was successful but there are no items in this list; this will be refined </p>


	<?php
}

?>
