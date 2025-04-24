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

$list_id = isset( $attributes['listID'] ) ? $attributes['listID'] : '';

$my_new_list_object = new \Cpl\AspenBookList\AspenList();


$teh_data = $my_new_list_object->fetch_list($list_id);
$catalog_url = $my_new_list_object->get_aspen_url();

// if  (empty($catalog_url)) {
// 	$the_error->add('the Catalog URL is not defined; please read the README For more information','the Catalog URL is not defined; please read the README For more information');
// 	echo $the_error->get_error_message();

// }

// // if headers response code is 403 - then bail and return; your API key is not authorized or there's a connection error with Aspen
// if ( $teh_request['response']['code'] === 403 ) {
// 	// $form_error = new WP_Error;
//  //	throw new Exception ( $teh_request['body'] . 'Your API key or IP address is not authorized ');
//  $the_error->add( $teh_request['body'] . 'Your API key or IP address is not authorized ');
//  echo $the_error->get_error_message();
// }

// even there is a successful response, the JSON body can return a message that has an error message
// if ( $teh_data['result']['success'] === false) {
	// $the_error_message = $teh_data['result']['message'];
	// $the_error_message = new \WP_Error;
	// $the_error_message->add( $teh_data['result']['message'] , $teh_data['result']['message'] );
	// echo $the_error_message;

		// throw new Exception ( $the_error_message . 'This happens when the list is set to private; OR You haven\'t entered the list\'s ID. please toggle the list to be public so it can be used');
	// return new WP_Error( $the_error_message, 'Falling and cant get up' );
// }

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
