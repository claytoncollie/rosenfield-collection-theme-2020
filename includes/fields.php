<?php
/**
 * Fields.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Fields;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_MEDIUM;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_THUMBNAIL;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\COLUMN;
use const RosenfieldCollection\Theme\Taxonomies\FIRING;
use const RosenfieldCollection\Theme\Taxonomies\FORM;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;
use const RosenfieldCollection\Theme\Taxonomies\RESULT;
use const RosenfieldCollection\Theme\Taxonomies\ROW;
use const RosenfieldCollection\Theme\Taxonomies\TECHNIQUE;

/**
 * Object ID
 * 
 * @var string
 */
const OBJECT_ID = 'object_id';

/**
 * Object prefix
 * 
 * @var string
 */
const OBJECT_PREFIX = 'rc_form_object_prefix';

/**
 * Object Price
 * 
 * @var string
 */
const OBJECT_PRICE = 'rc_object_purchase_price';

/**
 * Object Date
 * 
 * @var string
 */
const OBJECT_DATE = 'rc_object_purchase_date';

/**
 * Object images
 * 
 * @var string
 */
const OBJECT_IMAGES = 'images';

/**
 * Object length
 * 
 * @var string
 */
const OBJECT_LENGTH = 'length';

/**
 * Object width
 * 
 * @var string
 */
const OBJECT_WIDTH = 'width';

/**
 * Object height
 * 
 * @var string
 */
const OBJECT_HEIGHT = 'height';

/**
 * Artist photo meta key
 * 
 * @var string
 */
const ARTIST_PHOTO = 'artist_photo';

/**
 * Artist filter meta key
 * 
 * @var string
 */
const ARTIST_FILTER = 'artist_filter';

/**
 * Pending page slug
 * 
 * @var string
 */
const PENDING_SLUG = 'pending';

/**
 * Artist slug
 * 
 * @var string
 */
const ARTIST_SLUG = 'artists';

/**
 * Claim slug
 * 
 * @var string
 */
const CLAIM_SLUG = 'claim';

/**
 * Contact page slug
 * 
 * @var string
 */
const CONTACT_SLUG = 'contact';

/**
 * Term thumbnail
 * 
 * @var string
 */
const TERM_THUMBNAIL = 'rc_term_thumbnail';

/**
 * Choices for artist filter
 * 
 * @var array
 */
const THE_ALPHABET = [
	'a' => 'a',
	'b' => 'b',
	'c' => 'c',
	'd' => 'd',
	'e' => 'e',
	'f' => 'f',
	'g' => 'g',
	'h' => 'h',
	'i' => 'i',
	'j' => 'j',
	'k' => 'k',
	'l' => 'l',
	'm' => 'm',
	'n' => 'n',
	'o' => 'o',
	'p' => 'p',
	'q' => 'q',
	'r' => 'r',
	's' => 's',
	't' => 't',
	'u' => 'u',
	'v' => 'v',
	'w' => 'w',
	'x' => 'x',
	'y' => 'y',
	'z' => 'z',
];

/**
 * Setup
 */
function setup(): void {
	add_action( 'acf/init', __NAMESPACE__ . '\register_artist_fields' );
	add_action( 'acf/init', __NAMESPACE__ . '\register_claim_fields' );
	add_action( 'acf/init', __NAMESPACE__ . '\register_term_prefix_fields' );
	add_action( 'acf/init', __NAMESPACE__ . '\register_term_thumbnail_fields' );
	add_action( 'acf/init', __NAMESPACE__ . '\register_object_fields' );
}

/**
 * Register artist information fields
 */
