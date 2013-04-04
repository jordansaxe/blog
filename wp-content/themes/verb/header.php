<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<title><?php wp_title( '|', true, 'right' ); ?><?php echo bloginfo( 'name' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- media queries -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
	
	<!--[if lte IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
	<![endif]-->
	
	<!-- add js class -->
	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	
	<!-- load scripts -->
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<header class="header">
		<?php get_search_form();?>
		
		<!-- grab the logo and site title -->
		<?php if ( get_theme_mod('okay_theme_customizer_logo') ) { ?>
	    	<h1 class="logo-image">
				<a href="<?php echo home_url( '/' ); ?>"><img class="logo" src="<?php echo '' .get_theme_mod( 'okay_theme_customizer_logo', '' )."\n";?>" alt="<?php the_title(); ?>" /></a>
			</h1>
	    <?php } else { ?>
	    
		    <hgroup>	
		    	<h1 class="logo-text"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name') ?></a></h1>
		    	<h2 class="logo-subtitle"><?php bloginfo('description') ?></h2>
		    </hgroup>
	    
	    <?php } ?>
	    
	    <nav role="navigation" class="header-nav">
	    	<!-- search icon -->
	    	<a class="search-toggle" href="#" title=""><i class="icon-search"></i></a>
	    	
	    	<!-- nav menu -->
	    	<?php wp_nav_menu(array('theme_location' => 'main', 'menu_class' => 'nav')); ?>
	    </nav>	
	</header>
	
	<!-- next and previous page links -->
	<?php if(is_single()) { ?>	
		<div class="next-prev">
			<div class="prev-post">
				<?php previous_post_link('%link', 'Previous Post'); ?>
			</div>
			
			<div class="next-post">
				<?php next_post_link('%link', 'Next Post'); ?>
			</div>
		</div>	
	<?php } ?>
	
	<div id="wrapper">
		<div id="main">