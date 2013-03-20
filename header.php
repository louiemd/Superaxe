<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<?php global $gdl_is_responsive ?>
	<?php if( $gdl_is_responsive ){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/skeleton-responsive.css">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/layout-responsive.css">	
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/skeleton.css">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/layout.css">	
	<?php } ?>
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie-style.php?path=<?php echo GOODLAYERS_PATH; ?>" type="text/css" media="screen, projection" /> 
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie7-style.css" /> 
	<![endif]-->	
	
	<!-- Favicon
   ================================================== -->
	<?php 
		if(get_option( THEME_SHORT_NAME.'_enable_favicon','disable') == "enable"){
			$gdl_favicon = get_option(THEME_SHORT_NAME.'_favicon_image');
			if( $gdl_favicon ){
				$gdl_favicon = wp_get_attachment_image_src($gdl_favicon, 'full');
				echo '<link rel="shortcut icon" href="' . $gdl_favicon[0] . '" type="image/x-icon" />';
			}
		} 
	?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 0, true);
	});
	</script>
	
	

	<!-- Start WP_HEAD
   ================================================== -->
		
	<?php wp_head(); ?>
	
	<!-- FB Thumbnail
   ================================================== -->
	<?php
	if( is_single() ){
		$thumbnail_id = get_post_meta($post->ID,'post-option-inside-thumbnial-image', true);
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<link rel="image_src" href="' . $thumbnail[0] . '" />';
		}
	} else{
		$thumbnail_id = get_post_thumbnail_id();
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<link rel="image_src" href="' . $thumbnail[0] . '" />';		
		}
	}
	?>	
	
	
	
	
</head>
<body <?php echo body_class(); ?>>
	<?php
		$background_style = get_option(THEME_SHORT_NAME.'_background_style', 'Pattern');
		if($background_style == 'Custom Image'){
			$background_id = get_option(THEME_SHORT_NAME.'_background_custom');
			if(!empty($background_id)){
				$background_image = wp_get_attachment_image_src( $background_id, 'full' );
				echo '<div id="custom-full-background">';
				echo '<img src="' . $background_image[0] . '" alt="" />';
				echo '</div>';
			}
		}
	?>
<div class="body-wrapper">

	
	<?php $gdl_enable_top_navigation = get_option(THEME_SHORT_NAME.'_enable_top_navigation');
	if ( $gdl_enable_top_navigation == '' || $gdl_enable_top_navigation == 'enable' ){  ?>
	<div class="top-navigation-wrapper">
		<div class="top-navigation container">
			<div class="top-navigation-left">
				<?php wp_nav_menu( array( 'theme_location' => 'top_menu' ) ); ?>
				<br class="clear">
			</div>
			
			<?php 
				$top_navigation_right_text = do_shortcode( __(get_option(THEME_SHORT_NAME.'_top_navigation_right_text'), 'gdl_front_end') );
				if( $top_navigation_right_text ){
					echo '<div class="top-navigation-right">' . $top_navigation_right_text . '</div>';
				}
			?>

		</div>
		<div class="top-navigation-wrapper-gimmick"></div>
	</div>

	<?php } ?>

	<div class="container">
		<div class="header-wrapper">
			
			<!-- Get Logo -->
			<div class="logo-outer-wrapper">
				<div class="logo-wrapper">
					<?php
						echo '<a href="';
						echo  bloginfo('url');
						echo '">';
						$logo_id = get_option(THEME_SHORT_NAME.'_logo');
						$logo_attachment = wp_get_attachment_image_src($logo_id, 'full');
						$alt_text = get_post_meta($logo_id , '_wp_attachment_image_alt', true);
						if( !empty($logo_attachment) ){
							$logo_attachment = $logo_attachment[0];
						}else{
							$logo_attachment = GOODLAYERS_PATH . '/images/default-logo.png';
							$alt_text = 'default logo';
						}
						echo '<img src="' . $logo_attachment . '" alt="' . $alt_text . '"/>';
						echo '</a>';
					?>
				</div>
			</div>
			<br class="clear">
			<!-- Navigation and Search Form -->
			<div class="sixteen columns mt0" style="margin-top:-23px !important;">
				<?php 
					if( $gdl_is_responsive ){
						dropdown_menu( array('dropdown_title' => '-- Main Menu --', 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' => 'responsive-menu-wrapper', 'theme_location'=>'main_menu') );	
					}
				?>
				<div class="navigation-wrapper">
					<!-- Get Navigation -->
					<?php wp_nav_menu( array('container' => 'div', 'container_class' => 'menu-wrapper', 'container_id' => 'main-superfish-wrapper', 'menu_class'=> 'sf-menu',  'theme_location' => 'main_menu' ) ); ?>
					
					<!-- Get Search form -->
					<?php if(get_option(THEME_SHORT_NAME.'_enable_top_search','enable') == 'enable'){?>
					<div class="search-wrapper"><?php get_search_form(); ?></div> 
					<?php } ?>
					
					<br class="clear">
				</div>
			</div>
			<br class="clear">
		</div> <!-- header-wrapper -->
		