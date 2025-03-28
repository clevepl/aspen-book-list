<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


 $teh_request = wp_remote_get( '' );

 if( is_wp_error( $request ) ) {
	return false; // Bail early
}

$body = wp_remote_retrieve_body( $request );

?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( 'Aspen Book List – hello from a dynamic block!', 'aspen-book-list' ); ?>
</p>

<?php
