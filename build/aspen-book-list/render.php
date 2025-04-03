<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */



$special_header_args = [
	'headers' => [
		'X-Custom-SPECIAL' => defined( 'ASPEN_API_AUTHORIZATION_TOKEN' ),
		'X-custom-CPL'     => 'WP_PHP_Aspen_block',
	],
];




$teh_request = wp_remote_get( 'https://search.cpl.org/API/ListAPI?method=getListTitles&id=26', $special_header_args );
// $teh_request = wp_remote_get( 'https://rt.ambientweather.net/v1/devices?applicationKey=aee5a31d2dca41569022873b7c017395e3fdda29384a42b49d6404a8b9187f81&apiKey=4a56d5f742bc4517aac0d55b7c6e146f279da1cb7e3d4235af1c436f31124c83', $special_header_args );

if ( is_wp_error( $teh_request ) ) {
	return false; // Bail early
}



$body = wp_remote_retrieve_body( $teh_request );

print_r( $body );


$teh_data = json_decode( 'body', true ); // true for an array

if ( ! empty( $teh_data ) ) {
	?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( 'yes, the request was successful and there are items in this book list!', 'aspen-book-list' ); ?>
</p>
	<?php
} else {

	?>

<p> The API request was successful but there are no items in this list</p>


	<?php
}

?>
