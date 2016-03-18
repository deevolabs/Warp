<?php 

#-----------------------------------------------------------------#
# Global vars
#-----------------------------------------------------------------#

global $logo;
$logo = get_bloginfo('stylesheet_directory') . '/images/logo_warp.png';

//define global theme color
global $theme_color;
$theme_color = "theme-light"; 

global $one_page_site;
$one_page_site = false;

global $post_slug;
$post_slug=$post->post_name;




#-----------------------------------------------------------------#
# Register Global Scripts and Styles
#-----------------------------------------------------------------#

function loadResources(){
	
	//deactivate visual composer frontend editor 
	wp_deregister_style('js_composer_front');

	if (!is_admin()) {

		wp_enqueue_style('normalize', get_stylesheet_directory_uri() . '/libs/normalize.css');
		wp_enqueue_style('formalize', get_stylesheet_directory_uri() . '/libs/formalize/formalize.css');
		wp_enqueue_style('icomoon', get_stylesheet_directory_uri() . '/fonts/icomoon/style.css');
		wp_enqueue_style('buttons', get_stylesheet_directory_uri() . '/libs/buttons.css');
		wp_enqueue_style('warp', get_stylesheet_directory_uri() . '/libs/warp/warp.css');
		wp_enqueue_style('dx.tabs', get_stylesheet_directory_uri() . '/libs/dx/dx.tabs.css');
		wp_enqueue_style('dx.accordion', get_stylesheet_directory_uri() . '/libs/dx/dx.accordion.css');
		wp_enqueue_style('dx.slider', get_stylesheet_directory_uri() . '/libs/dx/dx.slider.css');
		wp_enqueue_style('dx.text_separator', get_stylesheet_directory_uri() . '/libs/dx/dx.text_separator.css');
		wp_enqueue_style('dx.grid', get_stylesheet_directory_uri() . '/libs/dx/dx.grid.fluid.12.css');
		wp_enqueue_style('dx.sharetab', get_stylesheet_directory_uri() . '/libs/dx/dx.sharetab.css');
		wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');


		//wp_enqueue_style('dx.postwall', get_stylesheet_directory_uri() . '/libs/dx/dx.postwall.css');
		//wp_enqueue_style('dx.video.playlist', get_stylesheet_directory_uri() . '/libs/dx/dx.video.playlist.css');
		//wp_enqueue_style('jquery-mobile', get_stylesheet_directory_uri() . '/libs/jquery-mobile/jquery.mobile.custom.structure.css');
		


		//registrando scripts
		wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/libs/jquery/jquery-1.8.3.js');
		wp_enqueue_script('polyfill-pointer-events', get_stylesheet_directory_uri() . '/libs/polyfills/pointer_events_polyfill.js','jquery');
		wp_enqueue_script('jquery-cookie', get_stylesheet_directory_uri() . '/libs/jquery/jquery.cookie.js', 'jquery');
		wp_enqueue_script('jquery.formalize', get_stylesheet_directory_uri() . '/libs/formalize/jquery.formalize.js', 'jquery');
		wp_enqueue_script('jquery.onscreen', get_stylesheet_directory_uri() . '/libs/jquery/jquery.onscreen.min.js', 'jquery');
		wp_enqueue_script('respond', get_stylesheet_directory_uri() . '/libs/respond.min.js', 'jquery');
		wp_enqueue_script('videobg', get_stylesheet_directory_uri() . '/libs/jquery/jquery.videoBG.js', 'jquery');
		wp_enqueue_script('stickyfloat', get_stylesheet_directory_uri() . '/libs/dx/dx.stickyfloat.js', 'jquery');
		wp_enqueue_script('stellar', get_stylesheet_directory_uri() . '/libs/jquery/jquery.stellar.js', 'jquery');
		wp_enqueue_script('dx.row', get_stylesheet_directory_uri() . '/libs/dx/dx.row.js', 'jquery');
		//wp_enqueue_script('ios-orientationchange-fix', get_stylesheet_directory_uri() . '/libs/ios-orientationchange-fix.js', 'jquery');
		wp_enqueue_script('moment', get_stylesheet_directory_uri() . '/libs/moment.js', 'jquery');
		wp_enqueue_script('jquery.mobile.touch.events', get_stylesheet_directory_uri() . '/libs/jquery-mobile/jquery.mobile.touch.events.js', 'jquery');
		wp_enqueue_script('warp', get_stylesheet_directory_uri() . '/libs/warp/warp.js', 'jquery');
		wp_enqueue_script('dx.tabs', get_stylesheet_directory_uri() . '/libs/dx/dx.tabs.js', 'jquery');
		wp_enqueue_script('dx.accordion', get_stylesheet_directory_uri() . '/libs/dx/dx.accordion.js', 'jquery');
		wp_enqueue_script('dx.lazyload', get_stylesheet_directory_uri() . '/libs/dx/dx.lazyload.js', 'jquery');
		wp_enqueue_script('dx.facebook', get_stylesheet_directory_uri() . '/libs/dx/dx.facebook.js', 'jquery');
		wp_enqueue_script('smoothscroll', get_stylesheet_directory_uri() . '/libs/SmoothScroll.js', 'jquery');
		wp_enqueue_script('dx.sharetab', get_stylesheet_directory_uri() . '/libs/dx/dx.sharetab.js');
		wp_enqueue_script('typed', get_stylesheet_directory_uri() . '/libs/typed.js');
		//wp_enqueue_script('isotope', get_stylesheet_directory_uri() . '/libs/jquery/jquery.isotope.min.js', 'jquery');	
		//wp_enqueue_script('google.webfont', get_stylesheet_directory_uri() . '/libs/google/webfont.js', 'jquery');		
		//wp_enqueue_script('iscroll', get_stylesheet_directory_uri() . '/libs/cubiq/iscroll.js');
		//wp_enqueue_script('dx.postwall', get_stylesheet_directory_uri() . '/libs/dx/dx.postwall.js', 'jquery');
		//wp_enqueue_script('dx.slider', get_stylesheet_directory_uri() . '/libs/dx/dx.slider.js', 'jquery');
		//wp_enqueue_script('dx.preloader', get_stylesheet_directory_uri() . '/libs/dx/dx.preloader.js', 'jquery');
		//wp_enqueue_script('dx.log', get_stylesheet_directory_uri() . '/libs/dx/dx.log.js', 'jquery');
		//wp_enqueue_script('dx.video.playlist', get_stylesheet_directory_uri() . '/libs/dx/dx.video.playlist.js', 'jquery');
		//wp_enqueue_script('easeljs', get_stylesheet_directory_uri() . '/libs/easeljs/easeljs-0.7.0.min.js');
		//wp_enqueue_script('movieclip', get_stylesheet_directory_uri() . '/libs/easeljs/movieclip-0.7.0.min.js');
		//wp_enqueue_script('preloadjs', get_stylesheet_directory_uri() . '/libs/easeljs/preloadjs-0.4.0.min.js');
		//wp_enqueue_script('tweenjs', get_stylesheet_directory_uri() . '/libs/easeljs/tweenjs-0.5.0.min.js');
		//wp_enqueue_script('dx_canvas', get_stylesheet_directory_uri() . '/libs/dx/dx.canvas.js');		
		//wp_enqueue_script('dx.moreposts', get_stylesheet_directory_uri() . '/libs/dx/dx.moreposts.wp.js');
		
		
		//individual styles
		if(is_home() || is_front_page()){
			wp_enqueue_style('home', get_stylesheet_directory_uri() . '/css/home.css');			
			wp_enqueue_script('home', get_stylesheet_directory_uri() . '/js/home.js');			
		}

		if(is_single() && !is_home() && !is_front_page() ){
			wp_enqueue_style('single', get_stylesheet_directory_uri() . '/css/single.css');			
			wp_enqueue_style('wpp', get_stylesheet_directory_uri() . '/css/wpp.css');			
			wp_enqueue_style('dx.gallery', get_stylesheet_directory_uri() . '/libs/dx/dx.gallery.css');
			wp_enqueue_script('dx.gallery', get_stylesheet_directory_uri() . '/libs/dx/dx.gallery.js', 'jquery');
		}

		if(is_page()){
			wp_enqueue_style('page', get_stylesheet_directory_uri() . '/css/page.css');			
		}

	}
}

