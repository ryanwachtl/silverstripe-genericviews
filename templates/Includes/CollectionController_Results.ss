		<% if $Results %>
		<h3><% _t('CollectionController_Results.ss.RESULTS','Results') %></h3>
		<ul class="records">
		<% loop $Results %>
			<li>
				<% if $Top.canDetailView %>
					$Title
					- <a href="{$Top.Link}/$ID/view">view</a>
					- <a href="{$Top.Link}/$ID/edit">edit</a>
					- <a href="{$Top.Link}/$ID/delete">delete</a>
				<% else %>
					$Title
				<% end_if %>
			</li>
		<% end_loop %>
		</ul>
		<% else %>
		<p class="message"><% _t('CollectionController_Results.ss.NORESULTSFOUND','No records found') %></p>
		<% end_if %>

		<% if $Results.MoreThanOnePage %>
			<div id="PageNumbers">
			<% if $Results.NotFirstPage %>
				<a class="prev" href="$Results.PrevLink"><% _t('CollectionController_Results.ss.PREV','Prev') %></a>
			<% end_if %>
			<span>
			<% loop $Results.Pages %>
				<% if CurrentBool %>
					$PageNum
				<% else %>
					<a href="$Link">$PageNum</a>
				<% end_if %>
			<% end_loop %>
			</span>
			<% if $Results.NotLastPage %>
				<a class="next" href="$Results.NextLink"><% _t('CollectionController_Results.ss.NEXT','Next') %></a>
			<% end_if %>
			</div>
		<% end_if %>