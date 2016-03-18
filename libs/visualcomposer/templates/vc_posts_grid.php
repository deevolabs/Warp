<?php
echo 'olá';
$posts = array();
extract( shortcode_atts( array(
	'title' => '',
	'class' => '',
	'orderby' => NULL,
	'order' => 'DESC',
	'loop' => '',
	'id' => '',
	'isotope_mode' => 'masonry',
	'columns' => 3,
	'fullwidth' => false,
	'gutters' => false,
	'more_posts_label'=>'load more posts',
	'post_style'=>'teaser',
	'lightbox'=>'false',
	't_image_size'=>'medium'
), $atts ) );


$pipe_pos = strpos($t_image_size, ' | ');
$t_image_size = substr($t_image_size, 0, $pipe_pos);
echo 'posts_query' . $loop;
$this->resetTaxonomies();
if ( empty( $loop ) ) return;
$this->getLoop( $loop );
$my_query = $this->query;
$args = $this->loop_args;

while ( $my_query->have_posts() ) {
	$my_query->the_post();
	$post = new stdClass();
	$post->id = get_the_ID();
	$post->date = get_the_date('Y-m-d');
	$post->link = get_permalink( $post->id );
	$post->title = the_title( "", "", false );
	$post->post_type = get_post_type();
	$post->content = $this->getPostContent();
	$post->excerpt = $this->getPostExcerpt();
	$post->thumbnail_data = $this->getPostThumbnail( $post->id, $t_image_size );
	$post->thumbnail = $post->thumbnail_data['thumbnail'];
	$post->full_image_link = $post->thumbnail_data['p_img_large'][0];
	$post->categories_css = $this->getCategoriesCss( $post->id );
	$posts[] = $post;
}
wp_reset_query();

wp_enqueue_script( 'isotope' );
wp_enqueue_script( 'dx.postwall' );
wp_enqueue_style( 'dx.postwall' );

//lightbox
if($post_style=='thumb_overlay' && $lightbox=='true') $lightbox_class = "lightbox";
else $lightbox_class = '';	


//gutters
if($gutters==true) $gutters_class = "";
else $gutters_class = 'nogutter';

//columns
$cols = 12/$columns;
$columns_class = "large-$cols columns";

//main class
$css_class = 'postwall ' . $class; 

?>
<div id="<?php echo $id; ?>" class="<?php echo $css_class; ?>" data-isotope-mode="<?php echo $isotope_mode; ?>" data-extra="oi">
	
	<div class="title">
		<h3><?php echo $title; ?></h3>
		<p class="subtext"></p>
	</div>

	<ul class="filter">
		<?php  
			//create filter
			$categories_array = $this->getFilterCategories();
			foreach ( $this->getFilterCategories() as $cat ):?>
				<li><a href="#" data-category="<?php echo 'grid-cat-'.$cat->term_id; ?>" data-category-name="<?php echo 'grid-cat-'.$cat->name; ?>"><?php echo esc_attr( $cat->name ) ?></a></li>
			<?php endforeach;?>
		<li><a href="#" class="active" data-category="*"><?php echo __( 'All articles', 'mytextdomain' ); ?></a></li>
	</ul>


	<ul class="wall row <?php echo $gutters_class; ?>" data-extra="ei">
		<?php if ( count( $posts ) > 0 ): ?>
			<?php foreach ( $posts as $post ): ?>
				<?php 
				//thumbnail click
				if($post_style=='thumb_overlay' && $lightbox=='true'){
					$thumb_link = $post->full_image_link;
				}
				else{
					$thumb_link = $post->link;
				}
				?>
				<li class="<?php echo $columns_class; ?> <?php echo $post_style; ?> <?php echo $post->categories_css; ?>" data-type="<?php echo $post->post_type;?>">
					<a href="<?php echo $thumb_link; ?>" class="thumbnail <?php echo $lightbox_class; ?>"><?php echo $post->thumbnail; ?></a>
					<div class="postinfo">
						<h3><a href="<?php echo $post->link; ?>"><?php echo $post->title; ?></a></h3>
						<time class="published"><?php echo $post->date; ?></time>
						<p class="excerpt"><?php echo $post->excerpt; ?><a class="readmore" href="<?php echo $post->link; ?>">read more</a></p>
					</div>
				</li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>nothing found</li>
		<?php endif; ?>
	</ul>
	<div id="morePosts">
		<button><?php echo $more_posts_label; ?></button>
	</div>
</div>