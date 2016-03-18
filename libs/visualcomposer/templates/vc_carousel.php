<?php
global $vc_teaser_box;

$posts_query = $el_class = $args = $my_query = $speed = $mode = $swiper_options = '';
$content = $link = $layout = $thumb_size = $link_target = $slides_per_view = $wrap = '';
$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $title = '';

$posts = array();

extract( shortcode_atts( array(
	'posts_query' => '',
	'mode' => 'horizontal',
	'speed' => '5000',
	'slides_per_view' => '1',
	'swiper_options' => '',
	'wrap' => '',
	'autoplay' => 'no',
	'hide_pagination_control' => '',
	'hide_prev_next_buttons' => '',
	'layout' => 'title,thumbnail,excerpt',
	'link_target' => '',
	'thumb_size' => 'thumbnail',
	'title' => '',
	'id'=>'',
	'class'=>''
), $atts ) );




/* ------------ create "posts" object, looping through posts ----------- */
$this->resetTaxonomies();
if ( empty( $posts_query ) ) return;
$this->getLoop( $posts_query );
$my_query = $this->query;


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
	
	$post->thumb_id = get_post_thumbnail_id( $post->id );
	$post->thumb_img = wp_get_attachment_image_src( $post->thumb_id, $thumb_size );
	$post->thumb_url =$post->thumb_img[0];
	$post->thumb_width = $post->thumb_img[1];
	$post->thumb_height = $post->thumb_img[2];

	$post->categories_css = $this->getCategoriesCss( $post->id );
	$posts[] = $post;
}
wp_reset_query();
//----------------------------------------------------------------------------------

$this->setLinktarget( $link_target );


wp_enqueue_style( 'dx.slider' );
wp_enqueue_script( 'dx.slider' );


$random = '';
for ($i = 0; $i < 16; $i++) {
	$random .= chr(rand(ord('a'), ord('z')));
}
$scroller_unique_id = 'post_scroller_' . $random;

$css_class ='post_scroller ' . $class;

?>
		<div id="<?php echo $id;?>" class="<?php echo $css_class ;?>" 
			data-wrap="<?php echo $wrap === 'yes' ? 'true' : 'false' ?>"
			data-interval="<?php echo $autoplay == 'yes' ? $speed : 0 ?>" 
			data-auto-height="true"
			data-mode="<?php echo $mode ?>" 
			data-partial="<?php echo $partial_view === 'yes' ? 'true' : 'false' ?>"
			data-per-view="<?php echo $slides_per_view; ?>"
			data-hide-on-end="<?php echo $autoplay == 'yes' ? 'false' : 'true' ?>"
			data-scroller-id="<?php echo $scroller_unique_id; ?>" 
			>

			<!-- title -->
			<?php if($title):?>
				<h3><?php echo $title; ?></h3>
			<?php endif; ?>

			<div class="wrapper">
	

			<!-- nav prev -->
			<?php if ( $hide_prev_next_buttons !== 'yes' ): ?>
				<a class="navigation nav-prev" href="#<?php echo $scroller_unique_id; ?>">
					<span class="icon-arrow-left3"></span>
				</a>
			<?php endif; ?>

			<!-- Wrapper for slides -->
			<div class="post_scroller_wrapper" id='<?php echo $scroller_unique_id; ?>'>			
				<ul>
					<?php foreach ( $posts as $post ): ?>
					<li>
						<div class="post">						
							<div class="post-thumb">
								<a href="<?php echo $post->link; ?>" class="" title="<?php echo $post->title; ?>">
									<img width="<?php echo $post->thumb_width; ?>" height="<?php echo $post->thumb_height ?>" src="<?php echo $post->thumb_url; ?>" class="lazy" alt="">
								</a>
							</div>
							<div class="post-info">
								<h2 class="post-title">
									<a href="<?php echo $post->link; ?>" class="" title="<?php echo $post->title; ?>"><?php echo $post->title; ?></a>
								</h2>
								<p class="excerpt"><?php echo $post->excerpt; ?></p>
							</div>

						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			
			<!-- nav next -->
			<?php if ( $hide_prev_next_buttons !== 'yes' ): ?>
				<a class="navigation nav-next" <a href="#<?php echo $scroller_unique_id; ?>">
					<span class="icon-arrow-right3"></span>
				</a>
			<?php endif; ?>
			</div>

			<!-- Indicators -->
			<?php if ( $hide_pagination_control !== 'yes' ): ?>
				<ol class="indicators">
					<?php for ( $i = 0; $i < count( $posts ); $i ++ ): ?>
					<li><a href="#<?php echo $scroller_unique_id .'?i='. $i; ?>"></a></li>
					<?php endfor; ?>
				</ol>
			<?php endif; ?>


		</div>