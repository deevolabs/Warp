<?php get_header(); ?>
<div id="main" class="grid-fluid-12">
	<div class="row">
		<div class="large-12 columns">
			<h1>Archives</h1>
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<div class="post-result">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<time><?php the_date(); ?></time>	
					<?php the_excerpt(); ?>										
				</div>
			<?php endwhile; endif; ?>	
		</div>
		
	</div>
</div>
<?php get_footer(); ?>

