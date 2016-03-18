<?php

   extract(shortcode_atts(array(

	  'bg_image'=> '',
	  'parallax_bg' => '', 
	  'bg_color'=> '', 
		'row_stretching' => false,
		'show_on_desktop' => true,
		'show_on_mobile' => true, 
	  'video_bg'=> '', 
	  'video_webm'=> '', 
	  'video_mp4'=> '', 
	  'video_poster'=> '', 
	  'enable_video_color_overlay'=> '', 
	  'video_overlay_color'=> '',
	  'class' => '',
	  'id' => ''
	  
	  ), 
	$atts));
	
    $style = '';
	$tag_class = '';





	
	//class ------------------------------------------------------------------------------------------------


	
	$bg_parallax_attr = $video_parallax_attr = '';
	
	if(strtolower($parallax_bg) == 'true'){
		$parallax_class = ' parallax';
		wp_enqueue_script('dx.row');
		wp_enqueue_script('stellar');
		$bg_parallax_attr = 'data-stellar-background-ratio="0.33"';
		$video_parallax_attr = 'data-stellar-ratio="0.33"';	
	} else {
		$parallax_class = '';
	}
	if($class!=""){
		$class= " " . $class;
	}



	//background ------------------------------------------------------------------------------------------------

	if(!empty($bg_image)) {
		if(!$video_bg || wp_is_mobile()){
			$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
			$style .= 'background-image: url('. $bg_image_src[0]. '); ';
		}
	}
	
	if(!empty($bg_color)) {
		$style .= 'background-color: '. $bg_color.'; ';
	}

	$autoplay = false;
	$videobg_class = "";
	$videoBG_code = "";
	if($video_bg) {
		if(!empty($video_poster)){
			$poster_src = wp_get_attachment_image_src($video_poster, 'full');
			$poster_style .= 'background-image: url('. $poster_src[0]. '); ';
		}
		
		$videobg_class = " videobg";
		$videoBG_code = '<div class="videoBG" '.$video_parallax_attr.'>';
		
		if(!wp_is_mobile()){
			$videoBG_code.=	'<video class="lazy" loop>';
			$videoBG_code.=	'<source src="'.$video_webm.'" type="video/webm">';
			$videoBG_code.=	'<source src="'.$video_mp4.'" type="video/mp4">';
		  	$videoBG_code.=	'</video>';
		}
		else{
			$videoBG_code.=	'<div class="bg" style="'.$poster_style.'"></div>';
		}

		if($enable_video_color_overlay){
			$videoBG_code.= '<div class="video_overlay" style="background:'. $video_overlay_color .';"></div>';
		}

  		$videoBG_code.= '</div>';
	}



	//render row
	if ($row_stretching=="fullwidth"){
		$tag_class = 'row fullwidth_bg' . $parallax_class . $videobg_class . $class;
	    $output = '<div id="'.$id.'" class="' . $tag_class.' " style="'.$style.'" '.$bg_parallax_attr.'>';
	    $output .= $videoBG_code;
	    $output .= '<div class="row_container">';
	    $output .= do_shortcode($content);
	    $output .= '</div></div>';
	    echo $output;
	} else if ($row_stretching=="fullwidth_content"){
		$tag_class = 'row fullwidth ' . $parallax_class . $videobg_class . $class;
	    echo '<div id="'.$id.'" class="' . $tag_class.' " style="'.$style.'" '.$bg_parallax_attr.'>'.$videoBG_code.do_shortcode($content).'</div>';		
	} else {
		$tag_class = 'row ' . $parallax_class . $videobg_class . $class;
		echo '<div id="'.$id.'" class="' . $tag_class.' " style="'.$style.'" '.$bg_parallax_attr.'>'.$videoBG_code.do_shortcode($content).'</div>';		
	}
?>