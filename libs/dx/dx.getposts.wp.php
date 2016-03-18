<?php

	$q = $_SERVER['QUERY_STRING'];
	
	parse_str($q, $args);
	
	include("../../../../wp-load.php");

	$query = new WP_Query( $args );
	//print_r($query);

	while ($query->have_posts()) : 
		$query->the_post();
		$output .= "<li>post</li>";
		//get_template_part('posts','grid');
	endwhile;

	echo $output;

wp_reset_query();

?>