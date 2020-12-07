<?php

add_action( 'wp_enqueue_scripts', 'business_event_chld_thm_parent_css' );
function business_event_chld_thm_parent_css() {

    wp_enqueue_style( 
    	'business_event_chld_css', 
    	trailingslashit( get_template_directory_uri() ) . 'style.css', 
    	array( 
    		'bootstrap',
    		'font-awesome-5',
    		'bizberg-main',
    		'bizberg-component',
    		'bizberg-style2',
    		'bizberg-responsive' 
    	) 
    );
    
}

add_action( 'init', 'business_event_colors' );
function business_event_colors(){

    $options = array(
        'bizberg_slider_title_box_highlight_color',
        'bizberg_slider_arrow_background_color',
        'bizberg_slider_dot_active_color',
        'bizberg_read_more_background_color',
        'bizberg_read_more_background_color_2',
        'bizberg_theme_color', // Change the theme color
        'bizberg_header_menu_color_hover',
        'bizberg_header_button_color',
        'bizberg_header_button_color_hover',
        'bizberg_link_color',
        'bizberg_background_color_2',
        'bizberg_link_color_hover',
        'bizberg_sidebar_widget_title_color',
        'bizberg_blog_listing_pagination_active_hover_color',
        'bizberg_heading_color',
        'bizberg_sidebar_widget_link_color_hover',
        'bizberg_footer_social_icon_color',
        'bizberg_footer_copyright_background',
        'bizberg_header_menu_color_hover_sticky_menu',
        'bizberg_header_button_color_sticky_menu',
        'bizberg_header_button_color_hover_sticky_menu'
    );

    foreach ( $options as $value ) {
        
        add_filter( $value , function(){
            return '#e91e63';
        });

    }

}

/**
* Changed to slider
*/

add_filter( 'bizberg_slider_banner_settings', 'business_event_slider_banner_settings' );
function business_event_slider_banner_settings(){
    return 'slider';
}

add_filter( 'bizberg_slider_gradient_primary_color', function(){
    return '#3a4cb4';
});

add_filter( 'bizberg_header_btn_border_radius', function(){
    return array(
        'top-left-radius'  => '0px',
        'top-right-radius'  => '0px',
        'bottom-left-radius' => '0px',
        'bottom-right-radius' => '0px'
    );
});

add_filter( 'bizberg_header_button_border_color', function(){
    return '#cc1451';
});

add_filter( 'bizberg_header_button_border_color_sticky_menu', function(){
    return '#cc1451';
});

add_filter( 'bizberg_header_button_border_dimensions', function(){
    return array(
        'top-width'  => '0px',
        'bottom-width'  => '5px',
        'left-width' => '0px',
        'right-width' => '0px',
    );
});

add_filter( 'bizberg_slider_btn_border_radius', function(){
    return array(
        'border-top-left-radius'  => '0px',
        'border-top-right-radius'  => '0px',
        'border-bottom-right-radius' => '0px',
        'border-bottom-left-radius' => '0px'
    );
});

add_filter( 'bizberg_read_more_border_color', function(){
    return '#cc1451';
});

add_filter( 'bizberg_read_more_border_dimensions', function(){
    return array(
        'top-width'  => '0px',
        'bottom-width'  => '5px',
        'left-width' => '0px',
        'right-width' => '0px',
    );
});