function register_artist_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'      => 'group_55ede3d456dsl9c1db8f56',
			'title'    => __( 'Artist Information', 'rosenfield-collection' ),
			'fields'   => [
				[
					'key'           => 'field_555675468754568067ec4',
					'label'         => __( 'Artist Photo', 'rosenfield-collection' ),
					'name'          => ARTIST_PHOTO,
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => IMAGE_THUMBNAIL,
					'library'       => 'all',
				],
				[
					'key'           => 'field_5e145676987897ad49aa83c',
					'label'         => __( 'Artist Filter', 'rosenfield-collection' ),
					'name'          => ARTIST_FILTER,
					'type'          => 'select',
					'choices'       => THE_ALPHABET,
					'default_value' => [],
					'allow_null'    => 1,
					'return_format' => 'value',
				],
			],
			'location' => [
				[
					[
						'param'    => 'user_role',
						'operator' => '==',
						'value'    => 'all',
					],
				],
			],
		] 
	);
}

/**
 * Register claim fields
 */
function register_claim_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'      => 'group_5e75dg6699894fb9dc81c',
			'title'    => __( 'Claim', 'rosenfield-collection' ),
			'fields'   => [
				[
					'key'           => 'field_556456e75dfca824cb',
					'label'         => __( 'Featured Image', 'rosenfield-collection' ),
					'name'          => 'rc_featured_image',
					'type'          => 'image',
					'required'      => 1,
					'return_format' => 'array',
					'preview_size'  => IMAGE_MEDIUM,
					'library'       => 'all',
				],
			],
			'location' => [
				[
					[
						'param'    => 'post_template',
						'operator' => '==',
						'value'    => 'templates/claim.php',
					],
				],
			],
		] 
	);
}

/**
 * Register form taxonomy fields
 */
function register_term_prefix_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'      => 'group_5699897944521cbedf42',
			'title'    => __( 'Term Meta', 'rosenfield-collection' ),
			'fields'   => [
				[
					'key'           => 'field_56545656457676573fb',
					'label'         => __( 'Prefix', 'rosenfield-collection' ),
					'name'          => OBJECT_PREFIX,
					'type'          => 'select',
					'choices'       => [
						'B'    => 'Bowl -> B',
						'C&S'  => 'Cream and Sugar -> C&S',
						'C'    => 'Cup -> C',
						'CP&S' => 'Cup and Saucer -> CP&S',
						'E'    => 'Ewer -> E',
						'J'    => 'Jar -> J',
						'L'    => 'Lamp -> L',
						'OT'   => 'Other -> OT',
						'P'    => 'Plate -> P',
						'PV'   => 'Pouring Vessel - > PV',
						'SW'   => 'Service Ware - > SW',
						'T'    => 'Teapot -> T',
						'V'    => 'Vase -> V',
					],
					'default_value' => [],
					'allow_null'    => 1,
					'return_format' => 'value',
				],
			],
			'location' => [
				[
					[
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => FORM,
					],
				],
			],
		] 
	);
}

/**
 * Register term thumbnail field
 */
function register_term_thumbnail_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'      => 'group_56a3455647567f42',
			'title'    => __( 'Term Meta', 'rosenfield-collection' ),
			'fields'   => [
				[
					'key'           => 'field_5664h8099767ec4',
					'label'         => __( 'Thumbnail', 'rosenfield-collection' ),
					'name'          => TERM_THUMBNAIL,
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => IMAGE_THUMBNAIL,
					'library'       => 'all',
				],
			],
			'location' => [
				[
					[
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => FORM,
					],
				],
				[
					[
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => FIRING,
					],
				],
				[
					[
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => TECHNIQUE,
					],
				],
			],
		] 
	);
}

/**
 * Register object fields
 */
