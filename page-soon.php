<?php 
//include <head> tag
include('head.php');
global $logo,$theme_color;
wp_enqueue_style('page-soon', get_stylesheet_directory_uri() . '/css/page-soon.css');
?>

<body class="page-soon <?php echo $theme_color;?> <?php echo $post_slug; ?>">
	<div id="main" class="grid-fluid-12">

		<div class="row" id="splash">
			<div class="large-12 columns">
				<div class="group">
					<img class="logo" src="<?php echo $logo; ?>">
					<p>Coming soon!</p>		
				</div>				
			</div>
		</div>

		<div class="row" id="contact">
			<div class="large-12 columns">
				<div class="group">
					<h3>Contact us</h3>
					<a href="mailto:contact@deevo.com.br">contact@deevo.com.br</a>
				</div>
			</div>
		</div>



	</div>


<?php 
//include <footer>
include('footer.php');
?>