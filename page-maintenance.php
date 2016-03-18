<?php 
//include <head> tag
include('head.php');
global $logo,$theme_color;
wp_enqueue_style('page-maintenance', get_stylesheet_directory_uri() . '/css/page-maintenance.css');
?>

<body class="page-maintenance <?php echo $theme_color;?> <?php echo $post_slug; ?>">
	<div id="main" class="grid-fluid-12">

		<div class="row" id="splash">
			<div class="large-12 columns">
				<div class="group">
					<img class="logo" src="<?php echo $logo; ?>">
					<p>We're under maintenance!</p>		
				</div>				
			</div>
		</div>

	</div>


<?php 
//include <footer>
include('footer.php');
?>