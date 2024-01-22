<?php
/**
 * Print Labels.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PrintLabels;

use WP_Query;

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * API Endpoint for conversion service.
 * 
 * @var string
 */
const ENDPOINT = 'https://hcti.io/v1/image';

/**
 * User ID for conversion service.
 * 
 * @var string
 */
const USER_ID = '00868e7f-e562-4d1d-a6ed-313e1823b76a';

/**
 * API key for conversion service.
 * 
 * @var string
 */
const API_KEY = 'c710d99b-5764-4623-ba6a-827281f00808';

/**
 * Allowed layouts
 * 
 * @var array
 */
const LAYOUTS = [
	'vertical',
	'horizontal',
];

/**
 * Setup
 */
function setup(): void {
	add_action( 'init', __NAMESPACE__ . '\add_rewrite_endpoint' );
	add_action( 'wp', __NAMESPACE__ . '\save_image' );
}

/**
 * Add endpoints for pretty permalinks
 */
function add_rewrite_endpoint(): void {
	foreach ( LAYOUTS as $layout ) {
		add_rewrite_endpoint( $layout, EP_ALL );
	}
}

/**
 * Check the $wp_query to make sure we are on the proper endpoint
 *
 * @param WP_Query $query WP_Query.
 * @param string   $layout Layout type.
 */
function maybe_run( WP_Query $query, string $layout ): bool {
	return isset( $query->query_vars[ esc_attr( $layout ) ] );
}

/**
 * Get the file name based on the Layout being requested
 *
 * @param string $layout Layout type.
 */
function get_file_name( string $layout ): string {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return '';
	}

	$object_id = get_field( OBJECT_ID, $post_id );
	if ( empty( $object_id ) ) {
		return '';
	}

	$prefix = get_taxonomy_term_prefix( $post_id );
	if ( empty( $prefix ) ) {
		return '';
	}

	return sprintf(
		'%s.jpg',
		uniqid( $prefix . $object_id . '-' . $layout . '-' )
	);
}

/**
 * Returns the prefix for a taxonomy term.
 *
 * @param int $post_id Post ID.
 */
function get_taxonomy_term_prefix( int $post_id ): string {
	$terms = get_the_terms( $post_id, FORM );
	if ( ! $terms ) {
		return '';
	}

	if ( is_wp_error( $terms ) ) {
		return '';
	}

	foreach ( $terms as $term ) {
		$term_id = $term->term_id;
	}

	if ( empty( $term_id ) ) {
		return '';
	}
	 
	$prefix = get_term_meta( $term_id, OBJECT_PREFIX, true );

	return $prefix ? (string) $prefix : '';
}

/**
 * Get the HTML layout depending on the endpoint
 *
 * @param string $layout Layout type.
 */
function get_the_layout( string $layout ): string {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return '';
	}

	$object_id = get_field( OBJECT_ID, $post_id );
	if ( empty( $object_id ) ) {
		return '';
	}

	$prefix = get_taxonomy_term_prefix( $post_id );
	if ( empty( $prefix ) ) {
		return '';
	}

	if ( 'vertical' === $layout ) {
		return sprintf(
			'<section style="text-align:center;">%s<h1 style="font-size:40px;margin:0;">%s%s</h1></section>',
			get_the_post_thumbnail(
				$post_id,
				'large',
				[
					'style' => 'width:150px;height:auto;margin-bottom:20px',
				],
			),
			esc_html( $prefix ),
			esc_html( $object_id )
		);

	}

	return sprintf(
		'<section style="display:flex;align-items:center;"><div style="display:inline-block;">%s</div><h1 style="display:inline-block;font-size:40px;margin:0 0 0 20px;">%s%s</h1></section>',
		get_the_post_thumbnail(
			$post_id,
			'large',
			[
				'style' => 'width:150px;height:auto;margin-left:20px',
			],
		),
		esc_html( $prefix ),
		esc_html( $object_id )
	);
}

/**
 * Contact the remote server to build the image.
 *
 * Get a JSON response back and grab the URL value.
 *
 * @param string $html HTML to convert.
 */
function get_remote_response( string $html ): string {
	$curlHandle = curl_init(); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_init

	curl_setopt( $curlHandle, CURLOPT_URL, ENDPOINT ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

	curl_setopt( $curlHandle, CURLOPT_RETURNTRANSFER, 1 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

	curl_setopt( // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
		$curlHandle,
		CURLOPT_POSTFIELDS,
		http_build_query(
			[
				'html' => $html,
			]
		)
	);

	curl_setopt( $curlHandle, CURLOPT_POST, 1 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

	curl_setopt( $curlHandle, CURLOPT_USERPWD, USER_ID . ':' . API_KEY ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

	$headers   = [];
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt( $curlHandle, CURLOPT_HTTPHEADER, $headers ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

	$result = curl_exec( $curlHandle );  // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec

	if ( curl_errno( $curlHandle ) !== 0 ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_errno
		echo wp_kses_post( 'Error:' . curl_error( $curlHandle ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_error
	}
	curl_close( $curlHandle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_close

	$response = json_decode( $result, true );

	return $response['url'];
}

/**
 * Build the document then save to the browser if we are on the proper endpoint.
 *
 * @param WP_Query $query WP_Query.
 */
function save_image( WP_Query $query ): void {
	foreach ( LAYOUTS as $layout ) {

		if ( maybe_run( $query, $layout ) ) {

			$url = get_remote_response( get_the_layout( $layout ) );

			if ( ! empty( $url ) ) {

				header( 'Content-Type: application/octet-stream' );
				header( 'Content-Disposition: attachment; filename=' . get_file_name( $layout ) );

				readfile( $url ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_readfile

			}
		}
	}
}
