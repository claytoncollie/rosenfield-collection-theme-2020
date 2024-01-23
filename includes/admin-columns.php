<?php
/**
 * Admin Columns.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\AdminColumns;

use const RosenfieldCollection\Theme\Fields\ARTIST_FILTER;
use const RosenfieldCollection\Theme\Fields\ARTIST_PHOTO;
use const RosenfieldCollection\Theme\Fields\OBJECT_DATE;
use const RosenfieldCollection\Theme\Fields\OBJECT_HEIGHT;
use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_IMAGES;
use const RosenfieldCollection\Theme\Fields\OBJECT_LENGTH;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\Fields\OBJECT_PRICE;
use const RosenfieldCollection\Theme\Fields\OBJECT_WIDTH;
use const RosenfieldCollection\Theme\ImageSizes\THUMBNAIL;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'get_avatar_url', __NAMESPACE__ . '\get_avatar_url', 10, 2 );
	add_filter( 'manage_posts_columns', __NAMESPACE__ . '\post_column_titles' );
	add_action( 'manage_posts_custom_column', __NAMESPACE__ . '\post_column_content', 10, 2 );
	add_filter( 'manage_edit-post_sortable_columns', __NAMESPACE__ . '\post_id_column_sortable' );
	add_filter( 'manage_users_columns', __NAMESPACE__ . '\user_column_titles' );
	add_filter( 'manage_users_custom_column', __NAMESPACE__ . '\user_column_content', 10, 3 );
	add_filter( 'manage_edit-rc_form_columns', __NAMESPACE__ . '\form_taxonomy_column_title' );
	add_filter( 'manage_rc_form_custom_column', __NAMESPACE__ . '\form_taxonomy_column_content', 10, 3 );
}

/**
 * Post column titles
 *
 * @param array $defaults Default columns.
 */
function post_column_titles( array $defaults ): array {
	// Unset default columns.
	unset( $defaults['title'] );
	unset( $defaults['author'] );
	unset( $defaults['categories'] );
	unset( $defaults['tags'] );
	unset( $defaults['comments'] );
	unset( $defaults['date'] );
	unset( $defaults['taxonomy-rc_form'] );
	unset( $defaults['taxonomy-rc_firing'] );
	unset( $defaults['taxonomy-rc_technique'] );
	unset( $defaults['taxonomy-rc_column'] );
	unset( $defaults['taxonomy-rc_row'] );
	unset( $defaults['taxonomy-rc_location'] );
	unset( $defaults['taxonomy-rc_result'] );

	// Add columns with new order.
	$defaults['featured_image']        = esc_html__( 'Featured Image', 'rosenfield-collection' );
	$defaults['title']                 = esc_html__( 'Title', 'rosenfield-collection' );
	$defaults['author']                = esc_html__( 'Artist', 'rosenfield-collection' );
	$defaults[ OBJECT_PREFIX ]         = esc_html__( 'Prefix', 'rosenfield-collection' );
	$defaults[ OBJECT_ID ]             = esc_html__( 'ID', 'rosenfield-collection' );
	$defaults['date']                  = esc_html__( 'Date', 'rosenfield-collection' );
	$defaults['taxonomy-rc_form']      = esc_html__( 'Form', 'rosenfield-collection' );
	$defaults['taxonomy-rc_firing']    = esc_html__( 'Firing', 'rosenfield-collection' );
	$defaults['taxonomy-rc_technique'] = esc_html__( 'Technique', 'rosenfield-collection' );
	$defaults['taxonomy-rc_column']    = esc_html__( 'Column', 'rosenfield-collection' );
	$defaults['taxonomy-rc_row']       = esc_html__( 'Row', 'rosenfield-collection' );
	$defaults['taxonomy-rc_location']  = esc_html__( 'Location', 'rosenfield-collection' );
	$defaults['taxonomy-rc_result']    = esc_html__( 'Result', 'rosenfield-collection' );
	$defaults[ OBJECT_HEIGHT ]         = esc_html__( 'Height', 'rosenfield-collection' );
	$defaults[ OBJECT_WIDTH ]          = esc_html__( 'Width', 'rosenfield-collection' );
	$defaults[ OBJECT_LENGTH ]         = esc_html__( 'Length', 'rosenfield-collection' );
	$defaults[ OBJECT_IMAGES ]         = esc_html__( 'Gallery', 'rosenfield-collection' );
	$defaults[ OBJECT_PRICE ]          = esc_html__( 'Purchase Price', 'rosenfield-collection' );
	$defaults[ OBJECT_DATE ]           = esc_html__( 'Purchase Date', 'rosenfield-collection' );

	return $defaults;
}

/**
 * Post column content
 *
 * @param string $column_name Column Name.
 * @param int    $post_id Post ID.
 */
