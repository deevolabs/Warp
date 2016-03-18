<?php



/* 
=========================================================================
Postwall Component
v1.0
=========================================================================
*/


require_once(get_template_directory() . '/libs/visualcomposer/WPBakeryShortCode_Post_Query.php');


// ----------------------------- main shortcut function -----------------------------
function postwall_func( $atts ) {

	//get necessary files

	//wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/libs/slick/slick.css');
	//wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/libs/slick/slick.js', 'jquery');
	wp_enqueue_script('isotope', get_stylesheet_directory_uri() . '/libs/isotope/isotope.js', 'jquery');
	wp_enqueue_style('dx.postwall', get_stylesheet_directory_uri() . '/libs/dx/dx.postwall.css');
	wp_enqueue_script('dx.postwall', get_stylesheet_directory_uri() . '/libs/dx/dx.postwall.js', 'jquery');




	//extract params
	$options = shortcode_atts( array(
		'title' => '','class'=>'','id'=>'',
		'slider_content'=>'images','images'=>'','posts_query' => '','readmore' => 'Leia Mais',
		'thumb_size' => '','post_style'=>'thumb_overlay',	'grid_layout' => 'image,date_time,title,excerpt,content,link',
		'grid_type'=>'default','mode' => 'masonry','mouseclick'=>'postLink','columns' => '3','header' => '','gutters' => '','autoplay' => 'false','speed' => '5000','more_posts'=>'','more_posts_label'=>'Mais'
	), $atts );


	//BUG: here is a confusion about how to inherit the class methods
	$c = new WPBakeryShortCode_Carousel(array());

	//create posts array (used for posts AND for images)
	$posts = getPostsArray($c,$options);

	//return wall's HTML
	return renderWall($c,$posts,$options);

}

add_shortcode('postwall', 'postwall_func');


