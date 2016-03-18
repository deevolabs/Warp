<?php get_header(); ?>
<div id="main" class="grid-fluid-12">

<!-- 
	<div class="row">
		<div class="large-12 columns">
			<header class="clearfix">					
				<h2 class="title"><?php the_title(); ?></h2>
			</header>	
		</div>
	</div> 
-->

	<div class="page_wrapper">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>		
			<?php the_content(); ?>
		<?php endwhile; endif; ?>		
	</div>

</div>
<?php get_template_part("global.footer"); ?>
<?php get_footer(); ?>