add_action('wp_enqueue_scripts', 'loadResources');




#-----------------------------------------------------------------#
# WP native text editor enhancements
#-----------------------------------------------------------------#
/*
TODO: Verificar funcionamento do editor de texto e decidir se as linhas abaixo são necessárias
remove_filter('the_content', 'wpautop');
add_filter( 'the_content', 'shortcode_unautop',100 );
remove_filter("the_content", "wptexturize");
remove_filter("the_content", "convert_chars");
*/



#-----------------------------------------------------------------#
# Register menus
#-----------------------------------------------------------------#

function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );


#-----------------------------------------------------------------#
# Navigation menus
#-----------------------------------------------------------------#
if(is_mobile()){
	require_once(get_stylesheet_directory() . '/libs/warp/warp.mobile.menu.php');
}else{
	require_once(get_stylesheet_directory() . '/libs/warp/warp.megamenu.php');
}

function render_navigation_menu(){
	if(is_mobile()){
		echo do_shortcode('[warp_mobile_menu]');
	}else{
		echo do_shortcode('[warp_megamenu]');
	}
}






#-----------------------------------------------------------------#
# Register sidebars
#-----------------------------------------------------------------#

function createSidebars() {

	register_sidebar( array(
		'name' => 'Blog Sidebar',
		'id' => 'blog-sidebar',
		'description' => 'Blog Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'createSidebars' );



#-----------------------------------------------------------------#
# image thumbnail sizes
#-----------------------------------------------------------------#

/*
add_image_size( 'HD', 1280, 720, false ); 
add_image_size( 'FullHD', 1920, 1080, false ); 
add_image_size( 'FullSize', 9999, 9999, false ); 
add_image_size( 'square_80x80px', 80, 80, true ); 
add_image_size( 'rectangular_80x45px', 80, 45, true ); 
add_image_size( 'square_160x160px', 160, 160, true ); 
add_image_size( 'rectangular_160x90px', 160, 90, true ); 
add_image_size( 'square_320x320px', 320, 320, true ); 
add_image_size( 'rectangular_320x180px', 320, 180, true ); 
add_image_size( 'square_640x640px', 640, 640, true ); 
add_image_size( 'rectangular_640x360px', 640, 360, true ); 
add_image_size( 'rectangular_768x1024px',  768, 1024, true ); 
add_image_size( 'rectangular_1024x768px', 1024, 768, true ); 
add_image_size( 'rectangular_1024x576px', 1024, 768, true ); 
add_image_size( 'rectangular_1280x720px', 1280, 720, true ); 
add_image_size( 'rectangular_1920x1080px', 1920, 1080, true ); 
*/


function list_thumbnail_sizes(){
    global $_wp_additional_image_sizes;
 	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}

	$c = array();
	foreach( $sizes as $size => $atts ){
		 $c[] = $size . ' | ' . implode( 'x', $atts );
	}
		
	return $c;
}


#-----------------------------------------------------------------#
# tags to attachments
#-----------------------------------------------------------------#
function wptp_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'wptp_add_tags_to_attachments' );



#-----------------------------------------------------------------#
# Lazyload
#-----------------------------------------------------------------#
function addLazyload(){
	echo '<script src="'.get_bloginfo("template_url").'/libs/dx/dx.lazyload.js"></script>';
}
add_action('wp_footer', 'addLazyload',30);//adicionando ao footer sem usar enqueue_script, que não funciona.

//Modifica o parametro src de  todas as tags "<img>" para template_directory/images/transparent.png
require_once(get_stylesheet_directory() . '/libs/dx/dx.lazyload.wp.php');




#-----------------------------------------------------------------#
# Utilities
#-----------------------------------------------------------------#

function local_date_i18n($format, $timestamp) {
    $timezone_str = get_option('timezone_string') ?: 'UTC';
    $timezone = new \DateTimeZone($timezone_str);

    // The date in the local timezone.
    $date = new \DateTime(null, $timezone);
    $date->setTimestamp($timestamp);
    $date_str = $date->format('Y-m-d H:i:s');

    // Pretend the local date is UTC to get the timestamp
    // to pass to date_i18n().
    $utc_timezone = new \DateTimeZone('UTC');
    $utc_date = new \DateTime($date_str, $utc_timezone);
    $timestamp = $utc_date->getTimestamp();

    return date_i18n($format, $timestamp, true);
}


function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}





