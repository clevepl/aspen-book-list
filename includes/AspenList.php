<?php


namespace Cpl\AspenBookList;

final class AspenList {

	/**
	 * Get the aspen CATALOG URL, return empty string if not defined
	 *
	 * @return string aspen catalog url
	 */
	protected function get_aspen_url(): string {
		return defined( 'ASPEN_API_CATALOG_URL' ) ? constant( 'ASPEN_API_CATALOG_URL' ) : '';
	}

	/**
	 * Get the associated/ special token that you registered with your Aspen Support Team; return empty string if not defined
	 *
	 * @return string special toke
	 */
	protected function get_aspen_special_token(): string {
		return defined( 'ASPEN_API_AUTHORIZATION_TOKEN' ) ? constant( 'ASPEN_API_AUTHORIZATION_TOKEN' ) : '';
	}

	// public function fetch_prep() {

	// }

	// returns an array, teh_request
	/**
	* @param  // listid attribute
	* @return array|WP_Error
	*/
	public function fetch_list() {
		$teh_request = wp_remote_get(
		$this->get_aspen_url() . '/API/ListAPI?method=getListTitles&id=26',
		[
		'headers' => [
			'X-Custom-SPECIAL' => $this->get_aspen_special_token(),
			'X-custom-CPL'     => 'WP_PHP_Aspen_block',
		],
		]
	);

	// set transient for the list spefifically
	// set_transient( self::LIBCAL_ACCESS_TOKEN_CACHE_GROUP, $data['access_token'], 3600 );


	// Check for request errors
	if ( is_wp_error( $teh_request ) ) {
		return new \WP_Error( 'libcal_token_error', __( 'Failed to retrieve LibCal access token.', 'cpl-plugin' ) );
	}

	$body = wp_remote_retrieve_body( $teh_request );

	$teh_data = json_decode( $body, true );

	echo "hossenfeffer";


	return $teh_data;


	}

}

?>
