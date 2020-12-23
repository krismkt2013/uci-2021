<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<?php
$body_class = ''; 
if( function_exists( 'bizberg_get_homepage_style_class' ) ){
	$body_class = bizberg_get_homepage_style_class();
}
?>

<body <?php body_class( 'bizberg sidebar ' . $body_class ); ?>>

<?php 

/**
* https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
*/

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else { 
	do_action( 'wp_body_open' ); 
}

do_action( 'bizberg_after_body' );

$primary_header_layout = bizberg_get_theme_mod( 'primary_header_layout' ); ?>

<header id="masthead" class="primary_header_<?php echo esc_attr( $primary_header_layout ); ?>">

	<a class="skip-link screen-reader-text" href="#content">
		<?php esc_html_e( 'Skip to content', 'bizberg' ); ?>		
	</a>

	<?php 
	do_action( 'bizberg_top_header' );
	?>

	<?php 

	$header_2_position = bizberg_get_theme_mod( 'header_2_position' );
	$flex_container = 'bizberg-flex-container';
	$primary_header_layout_width = bizberg_get_theme_mod( 'primary_header_layout_width' );

	$header_columns = bizberg_get_theme_mod( 'header_columns' );
	$header_columns_class = explode( '|' , $header_columns );

	$header_columns_middle_style = bizberg_get_theme_mod( 'header_columns_middle_style' );
	$header_columns_middle_style_class = explode( '|' , $header_columns_middle_style );

	$last_item_header = bizberg_get_theme_mod( 'last_item_header' );
	if( $last_item_header == 'none' ){
		$header_columns_class = array( 'col-sm-7' , 'col-sm-5' );
	}

	if( $primary_header_layout == 'center' ){ ?>

		<div class="primary_header_2_wrapper <?php echo esc_attr( $primary_header_layout_width == "100%" ? 'full_width' : '' ); ?>">

			<div class="container <?php echo esc_attr( $flex_container ); ?>">

				<div class="row <?php echo esc_attr( $flex_container ); ?>">

					<?php

					if( $header_2_position == 'left' ){ ?>

						<div class="<?php echo esc_attr( $header_columns_class[0] ); ?>">
							<div class="primary_header_2">
								<?php bizberg_get_primary_header_logo(); ?>
					   		</div>
					   	</div>
					   	<div class="<?php echo esc_attr( $header_columns_class[1] ); ?>">
					   		<div class="custom_header_content">
					   			<?php bizberg_get_last_item_header(); ?>
					   		</div>
					   	</div>

					   	<?php

					} else { ?>

						<div class="<?php echo esc_attr( $header_columns_middle_style_class[0] ); ?>">
							<div class="custom_header_content_logo_center left">
					   			<?php bizberg_get_first_item_header_logo_center(); ?>
					   		</div>
						</div>

						<div class="<?php echo esc_attr( $header_columns_middle_style_class[1] ); ?>">
							<div class="primary_header_2">
								<?php bizberg_get_primary_header_logo(); ?>
					   		</div>
					   	</div>

					   	<div class="<?php echo esc_attr( $header_columns_middle_style_class[2] ); ?>">
					   		<div class="custom_header_content_logo_center right">
					   			<?php bizberg_get_last_item_header_logo_center(); ?>
					   		</div>
					   	</div>

						<?php

					} ?>

				</div>

			</div>

		</div>		

		<?php
	} ?>

    <nav class="navbar navbar-default with-slicknav " style="background-color: rgba(10,10,10,0.5);top:0px;">
		<!--top bar -->
	<div id="top-bar" class="<?php echo esc_attr( $top_header_status_mobile ? 'enable_top_bar_mobile' : '' ); ?> collapse navbar-collapse navbar-arrow" style="border-bottom: none; background: rgba(10,10,10,0.5);">
		<div class="container">
			<div class="row">
				<div class="top_bar_wrapper">
					<div class="col-sm-4 col-xs-12">

						<?php 
						bizberg_get_header_social_links();
						?>

					</div>
					
					<div class="col-sm-8 col-xs-12">
						<div class="top-bar-right">
		                   	<ul class="infobox_header_wrapper">
							   <li>
							<a target="" href="/">
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHzSURBVHjaYkxOP8IAB//+Mfz7w8Dwi4HhP5CcJb/n/7evb16/APL/gRFQDiAAw3JuAgAIBEDQ/iswEERjGzBQLEru97ll0g0+3HvqMn1SpqlqGsZMsZsIe0SICA5gt5a/AGIEarCPtFh+6N/ffwxA9OvP/7//QYwff/6fZahmePeB4dNHhi+fGb59Y4zyvHHmCEAAAW3YDzQYaJJ93a+vX79aVf58//69fvEPlpIfnz59+vDhw7t37968efP3b/SXL59OnjwIEEAsDP+YgY53b2b89++/awvLn98MDi2cVxl+/vl6mituCtBghi9f/v/48e/XL86krj9XzwEEEENy8g6gu22rfn78+NGs5Ofr16+ZC58+fvyYwX8rxOxXr169fPny+fPn1//93bJlBUAAsQADZMEBxj9/GBxb2P/9+S/R8u3vzxuyaX8ZHv3j8/YGms3w8ycQARmi2eE37t4ACCDGR4/uSkrKAS35B3TT////wADOgLOBIaXIyjBlwxKAAGKRXjCB0SOEaeu+/y9fMnz4AHQxCP348R/o+l+//sMZQBNLEvif3AcIIMZbty7Ly6t9ZmXl+fXj/38GoHH/UcGfP79//BBiYHjy9+8/oUkNAAHEwt1V/vI/KBY/QSISFqM/GBg+MzB8A6PfYC5EFiDAABqgW776MP0rAAAAAElFTkSuQmCC" title="English" alt="English" width="16" height="11" style="width: 16px; height: 11px; margin-left: 12px;"> English
							</a>
							
		</li>
		<li>
							<a target="" href="/?page_id=863&amp;lang=zh&amp;customize_changeset_uuid=5e3e12b2-0c5d-4604-8ff7-aae25a1ed260&amp;customize_autosaved=on&amp;customize_messenger_channel=preview-27">
				
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGhSURBVHjaYnzLwPCPAQr+wUhk9Acs+AfMZmJgAAggFiCLp7oarPDffyD6+5fhz9//f/8w/P37//dvEPrzB04+3rQJIIBYmEBq//978hSoFKQaKPf3L4+V9X9urk9r1vz7BdTz6/+vX0DVTLKyQKUAAQRW/+8/VPXfv0xAwMz8Pznpv7o6h7AwIxPDv1+/IAioB+gcgABiAboMpPrPH4Y/fxgZGTlrav6/f////oP/HJzMkyZxP3/+NSvr15cvEOcBFQMEEAvIQX9AzgVq+Pf77/+bN/87Of3ftPk/J+f/f3//797979s3oPEMYG8ANQAEEMQGkPEgt/7+83HaNF6giJERKAC4OD+vW/f782eoH8BOAgggJlBQAnWDhP4ATWLj5/+vpwfiHjwAtISVhweiGmQ82AaAAALZADb+9z+wK3++fMlYUfHj4cNfnz/zHTny5fFjoAaGP7///fnL9PcvUDFAAIHi4d/vP4ySkkwgY4C+//0DqFlUlFlQ8MurVyxyciC//QWpBoYNUDFAADE+ZGD4hRqvyIw/qHHPxsAAEGAA8os95q2GYrQAAAAASUVORK5CYII=" title="中文 (香港)" alt="中文 (香港)" width="16" height="11" style="width: 16px; height: 11px;margin-left: 15px; "> 繁體中文
							</a>
					
		</li>  	                   		
		                   		<!-- <?php
		                   		bizberg_get_infobox_header();
								   ?> -->
							   </ul>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

        <div id="navbar" class="collapse navbar-collapse navbar-arrow" style="background-color: transparent;">

            <div class="container">

            	<div class="bizberg_header_wrapper">

	                <?php 	                
	                
	                bizberg_get_primary_header_logo();	                	               
					
	                if( has_nav_menu( 'menu-1' ) ){

	                	$walker = new Bizberg_Menu_With_Description;
	                	wp_nav_menu( array(
						    'theme_location' => 'menu-1',
						    'menu_class'=>'nav navbar-nav pull-right',
						    'container' => 'ul',
						    'menu_id' => 'responsive-menu',
						    'walker' => $walker,
						    'link_before' => '<span class="eb_menu_title">',
						    'link_after' => '</span>'
						) );

	                } else {

	                	wp_nav_menu( array(
						    'theme_location' => 'menu-1',
						    'menu_class'=>'nav navbar-nav pull-right',
						    'container' => 'ul',
						    'menu_id' => 'responsive-menu',
						    'link_before' => '<span class="eb_menu_title">',
						    'link_after' => '</span>'
						) );
						
	                }
	                
	                ?>

	            </div>

            </div>

        </div><!--/.nav-collapse -->

        <div id="slicknav-mobile" class="<?php echo ( !has_custom_logo() ? 'text-logo' : '' ); ?>"></div>

    </nav> 
</header><!-- header section end -->

<?php 
global $template; // For elementor
if( is_page_template( 'page-templates/full-width.php' ) 
	|| is_404() 
	|| is_page_template( 'contact-us.php' )
	|| is_page_template( 'page-templates/page-fullwidth-transparent-header.php' )
	|| basename($template) == 'header-footer.php' ){
	// no breadcrum
	echo '';
} elseif( ! ( is_front_page() || is_home() ) ){
	bizberg_get_breadcrums();
} else { 

	$status = bizberg_get_theme_mod( 'slider_banner' );
	switch ( $status ) {
		case 'slider':
			bizberg_get_slider_1();
			break;

		case 'banner':
			bizberg_get_banner();
			break;
		
		default:
			# code...
			break;
	}

} 