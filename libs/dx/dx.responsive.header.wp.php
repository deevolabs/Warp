<?php 
$logo = get_bloginfo('stylesheet_directory') . '/images/logo-positivo.png';

// custom walker form menus


wp_register_style('dx.responsive.header', get_template_directory_uri() . '/libs/dx/dx.responsive.header.css');
wp_register_script('dx.responsive.header', get_template_directory_uri() . '/libs/dx/dx.responsive.header.js', 'jquery');
wp_enqueue_style('dx.responsive.header');	
wp_enqueue_script('dx.responsive.header');




class description_walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth=0,$args = array(),$id = 0)
	{


		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

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


<header class="responsiveHeader grid-fluid-12">
	<div id="firstRow">
		<div class="container row">
			<?php
				if(is_active_sidebar('header-pre'))	dynamic_sidebar('header-pre');
				else echo '<div class="widget_placeholder">place widgets here</div>';
			?>
		</div>		
	</div>

	<div id="secondRow">
		<div class="container row">
			<div id="logo">
				<div class="vertical_center">
					<a href="<?php bloginfo('url'); ?>"><h1><img src="<?php echo $logo; ?>"><span class="title"><?php bloginfo("name"); ?></span></h1></a>					
				</div>
			</div>
			<div id="minimenu">
				<div class="vertical_center">
					<ul>
						<li id="search-button"><input id="input-field" type="text" placeholder="type your search" /><a class="icon-search" href="#"></a></li>
						<li id="menu-button"><a href="#" class="icon-menu"></a></li>
					</ul>
				</div>
			</div>				
			<div id="mainMenu">
				<div class="vertical_center">
					<ul class="navbar">
						<?php wp_nav_menu( array( 'items_wrap' => '%3$s','container'=>'','theme_location' => 'header-menu' ,'walker' => new description_walker) ); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="menuHolder"><div class="container row"></div></div>
</header>