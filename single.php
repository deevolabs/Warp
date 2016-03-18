<?php get_header(); ?>

<div id="main" class="grid-fluid-12">
	<div class="row">
		<div class="large-8 columns">


			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

			<?php
				$categories = get_the_category();
				$separator = ' ';
				$cats = '';
				$output = '';
				if($categories){
					foreach($categories as $category) {
						if ($category->cat_name != 'uncategorized' && $category->cat_name != 'Other') 
							$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
					}
				$cats .= trim($output, $separator);
				}
			?>
				
			<article>
				
				<!-- ======================== post header =============================== --> 
				<header class="clearfix">					
					
					<h2 class="title"><?php the_title(); ?></h2>
					<div class="excerpt"><?php the_excerpt(); ?></div>					
					<div class="meta-info">
						<div class="row">
							<div class="large-12 columns">								
								<div class="meta-item published"><span class="label_meta">Publicado em:</span><time class="meta-value"><?php the_date(); ?></time></div>
								<div class="meta-item categories"><span class="label_meta">Categorias:</span><span class="meta-value"><?php echo $cats; ?></span></div>
								<div class="meta-item readingtime"><span class="label_meta">Tempo de leitura:</span><span class="meta-value">5 minutos</span></div>							
							</div>
						</div>						
					</div>
					<div class="thumb">
						<?php the_post_thumbnail("rectangular_1024x576px"); ?>
					</div>



					<div class="row">
						<div class="large-12 columns">
							<?php get_template_part("libs/dx/dx.sharetab.wp.php"); ?>								
						</div>
					</div>
				</header>			

				

				<!-- ======================== post content =============================== --> 
			
				<div class="content clearfix">
					<?php the_content(); ?>
				</div>

				

					
				<footer>
					<!-- ======================== post attachments =============================== --> 
					<div class="row">
						<div class="large-12 columns">
							<ul class="attachments clearfix">
								<?php 
								//attachments plugin
								if(class_exists('Attachments')) {
									$attImages = '';
									$attImages = array();
									$attachments = new Attachments( 'attachments' );
									if( $attachments->exist() ) {
										while($attachments->get()){
											echo "<li>";
											echo "<a target='_blank' class='".$attachments->type()."' href='".$attachments->url()."'>";
											echo $attachments->field( 'title' );
											echo "</a>";
											echo "</li>";
											//$attImages[] = "{href:'" . $attachments->src( 'full' ) . "',title:'".$attachments->field( 'title' ) ."',caption:'".$attachments->field( 'caption' ) ."'}";
										}
									}
								}
							 	?>			
							</ul>	
							
						</div>
					</div>


					<!-- ======================== sharing tools =============================== --> 

					<div class="row">
						<div class="large-12 columns">
							<?php get_template_part('libs/dx/dx.sharetab.wp'); ?>							
						</div>
					</div>

					<!-- ======================== author info =============================== --> 
					<?php 
					$authorID = get_the_author_ID();
					$authorImage = get_the_author_meta('image', $authorID);
					$twitter = get_the_author_meta('twitter', $authorID);
					$googleplus = get_the_author_meta('googleplus', $authorID);
					$facebook = get_the_author_meta('facebook', $authorID);
					?>
					<div class="author">
						<div class="thumb">
							<img src='<?php echo $authorImage; ?>' alt="<?php echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); ?>" />
						</div>
						<div class="content">
							<h3 class="title">Sobre <span class="text"><?php echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); ?></span></h3>
							<div class="description"><?php the_author_meta('description'); ?></div>
							<ul class="social-media">
								<?php if ($facebook!='') { ?><li><a class="facebook" href="<?php echo $facebook; ?>" target="_blank"><span class="icon-facebook"></span></a></li><?php } ?>
								<?php if ($twitter!='') { ?><li><a class="twitter" href="<?php echo $twitter; ?>" target="_blank"><span class="icon-twitter"></span></a></li><?php } ?>
								<?php if ($googleplus!='') { ?><li><a class="googleplus" href="<?php echo $googleplus; ?>" target="_blank"><span class="icon-googleplus"></span></a></li><?php } ?>
							</ul>
						</div>
					</div>					

				</footer>

				<!-- ======================== facebook comments =============================== --> 

				<div class="comments">
					<h3>Comments</h3>
					<!-- TODO: mudar o data-href hardcoded -->
					<div class="fb-comments" data-href="https://www.facebook.com/deevoweb/" data-numposts="5" data-width="100%" data-colorscheme="light"></div>
				</div>				
			</article>
			<?php endwhile; endif; ?>	
		</div>




		<div class="large-4 columns">
			<!-- ======================== sidebar =============================== -->
			<div class="sidebar">
				<?php
				if(is_active_sidebar('blog-sidebar')){
					dynamic_sidebar('blog-sidebar');
				}
				else{
					echo '<div class="widget_placeholder">place widgets here</div>';
				}				
				?>
			</div>
		</div>
	</div>
	</div>
		

<?php get_footer(); ?>