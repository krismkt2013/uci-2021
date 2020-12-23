<div class="detail-content single_page" style="margin-top: 100px;">
<h3 class="blog-title"><?php the_title(); ?></h3>
	<?php 
	
	if( has_post_thumbnail() ){

		echo '<div class="detail_image_wrapper">';

		$detail_page_category = bizberg_get_theme_mod( 'detail_page_category' );
		$post_cat =  bizberg_post_categories( $post , 1 , true , false );

		if( $post_cat != false && $detail_page_category == 'show' ){
			echo '<div class="bizberg_detail_cat">';
			echo wp_kses_post( $post_cat );
			echo '</div>';
		}	
		
		the_post_thumbnail( 
			'large',
			[
				'class' => 'bizberg_featured_image', 
				'title' => get_the_title(),
				'alt' => get_the_title()
			] 
		);
		echo '</div>';

	} ?>

	<div class="bizberg_cocntent_wrapper">

		<?php 
		$date_status = bizberg_get_theme_mod( 'detail_page_post_date' );

		if( $date_status == 'show' ){ ?>
			<div class="bizberg_post_date">
				<a href="<?php echo esc_url( home_url() ); ?>/<?php echo esc_attr( date( 'Y/m' , strtotime( get_the_date() ) ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</a> 
			</div>
			<div class="bizberg_detail_user_wrapper">			
					<a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>"> 
						By  <i class="fa fa-user"></i> 
						<?php echo esc_html( bizberg_get_display_name( $post ) ); ?>		
					</a> 
				</div>
			<?php 
		} ?>

		<h3 class="blog-title"></h3>

		<?php

		do_action( 'bizberg_before_single_content' , $post );

		the_content();

		do_action( 'bizberg_after_single_content' , $post );

		$author_link = bizberg_get_theme_mod( 'detail_page_author_link' ); 
		$comment_stats = bizberg_get_theme_mod( 'detail_page_comment_stats' );
		$comment_wrapper = '';

		if( $author_link == 'hide' && $comment_stats == 'hide' ){
			$comment_wrapper = 'display:none';
		} ?>

		<div class="bizberg_user_comment_wrapper" style="<?php echo esc_attr( $comment_wrapper ); ?>">
			
			<?php 
			

			if( $comment_stats == 'show' ){ ?>

				<!-- <div class="bizberg_detail_comment_count">
					<i class="fas fa-comments"></i>
					<?php echo absint( get_comments_number() ); ?>
				</div> -->
				<section class="elementor-section elementor-top-section elementor-element elementor-element-2371b4f elementor-section-boxed ang-section-padding-initial elementor-section-height-default elementor-section-height-default" data-id="2371b4f" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-840ee5b" data-id="840ee5b" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-3e6d053 elementor-align-right elementor-tablet-align-center elementor-widget elementor-widget-global elementor-global-1351 elementor-widget-button" data-id="3e6d053" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#" class="elementor-button-link elementor-button elementor-size-sm" role="button" style="background-color: #FF782D;">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-icon elementor-align-icon-right">
							</span>
						<span class="elementor-button-text">See all news</span>
		</span>
					</a>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<?php 

			} ?>

		</div>

	</div>

	<?php

	if( has_tag() ){
		echo '<div class="tag-cloud-wrapper clearfix mb-40">
			<div class="tag-cloud-heading">' . esc_html__( 'Tags :' , 'bizberg' ) . ' </div>
			<div class="tagcloud tags clearfix mt-5">';
			the_tags('','','');
			echo '</div>
		</div>';
	} ?>
	
</div>
