<!DOCTYPE html>
<html class="dimensions_unavailable">
<head>
	<title><?php wp_title("|",true, 'right'); ?></title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<meta name="homepath" content="<?php bloginfo('url'); ?>" >
	<meta name="themefolder" content="<?php bloginfo('stylesheet_directory'); ?>" >

	<!-- mobile app ================================================= -->
	<link rel="shortcut icon" href="<?php get_stylesheet_directory_uri() . '/images/icon.png'; ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name='HandheldFriendly' content='True' />		
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200,700' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>
</head>
