<?php

/**
* Template Name: Page - Full Width
*/

get_header(); ?>
	
<section id="blog" class="blog-section">

	<div class="container" style="width: 100%; max-width: 100%;padding:0;">

		<div class="two-tone-layout">

			<div class="col-sm-12 content-wrapper" style="width: 100%; padding:0;">

				<div class="detail-content single_page eb_page">

					<?php
					while ( have_posts() ) : the_post();

						the_content();

					endwhile;
					?>

				</div>

			</div>

		</div>

	</div>

</section>

<?php
get_footer();