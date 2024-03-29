<?php
/**
 * Intervention configuration
 * 
 * @package RosenfieldCollection\Theme
 */

return [
	'application' => [
		'theme'      => 'rosenfield-collection-theme-2020',
		'plugins'    => [
			'advanced-custom-fields-pro/acf.php'  => true,
			'edit-author-slug'                    => true,
			'gravityforms'                        => true,
			'gravity-forms-custom-post-types/gfcptaddon.php' => true,
			'gravityformsmailchimp/mailchimp.php' => true,
			'gravityformsuserregistration/userregistration.php' => true,
			'intervention'                        => true,
			'worker/init.php'                     => true,
			'query-monitor'                       => true,
			'redirection'                         => true,
			'tracking-code-for-google-analytics'  => true,
			'wp-mail-smtp/wp_mail_smtp.php'       => true,
			'wp-search-with-algolia/algolia.php'  => true,
			'wordpress-seo/wp-seo.php'            => true,
		],
		'general'    => [
			'site-title'   => 'The Rosenfield Collection',
			'tagline'      => 'Contemporary, Functional Ceramic Art Collection',
			'admin-email'  => 'clayton.collie@gmail.com',
			'membership'   => false,
			'default-role' => 'author',
			'language'     => false,
			'timezone'     => '',
			'date-format'  => 'F j, Y',
			'time-format'  => 'g:i a',
			'week-starts'  => 'Sunday',
		],
		'writing'    => [
			'default-category'                => 0,
			'default-post-format'             => 'standard',
			'post-via-email.server'           => 'mail.example.com',
			'post-via-email.login'            => 'login@example.com',
			'post-via-email.pass'             => 'password',
			'post-via-email.port'             => 110,
			'post-via-email.default-category' => 0,
			'update-services'                 => 'http://rpc.pingomatic.com/',
		],
		'reading'    => [
			'front-page'        => 'posts',
			'front-page.page'   => 0,
			'front-page.posts'  => 0,
			'posts-per-page'    => 20,
			'posts-per-rss'     => 200,
			'rss-excerpt'       => 'summary',
			'discourage-search' => false,
		],
		'discussion' => [
			'post.ping-flag'              => 'closed',
			'post.ping-status'            => false,
			'post.comments'               => false,
			'comments.name-email'         => true,
			'comments.registration'       => '',
			'comments.close'              => '',
			'comments.close.days'         => 14,
			'comments.cookies'            => true,
			'comments.thread'             => true,
			'comments.thread.depth'       => 5,
			'comments.pages'              => '',
			'comments.pages.per-page'     => 50,
			'comments.pages.default'      => 'newest',
			'comments.order'              => 'asc',
			'emails.comment'              => false,
			'emails.moderation'           => true,
			'moderation.approve-manual'   => '',
			'moderation.approve-previous' => true,
			'moderation.queue-links'      => 2,
			'moderation.queue-keys'       => '',
			'moderation.disallowed-keys'  => '',
			'avatars'                     => 'closed',
			'avatars.rating'              => 'G',
			'avatars.default'             => 'mystery',
		],
		'media'      => [
			'sizes.thumbnail.width'  => 200,
			'sizes.thumbnail.height' => 200,
			'sizes.thumbnail.crop'   => true,
			'sizes.medium.width'     => 0,
			'sizes.medium.height'    => 0,
			'sizes.large.width'      => 0,
			'sizes.large.height'     => 0,
			'uploads.organize'       => true,
		],
		'permalinks' => [
			'structure'     => '/%postname%/',
			'category-base' => '',
			'tag-base'      => '',
		],
		'privacy'    => [
			'policy-page' => 17023,
		],
	],
];
