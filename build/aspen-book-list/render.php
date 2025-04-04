<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


// function get_api_key(): string {
// 	return defined( 'GOOGLE_PLACES_API_KEY' ) ? constant( 'GOOGLE_PLACES_API_KEY' ) : '';
// }


$special_header_args = [
	'headers' => [
		'X-Custom-SPECIAL' => constant('ASPEN_API_AUTHORIZATION_TOKEN'),
		'X-custom-CPL'     => 'WP_PHP_Aspen_block',
	],
];




$teh_request = wp_remote_get( 'https://search.cpl.org/API/ListAPI?method=getListTitles&id=79054', $special_header_args );
// $teh_request = wp_remote_get( 'https://rt.ambientweather.net/v1/devices?applicationKey=aee5a31d2dca41569022873b7c017395e3fdda29384a42b49d6404a8b9187f81&apiKey=4a56d5f742bc4517aac0d55b7c6e146f279da1cb7e3d4235af1c436f31124c83', $special_header_args );

if ( is_wp_error( $teh_request ) ) {
	return false; // Bail early
}
$body = wp_remote_retrieve_body( $teh_request );

$teh_data = json_decode( $body, true ); // true for an array

// print_r( $teh_data );


// result-> in an array, titles<

if ( ! empty( $teh_data ) ) {
	?>
<p <?php echo get_block_wrapper_attributes(); ?>> the block output will be below</p>
	<?php esc_html_e( 'yes ' . $teh_data['result']['listTitle'], 'aspen-book-list' );

$my_array = $teh_data['result']['titles'];
echo $teh_data['result']['listTitle'];

// for ($xx=0; $xx<count(($my_array)); $xx++)
// {

foreach ($my_array as $item):
?>
	<b> <?php echo esc_html( $item['title'], 'aspen-book-list' ); ?> </b> <br>

<?php
	endforeach;

//} // end of for loop
?>

	<?php
} else {

	?>

<p> USING THE api key explictly mentioned he API request was successful but there are no items in this list</p>


	<?php
}

?>