// ----------------------------- auxiliary functions ---------------------
	function getPostsArray($c,$options){

		$posts = array();
		//parse thumb_size;
		$pipe_pos = strpos($options["thumb_size"], ' | ');
		$options["thumb_size"] = substr($options["thumb_size"], 0, $pipe_pos);

		if($options["slider_content"]=='images'){
			$images = explode( ',', $options["images"] );
			$i = 1;

			foreach ( $images as $attach_id ) {
				$post = new stdClass();
				$post->n = $i;
				$post->thumb_img = wp_get_attachment_image_src( $attach_id, $options["thumb_size"] );
				$post->thumb_url =$post->thumb_img[0];
				$post->thumb_width = $post->thumb_img[1];
				$post->thumb_height = $post->thumb_img[2];
				$posts[] = $post;
				$i++;
			}
		}
		else if ($options["slider_content"]=='posts'){

			$c->resetTaxonomies();
			$c->getLoop( $options["posts_query"]);
			$my_query = $c->query;
			$i = 1;
			while ( $my_query->have_posts() ) {
				$my_query->the_post();
				$post = new stdClass();
				$post->n = $i;
				$i++;
				$post->id = get_the_ID();

				//get the date format
				//$options[""]
				$post->date = get_the_time('U');

				$post->title = the_title( "", "", false );
				$post->post_type = get_post_type();
				$post->content = get_the_content();
				$post->excerpt = get_the_excerpt();

				$post->thumb_id = get_post_thumbnail_id( $post->id );
				$post->thumb_img = wp_get_attachment_image_src( $post->thumb_id, $options["thumb_size"] );
				$post->thumb_url =$post->thumb_img[0];
				$post->thumb_width = $post->thumb_img[1];
				$post->thumb_height = $post->thumb_img[2];
				$fullimagelink = wp_get_attachment_image_src($post->thumb_id,'full');
				$post->full_image_link = $fullimagelink[0];

				//attachments plugin
				if(class_exists('Attachments')) {
					$attImages = '';
					$attImages = array();
					$attachments = new Attachments( 'my_attachments' );
					if( $attachments->exist() ) {
						while($attachments->get()){
							$attImages[] = "{href:'" . $attachments->src( 'full' ) . "',title:'".$attachments->field( 'title' ) ."',caption:'".$attachments->field( 'caption' ) ."',thumbnail:'".$attachments->src( 'medium' )."'}";
						}
					}
					$post->images = "[" . implode(",", $attImages) . "]";
				}
				else{
					do_action( 'add_debug_info', 'Attachments class not defined', 'dx_postwall' );
					$post->images = "";
				}

				//link
				if($options["mouseclick"]=='lightbox') $post->link = $post->full_image_link;
				else if($options["mouseclick"]=='attachments') $post->link = $post->full_image_link;
				else if($options["mouseclick"]=='no_link') $post->link = "#";
				else $post->link = get_permalink( $post->id );

				$post->categories = $c->getCategories( $post->id );
				$post->categories_css = $c->getCategoriesCss( $post->id );
				$posts[] = $post;
			}
			wp_reset_query();
		}
		return $posts;
	}

	//------------------------- wall css classes ---------------------------------


	function get_wall_css_classes($options){
		$classes = Array();
		$classes[] = "postwall";
		if($options["mode"]!='default') $classes[] = "isotope";
		$classes[] = $options["class"];
		$str_classes = implode(" ", $classes);
		return $str_classes;
	}


	//------------------------- post block structure ---------------------------------


	function getLinkClass($options){
		$link_class = "";
		$rel_attr = "";

		if($options["mouseclick"]=='lightbox') {
			$link_class .= "lightbox";
			$rel_attr = ' rel="gallery"';
		}
		else if($options["mouseclick"]=='attachments'){
			$link_class .= "lightbox";
		}
		$link_class .= "";
		return $link_class;
	}


	function part_thumb($post,$blockOptions,$options){

		$link_class = getLinkClass($options);

		ob_start();
		?>
			<div class="post-thumb">
				<a href="<?php echo $post->link; ?>" class="<?php echo $link_class; ?>" title="<?php echo $post->title; ?>" data-excerpt="<?php echo $post->excerpt; ?>" data-images="<?php echo $post->images;?>">
					<img width="<?php echo $post->thumb_width; ?>" height="<?php echo $post->thumb_height ?>" src="<?php echo $post->thumb_url; ?>" class="lazy" alt="">
				</a>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	function part_title($post,$blockOptions,$options){
		$link_class = getLinkClass($options);

		ob_start();
		?>
			<h3 class="post-title">
				<a href="<?php echo $post->link; ?>" class="<?php echo $link_class; ?>" title="<?php echo $post->title; ?>" data-images="<?php echo $post->images;?>"><?php echo $post->title; ?></a>
			</h3>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	function part_excerpt($post,$blockOptions,$options){
		ob_start();
		?>
		<div class="excerpt"><?php echo $post->excerpt; ?></div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}



	function part_content($post,$blockOptions,$options){
		ob_start();
		?>
			<div class="content"><?php echo $post->content; ?></div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	function part_button($post,$blockOptions,$options){
		$link_class = getLinkClass($options);
		ob_start();
		?>

			<?php if ($blockOptions=="button"):?>
				<?php $link_class.=' active'; ?>
				<button  type="submit" href="<?php echo $post->link; ?>" class="<?php echo $link_class; ?>"><?php echo $options["readmore"]; ?></button>
			<?php else:?>
				<?php $link_class.=' readmore'; ?>
				<a href="<?php echo $post->link; ?>" class="<?php echo $link_class; ?>"><?php echo $options["readmore"]; ?></a>
			<?php endif; ?>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	function part_time($post,$blockOptions,$options){
		$humanDate = '';


		$format = 'F d, Y H:i';
		$timestamp = $post->date;
		$local = local_date_i18n($format, $timestamp);
		$gmt = date_i18n($format, $timestamp);
		//echo "Local: ", $local, " UTC: ", $gmt;


		if($blockOptions=="full_date"){
			$humanDate = local_date_i18n('l, F j, Y', $timestamp);
			//$humanDate = get_date_from_gmt( $local, 'l, F j, Y' );
		}
		else if($blockOptions=="full_date_time"){
			$humanDate = local_date_i18n('l, F j, Y H:i', $timestamp);
			$humanDate = get_date_from_gmt( $local, 'l, F j, Y H:i' );
		}
		else if($blockOptions=="short_date"){
			$str_date = local_date_i18n('d/M', $timestamp);
			$arr_date = explode("/", $str_date);
			$d = "<span class='day'>".$arr_date[0]."</span>";
			$m = "<span class='month'>".$arr_date[1]."</span>";
			$humanDate = $d . $m;
		}
		else{
			$humanDate = local_date_i18n('d/m/Y', $timestamp);
		}

		ob_start();
		?>
			<time datetime="<?php echo $post->date; ?>" class="published"><?php echo $humanDate; ?></time>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}

	function part_categories($post,$blockOptions,$options){

		$output="";
		$categories = $post->categories;
		if(count($categories)>0){
			if($blockOptions=="main"){
				if ($category->name != 'uncategorized')
					$output .= '<li><a href="'.get_category_link( $categories[0]->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $categories[0]->name ) ) . '">'.$categories[0]->name.'</a></li>';
			}
			else if($blockOptions=="all"){
				foreach($categories as $category) {
					if ($category->name != 'uncategorized')
						$output .= '<li><a href="'.get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->name.'</a></li>';
				}
			}
		}

		ob_start();
		?>
			<ul class="categories"><?php echo $output; ?></ul>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}



	function outputBlocks($post,$options){
		//teaser blocks
		$thisPost = "";
		$teaser_blocks = vc_sorted_list_parse_value( $options['grid_layout'] );
		do_action( 'add_debug_info', $options['grid_layout'], '$grid_layout' );
		do_action( 'add_debug_info', $teaser_blocks, 'teaser_blocks' );

		//check first item to see if its the thumb. This is for grouping elements
		$normal_post_template = false;
		if(count($teaser_blocks)>1 && $teaser_blocks[0][0]=="image") $normal_post_template = true;

		for ($i=0; $i < count($teaser_blocks); $i++) {
			$blockType = $teaser_blocks[$i][0];
			$blockOptions = $teaser_blocks[$i][1][0];

			do_action( 'add_debug_info', $blockType, 'blockType'.$i );
			do_action( 'add_debug_info', $blockOptions, 'blockOptions'.$i );
			if($i==1 && $normal_post_template===true) $thisPost.="<div class='post-info'>";

			if($blockType=="image") {
				$thisPost.=part_thumb($post,$blockOptions,$options);
			}
			else if($blockType=="title"){
				$thisPost.=part_title($post,$blockOptions,$options);
			}
			else if($blockType=="excerpt") {
				$thisPost.=part_excerpt($post,$blockOptions,$options);
			}
			else if($blockType=="content") {
				$thisPost.=part_content($post,$blockOptions,$options);
			}
			else if($blockType=="link") {
				$thisPost.=part_button($post,$blockOptions,$options);
			}
			else if($blockType=="date_time") {
				$thisPost.=part_time($post,$blockOptions,$options);
			}
			else if($blockType=="categories") {
				$thisPost.=part_categories($post,$blockOptions,$options);
			}

			if($i==count($teaser_blocks)-1 && $normal_post_template===true) $thisPost.="</div>";

		}
		//do_action( 'add_debug_info', $thisPost, 'thisPost' );
		echo $thisPost;
	}


	//------------------------- post loop ---------------------------------
	function renderPost($post,$options){

		//columns
		$columns_class = '';
		$cols = 12/$options['columns'];
		if($options["grid_type"]=='default') $columns_class .= " large-$cols columns";
		if($options["mode"]!='default') $columns_class .= " isotope-item";

		ob_start();
		?>
			<li id="item-<?php echo $post->n; ?>" class="<?php echo $columns_class; ?> <?php echo $options['post_style']; ?> <?php echo $post->categories_css; ?>" data-type="<?php echo $post->post_type;?>">
				<div class="post">

					<?php if($options["slider_content"]=='images'): ?>
					<div class="post-thumb">
						<a href="<?php echo $post->link; ?>" class="<?php echo $link_class; ?>" rel="gallery" title="<?php echo $post->title; ?>">
							<img width="<?php echo $post->thumb_width; ?>" height="<?php echo $post->thumb_height ?>" src="<?php echo $post->thumb_url; ?>" class="lazy" alt="">
						</a>
					</div>
					<?php endif; ?>

					<?php if($options["slider_content"]=='posts'): ?>
						<?php outputBlocks($post,$options); ?>
					<?php endif; ?>


				</div>
			</li>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	//------------------------- header output ---------------------------------
	function renderHeader($c,$options){

		ob_start();
		?>
			<div class="header">

				
					<div class="title">
						<h3><?php echo $options["title"]; ?></h3>
					</div>
				

				<?php if($options["slider_content"]=='posts' && count($c->getTaxonomies())>0):?>
					<div class="filter_box">
						<div class="filter_text">filtrar por:</div>
						<select class="taxonomies">
							<?php foreach ( $c->getTaxonomies() as $tax ):?>
								<?php if($tax!="post_tag" && $tax!="post_format"): ?>
									<option value="<?php echo $tax; ?>"><?php echo $tax; ?></option>
								<?php endif; ?>
							<?php endforeach;?>
						</select>
					</div>
				<?php endif; ?>

				<?php if($options["slider_content"]=='posts' && count($c->getFilterCategories())>0) : ?>
					<ul class="filter">
						<li data-category="*" ><a href="#" class="active">ver todos</a></li>
						<?php foreach ( $c->getFilterCategories() as $cat ):?>
							<li  data-category="<?php echo 'grid-cat-'.$cat->term_id; ?>" data-category-name="<?php echo $cat->name; ?>" data-category-tax="<?php echo $cat->taxonomy; ?>" >
								<a href="#"><?php echo esc_attr( $cat->name ) ?></a>
							</li>
						<?php endforeach;?>

					</ul>
				<?php endif; ?>

			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	//------------------------- more posts output ---------------------------------

	//TODO: desabilitado por enquanto até resolver-se a questão da criação de um subcomponente "post" ou "teaser";

	function renderMorePosts(){
		return ''; //<-------------------breakpoint, remover
		ob_start();
		?>
			<div class="morePosts">
				<a href="#" class="button" data-url="<?php bloginfo('template_directory'); ?>/libs/dx/dx.getposts.wp.php" data-total-posts="" data-posts-per-page="10" data-offset="0" data-post-type="post" data-post-category="">mais posts</a>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}


	//------------------------- wall output ---------------------------------

	function renderWall($c,$posts,$options){

		$css_class = get_wall_css_classes($options);

		//gutters
		if($options["gutters"]==='true') $gutters_class = "";
		else $gutters_class = ' nogutter';

		ob_start();
		?>
			<div id="<?php echo $options['id'];?>" class="<?php echo $css_class ;?>" data-mode="<?php echo $options['mode'];  ?>"  data-interval="<?php echo $options['autoplay'] === 'true' ? $options['speed'] : 0 ?>">
				
				<?php if($options["header"]==='true') echo renderHeader($c,$options); ?>
				
				<ul class="wall row<?php echo $gutters_class; ?>">
					<?php foreach ( $posts as $post ): ?>
						<?php echo renderPost($post,$options); ?>
					<?php endforeach; ?>
				</ul>
				<?php if($options['more_posts']==='true'):?>
					<?php echo renderMorePosts(); ?>
				<?php endif; ?>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
	    return $output;
	}




//apply vc map
vc_map( array(
    "name" => "Postwall",
    "base" => "postwall",
    'class'=>'',
    'icon'=>'icon-wpb-vc_carousel',
    "show_settings_on_create" => true,
	"category" => "Deevo Components",

    // component params
    "params" => array(
    	// general tab
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			'group' =>  'General',
			'description' => "Leave empty if you don't want a title above your carousel"
		),
        array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            'group' =>  'General',
            "description" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => "ID",
            "param_name" => "id",
            'group' =>  'General',
            "description" => ""
        ),

        // content tab


		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Slider Content",
			"value" => array('Images'=>'images','Teaser Posts'=>'posts'),
			"param_name" => "slider_content",
			'group' =>  'Content',
			"description" => ""
		),


		array(
			"type" => "attach_images",
			"class" => "",
			"heading" => "Images",
			"param_name" => "images",
			'group' =>  'Content',
			"description" => "",
			"dependency" => Array('element' => "slider_content", 'value' => array('images'))
		),

		array(
			"type" => "loop",
			"heading" => __('Posts Query', 'js_composer'),
			"param_name" => "posts_query",
			'value' => 'size:10|order_by:date',
			'settings' => array(
				'size' => array( 'hidden' => false, 'value' => 10 ),
				'order_by' => array( 'value' => 'date' ),
			),
			'group' =>  'Content',
			"description" => "",
			// "dependency" => Array('element' => "slider_content", 'value' => array('posts'))
		),




		array(
			'type' => 'sorted_list',
			'heading' => __( 'Teaser layout', 'js_composer' ),
			'param_name' => 'grid_layout',
			//'description' => __( 'Control teasers look. Enable blocks and place them in desired order. Note: This setting can be overrriden on post to post basis.', 'js_composer' ),
			'group' =>  'Content',
			'value' => 'image,title,excerpt',
			"dependency" => Array('element' => "slider_content", 'value' => array('posts')),
			'options' => array(
				array( 'image', __( 'Thumbnail', 'js_composer' ) ),
				array( 'title', __( 'Title', 'js_composer' ), array(
					array( 'title_simple', __( 'Title', 'js_composer' ) ),
					array( 'title_linked', __( 'Title with link', 'js_composer' ) )
				)),
				array( 'excerpt', __( 'Excerpt', 'js_composer' ) ),
				array( 'content', __( 'Content', 'js_composer' ) ),
				array( 'link', __( 'link', 'js_composer' ), array(
					array( 'inline_link', __( 'Inline Link', 'js_composer' ) ),
					array( 'separate_link', __( 'Separate Link', 'js_composer' ) ),
					array( 'button', __( 'Button', 'js_composer' ) )
				) ),
				array( 'categories', __( 'categories', 'js_composer' ), array(
					array( 'main', __( 'categoria principal', 'js_composer' ) ),
					array( 'all', __( 'todas as categorias', 'js_composer' ) )
				) ),
				array( 'date_time', __( 'Date/Time', 'js_composer' ), array(
					array( 'full_date', __( 'Full date', 'js_composer' ) ),
					array( 'full_date_time', __( 'Full date and time', 'js_composer' ) ),
					array( 'short_date', __( 'Short Date', 'js_composer' ) ),
					array( 'dd-mm-yyyy', __( 'dd/mm/yyyy', 'js_composer' ) )
				) )

			)
		),

//TODO: desabilitado por enquanto até resolver-se a questão da criação de um subcomponente "post" ou "teaser";
/*
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '"Read More" button text',
			"param_name" => "readmore",
			'group' =>  'Content',
			"value" => "Leia Mais",
			"dependency" => Array('element' => "slider_content", 'value' => array('posts'))
		),
*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Mouse Click",
			"value" => array('No link'=>'no_link','Use post permalink'=>'post_link','Open image in lightbox'=>'lightbox','Open post attachments in lightbox'=>'attachments'),
			"param_name" => "mouseclick",
			'group' =>  'Content',
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Quality",
			"param_name" => "thumb_size",
			"value" => list_thumbnail_sizes(),
			'group' =>  'Content',
			"description" => "this is the image that will be used to compose the thumbnail. It will be stretched to fill the thumbnail size as defined by the CSS rules."
		),



		// Wall Settings tab
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "View Mode",
			"value" => array("Default"=>"default", "Isotope Masonry"=>"masonry","Isotope fitRows"=>"fitRows","Isotope cellsByRow"=>"cellsByRow" ),
			"param_name" => "mode",
			'group' =>  'Wall Settings',
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Grid type",
			"value" => array("Document Default Grid"=>'default',"No grid"=>'none'),
			"param_name" => "grid_type",
			'group' =>  'Wall Settings',
			"description" => ""
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Columns",
			"param_name" => "columns",
			'group' =>  'Wall Settings',
			"value" => "3"
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Post Style",
			"value" => array('post teaser'=>'teaser','thumbnail with overlay'=>'thumb_overlay','left-aligned'=>'left-aligned'),
			"param_name" => "post_style",
			'group' =>  'Wall Settings',
			"description" => "",
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Header",
			"value" => array("show postwall header?" => "true" ),
			"param_name" => "header",
			'group' =>  'Wall Settings',
			"description" => ""
		),


		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Gutters",
			"value" => array("show gutters?" => "true" ),
			"param_name" => "gutters",
			'group' =>  'Wall Settings',
			"description" => ""
		),


		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "More Posts Button",
			"value" => array('show "more posts" button' => "true" ),
			"param_name" => "more_posts",
			'group' =>  'Wall Settings',
			"description" => ""
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '"More Posts" button label',
			"param_name" => "more_posts_label",
			'group' =>  'Wall Settings',
			"value" => "Load More",
			"dependency" => Array('element' => "more_posts", 'not_empty' => true)
		)
    )
) );


//BUG: confusion!! See above
class WPBakeryShortCode_Postwall extends WPBakeryShortCode_Post_Query {}


?>
