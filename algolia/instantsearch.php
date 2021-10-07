<?php
/**
 * Rosenfield Collection Theme.
 *
 * @version   2.0.0
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

get_header();

?>

	<section class="hero-section" role="banner" aria-label="Page Header">
		<div class="wrap">
			<div class="hero-inner">
				<?php echo wp_kses_post( RosenfieldCollection\Theme2020\Structure\hero_title() ); ?>
				<div id="search-box"></div>
			</div>
		</div>
	</section>
	<div class="wrap">
		<section class="refinements" aria-label="Statistics and Current Refinements" role="contentinfo" id="rosenfield-collection-current-refinements">
			<div id="algolia-stats"></div>
			<span class="entry-sep">&middot;</span>
			<div id="current-refinements"></div>
		</section>
		<main id="genesis-content" class="content">
			<div id="algolia-hits"></div>
			<div id="algolia-pagination"></div>
		</main>
		<aside class="sidebar sidebar-primary" role="search" aria-label="Primary Sidebar" id="genesis-sidebar-primary">
			<div id="clear-refinements"></div>
			<div id="facet-users"></div>
			<div id="facet-form"></div>
			<div id="facet-firing"></div>
			<div id="facet-technique"></div>
			<div id="facet-column"></div>
			<div id="facet-row"></div>
			<?php if ( is_user_logged_in() && current_user_can( 'edit_others_pages' ) ) : ?>
				<div id="facet-location"></div>
				<div id="facet-tags"></div>
			<?php endif; ?>
		</aside>
	</div>

	<script type="text/html" id="tmpl-instantsearch-hit">
		<article class="entry" itemtype="http://schema.org/Article" aria-label="{{ data.rc_id }}: {{ data.post_title }} made by {{ data.post_author.display_name }}">
			<# if ( data.images.thumbnail ) { #>
			<a href="{{ data.permalink }}" class="entry-image-link first one-sixth">
				<img height="{{ data.images.thumbnail.height }}" width="{{ data.images.thumbnail.width }}" src="{{ data.images.thumbnail.url }}" alt="{{ data.rc_id }}: Main image for {{ data.post_title }} made by {{ data.post_author.display_name }}" itemprop="image" />
			</a>
			<# } #>
			<div class="entry-wrap five-sixths">
				<h2 class="entry-title" itemprop="name">
					<a href="{{ data.permalink }}" class="entry-title-link" rel="bookmark" itemprop="url" aria-label="{{ data.rc_id }}: Read more about {{ data.post_title }} made by {{ data.post_author.display_name }}">{{{ data._highlightResult.post_title.value }}}</a>
				</h2>
				<div class="entry-content">
					<p>
						{{ data.post_author.display_name }}<span class="entry-sep">&middot;</span>{{ data.rc_id }}
						<# if ( data.taxonomies.rc_form ) { #>
							<span class="entry-sep">&middot;</span>{{ data.taxonomies.rc_form }}
						<# } #>
						<# if ( data.taxonomies.rc_firing ) { #>
							<span class="entry-sep">&middot;</span>{{ data.taxonomies.rc_firing }}
						<# } #>
						<# if ( data.taxonomies.rc_technique ) { #>
							<span class="entry-sep">&middot;</span>{{ data.taxonomies.rc_technique }}
						<# } #>
						<# if ( data.taxonomies.rc_column ) { #>
							<span class="entry-sep">&middot;</span>{{ data.taxonomies.rc_column }}
						<# } #>
						<# if ( data.taxonomies.rc_row ) { #>
							<span class="entry-sep">&middot;</span>{{ data.taxonomies.rc_row }}
						<# } #>
					</p>
				</div>
			</div>
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
					searchClient: algoliasearch( algolia.application_id, algolia.search_api_key ),
					routing: {
						router: instantsearch.routers.history({ writeDelay: 1000 }),
						stateMapping: {
							stateToRoute( indexUiState ) {
								return {
									s: indexUiState[ algolia.indices.searchable_posts.name ].query,
									page: indexUiState[ algolia.indices.searchable_posts.name ].page
								}
							},
							routeToState( routeState ) {
								const indexUiState = {};
								indexUiState[ algolia.indices.searchable_posts.name ] = {
									query: routeState.s,
									page: routeState.page
								};
								return indexUiState;
							}
						}
					}
				});
				search.addWidget(
					instantsearch.widgets.stats({
						container: '#algolia-stats',
					})
				);
				search.addWidget(
					instantsearch.widgets.currentRefinements({
						container: '#current-refinements',
					})
				);
				search.addWidget(
					instantsearch.widgets.hits({
						container: '#algolia-hits',
						hitsPerPage: 10,
						templates: {
							empty: 'No results were found for "<strong>{{query}}</strong>".',
							item: wp.template('instantsearch-hit')
						},
					})
				);
				search.addWidget(
					instantsearch.widgets.pagination({
						container: '#algolia-pagination',
						cssClasses: {
							root: ['archive-pagination', 'pagination']
						},
					})
				);
				search.addWidget(
					instantsearch.widgets.searchBox({
						container: '#search-box',
						autofocus: true,
						searchAsYouType: true,
						showReset: false,
						showSubmit: true,
						placeholder: 'Search by any keyword, artist, form, firing, or technique',
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-users',
						attribute: 'post_author.display_name',
						sortBy: ['name:asc'],
						limit: 10000,
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
						limit: 10000,
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
						limit: 10000,
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
						limit: 10000,
						templates: {
							defaultOption: 'Techniques'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-column',
						attribute: 'taxonomies.rc_column',
						sortBy: ['name:asc'],
						limit: 10000,
						templates: {
							defaultOption: 'Columns'
						}
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-row',
						attribute: 'taxonomies.rc_row',
						sortBy: ['name:asc'],
						limit: 10000,
						templates: {
							defaultOption: 'Rows'
						}
					})
				);

				if ( jQuery('#facet-location').length > 0 ) {
					search.addWidget(
						instantsearch.widgets.menuSelect({
							container: '#facet-location',
							attribute: 'taxonomies.rc_location',
							sortBy: ['name:asc'],
							limit: 10000,
							templates: {
								defaultOption: 'Locations'
							}
						})
					);
				}

				if ( jQuery('#facet-tags').length > 0 ) {
					search.addWidget(
						instantsearch.widgets.menuSelect({
							container: '#facet-tags',
							attribute: 'taxonomies.post_tag',
							sortBy: ['name:asc'],
							limit: 10000,
							templates: {
								defaultOption: 'Tags'
							}
						})
					);
				}
				search.addWidget(
					instantsearch.widgets.clearRefinements({
						container: '#clear-refinements',
					})
				);

				search.start();

				jQuery('.search-form-input').attr('type', 'search').select();
			}
		});
	</script>

<?php get_footer(); ?>
