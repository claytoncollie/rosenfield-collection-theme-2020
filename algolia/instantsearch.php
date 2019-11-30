<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

get_header();

?>

	<section class="hero-section" role="banner">
		<div class="wrap">
			<div class="hero-inner">
				<?php echo wp_kses_post( RosenfieldCollection\Theme2020\Structure\hero_title() ); ?>
			</div>
		</div>
	</section>
	<div class="wrap">
		<main id="genesis-content" class="content">
			<div id="algolia-stats"></div>
			<div id="algolia-hits"></div>
			<div id="algolia-pagination"></div>
		</main>
		<aside class="sidebar sidebar-primary">
			<?php echo get_search_form(); ?>
			<section id="facet-users" class="widget"></section>
			<section id="facet-form" class="widget"></section>
			<section id="facet-firing" class="widget"></section>
			<section id="facet-technique" class="widget"></section>
			<section id="facet-location" class="widget"></section>
			<section id="facet-row" class="widget"></section>
			<section id="facet-column" class="widget"></section>
			<section id="facet-tags" class="widget"></section>
		</aside>
	</div>

	<script type="text/html" id="tmpl-instantsearch-hit">
		<article class="entry" itemtype="http://schema.org/Article">
			<# if ( data.images.thumbnail ) { #>
			<div class="ais-hits--thumbnail">
				<a href="{{ data.permalink }}" title="{{ data.post_title }}">
					<img src="{{ data.images.thumbnail.url }}" alt="{{ data.post_title }}" title="{{ data.post_title }}" itemprop="image" />
				</a>
			</div>
			<# } #>

			<div class="ais-hits--content">
				<h2 itemprop="name headline"><a href="{{ data.permalink }}" title="{{ data.post_title }}" itemprop="url">{{{ data._highlightResult.post_title.value }}}</a></h2>
			</div>
			<div class="ais-clearfix"></div>
		</article>
	</script>
	<script type="text/javascript">
		jQuery(function() {
			if(jQuery('.search-form').length > 0) {

				if (algolia.indices.searchable_posts === undefined && jQuery('.admin-bar').length > 0) {
					alert('It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.');
				}

				// Instantiate instantsearch.js.
				var search = instantsearch({
					indexName: algolia.indices.searchable_posts.name,
					searchClient: algoliasearch(algolia.application_id, algolia.search_api_key),
					routing: true,
					searchParameters: {
						facetingAfterDistinct: true,
					}
				});

				search.addWidget(
					instantsearch.widgets.stats({
						container: '#algolia-stats'
					})
				);
				search.addWidget(
					instantsearch.widgets.hits({
						container: '#algolia-hits',
						hitsPerPage: 12,
						templates: {
							empty: 'No results were found for "<strong>{{query}}</strong>".',
							item: wp.template('instantsearch-hit')
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.pagination({
						container: '#algolia-pagination'
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-users',
						attribute: 'post_author.display_name',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Artists'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-form',
						attribute: 'taxonomies.rc_form',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Forms'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-firing',
						attribute: 'taxonomies.rc_firing',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Firings'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-technique',
						attribute: 'taxonomies.rc_technique',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Techniques'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-location',
						attribute: 'taxonomies.rc_location',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Locations'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-row',
						attribute: 'taxonomies.rc_row',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Rows'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-column',
						attribute: 'taxonomies.rc_column',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Columns'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-tags',
						attribute: 'taxonomies.post_tag',
						sortBy: ['name:asc'],
						templates: {
							defaultOption: 'Tags'
						}
					})
				);

				search.start();

				jQuery('.search-form-input').attr('type', 'search').select();
			}
		});
	</script>

<?php get_footer(); ?>
