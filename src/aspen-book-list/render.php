<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// ini_set('display_errors', 'On');

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

$teh_request = wp_remote_get( $catalog_url . '/API/ListAPI?method=getListTitles&id=' . $list_id, $special_header_args );

// if headers response code is 403 - then bail and return; your API key is not authorized or there's a connection error with Aspen
if ( $teh_request['response']['code'] === 403 ) {
	// $form_error = new WP_Error;
 //	throw new Exception ( $teh_request['body'] . 'Your API key or IP address is not authorized ');
}

$body = wp_remote_retrieve_body( $teh_request );

$teh_data = json_decode( $body, true );

// even there is a successful response, the JSON body can return a message that has an error message
if ( $teh_data['result']['success'] === false) {
	// $the_error_message = $teh_data['result']['message'];
	// $the_error_message = new \WP_Error;
	// $the_error_message->add( $teh_data['result']['message'] , $teh_data['result']['message'] );
	// echo $the_error_message;

		// throw new Exception ( $the_error_message . 'This happens when the list is set to private; OR You haven\'t entered the list\'s ID. please toggle the list to be public so it can be used');
	// return new WP_Error( $the_error_message, 'Falling and cant get up' );
}

if ( ! empty( $teh_data ) ) {
	?>
<div
	<?php
	echo get_block_wrapper_attributes(
		[
			'class' => 'master-container',
		]
	);
	?>
	>

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
	<img alt="<?php echo esc_html( $title ); ?> cover" src="<?php echo esc_url( $catalog_url . $image_small, 'aspen-book-list' ); ?>">
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