#-----------------------------------------------------------------#
# WP Admin Customizations
#-----------------------------------------------------------------#
add_action('admin_head', 'custom_admin_styles');

function custom_admin_styles() {
	ob_start();?>
		<style>
			body, td, textarea, input, select { font-family: "Open Sans"; font-size: 12px; }
			#adminmenu div.wp-menu-image:before { color: rgb(226, 226, 226) !important; }
			.index-php .welcome-panel { padding: 2em; margin-top: 3em; overflow: hidden; }
			.index-php .welcome-panel-content img { width: 290px; padding: 2em 2em; position: relative; float: left; }
			.index-php a.welcome-panel-close { display: none; }
			.index-php #wpbody #wpbody-content>.wrap>h2:first-child { display: none; }
			.index-php .welcome-panel-content { padding: 0px; margin: 0px; overflow: hidden; }
			.hide { display: none; }
			textarea#excerpt { height: 5em; }
			textarea#excerpt+p { display: none; }
			a:focus, a:focus .media-icon img{outline:none !important;box-shadow:none !important;}
			i.vc_element-description {display: none !important;}			
		</style>
	<?php 
	$output = ob_get_contents();
	ob_end_clean();
    echo $output;
}




#-----------------------------------------------------------------#
# Admin bar Customizations
#-----------------------------------------------------------------#
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wpseo-menu');
	$wp_admin_bar->remove_menu('WPML_ALS');
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('search');         // Remove the search link
    $wp_admin_bar->remove_menu('customize');         // Remove the customize link
    $wp_admin_bar->remove_menu('vc_inline-admin-bar-link');         // Remove the vc_inline-admin-bar-link link
    //$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    //$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
