<?php 
/* 
=========================================================================
Mobile Menu Component
v1.0
=========================================================================
*/

class warp_mobile_menu{

	function __construct(){
		

		
		function loadMobileMenuResources(){
			wp_enqueue_style('mobilemenu_css', get_stylesheet_directory_uri() . '/libs/warp/warp.mobile.menu.css');
			wp_enqueue_script('mobilemenu_js', get_stylesheet_directory_uri() . '/libs/warp/warp.mobile.menu.js', 'jquery');
		}

		add_action('wp_enqueue_scripts', 'loadMobileMenuResources');
				add_action("init",array($this,"warp_mobile_menu_init"));
		add_shortcode("warp_mobile_menu",array($this,"display_warp_mobile_menu"));
	}

	function warp_mobile_menu_init(){
		//code
	}

	function display_warp_mobile_menu(){
		global $logo;
		ob_start();?>
			<header class="mobileMenu">					
				<div class="group">
					<div class="group clearfix">
						<a class="logo" href="<?php bloginfo('url'); ?>"><h1><img src="<?php echo $logo; ?>"><span class="title"><?php bloginfo("name"); ?></span></h1></a>
						<div class="buttons clearfix">
							<div class="search-button"><input class="input-field" type="text" placeholder="buscar" /><a class="icon-search" href="#"></a></div>
							<div class="menu-button"><a href="#" class="icon-menu"></a></div>
						</div>
					</div>
					<div class="menu">
						<ul class="nav_menu clearfix">
							<?php wp_nav_menu( array( 'items_wrap' => '%3$s','container'=>'','theme_location' => $menu,'depth' => '2') ); ?>
						</ul>
					</div>
				</div>

			</header>		
		<?php 
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}

}
new warp_mobile_menu;
?>