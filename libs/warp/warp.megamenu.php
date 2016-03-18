<?php 
/* 
=========================================================================
Megamenu Component
v1.0
=========================================================================
*/

class warp_megamenu{

	function __construct(){
		
		add_action("init",array($this,"warp_megamenu_init"));
		add_shortcode("warp_megamenu",array($this,"display_warp_megamenu"));
		
		function loadMegamenuResources(){
			wp_enqueue_style('megamenu', get_stylesheet_directory_uri() . '/libs/warp/warp.megamenu.css');
			wp_enqueue_script('megamenu', get_stylesheet_directory_uri() . '/libs/warp/warp.megamenu.js', 'jquery');
			
			wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/libs/slick/slick.css');
			wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/libs/slick/slick.js', 'jquery');

		}

		add_action('wp_enqueue_scripts', 'loadMegamenuResources');
	}

	function warp_megamenu_init(){
		//code
	}

	function display_warp_megamenu(){
		global $logo;
		ob_start();?>

			<header class="megamenu grid-fluid-12">

				<div class="breakingNews">
					<div class="group">
						<span class="title">This is a call to action!</span>
						<span class="subtitle">It's awesome stuff!</span>
						<a class="button active" href="#" target="_self">Click here</a>
						<a class="btClose"><span class="icon-cross"></span></a>		
					</div>
				</div>

				<div class="statusLine">
					<div class="flexrow">
						
						<div class="news_ticker flexitem">
							<?php echo do_shortcode('[dx_newsTicker]'); ?>
						</div>

						<div class="support flexitem">
							<div class="group">
								<span class="icon-phone"></span><span>Atendimento: <span class="negrito">11 99555-2525</span></span>
							</div>					
						</div>
						<div class="social flexitem">
							<div class="group">
								<a class="facebook" href="https://www.facebook.com/deevo" target="_blank"><span class="icon-facebook"></span></a>
								<a class="twitter" href="https://www.twitter.com/deevo" target="_blank"><span class="icon-twitter"></span></a>
								<a class="googleplus" href="https://www.googleplus.com/deevo" target="_blank"><span class="icon-googleplus"></span></a>
								<a class="pinterest" href="https://www.pinterest.com/deevo" target="_blank"><span class="icon-pinterest"></span></a>										
								<a class="instagram" href="https://www.instagram.com/deevo" target="_blank"><span class="icon-instagram"></span></a>
								<a class="youtube" href="https://www.youtube.com/deevo" target="_blank"><span class="icon-youtube"></span></a>
								<a class="linkedin" href="https://www.linkedin.com/deevo" target="_blank"><span class="icon-linkedin"></span></a>


							</div>
						</div>	
					</div>
				</div>

				<div class="largeMenu">
					<div class="flexrow">			
						<div class="logo_container flexitem clearfix">
							<a class="logo" href="<?php bloginfo('url'); ?>"><h1><img src="<?php echo $logo; ?>"><span class="title"><?php bloginfo("name"); ?></span></h1></a>				
						</div>
						<div class="main_menu flexitem clearfix">
							<ul class="clearfix">
								<?php wp_nav_menu( array('items_wrap' => '%3$s','container'=>'','depth' => '1','theme_location' => $menu,'walker' => new description_walker) ); ?>
							</ul>			
						</div>
						<div class="buttons flexitem clearfix">
							<div class="btItem expandable search-field"><a class="icon-search" href="#"></a><input class="input-field" type="text" placeholder="Sobre o que você quer saber?" /></div>
						</div>

					</div>
					<div class="line"></div>
					<div class="tip"></div>
				</div>

				<div class="menu_areas clearfix">
					<ul class="original_menu">
						<?php wp_nav_menu( array( 'items_wrap' => '%3$s','container'=>'','theme_location' => 'header-menu','depth' => '3','walker' => new description_walker) ); ?>
					</ul>
				</div>
				
			</header>
		
		<?php 
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}

}
new warp_megamenu;



// custom walker form menus

class description_walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth=0,$args = array(),$id = 0)
	{

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		//item classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .' data-depth="'.$depth.'">';



		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$description  = '<span class="description">'.esc_attr( $item->description ).'</span>';

		if($depth != 0)
		{
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= '<span class="title">'.$args->link_before.apply_filters( 'the_title', $item->title, $item->ID )."</span>";
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}

?>