// and we hook our function via
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );




#-----------------------------------------------------------------#
# Page Slug Body Class
#-----------------------------------------------------------------#
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	$blacklist = preg_grep("/page-id/", $classes);
	$classes = array_diff($classes,$blacklist);
	
	$blacklist = preg_grep("/postid/", $classes);
	$classes = array_diff($classes,$blacklist);
global $theme_color;
	//$theme_color = "theme-light";
	array_push($classes,$theme_color);

	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );




#-----------------------------------------------------------------#
# Posts Order By
#-----------------------------------------------------------------#

add_filter('posts_orderby', 'group_by_post_type', 10, 2);
function group_by_post_type($orderby, $query) {
global $wpdb;
if ($query->is_search) {
    return $wpdb->posts . '.post_type DESC';
}
// provide a default fallback return if the above condition is not true
return $orderby;
}



#-----------------------------------------------------------------#
# Visual Composer configuration
#-----------------------------------------------------------------#
//if(is_plugin_active('/wp-content/plugins/js_composer/js_composer.php')) TODO: Checagem se o vc está rodando não funciona


/*Visual composer general settings
O arquivo abaixo é responsável por configurar o visual composer e alguns de seus componentes mais básicos como rows, columns, imagens, tabs, etc.
TODO: está muito confuso. Todo o conteúdo da pasta templates, aliás, está confuso.
*/

require_once(get_stylesheet_directory() . '/libs/visualcomposer/vc_config.php');

//Extra Visual composer components by Deevo
require_once(get_stylesheet_directory() . '/libs/dx/dx.postscroller.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.postwall.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.googlemaps.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.calltoaction.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.slidescroller.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.news.ticker.wp.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.videoplaylist.wp.vc.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.lightbox.gallery.wp.php');
//require_once(get_stylesheet_directory() . '/libs/dx/dx.canvas.wp.vc.php');
//require_once(get_stylesheet_directory() . '/libs/dx/dx.feature.wp.vc.php');

//TODO:transformar em shortcode e/ou vc_component
require_once(get_stylesheet_directory() . '/libs/dx/dx.gallery.wp.php');
require_once(get_stylesheet_directory() . '/libs/dx/dx.authorinfo.wp.php');