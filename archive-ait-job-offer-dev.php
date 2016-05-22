{block content}

	{* template for page title is in parts/page-title.php *}

	{customQuery as $query,
		type    => job-offer,
		tax     => offers,
		cat     => $el->option(category),
		limit   => $el->option(count),
		orderby => $el->option(orderby),
		order 	=> $el->option(order)
	}

	{* determine if there are valid job offers *}
	{var $itemsCount = 0}
	{if $query->havePosts}
		{customLoop from $query as $item}
			{if time() <= strtotime($item->meta('offer-data')->validTo)}
				{var $itemsCount++}
			{/if}
		{/customLoop}
	{/if}
	{* determine if there are valid job offers *}

	{var $dateFormat 		= 'j M Y'}
	{var $dateFormatFull 	= 'D, j M Y'}

	{if $itemsCount != 0}
		
		{var $textRows = $el->option->textRows}		
		{var $addInfo = $el->option->addInfo}
		{* Unified variables and data *}
		
			{var $enableCarousel  = $el->option->listEnableCarousel}
			{var $numOfRows       = $el->option->listRows}
			{var $numOfColumns    = $el->option->listColumns}
			{var $imgWidth = 220}


			<div class="elm-item-organizer-container column-1 layout-list carousel-disabled" data-last="2" data-first="1" data-cols="1">
			{customLoop from $query as $item}
				{var $meta = $item->meta('offer-data')}
				{if time() <= strtotime($meta->validTo)}
					{if $enableCarousel and $iterator->isFirst($numOfRows)}
						<div n:class="item-box, $enableCarousel ? carousel-item">
					{/if}

					<div n:class='item, "item{$iterator->counter}", $enableCarousel ? carousel-item, $iterator->isFirst($numOfColumns) ? item-first, $item->hasImage ? image-present, $iterator->isLast($numOfColumns) ? item-last, '	data-id="{$iterator->counter}">
						<a href="{$item->permalink}">

							{if $item->hasImage}
								<div class="item-thumbnail">
										<img src="{imageUrl $item->imageUrl, width => 100, height => 100, crop => 1}" alt="{!$item->title}">
								</div>
							{/if}

							<div class="item-title">
								<h3>{!$item->title}</h3>
								{if $addInfo}
								{if $meta->validTo != ''}
									<div class="item-duration">
										<span class="item-dur-title"><strong>{__ 'Validity:'}</strong></span>
										<time class="item-from" datetime="{$meta->validFrom|dateI18n:'c'}">{$meta->validFrom|dateI18n: $dateFormat}</time>
										<span class="item-sep">-</span>
										<time class="item-to" datetime="{$meta->validTo|dateI18n:'c'}">{$meta->validTo|dateI18n: $dateFormat}</time>
									</div>
								{/if}
								{/if}
							</div>
						</a>

						<div class="item-text">
							<div class="item-excerpt txtrows-{$textRows}">{!$item->excerpt(200)}</div>
						</div>

						{if $addInfo}
						<div class="item-info">
							<div class="job-contact">
								<span class="job-contact-title"><strong>{__ 'Contact:'}</strong></span>
								{if $meta->contactName}<span class="job-contact-name">{$meta->contactName}</span>{/if}<!--
								-->{if $meta->contactMail}<span class="job-contact-mail"><a href="mailto:{$meta->contactMail}">{$meta->contactMail}</a></span>{/if}<!--
								-->{if $meta->contactPhone}<span class="job-contact-phone">{$meta->contactPhone}</span>{/if}
							</div>
						</div>
						{/if}
					</div>

					{if $enableCarousel and $iterator->isLast($numOfRows)}
						</div>
					{/if}
				{/if}
			{/customLoop}
			</div>



	{else}
		{includePart parts/none, message => no-posts}
	{/if}
