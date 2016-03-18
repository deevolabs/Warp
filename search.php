<?php 


 ?>


<?php get_header(); ?>
<div id="main" class="grid-fluid-12">
	<div class="page_wrapper">

		<div class="row">
			<div class="large-12 columns">
				<h1>Search Results</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, suscipit.</p>
			</div>
		</div>

<?php 


$last_type="";
$typecount = 0;
while (have_posts()){
    the_post();



    if ($last_type != $post->post_type){
        $typecount = $typecount + 1;
        if ($typecount > 1){
            echo '</div>'; //close type container
        }
        // save the post type.
        $last_type = $post->post_type;
        //open type container
        switch ($post->post_type) {
            case 'post':
                echo "<div class=\"container post_container\"><h2>Posts</h2>";
                break;
            case 'page':
                echo "<div class=\"container page_container\"><h2>Páginas</h2>";
                break;
            case 'custom_type_name':
                echo "<div class=\"container custom_container\"><h2>Custom Posts</h2>";
                break;
            //add as many as you need.
        }
    }


    ?>
		<div class="post-result">
		<div class="row">
			<div class="large-12 columns">

				<div class="post-thumb">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>	
				</div>
				<div class="post-info">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>					
					<?php the_excerpt(); ?>
				</div>
			</div>
			</div>
		</div>
<?php 

}

 ?>

			<button class="MorePosts" href="#" 
				data-url = "<?php get_template_directory() . '/libs/dx/dx.getposts.wp.php' ?>"
				data-total-posts = "0" 
				data-posts-per-page = "10" 
				data-offset = "10" 
				data-post-type = "" 
				data-post-category = "" 
				data-container = ".page_wrapper">
				Mais Posts
			</button>
	</div>
</div>
<?php get_footer(); ?>