add_action( 'bizberg_before_homepage_blog', 'business_event_editor_choice', 30 );
function business_event_editor_choice(){

    $editor_pick_section_status = bizberg_get_theme_mod( 'editor_pick_section_status' ); 

    if( !$editor_pick_section_status ){
        return;
    } 

    $editor_pick_section_title = bizberg_get_theme_mod( 'editor_pick_section_title' );

    $editor_pick_section_category = bizberg_get_theme_mod( 'editor_pick_section_category' );
    $editor_pick_post_per_page = bizberg_get_theme_mod( 'editor_pick_post_per_page' );
    $editor_pick_order_by = bizberg_get_theme_mod( 'editor_pick_order_by' );

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $editor_pick_post_per_page,
        'orderby' => $editor_pick_order_by,
        'ignore_sticky_posts' => 1
    ); 

    if( !empty( array_filter( $editor_pick_section_category ) ) ){
        $args['category__in'] = $editor_pick_section_category;
    }

    $editor_pick_query = new WP_Query( $args );
    $flag = false;
    $count = 0; ?>

    <section id="bizberg_editor_choice">

        <?php 

        if( !empty( $editor_pick_section_title ) ){ ?>

            <div class="container">
                
                <div class="row">

                    <div class="col-xs-12">

                        <h2 class="editor_heading"><?php echo esc_html( $editor_pick_section_title ); ?></h2>

                    </div>

                </div>

            </div>

            <?php 

        } 

        if( $editor_pick_query->have_posts() ): ?>
        
            <div class="container business-event-flex-container">

                <div class="row">

                    <?php 

                    while( $editor_pick_query->have_posts() ): $editor_pick_query->the_post();

                        global $post;

                        $category_detail = get_the_category( $post->ID );

                        $cat_name = !empty( $category_detail[0]->name ) ? $category_detail[0]->name : '';

                        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium_large' );

                        if( $flag == false ): ?>
                    
                            <div class="col-xs-12  col-sm-12 col-md-8 content2">
                                
                                <div class="big_left_post" style="background-image: linear-gradient(to right,rgb(0 0 0 / 0.4),rgb(0 0 0 / 0.4)),url(<?php echo esc_url( !empty( $image_attributes[0] ) ? $image_attributes[0] : '' ); ?>)">

                                    <div class="big_left_post_content">
                                        
                                        <?php 
                                        if( !empty( $cat_name ) ){ ?>
                                            <a href="<?php echo esc_url( get_category_link( $category_detail[0] ) ); ?>" class="post-cat1 editor_cat_background_<?php  echo absint( $category_detail[0]->term_id ); ?>">
                                                <?php echo esc_html( $cat_name ); ?>
                                            </a>
                                            <?php 
                                        } ?>

                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                        <div class="post_meta2">
                                            <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php 

                            $flag = true;

                        else: 

                            if( $count == 0 ){ ?> <div class="col-xs-12  col-sm-12 col-md-4 right"> <?php } ?>                                

                                <div class="bizberg-row">
                                    
                                    <?php 
                                    if( has_post_thumbnail() ){ ?>
                                        <div class="thumbnail3">
                                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                                        </div>
                                        <?php 
                                    }?>

                                    <div class="content3">
                                        <?php 
                                        if( !empty( $cat_name ) ){ ?>
                                            <a href="<?php the_permalink(); ?>" class="post-cat1 editor_cat_background_<?php echo absint( $category_detail[0]->term_id ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                                            <?php 
                                        } ?>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="post_meta2">
                                            <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                        </div>
                                    </div>

                                </div>

                                <?php

                                if( $editor_pick_query->found_posts == ( $count + 1 ) ){ ?> </div> <?php } ?>  

                            <?php

                            $count++;

                        endif;

                    endwhile; ?>

                </div>

            </div>

            <?php 

        endif;

        wp_reset_postdata(); ?>

    </section>

    <?php
}

