<?php
	//extract params
	extract( shortcode_atts( array(
		'id'=>'','class'=>'','caption'=>'',
		'alignment' => 'none','image'=> '','thumb_size' => 'full','lazyload' => 'false','lightbox' => 'false','link_to'=>'no_link','custom_link'=>''
	), $atts ) );

	//set image
	$pipe_pos = strpos($thumb_size, ' | ');
	$thumb_size = substr($thumb_size, 0, $pipe_pos);
	$thumb_img = wp_get_attachment_image_src( $image, $thumb_size );
	$thumb_url =$thumb_img[0];
	$thumb_width = $thumb_img[1];
	$thumb_height = $thumb_img[2];

	//lightbox
	if($lightbox==='true') $lightbox_class = "lightbox";
	else $lightbox_class = '';	

	//lazyload
	if($lazyload==='true') $lazyload_class = "lazy";
	else $lazyload_class = '';	

	//set css class
	if($alignment!='none') $alignment_class = 'alignment-' .$alignment ;
	else $alignment_class = '';

	//link_to
	if($link_to==='link_larger'){
		$large_img = wp_get_attachment_image_src( $image,'full' );
		$link =$large_img[0];		
	}
	else if($link_to==='link_custom'){
		$link = $custom_link;
	}
	else{$link="#";}

	$css_class = 'dx_image ' . $class . ' ' .$alignment_class;

	//start composing HTML structure
	ob_start();
?>
			<?php if($link_to==='no_link'):?>
				<img id="<?php echo $id;?>" class="<?php echo $css_class . ' ' . $lazyload_class;?>" src="<?php echo $thumb_url; ?>" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" alt="<?php echo $caption; ?>"/>
			<?php else: ?>
				<a id="<?php echo $id;?>" href="<?php echo $link ;?>" class="<?php echo $css_class . ' ' . $lightbox_class ;?>" title="<?php echo $caption; ?>">
					<img class="<?php echo $lazyload_class ;?>" src="<?php echo $thumb_url; ?>" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" alt="<?php echo $caption; ?>" />
				</a>
			<?php endif; ?>


<?php 
	$output = ob_get_contents();
	ob_end_clean();
    echo $output;
?>