<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


// function get_api_key(): string {
// return defined( 'GOOGLE_PLACES_API_KEY' ) ? constant( 'GOOGLE_PLACES_API_KEY' ) : '';
// }


$special_header_args = [
	'headers' => [
		'X-Custom-SPECIAL' => constant( 'ASPEN_API_AUTHORIZATION_TOKEN' ),
		'X-custom-CPL'     => 'WP_PHP_Aspen_block',
	],
];

// can abstract this out for a more generic block as a block attribute
$home_url = 'https://search.cpl.org';


$teh_request = wp_remote_get( 'https://search.cpl.org/API/ListAPI?method=getListTitles&id=79054', $special_header_args );
// $teh_request = wp_remote_get( 'https://rt.ambientweather.net/v1/devices?applicationKey=aee5a31d2dca41569022873b7c017395e3fdda29384a42b49d6404a8b9187f81&apiKey=4a56d5f742bc4517aac0d55b7c6e146f279da1cb7e3d4235af1c436f31124c83', $special_header_args );


if ( is_wp_error( $teh_request ) ) {
	return false; // Bail early
}

// if headers response code is 403 - then bail and return; your API key is not authorized or there's a connection error with Aspen
// result-> in an array, titles<
if ( $teh_request['response']['code'] === 403 ) {
	return new WP_Error( 'Bad response code, 403', 'Falling and cant get up' );
}

echo $teh_request['response']['code'];


$body = wp_remote_retrieve_body( $teh_request );

$teh_data = json_decode( $body, true ); // true for an array

if ( ! empty( $teh_data ) ) {
	?>
<p <?php echo get_block_wrapper_attributes(); ?>> keep this for now, so i don't forget about block_wrapper_attributes </p>
	<h2> <?php esc_html_e( $teh_data['result']['listTitle'], 'aspen-book-list' ); ?> </h2>

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
	<h3 class="cpl-flex--mini__item-name">
			<?php echo esc_html( $title ); ?>          </h3>
				<span class="cpl-flex--mini__item-date">
				<?php echo esc_html( $author ); ?>   </span><br>

					<p><?php echo( $description ); ?>    </p>             </li>
</div>

	<div class="footer">
	An optional footer goes here.
	</div>
</div>

		<?php
	endforeach;

	// } // end of for loop
	?>

	<?php
} else {

	?>

<p> USING THE api key explictly mentioned he API request was successful but there are no items in this list</p>


	<?php
}

?>