add_action( 'bizberg_before_homepage_blog', 'business_event_popular_posts', 20 );
function business_event_popular_posts(){

    $popular_section_status = bizberg_get_theme_mod( 'popular_section_status' );

    if( !$popular_section_status ){
        return;
    }

    $popular_section_title = bizberg_get_theme_mod( 'popular_section_title' );
    $popular_section_subtitle = bizberg_get_theme_mod( 'popular_section_subtitle' ); 
    $popular_section_category = bizberg_get_theme_mod( 'popular_section_category' ); 
    $popular_section_category_posts_per_page = bizberg_get_theme_mod( 'popular_section_category_posts_per_page' );

    $section_header = true;
    if( empty( $popular_section_title ) && empty( $popular_section_subtitle ) ){
        $section_header = false;
    }

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $popular_section_category_posts_per_page,
        'ignore_sticky_posts' => 1
    );

    if( !empty( array_filter( $popular_section_category ) ) ){
        $args['category__in'] = $popular_section_category;
    }

    $popular_query = new WP_Query( $args );

    if( $popular_query->have_posts() ):

        ?>

        <section 
        id="business_event_popular_posts"
        style="<?php echo( !$section_header ? 'padding: 0 0 50px 0;' : '' ); ?>">
            
            <div class="container">
                
                <?php 
                if( $section_header ){ ?>

                    <div class="row">
                        
                        <div class="col-xs-12">

                            <div class="title_wrapper_1">
                                <h2 class="text-center"><?php echo esc_html( $popular_section_title ); ?></h2>
                                <p class="text-center"><?php echo esc_html( $popular_section_subtitle ); ?></p>
                            </div>

                        </div>

                    </div>

                    <?php 
                } ?>

                <div class="row business_event_popular_posts_wrapper">

                    <?php 

                    while( $popular_query->have_posts() ): $popular_query->the_post();

                        global $post;

                        $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium_large' );
                        $image_link = !empty( $image_attributes[0] ) ? $image_attributes[0] : '';

                        $category_detail = get_the_category( $post->ID );

                        $cat_name = !empty( $category_detail[0]->name ) ? $category_detail[0]->name : ''; ?>

                        <div class="col-xs-12 col-sm-6 col-md-4 pop_wrapper">

                            <a href="<?php the_permalink(); ?>">
                                <div 
                                class="thumb1" 
                                style="background-image: <?php echo empty( $image_link ) ? 'linear-gradient(to right,rgb(0 0 0 / 0.4),rgb(0 0 0 / 0.4))' : 'url(' . esc_url( $image_link ) . ')'; ?>">
                                    <?php 
                                    if( !empty( $cat_name ) ){ ?>
                                        <span class="cat1">
                                            <?php echo esc_html( $cat_name ); ?>
                                        </span>
                                        <?php 
                                    } ?>
                                </div>
                            </a>

                            <div class="content1">
                                
                                <h4>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>            
                                    </a>
                                </h4>
                                <div class="post_meta1">
                                    <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                </div>

                            </div>

                        </div>

                        <?php 

                    endwhile; ?>

                </div>

            </div>

        </section>

        <?php

    endif;

    wp_reset_postdata();
}

add_action( 'bizberg_before_homepage_blog', 'business_event_3_col_posts' );
function business_event_3_col_posts(){

    // Display from category / pages
    $post_type = bizberg_get_theme_mod( 'blog_featured_3_col_post_type' );

    $pages = bizberg_get_theme_mod('featured_post_3_column');

    if( $post_type == 'none' ){
        return;
    }

    $page_ids = array();
    foreach ( $pages as $key => $value ) {
        $page_ids[] = $value['page_id'];
    }

    $args = array(
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1
    );

    // Include pages
    if( $post_type == 'page' ){
        $args['post__in'] = empty( $page_ids ) ? array( 'none' ) : $page_ids;
        $args['post_type'] = 'page';
        $args['orderby'] = 'post__in';
    } else {
        // Includes category
        $args['cat'] = bizberg_get_theme_mod( 'featured_post_3_column_category' );
        $args['post_type'] = 'post';
    }

    $featured_post = new WP_Query( $args );

    if( $featured_post->have_posts() ): ?>

        <section id="featured_3_grid">

            <div class="container">

                <div class="row">

                    <?php 

                    while( $featured_post->have_posts() ): $featured_post->the_post();

                        global $post; ?>
                    
                        <div class="col-xs-12 col-sm-12 col-md-4">

                            <?php 

                            if( has_post_thumbnail() ){ ?>
                            
                                <div class="bizberg_post_thumb">
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        
                                        <?php 
                                        the_post_thumbnail( 'bizberg_medium' );
                                        ?>

                                    </a>

                                </div>

                                <?php 

                            } ?>

                            <div class="bizberg_post_text">
                                
                                <div class="bizberg_post_title">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                                <div class="bizberg_post_date">
                                    <i class="far fa-clock"></i> <?php echo esc_html( get_the_date() ); ?>
                                </div>

                            </div>

                        </div>

                        <?php 

                    endwhile; ?>

                </div>

            </div>

        </section>

        <?php

    endif;

    wp_reset_postdata();

}

