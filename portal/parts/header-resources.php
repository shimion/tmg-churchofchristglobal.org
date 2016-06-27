{var $resources = get_posts(array('post_type' => 'ait-item', 'category' => 0, 'posts_per_page' => -1))}

{if $options->theme->header->displayHeaderResources}
<div class="header-resources">

	<span class="resources-data">
		<span class="resources-count">{count($resources)}</span>
		<span class="resources-text">{__ 'Listings'}</span>
	</span>
	{if is_user_logged_in()}
	<a href="/dev/add-lisiting/" class="resources-button ait-sc-button">{__ 'Add'}</a>
	{else}
	{var $link = get_permalink( $options->theme->header->headerResourcesButtonLink )}
	<a href="/dev/add-lisiting/" class="resources-button ait-sc-button">{__ 'Add'}</a>
	{/if}

</div>
{/if}