function register_object_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'                   => 'group_54563456rjr67jr6708ddf',
			'title'                 => __( 'Object', 'rosenfield-collection' ),
			'fields'                => [
				[
					'key'      => 'field_5456b6r7346546jr7r798b',
					'label'    => __( 'ID', 'rosenfield-collection' ),
					'name'     => OBJECT_ID,
					'type'     => 'text',
					'required' => 0, // Do not make required.
					'wrapper'  => [
						'width' => '25',
					],
				],
				[
					'key'           => 'field_5456245345dd1r77jr7j78',
					'label'         => __( 'Form', 'rosenfield-collection' ),
					'name'          => 'rc_object_form',
					'type'          => 'taxonomy',
					'required'      => 1,
					'wrapper'       => [
						'width' => '25',
					],
					'taxonomy'      => FORM,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'           => 'field_5dd565671296350720',
					'label'         => __( 'Firing', 'rosenfield-collection' ),
					'name'          => 'rc_object_firing',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '25',
					],
					'taxonomy'      => FIRING,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'           => 'field_5dd12977969789750721',
					'label'         => __( 'Technique', 'rosenfield-collection' ),
					'name'          => 'rc_object_technique',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '25',
					],
					'taxonomy'      => TECHNIQUE,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'           => 'field_5dd12a908908906ed642d',
					'label'         => __( 'Column', 'rosenfield-collection' ),
					'name'          => 'rc_object_column',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '33',
					],
					'taxonomy'      => COLUMN,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'           => 'field_5dd1278079090a88d642e',
					'label'         => __( 'Row', 'rosenfield-collection' ),
					'name'          => 'rc_object_row',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '33',
					],
					'taxonomy'      => ROW,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'           => 'field_5e158978978940461fea2',
					'label'         => __( 'Result', 'rosenfield-collection' ),
					'name'          => 'rc_object_result',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '33',
					],
					'taxonomy'      => RESULT,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'     => 'field_5456b7e32342345c7992',
					'label'   => __( 'Length', 'rosenfield-collection' ),
					'name'    => OBJECT_LENGTH,
					'type'    => 'number',
					'wrapper' => [
						'width' => '33',
					],
					'prepend' => 'inches',
					'min'     => 0,
				],
				[
					'key'     => 'field_5456b756456456d4c7991',
					'label'   => __( 'Width', 'rosenfield-collection' ),
					'name'    => OBJECT_WIDTH,
					'type'    => 'number',
					'wrapper' => [
						'width' => '33',
					],
					'prepend' => 'inches',
					'min'     => 0,
				],
				[
					'key'     => 'field_5456b7b3454352342ac7990',
					'label'   => __( 'Height', 'rosenfield-collection' ),
					'name'    => OBJECT_HEIGHT,
					'type'    => 'number',
					'wrapper' => [
						'width' => '33',
					],
					'prepend' => 'inches',
					'min'     => 0,
				],
				[
					'key'           => 'field_5dd12a2457457a9d642f',
					'label'         => __( 'Purchase Location', 'rosenfield-collection' ),
					'name'          => 'rc_object_location',
					'type'          => 'taxonomy',
					'wrapper'       => [
						'width' => '33',
					],
					'taxonomy'      => LOCATION,
					'field_type'    => 'select',
					'allow_null'    => 1,
					'add_term'      => 1,
					'save_terms'    => 1,
					'load_terms'    => 1,
					'return_format' => 'id',
				],
				[
					'key'            => 'field_5e14b734573457368426c617',
					'label'          => __( 'Purchase Date', 'rosenfield-collection' ),
					'name'           => OBJECT_DATE,
					'type'           => 'date_picker',
					'wrapper'        => [
						'width' => '33',
					],
					'display_format' => 'm/d/Y',
					'return_format'  => 'm/d/Y',
					'first_day'      => 0,
				],
				[
					'key'          => 'field_5724562456839ad815c60',
					'label'        => __( 'Purchase Price', 'rosenfield-collection' ),
					'name'         => OBJECT_PRICE,
					'type'         => 'number',
					'instructions' => 'Only numbers and decimals. 3.45 or 4.00. Not $3.45.',
					'wrapper'      => [
						'width' => '33',
					],
					'prepend'      => '$',
					'min'          => 0,
				],
				[
					'key'           => 'field_52345234546d0ad42e7f0',
					'label'         => __( 'Images', 'rosenfield-collection' ),
					'name'          => 'images',
					'type'          => 'gallery',
					'preview_size'  => IMAGE_THUMBNAIL,
					'library'       => 'all',
					'return_format' => 'array',
					'insert'        => 'append',
				],
			],
			'location'              => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => POST_SLUG,
					],
				],
			],
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => [
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'slug',
				7 => 'format',
				8 => 'categories',
				9 => 'send-trackbacks',
			],
		] 
	);
}
