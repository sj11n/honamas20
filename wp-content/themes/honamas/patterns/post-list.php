<?php
/**
 * Title: Post List
 * Slug: honamas/post-list
 * Categories: query
 */
?>
<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true}} -->
<div class="wp-block-query">
	<!-- wp:post-template -->
		<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
			<!-- wp:post-title {"isLink":true} /-->
			<!-- wp:post-date {"className":"honamas-meta"} /-->
			<!-- wp:post-excerpt {"moreText":"Weiterlesen"} /-->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->
	<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous {"label":"Neuere Beitraege"} /-->
		<!-- wp:query-pagination-next {"label":"Aeltere Beitraege"} /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
