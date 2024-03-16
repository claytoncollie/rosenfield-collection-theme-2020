<?php
/**
 * Instant Search.
 * 
 * @version 2.7.1
 *
 * @package RosenfieldCollection\Theme
 */

get_header();

?>

	<div class="row">
		<section class="col col-12" aria-label="Statistics and Current Refinements" role="contentinfo" id="rosenfield-collection-current-refinements">
			<div class="border-bottom pb-3 mb-4">
				<div id="algolia-stats" class="d-inline-block mb-2 mb-md-0"></div>
				<span class="entry-sep">&middot;</span>
				<div id="current-refinements" class="d-inline-block"></div>
			</div>
		</section>
		<main id="genesis-content" class="col col-12 col-md-9 order-1">
			<div id="algolia-hits"></div>
			<div id="algolia-pagination" class="mt-5"></div>
		</main>
		<aside class="col col-12 col-md-3 order-0" role="search" aria-label="Primary Sidebar" id="genesis-sidebar-primary">
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
		<article class="row align-items-start align-items-md-center mb-3" aria-label="{{ data.rc_id }}: {{ data.post_title }} made by {{ data.post_author.display_name }}">
			<div class="col col-5 col-lg-3 col-xl-2">
				<# if ( data.images.thumbnail ) { #>
					<a href="{{ data.permalink }}" class="d-block mb-3 mb-md-0">
						<img 
							class="img-fluid border shadow-sm"
							height="{{ data.images.thumbnail.height }}" 
							width="{{ data.images.thumbnail.width }}" 
							src="{{ data.images.thumbnail.url }}" 
							alt="{{ data.rc_id }}: Main image for {{ data.post_title }} made by {{ data.post_author.display_name }}" 
						/>
					</a>
				<# } #>
			</div>
			<div class="col col-7 col-lg-9 col-xl-10">
				<h2 class="h4 mb-2">
					<a href="{{ data.permalink }}" class="link-dark link-hidden-dots" aria-label="{{ data.rc_id }}: Read more about {{ data.post_title }} made by {{ data.post_author.display_name }}">
						{{{ data._highlightResult.post_title.value }}}
					</a>
				</h2>
				<div class="entry-content">
					{{ data.post_author.display_name }}
					<span class="entry-sep">
						&middot;
					</span>
					{{ data.rc_id }}

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
				</div>
			</div>
		</article>
		<hr aria-hidden="true">
	</script>
	<script type="text/javascript">
		window.addEventListener('load', function() {
			if ( document.getElementById("algolia-search-box") ) {
				if ( algolia.indices.searchable_posts === undefined && document.getElementsByClassName("admin-bar").length > 0) {
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
						cssClasses: {
							root: [
								'd-inline-block',
								'position-relative',
								'top-0',
								'fs-6'
							]
						},
					})
				);
				search.addWidget(
					instantsearch.widgets.currentRefinements({
						container: '#current-refinements',
						cssClasses: {
							root: 'd-inline-block',
							label: 'd-none',
							delete: [
								'btn',
								'btn-outline-primary',
								'btn-sm'
							],
							list: [
								'list-unstyled',
								'mb-0'
							],
							item: [
								'd-inline-block',
								'me-3'
							],
							category: [
								'd-flex',
								'align-items-center',
								'flex-nowrap',
								'mb-2',
								'mb-md-0'
							],
							categoryLabel: [
								'me-2'
							]
						},
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
						cssClasses: {
							item: [
								'border-0',
								'p-0',
								'm-0'
							],
							list: [
								'list-unstyled',
								'mb-0'
							],
						},
					})
				);
				search.addWidget(
					instantsearch.widgets.pagination({
						container: '#algolia-pagination',
						cssClasses: {
							root: [
								'archive-pagination', 
								'pagination'
							]
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
						cssClasses: {
							form: [
								'position-relative',
								'mw-700',
								'mx-auto',
								'mt-3'
							],
							input: [
								'form-control',
								'bg-white',
								'py-3',
								'px-5',
								'rounded-5'
							],
							submitIcon: [
								'h-15',
								'w-15',
							]
						},
					})
				);
				search.addWidget(
					instantsearch.widgets.menuSelect({
						container: '#facet-users',
						attribute: 'post_author.display_name',
						sortBy: ['name:asc'],
						limit: 10000,
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
						cssClasses: {
							root: [
								'mb-3'
							],
							select: [
								'form-select'
							],
						},
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
							cssClasses: {
								root: [
									'mb-3'
								],
								select: [
									'form-select'
								],
							},
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
							cssClasses: {
								root: [
									'mb-3'
								],
								select: [
									'form-select'
								],
							},
							templates: {
								defaultOption: 'Tags'
							}
						})
					);
				}
				search.addWidget(
					instantsearch.widgets.clearRefinements({
						container: '#clear-refinements',
						cssClasses: {
							root: 'mb-3',
							button: [
								'btn',
								'btn-primary',
								'w-100',
							],
						},
					})
				);

				search.start();

				document.querySelector("#algolia-search-box input[type='search']").select()
			}
		});
	</script>

<?php get_footer(); ?>
