<?php get_header(); ?>
<div id="main" class="grid-fluid-12">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>		
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
</div>