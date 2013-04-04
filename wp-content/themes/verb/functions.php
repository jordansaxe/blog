<?php

//-----------------------------------  // Load Scripts //-----------------------------------//

function okay_scripts_styles() {
	
	//Enqueue Styles
	
	//Pocket Stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	//Font Awesome CSS
	wp_enqueue_style( 'font_awesome_css', get_template_directory_uri() . "/includes/fonts/fontawesome/font-awesome.css", array(), '0.1', 'screen' );
	
	//Media Queries CSS
	wp_enqueue_style( 'media_queries_css', get_template_directory_uri() . "/media-queries.css", array(), '0.1', 'screen' );
	
	//Google Merriweather Font
	wp_enqueue_style('google_merriweather', 'http://fonts.googleapis.com/css?family=Merriweather:400,700');
	
	//Enqueue Scripts
	
	//Register jQuery
	wp_enqueue_script('jquery');
	
	//Custom JS
	wp_enqueue_script('custom_js', get_template_directory_uri() . '/includes/js/custom/custom.js', false, false , true);
	
	//Mobile JS
	wp_enqueue_script('mobile_menu_js', get_template_directory_uri() . '/includes/js/menu/jquery.mobilemenu.js', false, false , true);
	
	//Chirp
	wp_enqueue_script('chirp_js', get_template_directory_uri() . '/includes/js/chirp/chirp.min.js', false, false , false);
	
	//FidVid
	wp_enqueue_script('fitvid_js', get_template_directory_uri() . '/includes/js/fitvid/jquery.fitvids.js', false, false , true);

}
add_action( 'wp_enqueue_scripts', 'okay_scripts_styles' );




//-----------------------------------  // Add Customizer CSS To Header //-----------------------------------//

function customizer_css() {
    ?>
	<style type="text/css">
		a, #cancel-comment-reply i  {
			color: <?php echo '' .get_theme_mod( 'okay_theme_customizer_accent', '#DD574C' )."\n";?>;
		}
		
		.next-prev a, #respond .respond-submit, .wpcf7-submit, .header .search-form .submit, .search-form .submit {
			background: <?php echo '' .get_theme_mod( 'okay_theme_customizer_accent', '#DD574C' )."\n";?>; 
		}
		
		<?php echo '' .get_theme_mod( 'okay_theme_customizer_css', '' )."\n";?>
	</style>
    <?php
}
add_action('wp_head', 'customizer_css');




//-----------------------------------  // Add Localization //-----------------------------------//

load_theme_textdomain( 'okay', get_template_directory() . '/includes/languages' );
 
$locale = get_locale();
$locale_file = get_template_directory_uri() . "/includes/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);	



//-----------------------------------  // Pagination //-----------------------------------//

function okay_page_has_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}




//-----------------------------------  // Customizer & Background Support //-----------------------------------//

require_once(dirname(__FILE__) . "/customizer.php");
add_theme_support( 'custom-background' );



//-----------------------------------  // Add Customizer To Menu //-----------------------------------//

function okay_customizer_admin() {
	add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' ); 
}
add_action ('admin_menu', 'okay_customizer_admin');



//-----------------------------------  // Add Quote Post Format //-----------------------------------//

add_theme_support('post-formats', array( 'quote'));



//-----------------------------------  // Excerpt Read More Link //-----------------------------------//

function okay_new_excerpt_more($more) {
       global $post;
	return ' <a class="more-link" href="'. get_permalink($post->ID) . '">- Read More -</a>';
}
add_filter('excerpt_more', 'okay_new_excerpt_more');




//-----------------------------------  // Custom Read More //-----------------------------------//

function okay_readmore() {
	global $post;
	$ismore = @strpos( $post->post_content, '<!--more-->');
	if($ismore) : the_content(__( '- Read More -','okay'));
	else : the_excerpt(__( '- Read More -','okay'));
	endif;
}




//-----------------------------------  // Editor Styles //-----------------------------------//

require_once(dirname(__FILE__) . "/includes/editor/add-styles.php");



//-----------------------------------  // Auto Feed Links //-----------------------------------//

add_theme_support( 'automatic-feed-links' );



//-----------------------------------  // Load Widgets //-----------------------------------//

require_once(dirname(__FILE__) . "/includes/widgets/twitter.php");



//-----------------------------------  // Add Menus //-----------------------------------//

add_theme_support( 'menus' );
register_nav_menu('main', 'Main Menu');
register_nav_menu('custom', 'Custom Menu');



//-----------------------------------  // Thumbnail Sizes //-----------------------------------//

add_theme_support('post-thumbnails');
add_image_size( 'large-image', 9999, 9999, false ); // Large Post Image

if ( ! isset( $content_width ) ) $content_width = 690;



//-----------------------------------  // Register Widget Areas //-----------------------------------//

if ( function_exists('register_sidebars') )

register_sidebar(array(
	'name' => 'Footer Widgets',
	'description' => 'Widgets in this area will be shown in the footer.',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>'
));



//-----------------------------------  // Custom Comment Output //-----------------------------------//

function okay_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
		
		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="comment-info">	
				<div class="comment-author vcard clearfix">
					<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>
					
					<div class="comment-meta commentmetadata">
						<?php printf(__('<cite class="fn">%s</cite>', 'okay'), get_comment_author_link()) ?>
						<div style="clear:both;"></div>
						<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'okay'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'okay'),'  ','') ?>
					</div>
				</div>
			<div class="clearfix"></div>
			</div>
			
			<div class="comment-text">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</p>
			</div>
		
			<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'okay') ?></em>
			<?php endif; ?>    
		</div>
<?php
}

function okay_alter_comment_form_fields($fields){

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
    $fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Your Name *', 'okay' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="author" name="author" type="text" placeholder="Your Name *" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
                    
    $fields['email'] = '<p class="comment-form-email">' . '<label for="email">' . __( 'Your Email *', 'okay' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="email" name="email" type="text" placeholder="Your Email *" value="' . esc_attr( $commenter['comment_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url">' . '<label for="url">' . __( 'Your Website', 'okay' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                    '<input id="url" name="url" type="text" placeholder="Your Website" value="' . esc_attr( $commenter['comment_url'] ) . '" size="30"' . $aria_req . ' /></p>';

    return $fields;
}
add_filter('comment_form_default_fields','okay_alter_comment_form_fields');


function okay_cancel_comment_reply_button($html, $link, $text) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="icon-remove-sign"></i> </div>';
}
 
add_action('cancel_comment_reply_link', 'okay_cancel_comment_reply_button', 10, 3);