add_action( 'init' , 'business_event_kirki_fields' );
function business_event_kirki_fields(){

    /**
    * Start Featured Post 3 Column
    */

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'blog_homepage_featured_posts_3_col',
        'section'     => 'homepage',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Featured Posts ( 3 Column )', 'business-event' ) . '</div>'
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'radio',
        'settings'    => 'blog_featured_3_col_post_type',
        'label'       => esc_html__( 'Slider Type', 'business-event' ),
        'section'     => 'homepage',
        'default'     => 'category',
        'choices'     => [
            'category'   => esc_html__( 'From Category', 'business-event' ),
            'page' => esc_html__( 'From Pages', 'business-event' ),
            'none' => esc_html__( 'None', 'business-event' )
        ]
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'repeater',
        'label'       => esc_attr__( 'Select Pages', 'business-event' ),
        'section'     => 'homepage',
        'priority'    => 10,
        'row_label' => [
            'type'  => 'field',
            'value' => esc_html__( 'Page', 'business-event' )
        ],
        'settings'    => 'featured_post_3_column',
        'fields' => [
            'page_id'  => [
                'type'        => 'select',
                'label'       => esc_html__( 'Page', 'business-event' ),
                'choices'  => bizberg_get_all_pages()
            ],
        ],
        'default' => [],
        'choices' => [
            'limit' => 3
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'page',
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', array(
        'type'        => 'select',
        'settings'    => 'featured_post_3_column_category',
        'label'       => esc_html__( 'Select Post Category', 'business-event' ),
        'section'     => 'homepage',
        'multiple'    => 1,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'blog_featured_3_col_post_type',
                'operator' => '==',
                'value'    => 'category',
            ),
        ),
    ) );

    /**
    * End Featured Post 3 Column
    */

    /**
    * Start Popular News
    */

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'blog_homepage_popular_post',
        'section'     => 'homepage',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( 'Popular Posts', 'business-event' ) . '</div>'
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'popular_section_status',
        'label'       => esc_html__( 'Enable Popular Section ?', 'business-event' ),
        'section'     => 'homepage',
        'default'     => true,
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'popular_section_title',
        'label'    => esc_html__( 'Title', 'business-event' ),
        'section'  => 'homepage',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'popular_section_subtitle',
        'label'    => esc_html__( 'Subtitle', 'business-event' ),
        'section'  => 'homepage',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'popular_section_category',
        'label'       => esc_html__( 'Select Category', 'business-event' ),
        'section'     => 'homepage',
        'multiple'    => 10,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'popular_section_category_posts_per_page',
        'label'       => esc_html__( 'Limit', 'business-event' ),
        'section'     => 'homepage',
        'default'     => '3',
        'multiple'    => 1,
        'choices'     => [
            3 => 3,
            6 => 6,
            9 => 9,
            12 => 12
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'popular_section_category_background_color',
        'label'       => __( 'Category Background Color', 'business-event' ),
        'section'     => 'homepage',
        'default'     => '#e91e63',
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
        'transport' => 'auto',
        'output' => array(
            array(
                'element'  => '#business_event_popular_posts span.cat1',
                'property' => 'background',
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'popular_section_category_img_height',
        'label'       => esc_html__( 'Image Height', 'business-event' ),
        'section'     => 'homepage',
        'default'     => 300,
        'choices'     => [
            'min'  => 100,
            'max'  => 500,
            'step' => 25,
        ],
        'output' => array(
            array(
                'element'  => '#business_event_popular_posts .thumb1',
                'property' => 'height',
                'suffix' => 'px'
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'popular_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    /**
    * End Popular News
    */

    /**
    * Start Editors Pick
    */

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'blog_homepage_editors_pick',
        'section'     => 'homepage',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( "Editor's Choice Section", 'business-event' ) . '</div>'
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'checkbox',
        'settings'    => 'editor_pick_section_status',
        'label'       => esc_html__( "Enable Editor's Choice Section ?", 'business-event' ),
        'section'     => 'homepage',
        'default'     => true
    ] );

    Kirki::add_field( 'bizberg', [
        'type'     => 'text',
        'settings' => 'editor_pick_section_title',
        'label'    => esc_html__( 'Title', 'business-event' ),
        'section'  => 'homepage',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'editor_pick_section_category',
        'label'       => esc_html__( 'Select Category', 'business-event' ),
        'section'     => 'homepage',
        'multiple'    => 10,
        'choices'     => bizberg_get_post_categories(),
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'slider',
        'settings'    => 'editor_pick_post_per_page',
        'label'       => esc_html__( 'Limit', 'business-event' ),
        'section'     => 'homepage',
        'default'     => 5,
        'choices'     => [
            'min'  => 3,
            'max'  => 10,
            'step' => 1,
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'select',
        'settings'    => 'editor_pick_order_by',
        'label'       => esc_html__( 'Order By', 'business-event' ),
        'section'     => 'homepage',
        'default'     => 'date',
        'multiple'    => 1,
        'choices'     => [
            'date' => esc_html__( 'Date', 'business-event' ),
            'title' => esc_html__( 'Title', 'business-event' ),
            'rand' => esc_html__( 'Random', 'business-event' )
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'repeater',
        'label'       => esc_attr__( 'Select Category Background Colors', 'business-event' ),
        'section'     => 'homepage',
        'row_label' => [
            'type'  => 'field',
            'value' => esc_html__( 'Color', 'business-event' )
        ],
        'settings'    => 'editor_pick_colors',
        'fields' => [
            'cat_id'  => [
                'type'        => 'select',
                'label'       => esc_html__( 'Category', 'business-event' ),
                'choices'  => bizberg_get_post_categories()
            ],
            'color'  => [
                'type'        => 'color',
                'label'       => esc_html__( 'Color', 'business-event' ),
                'default'     => '#0088CC'
            ],
        ],
        'default' => [
            [
                'cat_id' => '',
                'color' => '#0088CC' 
            ]
        ],
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ] );

    Kirki::add_field( 'bizberg', [
        'type'        => 'color',
        'settings'    => 'editor_pick_background_color',
        'label'       => __( 'Background Color', 'business-event' ),
        'section'     => 'homepage',
        'default'     => '#fdeedc',
        'active_callback'    => array(
            array(
                'setting'  => 'editor_pick_section_status',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'transport' => 'auto',
        'output' => array(
            array(
                'element'  => '#bizberg_editor_choice',
                'property' => 'background',
            ),
        ),
    ] );

    /**
    * End Editors Pick
    */

    Kirki::add_field( 'bizberg', [
        'type'        => 'custom',
        'settings'    => 'blog_homepage_other_settings',
        'section'     => 'homepage',
        'default'     => '<div class="bizberg_customizer_custom_heading">' . esc_html__( "Other Blog Settings", 'business-event' ) . '</div>'
    ] );

}

add_filter( 'bizberg_inline_style', function( $inline_css ){

    $editor_pick_colors = bizberg_get_theme_mod( 'editor_pick_colors' );

    if( empty( $editor_pick_colors ) ){
        return $inline_css;
    }

    foreach ( $editor_pick_colors as $key => $value) {
        $inline_css .= '.editor_cat_background_' . absint( $value['cat_id'] ) . '{ background:' . esc_attr( $value['color'] ) . ' !important; }';
    }

    return $inline_css;

});