function post_column_content( string $column_name, int $post_id ): void {
	if ( 'featured_image' === $column_name && has_post_thumbnail( $post_id ) ) {
		$permalink = get_edit_post_link( $post_id ) ?? '';

		printf(
			'<a href="%s">%s</a>',
			esc_url( $permalink ),
			get_the_post_thumbnail(
				$post_id,
				[ 100, 100 ]
			)
		);
	}

	if ( OBJECT_PREFIX === $column_name ) {
		$terms = get_the_terms( $post_id, FORM );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$term   = array_pop( $terms );
			$prefix = get_field( OBJECT_PREFIX, $term );
			if ( $prefix ) {
				echo esc_html( (string) $prefix ); // @phpstan-ignore-line
			}
		}
	}

	if ( OBJECT_ID === $column_name ) {
		$object_id = get_field( OBJECT_ID, $post_id );
		if ( $object_id ) {
			echo esc_html( (string) $object_id ); // @phpstan-ignore-line
		}
	}

	if ( OBJECT_HEIGHT === $column_name ) {
		$height = get_field( OBJECT_HEIGHT, $post_id );
		if ( $height ) {
			echo esc_html( (string) $height ); // @phpstan-ignore-line
		}
	}

	if ( OBJECT_WIDTH === $column_name ) {
		$width = get_field( OBJECT_WIDTH, $post_id );
		if ( $width ) {
			echo esc_html( (string) $width ); // @phpstan-ignore-line
		}
	}

	if ( OBJECT_LENGTH === $column_name ) {
		$length = get_field( OBJECT_LENGTH, $post_id );
		if ( $length ) {
			echo esc_html( (string) $length ); // @phpstan-ignore-line
		}
	}

	if ( OBJECT_IMAGES === $column_name ) {
		$images = get_field( OBJECT_IMAGES, $post_id );
		if ( $images ) {
			foreach ( (array) $images as $image ) :
				printf(
					'<img src="%s" style="width: 50px; float: left; margin: 0 5px 5px 0px;"/>',
					esc_url( (string) $image['sizes'][ THUMBNAIL ] ) // @phpstan-ignore-line
				);
			endforeach;
		}
	}

	if ( OBJECT_PRICE === $column_name ) {
		$purchase_price = get_field( OBJECT_PRICE, $post_id );
		if ( $purchase_price ) {
			echo esc_html( (string) $purchase_price ); // @phpstan-ignore-line
		}
	}

	if ( OBJECT_DATE === $column_name ) {
		$purchase_date = get_field( OBJECT_DATE, $post_id );
		if ( $purchase_date ) {
			echo esc_html( (string) $purchase_date ); // @phpstan-ignore-line
		}
	}
}

/**
 * Sort the object ID column
 *
 * @param array $sortable Sortable columns.
 */
function post_id_column_sortable( array $sortable ): array {
	$sortable[ OBJECT_ID ] = OBJECT_ID;
	return $sortable;
}

/**
 * Replaces the default gravatar URL with their custom photo from the user profile.
 *
 * @param string $url Gravatar URL.
 * @param mixed  $user_meta User Meta.
 */
function get_avatar_url( string $url, mixed $user_meta ): string {
	/**
	 * User meta is a mixed value so we have to see what we get before
	 * sending data to the custom field.
	 */
	if ( is_int( $user_meta ) ) {
		$user_id = $user_meta;
	} elseif ( is_string( $user_meta ) ) {
		$user    = get_user_by( 'email', $user_meta );
		$user_id = ! empty( $user ) && is_object( $user ) ? $user->ID : false;
	} elseif ( is_object( $user_meta ) ) {
		$user_id = $user_meta->ID; // @phpstan-ignore-line
	} else {
		$user_id = 0;
	}

	if ( empty( $user_id ) ) {
		return '';
	}
		
	$avatar_id = get_field( ARTIST_PHOTO, 'user_' . $user_id );
	if ( empty( $avatar_id ) ) {
		return '';
	}

	$url = wp_get_attachment_url( (int) $avatar_id ); // @phpstan-ignore-line

	return $url ? (string) $url : '';
}

/**
 * Custom column titles for users
 *
 * @param array $columns All columns.
 */
function user_column_titles( array $columns ): array {
	$columns['letter']  = esc_html__( 'Filter', 'rosenfield-collection' );
	$columns['website'] = esc_html__( 'Website', 'rosenfield-collection' );

	return $columns;
}

/**
 * Content for user columns
 *
 * @param string $value Column content.
 * @param string $column_name Column name.
 * @param int    $user_id User ID.
 */
function user_column_content( string $value, string $column_name, int $user_id ): string {
	if ( 'letter' === $column_name ) {
		$letter = get_field( ARTIST_FILTER, 'user_' . $user_id );

		return sprintf(
			'<a href="%s" target="_blank">%s</a>',
			esc_url(
				add_query_arg(
					ARTIST_FILTER,
					$letter,
					home_url( '/artists/' )
				)
			),
			esc_html( ucwords( (string) $letter ) ) // @phpstan-ignore-line
		);
	}

	if ( 'website' === $column_name ) {
		$user_info = get_userdata( $user_id );
		if ( ! $user_info ) {
			return '';
		}

		return sprintf(
			'<a target="_blank" href="%s">%s</a>',
			esc_url( $user_info->user_url ),
			esc_url( $user_info->user_url )
		);
	}

	return $value;
}

/**
 * Taxonomy column titles for rc_form
 *
 * @param array $defaults Column defaults.
 */
function form_taxonomy_column_title( array $defaults ): array {
	// Unset default columns.
	unset( $defaults['name'] );
	unset( $defaults['description'] );
	unset( $defaults['slug'] );
	unset( $defaults['posts'] );

	// Add columns back in proper order.
	$defaults['name']          = esc_html__( 'Name', 'rosenfield-collection' );
	$defaults[ OBJECT_PREFIX ] = esc_html__( 'Prefix', 'rosenfield-collection' );
	$defaults['slug']          = esc_html__( 'Slug', 'rosenfield-collection' );
	$defaults['posts']         = esc_html__( 'Count', 'rosenfield-collection' );

	return $defaults;
}

/**
 * Taxonomy column content for rc_form
 *
 * @param string $content Column content.
 * @param string $column_name Column name.
 * @param int    $term_id Taxonomy term id.
 */
function form_taxonomy_column_content( string $content, string $column_name, int $term_id ): string {
	if ( OBJECT_PREFIX !== $column_name ) {
		return $content;
	}

	$prefix = get_field( OBJECT_PREFIX, FORM . '_' . $term_id );
	if ( empty( $prefix ) ) {
		return $content;
	}

	return (string) $prefix; // @phpstan-ignore-line
}
