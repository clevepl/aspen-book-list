<?php

namespace Cpl\AspenBookList;

final class AspenList {

	/**
	 * Get the aspen CATALOG URL, return empty string if not defined
	 * should be defined in wp-config.php
	 *
	 * @return string aspen catalog url
	 */
	public function get_aspen_url(): string {
		return defined( 'ASPEN_API_CATALOG_URL' ) ? constant( 'ASPEN_API_CATALOG_URL' ) : '';
	}

	/**
	 * Get the associated/ special token that you registered with your Aspen Support Team; return empty string if not defined
	 * ASPEN_API_AUTHORIZATION_TOKEN is defined in wp-config.php
	 *
	 * @return string special token
	 */
	protected function get_aspen_special_token(): string {
		return defined( 'ASPEN_API_AUTHORIZATION_TOKEN' ) ? constant( 'ASPEN_API_AUTHORIZATION_TOKEN' ) : '';
	}

	// returns an array, teh_request
	/**
	 * @param  string $listid (it's just easier if we treat it as a string)
	 * @return array|WP_Error
	 */
	public function fetch_list( $listid ) {


		$cached_list = get_transient ( 'aspen_api_list_id_' . $listid);

		if (! empty ( $cached_list ) ) {
			return $cached_list;

		}

		$teh_request = wp_remote_get(
			$this->get_aspen_url() . '/API/ListAPI?method=getListTitles&id=' . sanitize_key( $listid ),
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

		/*
		* even there is a successful response from the API, the response from Aspen can result in 3 scenarios where we will not have a list:
		* $teh_data['result']['success'] === false has three scenarios:
		* the list is exists and is marked as private in Aspen (clear error message is given here)
		// OR (and the Aspen API gives the identical error message in the following two scenarios )
		// No listID was included in the block; or no such list with that listID exists.
		*/
		if ( $teh_data['result']['success'] === false ) {
			$the_error_message = $teh_data['result']['message'];
			$the_error_message = new \WP_Error();
			echo 'Error in block: ' . $teh_data['result']['message'] . 'Your list does not exist or you forgot to input a listid';
			// $the_error_message->add( $teh_data['result']['message'] , $teh_data['result']['message'] );
			// echo $the_error_message;
		}

		// transient length set for 7 days ()
		set_transient( 'aspen_api_list_id_' . $listid , $teh_data, 604800);

		return $teh_data;
	}
}
